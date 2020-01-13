<?php

    $num= $_GET['num'];

    include "../lib/dbconn.php";

    // 업로드된 파일도 삭제하도록 하고 싶다면.
    $sql= "SELECT * FROM board WHERE num=$num";
    $result= mysqli_query($conn, $sql);
    $row= mysqli_fetch_array($result, MYSQLI_ASSOC);

    //저장된 파일명 얻어오기
    $copied_name= $row['file_copied'];

    //첨부된 파일이 있는지
    if($copied_name){
        //저장되어 있는 경로명을 포함한 파일명 만들기
        $file_path= "./uploads/".$copied_name;
        //위 경로의 파일을 제거
        unlink($file_path); //해당 경로의 파일을 제거
    }


    $sql= "DELETE FROM board WHERE num=$num";
    mysqli_query($conn, $sql);
    mysqli_close($conn);

    //삭제완료 되었으니 목록페이지로 이동
    echo "
        <script>
            location.href='./board_list.php';
        </script>
    ";

?>