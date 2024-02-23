    <?php
//connect ot database
$connect = mysqli_connect('localhost','root','','smilez', 3309);

if (!$connect)
 {
    //code
echo mysqli_error($connect);
 }
