<?php

    session_start();
    $userid= $_SESSION['userid'];
    $username= $_SESSION['username'];

    //post로 전달된 값들
    $subject= $_POST['subject'];
    $content= $_POST['content'];

    $regist_day= date('Y-m-d (h:i)');

    // 업로드뢴 파일
    $srcName= $_FILES['attach_file']['name'];
    $tmpName= $_FILES['attach_file']['tmp_name'];
    $fileType= $_FILES['attach_file']['type'];

    //업로드된 파일 있다면
    if( $srcName ){
        //서버에 영구 저장할 파일명(날짜_원본파일명.확장자)
        $new_file_name= date("YmdHis")."_".$srcName;
        //최종저장될 경로포함한 파일위치
        $dstName= "./uploads/".$new_file_name;
        
        //임시저장소($temName)의 파일을 $dstName으로 이동
        move_uploaded_file($tmpName, $dstName);

    }else{
        $srcName= "";  //원본파일명
        $fileType= "";  //파일타입
        $new_file_name= "";//경로제외한 목적지 파일명 (날짜가 추가된 파일명)
    }

    //board테이블에 값들 저장
    include "../lib/dbconn.php";

    $sql = "INSERT INTO board (id, name, subject, content, regist_day, hit, file_name, file_type, file_copied) ";
    $sql.= "VALUES('$userid','$username','$subject','$content','$regist_day','0','$srcName','$fileType','$new_file_name')";
    mysqli_query($conn, $sql);

    //게시글 작성하면 회원의 포인트를 100 추가

    //member테이블에서 해당 id 의 point 컬룸 값 얻어오기
    $sql= "SELECT point FROM member WHERE id='$userid'";
    $result= mysqli_query($conn, $sql);
    $row= mysqli_fetch_array($result);

    $newPoint= $row['point'] + 100; //기존 포인트에 100추가

    //추가된 포인트로 회원정보 수정
    $sql= "UPDATE member SET point=$newPoint WHERE id='$userid'";
    mysqli_query($conn, $sql);
    mysqli_close($conn);

    // 리스트 목록 화면으로 이동
    echo "
        <script>
            location.href='./board_list.php';
        </script>
    ";



?>