<?php include('partials-front/menu.php'); ?>

    <!-- Location Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Locations</h2>
    
            <?php

                //Display all the locations that are active
                //create SQL Query
                $sql = "SELECT * FROM tbl_location WHERE active='YEs'";

                //Execute the query
                $res = mysqli_query($conn, $sql);

                //Count Rows
                $count = mysqli_num_rows($res);

                //Check wether Location available or not
                if($count>0)
                {
                    //Locations Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the Values
                        $id = $row['id'];
                        $name = $row['name'];
                        $image_name = $row['image_name'];
                        ?>

                        <a href="#">
                            <div class="box-3 float-container">
                                <?php 
                                    if($image_name=="")
                                    {
                                        //Image not Available
                                        echo "<div class='error'>Image not found. </div>";
                                    }
                                    else
                                    {
                                        //Image available
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
                    //Locations not avilable
                    echo "<div class='error'>Locations not found. </div>";
                }

            ?>

            


            <div class="clearfix"></div>

         </div>   
        
    </section>
    <!-- Categories Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>