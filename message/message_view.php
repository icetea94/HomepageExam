<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>쪽지 보기</title>

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/message_view.css">
</head>
<body>
    <header>
        <?php include "../lib/header2.php"; ?>
    </header>
    <section>
        <div id="main_content">
            <div id="message_box">
                <!-- 1. 제목 -->
                <h3>
                    <?php $mode= $_GET['mode'];?>
                    <?=($mode=="send")?"송신 쪽지함 > 내용보기":"수신 쪽지함 > 내용보기"?>
                </h3>

                <?php
                    //내용을 표시할 num 쪽지번호의 내용 읽어오기
                    $num= $_GET['num'];

                    include "../lib/dbconn.php";

                    //해당번호의 쪽지 레코드 읽어오기
                    $sql= "SELECT * FROM message WHERE num=$num";
                    $result= mysqli_query($conn, $sql);

                    //쿼리결과에서 한줄 데이터를 연관배열로 읽어오기
                    $row= mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $send_id= $row['send_id'];
                    $rv_id= $row['rv_id'];
                    $regist_day= $row['regist_day'];
                    $subject= $row['subject'];
                    $content= $row['content'];

                    // $content는 줄바꿈 \n이 있을 수 있어서
                    $content= str_replace("\n","<br>", $content);
                    $content= str_replace(" ","&nbsp;", $content);

                    $msg_id= ($mode=="send")? $rv_id : $send_id;
                ?>

                <!-- 2. 쪽지내용 -->
                <ul id="view_content">
                    <!-- 2.1 제목/상대방id/등록일 표시 줄 -->
                    <li>
                        <span class="col1"><strong>제목 : </strong> <?=$subject?></span>
                        <span class="col2"><?=$msg_id?> | <?=$regist_day?></span>
                    </li>
                    <!-- 2.2 내용 표시 -->
                    <li>
                        <?= $content ?>
                    </li>
                </ul>

                <!-- 3. 버튼들 -->
                <ul class="buttons">
                    <li><button onclick="location.href='./message_box.php?mode=rv'">수신 쪽지함</button></li>
                    <li><button onclick="location.href='./message_box.php?mode=send'">송신 쪽지함</button></li>

                    <!-- 답변 쪽지 작성 페이지로 이동[답변할 쪽지번호 전달] -->
                    <li><button onclick="location.href='./message_response_form.php?num=<?=$num?>'">답변 쪽지</button></li>

                    <!-- 쪽지 삭제 페이지 이동[삭제할 쪽지번호 전달, 삭제후 쪽지함페이지로 돌아올때 송신/수신 모드 결정하기 위해 $mode전달] -->
                    <li><button onclick="location.href='./message_delete.php?num=<?=$num?>&mode=<?=$mode?>'">삭제</button></li>
                </ul>
            </div>
        </div>
    </section>
    <footer>
        <?php include "../lib/footer.php"; ?>
    </footer>
    
</body>
</html>