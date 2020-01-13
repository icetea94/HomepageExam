<?php

    $num= $_GET['num'];

    include "../lib/dbconn.php";    

    //멤버를 삭제하면 그 회원이 작성했던 쪽지와 게시글도 모두 삭제해야 함.
    //그걸 안하면 문제 생김, 아니면 그 글의 작성자를 변경하던가..

    $sql= "DELETE FROM member WHERE num=$num";
    mysqli_close($conn);

    echo "
        <script>
            location.href='./admin.php';
        </script>
        ";

?>