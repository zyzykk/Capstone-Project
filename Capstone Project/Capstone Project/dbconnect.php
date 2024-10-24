<?php

// Connect to Database
$conn = mysqli_connect('localhost', 'Kong', '12321','login');

//Check Connection
if($conn){
    echo 'Connection Error: ' . mysqli_connect_error();
}
?>