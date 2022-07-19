<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
         <h1>Manage Location</h1>

         <br/><br/>

         <?php
        
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['remove']))
            {
                echo $_SESSION['remove'];
                unset($_SESSION['remove']);
            }

            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if(isset($_SESSION['no-location-found']))
            {
                echo $_SESSION['no-location-found'];
                unset($_SESSION['no-location-found']);
            }

            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            if(isset($_SESSION['failed-remove']))
            {
                echo $_SESSION['failed-remove'];
                unset($_SESSION['failed-remove']);
            }

        ?>
        <br/><br/>

                 <!-- Button to add Admin -->
                 <a href="<?php echo SITEURL; ?>admin/add-location.php" class="btn-primary">Add Location</a>

                 <br/><br/><br/>

                 <table class="tbl-full">
                     <tr>
                         <th>S.N.</th>
                         <th>Name</th>
                         <th>Image</th>
                         <th>Featured</th>
                         <th>Active</th>
                         <th>Actions</th>
                     </tr>

                     <?php
                     
                        //Query to Get all Location from Database
                        $sql = "SELECT * FROM tbl_location";

                        //Execute Query
                        $res  = mysqli_query($conn, $sql);

                        //Count Rows
                        $count = mysqli_num_rows($res);

                        //Create Serial Number Variable and assing Value as 1
                        $sn=1;

                        //Check wether we have Data in Database or not
                        if($count>0)
                        {
                            //We have Data in Database
                            //Get DAta and Display
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $id = $row['id'];
                                $name = $row['name'];
                                $image_name = $row['image_name'];
                                $featured = $row['featured'];
                                $active = $row['active'];

                                ?>

                                    <tr>
                                        <td><?php echo $sn++; ?></td>
                                        <td><?php echo $name; ?></td>

                                        <td>

                                            <?php 
                                                //Check wether Image Name is Available or not
                                                if($image_name!="")
                                                {
                                                    //Display the Image
                                                    ?>
                                                    <img src="<?php echo SITEURL; ?>images/location/<?php echo $image_name; ?>" width="100px" >

                                                    <?php
                                                }
                                                else
                                                {
                                                    //Display the Messagess
                                                    echo "<div class='error'>Image not Added.</div>";
                                                }
                                            ?>

                                        </td>

                                        <td><?php echo $featured; ?></td>
                                        <td><?php echo $active; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-location.php?id=<?php echo $id; ?>" class="btn-secondary">Update Location</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-location.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger" >Delete Location</a>
                                        </td>
                                    </tr>

                                <?php
                            }
                        }
                        else
                        {
                            //We Do not have Data
                            //We will Display the Message inside Table
                            ?>

                            <tr>
                                <td colspan="6"><div class="errror">No Location Added.</div></td>
                            </tr>

                            <?php
                        }

                     ?>
                     
                     

                     
                 </table>
    </div>
    
</div>

<?php include('partials/footer.php'); ?>