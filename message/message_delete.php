<?php

    $num= $_GET['num'];
    $mode= $_GET['mode'];

    include "../lib/dbconn.php";

    //해당 번호 쪽지 삭제
    $sql= "DELETE FROM message WHERE num=$num";
    mysqli_query($conn, $sql);
    mysqli_close($conn);

    //돌아갈 쪽지함의 종류를 지정한 페이지경로
    if($mode=="send") $url= "./message_box.php?mode=send";
    else $url= "./message_box.php?mode=rv";

    echo "
        <script>
            location.href='$url';
        </script>
    ";

?>