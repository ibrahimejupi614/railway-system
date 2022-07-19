<?php include('partials-front/menu.php'); ?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="" method="POST">
            <input type="text" name="name" placeholder="Name"><br><br>
            <input type="email" name="email" placeholder="Email"><br><br>
            <textarea name="msg"  placeholder="Type your Request" ></textarea><br>
            <input type="submit" value="submit request">
        </form>
    </body>
</html>
<?php
        $sql = "INSERT INTO tbl_data SET
            name='$name',
            email='$email',
            msg='$msg'
        ";

        $res = mysqli_query($conn, $sql);
        
?>

<?php include('partials-front/footer.php'); ?>