<?php include('partials-front/menu.php'); ?>

    <!-- Train Search Section Starts Here -->
    <section class="train-search text-center">
        <div class="container">

        <?php 
            
            //Get the search keyword 
            $search = $_POST['search'];
        
        ?>

        <h2 >Trains on your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

            
        </div>

    </section>
    <!-- Train Search Section Ends Here -->

    <!-- Schedule Section Starts Here -->
    <section class="schedule">
        <div class="container">
            

            <?php 
            
                

                //SQL Query to get Train based on search keyword
                $sql = "SELECT * FROM tbl_train WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

                //Execute the Query
                $res = mysqli_query($conn, $sql);

                //Count Rows
                $count = mysqli_num_rows($res);

                //Check wether Train available or not
                if($count>0)
                {
                    //Train Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the Details
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
                                    //Check wether Image name is availble or not
                                    if($image_name=="")
                                    {
                                        //Image not Available
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

                                <a href="#" class="btn btn-primary">Get Tickets</a>
                            </div>
                        </div>

                        <?php
                    }
                }
                else
                {
                    //Train not Available
                    echo "<div class='error'>Train not Found. </div>";
                }
            
            ?>

            <div class="clearfix"></div>

        </div>
    </section>
    <!-- Schedule Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>