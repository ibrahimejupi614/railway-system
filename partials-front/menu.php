<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Railway System</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <img src="images/logo.png" alt="Train Logo" class="img-responsive">
            </div>

            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="<?php echo SITEURL; ?>">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>locations.php">Locations</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>trains.php">Trains</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>contactus.php">Contact Us</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>aboutus.php">About Us</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>admin/login.php">Login</a>
                    </li>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->