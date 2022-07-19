<?php
    //Include Constants Page
    include('../config/constants.php');

    //echo "Delete Train";

    //1. Check wether Value is Passed
    if(isset($_GET['id']) && isset($_GET['image_name'])) //Either use '&&' or 'AND'
    {
        //Process to Delete
        //echo "Process to Delete";

        //1. Get ID and Image Name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2. Remove the Image if Available
        //Check wether the Image is Available or not and Delete only if available
        if($image_name != "")
        {
            //It has Image and need to Remove from Folder 
            //Get the Image Path
            $path = "../images/train/".$image_name;

            //Remove Image File from Folder
            $remove = unlink($path);

            //Check wether the Image is Removed or not
            if($remove==false)
            {
                //Failed to Remove Image
                $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File. </div>";
                header('location:'.SITEURL.'admin/manage-train.php');
                //Stop the Process of Deleting Train
                die();
            }
        }

        //3. Delete Train from Database
        $sql = "DELETE FROM tbl_train WHERE id=$id";
        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Check wether Query is Executed or not and set the Session Message Respectively
        //4. Redirect to Manage Train with Session Message
        if($res==true)
        {
            //Train Deleted
            $_SESSION['delete'] = "<div class='success'>Train Deleted Successfully. </div>";
            header('location:'.SITEURL.'admin/manage-train.php');
        }
        else
        {
            //Failed to Delete Train
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Train. </div>";
            header('location:'.SITEURL.'admin/manage-train.php');
        }

        
    }
    else
    {
        //Redirect to Manage Train Page
        //echo "Redirect";
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access. </div>";
        header('location:'.SITEURL.'admin/manage-train.php');
    }

?>