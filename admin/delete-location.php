<?php
    //Include Constants File
    include('../config/constants.php');

    //echo "Delete Page";
    //Check wether the id and image_name value is Set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //Get the Value and Delete
        //echo "Get Value and Delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file if available
        if($image_name != "")
        {
            //Image Available. So Remove it
            $path = "../images/location/".$image_name;
            //Remove the Image
            $remove = unlink($path);

            //If failed to remove Image then add an Error Message and stop the process
            if($remove==false)
            {
                //SEt the Session Message
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Location Image. </div>";
                //Redirect to Manage Location Page
                header('location:'.SITEURL.'admin/manage-location.php');
                //Stop the Process
                die();
            }
        }

        //Delete Data From Database
        //SQL Query to Delete Data from Database
        $sql = "DELETE FROM tbl_location WHERE id=$id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Check wether the data is delete from Database or not
        if($res==true)
        {
            //Set Success Message and Redirect
            $_SESSION['delete'] = "<div class='success'>Location Deleted Successfully. </div>";
            //Redirect to Manage Location Page
            header('location:'.SITEURL.'admin/manage-location.php');
        }
        else
        {
            //Set Fail Message and Redirect
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Location. </div>";
            //Redirect to Manage Location Page
            header('location:'.SITEURL.'admin/manage-location.php');
        }

        //Redirect to Manage Location Page with Message
        //header('location:'.SITEURL.'addmin/manage-location.php');
    }
    else
    {
        //Redirect to Manage Location Page
        header('location:'.SITEURL.'admin/manage-location.php');
    }
?>