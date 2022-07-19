<?php include('partials-front/menu.php'); ?>

    <!-- Train Search Section Starts Here -->
    <section class="train-search text-center">
        <div class="container">

            <form action="<?php echo SITEURL; ?>train-search.php" method="POST">

             <input type="search" name="search" placeholder="Search for Train..">
             <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>
        </div>

    </section>
    <!-- Train Search Section Ends Here -->

    <!-- Schedule Section Starts Here -->
    <section class="schedule">
        <div class="container">
            <h2 class="text-center">Find Train</h2>

            <?php
                //Display Trains that are Active
                //SQL Query
                $sql = "SELECT * FROM tbl_train WHERE active='Yes'";

                //Execute the Query
                $res = mysqli_query($conn, $sql);

                //Count rows to check wether the location is available or not
                $count = mysqli_num_rows($res);

                //Check wether Train availavle or not
                if($count>0)
                {
                    //Trains Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the Values
                        $id = $row['id'];
                        $from_location = $row['from_location_id'];
                        $to_location = $row['to_location_id'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>

                        <div class="schedule-box">
                            <div class="destination-img">
                                <?php
                                    //Check wether Image available or not
                                    if($image_name=="")
                                    {
                                        //Image not available
                                        echo "<div class='error'>Image not Found. </div>";
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
                    //Trains not Available
                    echo "<div class='error'>Train not Found. </div>";
                }
            ?>

            

            <div class="clearfix"></div>

        </div>
    </section>
    <!-- Schedule Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>