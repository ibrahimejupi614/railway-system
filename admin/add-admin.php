<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br/><br/>

        <?php
            if(isset($_SESSION['add'])) //Checking wether the Session is Set or Not
            {
               echo $_SESSION['add']; //Display the Session Message if Set
               unset($_SESSION['add']); //Remove Session Message
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>

                <tr>
                    <td>Username</td>
                    <td>
                        <input type="text" name="username" placeholder="Your Username">
                    </td>
                </tr>

                <tr>
                    <td>Password</td>
                    <td>
                        <input type="password" name="password" placeholder="Your Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php
    //Proces the Value from Form and Save it in Database

    //Check whether the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        //Button Clicked
        //echo "Button Clicked";

        //1.Get the Data from Form
        //$full_name = $_POST['full_name'];
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);

        //$username = $_POST['username'];
        $username = mysqli_real_escape_string($conn, $_POST['username']);

        //$password = md5($_POST['password']); //Password Encryption with MD5
        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);

        //2.SQL to Save the data into Database
        $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
        ";

        //3.Executing Query and Saving Data into Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        //4.Check wether the (Query is Executed) data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            //Data Inserted
            //echo "Data Inserted";
            //Create a Session Variable to Display Message
            $_SESSION['add'] = "Admin Added Successfully";
            //Redirect Page to Manage Admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //Falied to Insert Data
            //echo "Falied to Insert Data";
            //Create a Session Variable to Display Message
            $_SESSION['add'] = "Falied to Add Admin";
            //Redirect Page Add Admin
            header("location:".SITEURL.'admin/add-admin.php');
        }

    }

?>