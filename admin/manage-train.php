<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
         <h1>Manage Train</h1>

         <br/><br/><br/>

                 <!-- Button to add Admin -->
                 <a href="<?php echo SITEURL; ?>admin/add-train.php" class="btn-primary">Add Train</a>

                 <br/><br/><br/>

                 <?php

                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['upload']))
                    {
                        echo $_SESSION['upload'];
                        unset($_SESSION['upload']);
                    }

                    if(isset($_SESSION['unauthorize']))
                    {
                        echo $_SESSION['unauthorize'];
                        unset($_SESSION['unauthorize']);
                    }

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                 ?>

                 <table class="tbl-full">
                     <tr>
                         <th>S.N.</th>
                         <th>Title</th>
                         <th>Price</th>
                         <th>Image</th>
                         <th>Featured</th>
                         <th>Active</th>
                         <th>Actions</th>
                     </tr>
                     
                     <?php
                        //Create SQL Quert to Get all the Train
                        $sql = "SELECT * FROM tbl_train";

                        //Execute the Query
                        $res = mysqli_query($conn, $sql);

                        //Count Rows to check wether we have train or not
                        $count = mysqli_num_rows($res);

                        //Create Serial Number Variable and Set Default Value as 1
                        $sn = 1;

                        if($count>0)
                        {
                            //We have Train in our Database
                            //Get the Train From Database and Display
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //Get the Value from Individual Colums
                                $id = $row['id'];
                                $title = $row['title'];
                                $price = $row['price'];
                                $image_name = $row['image_name'];
                                $featured = $row['featured'];
                                $active = $row['active'];
                                ?>

                                    <tr>
                                        <td><?php echo $sn++; ?></td>
                                        <td><?php echo $title; ?></td>
                                        <td>$<?php echo $price; ?></td>
                                        <td>
                                            <?php 
                                                //Check wether we have Image or not
                                                if($image_name=="")
                                                {
                                                    //We do not Have Image, Display Error Message
                                                    echo "<div class='error'>Image not Added</div>";
                                                }
                                                else
                                                {
                                                    //We Have Image, Display Image
                                                    ?>
                                                        <img src="<?php echo SITEURL; ?>images/train/<?php echo $image_name; ?>" width="100px">
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $featured; ?></td>
                                        <td><?php echo $active; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-train.php?id=<?php echo $id; ?>" class="btn-secondary">Update Train</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-train.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger" >Delete Train</a>
                                        </td>
                                    </tr>

                                <?php
                            }
                        }
                        else
                        {
                            //We do not added Data in our Database
                            echo "<tr> <td colspan='7' class='error'> Train not Added Yet. </td> </tr>";
                        }
                     ?>

                 </table>
    </div>
    
</div>

<?php include('partials/footer.php'); ?>