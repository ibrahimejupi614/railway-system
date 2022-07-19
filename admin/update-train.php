<?php include('partials/menu.php'); ?>

<?php
    //Check wether ID is Set or not
    if(isset($_GET['id']))
    {
        //Get all the Details
        $id = $_GET['id'];

        //SQL Query to Get Selected Train
        $sql2 = "SELECT * FROM tbl_train WHERE id=$id";
        //Execute the Query
        $res2 = mysqli_query($conn, $sql2);

        //Get the Value based on Query Executed
        $row2 = mysqli_fetch_assoc($res2);

        //Get the Individual Values of Selected Train
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_from_location = $row2['from_location_id'];
        $current_to_location = $row2['to_location_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    }
    else
    {
        //Redirect to Manage Train
        header('location:'.SITEURL.'admin/manage-train.php');
    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Train Page</h1>
        <br/><br/>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image == "")
                            {
                                //Image not Available
                                echo "<div class='error'>Image not Available. </div>";
                            }
                            else
                            {
                                //Image Available
                                ?>
                                    <img src="<?php echo SITEURL; ?>images/train/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>From Location: </td>
                    <td>
                        <select name="from_location">

                            <?php
                                //Query to Get Active Categories
                                $sql = "SELECT * FROM tbl_location WHERE active='Yes'";
                                //Execute the Query
                                $res = mysqli_query($conn, $sql);
                                //Count Rows
                                $count = mysqli_num_rows($res);

                                //Check wether Category is Available or not
                                if($count>0)
                                {
                                    //Category Available
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $from_location_name = $row['name'];
                                        $from_location_id = $row['id'];
                                        
                                        //echo "<option value='$category_id'>$category_title</option>";
                                        ?>
                                        <option <?php if($current_from_location==$from_location_id) {echo "selected";} ?> value="<?php echo $from_location_id; ?>"><?php echo $from_location_name; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    //Category not Available
                                    echo "<option value='0'>Category not Available. </option>";
                                }
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>To Location: </td>
                    <td>
                        <select name="to_location">

                            <?php
                                //Query to Get Active Categories
                                $sql4 = "SELECT * FROM tbl_location WHERE active='Yes'";
                                //Execute the Query
                                $res4 = mysqli_query($conn, $sql4);
                                //Count Rows
                                $count4 = mysqli_num_rows($res4);

                                //Check wether Category is Available or not
                                if($count4>0)
                                {
                                    //Category Available
                                    while($row4=mysqli_fetch_assoc($res4))
                                    {
                                        $to_location_name = $row4['name'];
                                        $to_location_id = $row4['id'];
                                        
                                        //echo "<option value='$category_id'>$category_title</option>";
                                        ?>
                                        <option <?php if($current_to_location==$to_location_id) {echo "selected";} ?> value="<?php echo $to_location_id; ?>"><?php echo $to_location_name; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    //Category not Available
                                    echo "<option value='0'>Category not Available. </option>";
                                }
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Train" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php
        
            if(isset($_POST['submit']))
            {
                //echo "Button Clicked";

                //1. Get all the Details from the Form
                $id = $_POST['id'];

                //$title = $_POST['title'];
                $title = mysqli_real_escape_string($conn, $_POST['title']);

                //$description = $_POST['description'];
                $description = mysqli_real_escape_string($conn, $_POST['description']);

                //$price = $_POST['price'];
                $price = mysqli_real_escape_string($conn, $_POST['price']);

                $current_image = $_POST['current_image'];

                $from_location = $_POST['current_image'];
                $to_location = $_POST['current_image'];
                
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2. Upload the Image if Selected

                //Check wether Upload button is Clicked or not
                if(isset($_FILES['image']['name']))
                {
                    //Upload Button Clicked4
                    $image_name = $_FILES['image']['name']; //New Image Name

                    //Check wether the Image is Available or not
                    if($image_name!="")
                    {
                        //Image is Available
                        //A. Uploading New Image

                        //Rename the Image
                        $ext = end(explode('.',$image_name)); //Gets the extension of the Image

                        $image_name = "Train-Name-".rand(0000, 9999).'.'.$ext; //This will be Renamed Image

                        //Get the Source Path and Destination Path
                        $src_path = $_FILES['image']['tmp_name']; //Source Path
                        $dest_path = "../images/train/".$image_name; //Destination Path

                        //Upload the Image
                        $upload = move_uploaded_file($src_path, $dest_path);

                        // Check wether the Image is Uploaded or not
                        if($upload==false)
                        {
                            //Failed to Upload
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image. </div>";
                            //Redirect to Manage Train Page
                            header('location:'.SITEURL.'admin/manage-train.php');
                            //Stop the Process
                            die();
                        }

                        //3. Remove the Image if New Image is Uploaded and Current Image Exists
                        //B. Remove current Image if Available
                        if($current_image!="")
                        {
                            //Current Image is Available
                            //Remove the Image
                            $remove_path = "../images/train/".$current_image;

                            $remove = unlink($remove_path);

                            //Check wether the Image is Removed or not
                            if($remove==false)
                            {
                                //Failed to Remove Current Image
                                $_SESSION['remive-failed'] = "<div class='error'>Failed to Remove the Image. </div>";
                                //Redirect to Manage Train Page
                                header('location:'.SITEURL.'admin/manage-train.php');
                                //Stop the Process
                                die();
                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_image; //Default Image when Image is not Selected
                    }
                }
                else
                {
                    $image_name = $current_image; //Default Image when Button is not Clicked
                }

                

                //4. Update the Train in Database
                $sql3 = "UPDATE tbl_train SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    from_location_id = '$from_location',
                    to_location_id = '$to_location',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

                //Execute the SQl Query
                $res3 = mysqli_query($conn, $sql3);

                //Check wether Query is Executed or Not
                if($res3==true)
                {
                    //Query Executed and Train Updated
                    $_SESSION['update'] = "<div class='success'>Train Updated Successfully. </div>";
                    header('location:'.SITEURL.'admin/manage-train.php');
                }
                else
                {
                    //Failed to Update Train
                    $_SESSION['update'] = "<div class='error'>Failed to Update Train. </div>";
                    header('location:'.SITEURL.'admin/manage-train.php');
                }

                
            }
        
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>