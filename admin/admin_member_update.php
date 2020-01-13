<?php

    $num= $_GET['num'];
    $level= $_POST['level'];
    $point= $_POST['point'];

    include "../lib/dbconn.php";

    $sql= "UPDATE member SET level=$level, point=$point WHERE num=$num";
    mysqli_query($conn, $sql);
    mysqli_close($conn);

    echo "
        <script>
            location.href='./admin.php';
        </script>
        ";

?>