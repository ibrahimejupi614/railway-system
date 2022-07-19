<?php include('partials-front/menu.php'); ?>

<?php
    //Check wether id is pased or not
    if(isset($_GET['to_location_id']))
    {
        //To Location id is set and get the id
        $to_location_id = $_GET['to_location_id'];
        //Get Location name based on to Location Id
        $sql = "SELECT name FROM tbl_location WHERE id=$to_location_id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Get the Value from Database
        $row = mysqli_fetch_assoc($res);
        //Get the Name
        $to_location_name = $row['name'];
    }
    else
    {
        //To Location not passes
        //Redirect to Home Page
        header('location:'.SITEURL);
    }
?>

    <!-- Train Search Section Starts Here -->
    <section class="train-search text-center">
        <div class="container">


            <h2>Trains on <a href="#" class="text-white">"<?php echo $to_location_name ?>"</a></h2>

        </div>

    </section>
    <!-- Train Search Section Ends Here -->
    
    <!-- Schedule Section Starts Here -->
    <section class="schedule">
        <div class="container">
            <h2 class="text-center">Find Train</h2>

            <?php
            
                //Create SQL to get train based on Selected Location
                $sql2 = "SELECT * FROM tbl_train WHERE to_location_id=$to_location_id";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                //Count the rows
                $count2 = mysqli_num_rows($res2);

                //Check wether train is available or not
                if($count2>0)
                {
                    //Train is Available
                    while($row2=mysqli_fetch_assoc($res2))
                    {
                        $id = $row2['id'];
                        $from_location = $row2['from_location_id'];
                        $to_location = $row2['to_location_id'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];
                        ?>
                        <div class="schedule-box">
                            <div class="destination-img">
                                <?php
                                    if($image_name=="")
                                    {
                                        //Image not Available
                                        echo "<div class='error'>Image not Available. </div>";
                                    }
                                    else
                                    {
                                        //Image Available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/train/<?php echo $image_name; ?>" alt="Tirana Destination" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                                
                            </div>

                            <div class="schedule-desc">
                                <h4>From Location <?php echo $from_location; ?></h4>
                                <h4>To Location <?php echo $to_location; ?></h4>
                                <p class="destination-price"><?php echo $price; ?>€</p>
                                <p class="destination-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br/>

                                <a href="<?php echo SITEURL; ?>book.php?train_id=<?php echo $id; ?>" class="btn btn-primary">Get Tickets</a>
                            </div>
                        </div>
                        <?php
                    }
                }
                else
                {
                    //Train not available
                    echo "<div class='error'>Train not Available. </div>";
                }

            ?>

            <div class="clearfix"></div>

        </div>
    </section>
    <!-- Schedule Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>