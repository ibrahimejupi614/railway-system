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

    <?php
        if(isset($_SESSION['book']))
        {
            echo $_SESSION['book'];
            unset($_SESSION['book']);
        }
    ?>

    <!-- Location Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Locations</h2>
    
            <?php
                //Create SQL Query to Display Categories from Database
                $sql = "SELECT * FROM tbl_location WHERE active='Yes' AND featured='Yes' LIMIT 3";
                //Execute the Query
                $res = mysqli_query($conn, $sql);

                //Count rows to check wether the location is available or not
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    //Locations Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the Values like Id, title, image_name 
                        $id = $row['id'];
                        $name = $row['name'];
                        $image_name = $row['image_name'];
                        ?>

                        <a href="<?php echo SITEURL; ?>locations-trains.php?to_location_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php
                                    //Check wether Image is Available or not
                                    if($image_name=="")
                                    {
                                        //Display the Message
                                        echo "<div class='error'>Image not Available. </div>";
                                    }
                                    else
                                    {
                                        //Image Available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/location/<?php echo $image_name; ?>" alt="Economy Class" class="img-responsive img-curve img-height-400px">
                                        <?php
                                    }
                                ?>
                                

                                <h3 class="float-text text-white"><?php echo $name; ?></h3>
                            </div>
                        </a>

                        <?php
                    }
                }
                else
                {
                    //Locations not Available
                    echo "<div class='error'>Locations not Added. </div>";
                }
            ?>

            

            <div class="clearfix"></div>

         </div>   
        
    </section>
    <!-- Locations Section Ends Here -->

    <!-- Schedule Section Starts Here -->
    <section class="schedule">
        <div class="container">
            <h2 class="text-center">Find Train</h2>

            <?php 
            
            //Getting Trains actived from Database that are active and featured
            //SQL Query
            $sql2 = "SELECT * FROM tbl_train WHERE active='Yes' AND featured='Yes' LIMIT 6";

            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            //Count rows to check wether the location is available or not
            $count2 = mysqli_num_rows($res2);

            //Check wether Train availavle or not
            if($count2>0) 
            {
                //Train Available
                while($row=mysqli_fetch_assoc($res2))
                {
                    //Get all the values 
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
                                //Check wether the image is available or not
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

                                <a href="<?php echo SITEURL; ?>book.php?train_id=<?php echo $id; ?>" class="btn btn-primary">Get Tickets</a>
                        </div>
                    </div>

                    <?php
                }
            }
            else
            {
                //Train not Available
                echo "<div class='error'>Train not available. </div>";
            }
            
            ?>

            

            <div class="clearfix"></div>

        </div>
    </section>
    <!-- Schedule Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>