<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wapper">
        <h1>Add Train</h1>

        <br/><br/>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Train">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Train"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>From Location: </td>
                    <td>
                        <select name="from_location">

                            <?php
                                //Create PHP Code to Display Categories From Database
                                //1. Create SQL Query to get all Active Categories from Database
                                $sql = "SELECT * FROM tbl_location WHERE active='Yes'";

                                //Execute query
                                $res = mysqli_query($conn, $sql);

                                //Count Rows to Check wether we have Categories or not
                                $count = mysqli_num_rows($res);

                                //If count is greater than zero, we have Categories else we dont have Categories
                                if($count>0)
                                {
                                    //We have Categories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //Get the Details of Categories
                                        $id = $row['id'];
                                        $name = $row['name'];
                                        ?>
                                            <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    //We do not have Categories
                                    ?>
                                        <option value="0">No Category Found</option>
                                    <?php
                                }

                                //2. Display on Dropdown
                            ?>
      
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>To Location: </td>
                    <td>
                        <select name="to_location">

                            <?php
                                //Create PHP Code to Display Categories From Database
                                //1. Create SQL Query to get all Active Categories from Database
                                $sql2 = "SELECT * FROM tbl_location WHERE active='Yes'";

                                //Execute query
                                $res2 = mysqli_query($conn, $sql2);

                                //Count Rows to Check wether we have Categories or not
                                $count2 = mysqli_num_rows($res2);

                                //If count is greater than zero, we have Categories else we dont have Categories
                                if($count2>0)
                                {
                                    //We have Categories
                                    while($row=mysqli_fetch_assoc($res2))
                                    {
                                        //Get the Details of Categories
                                        $id2 = $row['id'];
                                        $name2 = $row['name'];
                                        ?>
                                            <option value="<?php echo $id2; ?>"><?php echo $name2; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    //We do not have Categories
                                    ?>
                                        <option value="0">No Category Found</option>
                                    <?php
                                }

                                //2. Display on Dropdown
                            ?>
      
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Train" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php
        
            //Check wether the Button is Clicked or not
            if(isset($_POST['submit']))
            {
                //Add the Train in Database
                //echo "Clicked";

                //1. Get the Data from Form
                //$title = $_POST['title'];
                $title = mysqli_real_escape_string($conn, $_POST['title']);

                //$description = $_POST['description'];
                $description = mysqli_real_escape_string($conn, $_POST['description']);

                //$price = $_POST['price'];
                $price = mysqli_real_escape_string($conn, $_POST['price']);

                $from_location = $_POST['from_location'];
                $to_location = $_POST['to_location'];
                
                //Check wether Radio Button for Featured and Active are checked or not
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No"; //Setting the Default Value
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No"; //Setting the Default Value
                }

                //2. Upload the Image if Selected
                //Check wether the Select Image is Clicked or not and upload the image only if the Image is selected
                if(isset($_FILES['image']['name']))
                {
                    //Get the details of the Selected Image
                    $image_name = $_FILES['image']['name'];

                    //Check wether the Image is Selected or not and Upload Image only if Selected
                    if($image_name!="")
                    {
                        // Image is Selected
                        //A. Rename the Image
                        //Get the extension of Selected Image (jpg, png, gif, etc.)
                        $ext = end(explode('.', $image_name));

                        //Create New Name for Image
                        $image_name = "Train-Name-".rand(0000, 9999).'.'.$ext; //New Image Name May Be "Train-Name-657.jpg"

                        //B. Upload the Image
                        //Get the Src Path and Destination path

                        // Sourece path is the Current Location of the Image
                        $src=$_FILES['image']['tmp_name'];

                        //Destination Path for Image to be Uploaded
                        $dst = "../images/train/".$image_name;

                        //Finally Upload the Train Image
                        $upload = move_uploaded_file($src, $dst);

                        //Check wether Image Uploaded or not
                        if($upload==false)
                        {
                            //Failed to Upload the Image
                            //Redirect to Add Train Page with error Message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image. </div>";
                            header('location:'.SITEURL.'admin/add-train.php');
                            //Stop the Process
                            die();
                        }
                    }
                }
                else
                {
                    $image_name = ""; //Setting Default Value as Blank
                }

                //3. Insert Into Database

                //Create a SQL Query to Save our Add Train
                // For Numerical we do not need to pass value inside quotes '' But for String Value it is Complusory to add Quotes ''
                $sql3 = "INSERT INTO tbl_train SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    from_location_id = $from_location,
                    to_location_id = $to_location,
                    featured = '$featured',
                    active = '$active'
                ";

                //Execute the Query
                $res3 = mysqli_query($conn, $sql3);

                //Check wether data insertedd or not
                //4. Redirect with Message to Manage Train Page
                if($res3 == true)
                {
                    //Data Inserted Successfully
                    $_SESSION['add'] = "<div class='success'>Train Added Successfully. </div>";
                    header('location:'.SITEURL.'admin/manage-train.php');
                }
                else
                {
                    //Failed to Insert Data
                    $_SESSION['add'] = "<div class='error'>Failed to Add Train. </div>";
                    header('location:'.SITEURL.'admin/manage-train.php');
                }

                
            }
        
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>