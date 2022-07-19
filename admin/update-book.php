<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Book</h1>
        <br/><br/>

        <?php

            //Check wether ID is set or not
            if(isset($_GET['id']))
            {
                //Get the Book Details
                $id = $_GET['id'];

                //Get all other Details based on this ID
                //SQL Query to get the Book Details
                $sql = "SELECT * FROM tbl_book WHERE id=$id";
                //Execute the Query
                $res = mysqli_query($conn, $sql);
                //Count Rows
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //Detail Available
                    $row=mysqli_fetch_assoc($res);

                    $train = $row['train'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $status = $row['status'];
                    $passenger_name = $row['passenger_name'];
                    $passenger_contact = $row['passenger_contact'];
                    $passenger_email = $row['passenger_email'];
                    $passenger_address = $row['passenger_address'];
                }
                else
                {
                    //Detail not Available
                    //Redirect Manage Book
                    header('location:'.SITEURL.'admin/manage-book.php');
                }
            }
            else
            {
                //Redirect to Manage Book Page
                header('location:'.SITEURL.'admin/manage-book.php');
            }

        ?>

        <form action="" method="POST">

            <table class="30">
                <tr>
                    <td>Train Name</td>
                    <td><b><?php echo $train; ?></b></td>
                </tr>

                <tr>
                    <td>Price</td>
                    <td><b> $ <?php echo $price; ?></b></td>
                </tr>

                <tr>
                    <td>Qty</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Booked"){echo "selected";} ?> value="Booked">Booked</option>
                            <option <?php if($status=="Arrived"){echo "selected";} ?> value="Arrived">Arrived</option>
                            <option <?php if($status=="Cancelled"){echo "selected";} ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Passenger Name: </td>
                    <td>
                        <input type="text" name="passenger_name" value="<?php echo $passenger_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Passenger Contact: </td>
                    <td>
                        <input type="text" name="passenger_contact" value="<?php echo $passenger_contact; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Passenger Email: </td>
                    <td>
                        <input type="text" name="passenger_email" value="<?php echo $passenger_email; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Passenger Address: </td>
                    <td>
                        <textarea name="passenger_address" cols="30" rows="5"><?php echo $passenger_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <input type="submit" name="submit" value="Update Book" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>

        <?php
            //Check wether Update Button is Clicked or Not
            if(isset($_POST['submit']))
            {
                //echo "Clicked";
                //Get all the Values from Form
                $id = $_POST['id'];
                $price = $_POST['price'];

                //$qty = $_POST['qty'];
                $qty = $_POST['qty'];

                $total = $price * $qty;

                $status = $_POST['status'];

                //$passenger_name = $_POST['passenger_name'];
                $passenger_name = mysqli_real_escape_string($conn, $_POST['passenger_name']);

                //$passenger_contact = $_POST['passenger_contact'];
                $passenger_contact = mysqli_real_escape_string($conn, $_POST['passenger_contact']);

                //$passenger_email = $_POST['passenger_email'];
                $passenger_email = mysqli_real_escape_string($conn, $_POST['passenger_email']);

                //$passenger_address = $_POST['passenger_address'];
                $passenger_address = mysqli_real_escape_string($conn, $_POST['passenger_address']);

                //Update the Values
                $sql2 = "UPDATE tbl_book SET
                    qty = $qty,
                    total = $total,
                    status = '$status',
                    passenger_name = '$passenger_name',
                    passenger_contact = '$passenger_contact',
                    passenger_email = '$passenger_contact',
                    passenger_address = '$passenger_address'
                    WHERE id=$id
                ";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                //Check wether Updated or not
                //And Redirect to Manage Book with Message
                if($res2==true)
                {
                    //Updated
                    $_SESSION['update'] = "<div class='success'>Book Updated Successfully. </div>";
                    header('location:'.SITEURL.'admin/manage-book.php');
                }
                else
                {
                    //Failed to Update
                    $_SESSION['update'] = "<div class='error'>Failed to Update Book. </div>";
                    header('location:'.SITEURL.'admin/manage-book.php');
                }
            }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>