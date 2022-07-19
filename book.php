<?php include('partials-front/menu.php'); ?>  

    <?php
        //Check wether train id is set or not
        if(isset($_GET['train_id']))
        {
            //Get the Train id and details of selected Train
            $train_id = $_GET['train_id'];

            //Get the Details of Selected Train
            $sql = "SELECT * FROM tbl_train WHERE id=$train_id";

            //Execute the Query
            $res = mysqli_query($conn, $sql);

            //Count the Rows
            $count = mysqli_num_rows($res);

            //Check wether the data is available or not 
            if($count==1)
            {
                //We have Data
                //Get the Data from Database
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
            }
            else
            {
                //We do not have data
                //Redirect to Home Page
                header('location:'.SITEURL);
            }
        }
        else
        {
            //Redirect to Home Page
            header('location:'.SITEURL);
        }
    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="train-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your book.</h2>

            <form action="" method="POST" class="book">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="train-menu-img">
                        <?php
                        
                            //Check wether the Image is Available or not
                            if($image_name=="")
                            {
                                //Image not Found
                                echo "<div class='error'>Image not found. </div>";
                            }
                            else
                            {
                                //Image Found
                                ?>
                                <img src="<?php echo SITEURL; ?>images/train/<?php echo $image_name; ?>"  class="img-responsive img-curve img-height-200px img-width-200px">
                                <?php
                            }
                        
                        ?>
                        
                    </div>
    
                    <div class="train-menu-desc text-center">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="train" value="<?php echo $title; ?>">

                        <p class="train-price"><?php echo $price; ?>€</p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="book-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="book-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Artan Gashi" class="input-responsive" required>

                    <div class="book-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="book-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. artan.gashi@example.com" class="input-responsive" required>

                    <div class="book-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Book" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
            
                //Check wether submit button is clicked or not
                if(isset($_POST['submit']))
                {
                    //Get all the details from the form

                    $train = $_POST['train'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty; // total = price x qty

                    $book_date = date("Y-m-d h:i:sa"); //Book Date

                    $status = "Booked"; //Booked, the train arrived, Cancelled

                    $passenger_name = $_POST['full-name'];
                    $passenger_contact = $_POST['contact'];
                    $passenger_email = $_POST['email'];
                    $passenger_address = $_POST['address'];

                    //Save the Book in Database
                    //Crate SQL to save the Data
                    $sql2 = "INSERT INTO tbl_book SET
                        train = '$train',
                        price = $price,
                        qty = $qty,
                        total = $total,
                        book_date = '$book_date',
                        status = '$status',
                        passenger_name = '$passenger_name',
                        passenger_contact = '$passenger_contact',
                        passenger_email = '$passenger_email',
                        passenger_address = '$passenger_address'
                    ";

                    //Execute the Query
                    $res2 = mysqli_query($conn, $sql2);

                    //Check wether Query executed Successfully or not
                    if($res2==true)
                    {
                        //Query Executed and Book Saved
                        $_SESSION['book'] = "<div class='success text-center'>Train booked Successfully. </div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        //Failed to Save Book
                        $_SESSION['book'] = "<div class='error text-center'>Failed to Book Train. </div>";
                        header('location:'.SITEURL);
                    }

                }

            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>