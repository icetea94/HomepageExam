<!-- 쪽지 보내기페이지 message_form.php와 거의 흡사함 -->
<!-- 그래서 복사해와서 수정!! -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>답변 쪽지</title>

        <!-- 공통스타일 연결 -->
        <link rel="stylesheet" href="../css/common.css">
        <!-- 쪽지작성 페이지의 전용 스타일 -->
        <link rel="stylesheet" href="../css/message.css">
    </head>
    <body>
        <header>
            <?php include "../lib/header2.php" ?>
        </header>
        <section>
            <div id="main_content">
                <div id="message_box">
                    <h3 id="write_title">답변 쪽지 보내기</h3>

                    <!-- message_insert.php를 통해 DB의 message테이블에 저장 : 송신id는 get방식으로-->
                    <form action="./message_insert.php?send_id=<?=$userid?>" method="post" name="message_form">

                        <!-- 답변쪽지 화면에는 답변할 쪽지의 내용이 이미 표시되어 있음 -->
                        <!-- 그래서 답변할 쪽지의 내용을 message테이블에서 읽어오기 -->
                        <?php
                            // 답변할 쪽지 번호
                            $num= $_GET['num'];

                            include "../lib/dbconn.php";

                            $sql= "SELECT * FROM message WHERE num=$num";
                            $result= mysqli_query($conn, $sql);

                            // 결과표에서 해당 데이터 레코드 배열로 읽어오기
                            $row= mysqli_fetch_array($result, MYSQLI_ASSOC);
                            $send_id = $row['send_id'];
                            $rv_id = $row['rv_id'];
                            $subject = $row['subject'];
                            $content = $row['content'];

                            //답변쪽지의 제목에 RE: 글자가 추가되어 표시되도록
                            $subject= "RE: ".$subject;

                            // 보낸글과 내가 작성하는 글을 구별하기 위해
                            // 보낸글의 앞에 > 표시 추가 및 줄바꿀때 마다 > 추가
                            $content= ">".$content;
                            $content= str_replace("\n","\n>", $content);

                            // 구분선 ------------------
                            $content= "\n\n\n-----------------------\n".$content;

                            mysqli_close($conn);
                        ?>

                        <div id="write_msg">
                            <ul>
                                <li>
                                    <span class="col1">보내는 사람 : </span>
                                    <span class="col2"><?=$userid?></span>
                                </li>
                                <li>
                                    <span class="col1">수신 아이디 : </span>
                                    <span class="col2"><?=$send_id?></span>
                                    <!-- 수신 id값을 input요소를 이용하지 않기 때문에 post로 전달되지 않음. 그래서 보이지는 안지만 form에 의해 자동 전송되는 type="hidden"사용 -->
                                    <input type="hidden" name="rv_id" value="<?=$send_id?>">
                                </li>
                                <li>
                                    <span class="col1">제목 : </span>
                                    <span class="col2"><input type="text" name="subject" value="<?=$subject?>"></span>
                                </li>
                                <li id="textarea">
                                    <span class="col1">내용 : </span>
                                    <span class="col2"><textarea name="content"><?=$content?></textarea></span>
                                </li>                                
                            </ul>
                            <!-- 서밋버튼 -->
                            <input type="submit" value="보내기">
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <footer>
            <?php include "../lib/footer.php" ?>;
        </footer>
        
    </body>
</html>