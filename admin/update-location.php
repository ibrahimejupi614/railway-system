<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Location</h1>

        <br/><br/>

        <?php
        
            //Check wether the Id is Set or not
            if(isset($_GET['id']))
            {
                //Get the Id and all other Details
                //echo "Getting the Data";
                $id = $_GET['id'];

                //Create SQL Query to get all other Details
                $sql = "SELECT * FROM tbl_location WHERE id=$id;";

                //Execute the Query
                $res = mysqli_query($conn, $sql);

                //Count the Rows to Check wether the id is Valid or not
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //Get all the Data
                    $row = mysqli_fetch_assoc($res);
                    $name = $row['name'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {
                    //Redirect to Manage Location Page With Session Message
                    $_SESSION['no-location-found'] = "<div class='error'>Location not Found. </div>";
                    header('location:'.SITEURL.'admin/manage-location.php');
                }
            }
            else
            {
                //Redirect to Manage Location Page
                header('location:'.SITEURL.'admin/manage-location.php');
            }
        
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table calss="tbl-30">
                <tr>
                    <td>Name: </td>
                    <td>
                        <input type="text" name="name" value="<?php echo $name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image != "")
                            {
                                //Display the Image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/location/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                            else
                            {
                                //Display Message
                                echo "<div class='error'>Image not Added. </div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes

                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes

                        <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Location" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php
        
            if(isset($_POST['submit']))
            {
                //echo "Clicked";
                //1. Get all the Values from our Form
                $id = $_POST['id'];

                //$name = $_POST['name'];
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2. Updating New Image if Selected
                //Check wether the Image is Selected or not
                if(isset($_FILES['image']['name']))
                {
                    //Get the Image Details
                    $image_name = $_FILES['image']['name'];

                    //Check wether the Image is Available or Not
                    if($image_name != "")
                    {
                        //Image Available

                        //A. Upload the New Image

                        //Auto Rename our Image
                        //Get the Extension of our Image (jpg, png, gif, etc) e.g. "specialtrain1.jpg"
                        $ext = end(explode('.', $image_name));

                        //Rename the Image
                        $image_name = "Train_Location_".rand(000, 999).'.'.$ext; // e.g. Train_Location_834.jpg
                        

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/location/".$image_name;

                        //Finally Upload the Image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Check wether the Image is Uploaded or not
                        //And if Image is not Uploaded the we will stop the proccess and redirect with error message
                        if($upload==false)
                        {
                            //Set Message
                            $_SESSION['upload'] = "<div class='error'>Falied to Upload Image. </div>";
                            //Redirect to Add Location Page
                            header('location:'.SITEURL.'admin/manage-location.php');
                            //Stop the Process
                            die();
                        }

                        //B. Remove the Current Image if is Available
                        if($current_image != "")
                        {
                                $remove_path = "../images/location/".$current_image;

                                $remove = unlink($remove_path);

                                //Check wether the Image the Image is Removed or Not
                                //If Failed to remove then Display Message and stop the Process
                                if($remove==false)
                                {
                                    //Failed to remove the Image
                                    $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image. </div>";
                                    header('location:'.SITEURL.'admin/manage-location.php');
                                    die(); //Stop the Process
                                }   
                        }
                        
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                //3. Update the Database
                $sql2 = "UPDATE tbl_location SET
                    name = '$name',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                //4. Redirect to Manage Location Page with Message
                //Check wether Query executed or not
                if($res2==true)
                {
                    //Location Updated
                    $_SESSION['update'] = "<div class='success'>Location Updated Successfully. </div>";
                    header('location:'.SITEURL.'admin/manage-location.php');
                }
                else
                {
                    //Failed to Update Location
                    $_SESSION['update'] = "<div class='error'>Failed to Update Location. </div>";
                    header('location:'.SITEURL.'admin/manage-location.php');
                }

            }
        
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>