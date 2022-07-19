<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Book</h1>

        <br/><br/><br/>

        <table class="tbl-full">
                     <tr>
                         <th>S.N.</th>
                         <th>Train</th>
                         <th>Price</th>
                         <th>Qty.</th>
                         <th>Total</th>
                         <th>Book Date</th>
                         <th>Status</th>
                         <th>Passenger Name</th>
                         <th>Contact</th>
                         <th>Email</th>
                         <th>Address</th>
                         <th>Actions</th>
                     </tr>
                     <?php
                        //Get all the Books from Database
                        $sql = "SELECT * FROM tbl_book ORDER BY id DESC"; //Display the Latest Book at First
                        //Execute the Query
                        $res = mysqli_query($conn, $sql);
                        //Count the Rows
                        $count = mysqli_num_rows($res);

                        $sn = 1; //Create a Serial Number and Set its initial Value as 1

                        if($count>0)
                        {
                            //Books Available
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //Get all the Books Details
                                $id = $row['id'];
                                $train = $row['train'];
                                $price = $row['price'];
                                $qty = $row['qty'];
                                $total = $row['total'];
                                $book_date = $row['book_date'];
                                $status = $row['status'];
                                $passenger_name = $row['passenger_name'];
                                $passenger_contact = $row['passenger_contact'];
                                $passenger_email = $row['passenger_email'];
                                $passenger_address = $row['passenger_address'];

                                ?>

                                    <tr>
                                        <td><?php echo $sn++; ?>. </td>
                                        <td><?php echo $train; ?></td>
                                        <td><?php echo $price; ?></td>
                                        <td><?php echo $qty; ?></td>
                                        <td><?php echo $total; ?></td>
                                        <td><?php echo $book_date; ?></td>

                                        <td>
                                            <?php
                                                // Ordered, On Delivery, Delivered, Cancelled

                                                if($status=="Booked")
                                                {
                                                    echo "<label style='color: orange;'>$status</label>";
                                                }
                                                elseif($status=="Arrived")
                                                {
                                                    echo "<label style='color: green;'>$status</label>";
                                                }
                                                elseif($status=="Cancelled")
                                                {
                                                    echo "<label style='color: red;'>$status</label>";
                                                }
                                            ?>
                                        </td>

                                        <td><?php echo $passenger_name; ?></td>
                                        <td><?php echo $passenger_contact; ?></td>
                                        <td><?php echo $passenger_email; ?></td>
                                        <td><?php echo $passenger_address; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-book.php?id=<?php echo $id;  ?>" class="btn-secondary">Update Book</a>
                                        </td>
                                    </tr>

                                <?php

                            }
                        }
                        else
                        {
                            //Book not Available
                            echo "<tr><td colspan='12' class='error'>Books not Available. </td></tr>";
                        }
                     ?>
                     
                     

                     
                 </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>