<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Location</h1>

        <br/><br/>

        <?php
        
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

        ?>

        <br/><br/>

        <!-- Add Location Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Name: </td>
                    <td>
                        <input type="text" name="name" placeholder="Location Name">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
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
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Location" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
        <!-- Add Location Form Ends -->

        <?php 
        
            //Check wether the Submit Button is Clicked or not
            if(isset($_POST['submit']))
            {
                //echo "Clicked";

                //1. Get the Value From Location Form
                //$name = $_POST['name'];
                $name = mysqli_real_escape_string($conn, $_POST['name']);

                //For Radio Input Type we need to check wether the Button is Selecked or not
                if(isset($_POST['featured']))
                {
                    //Get the Value From Form
                    $featured = $_POST['featured'];
                }
                else
                {
                    //Set the Default Value
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }

                //Check wether the Image is Selected or not and set the Value for Image Name Accordingly
                //print_r($_FILES['image']);
                
                //die(); //Break the Code Here

                if(isset($_FILES['image']['name']))
                {
                    //Upload the Image
                    //To Upload Image we need Image name, Source path and destionation path
                    $image_name = $_FILES['image']['name'];

                    //Upload the Image only if Image is Selected
                    if($image_name != "")
                    {
                        //Auto Rename our Image
                        //Get the Extension of our Image (jpg, png, gif, etc) e.g. "speciallocation1.jpg"
                        $ext = end(explode('.', $image_name));

                        //Rename the Image
                        $image_name = "Special_Location_".rand(000, 999).'.'.$ext; // e.g. Special_Location_834.jpg
                        

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
                            header('location:'.SITEURL.'admin/add-location.php');
                            //Stop the Process
                            die();
                        }

                    }
                }
                else
                {
                    //Dont't Upload Image and set the image_name value as blank
                    $image_name="";
                }

                 //2. Create SQL Query to Insert Location into Database
                 $sql = "INSERT INTO  tbl_location SET
                    name='$name',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                 ";

                 //3. Execute the Query and Save in Database
                 $res = mysqli_query($conn, $sql);

                 //4. Check wether the Query Executed or not and Data added or not
                 if($res==true)
                 {
                    //Query Executed and Location Added
                    $_SESSION['add'] = "<div class='success'>Location Added Successfully.</div>";
                    //Redirect to Manage Location Page
                    header('location:'.SITEURL.'admin/manage-location.php');
                 }
                 else
                 {
                    //Falied to Add Location
                    $_SESSION['add'] = "<div class='error'>Falied to Add Location.</div>";
                    //Redirect to Manage Location Page
                    header('location:'.SITEURL.'admin/add-location.php');
                 }
            }
        
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>