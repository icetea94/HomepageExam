<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>쪽지함</title>

        <link rel="stylesheet" href="../css/common.css">
        <link rel="stylesheet" href="../css/message_box.css">
    </head>
    <body>
        <header>
            <?php include "../lib/header2.php"; ?>
        </header>
        <section>
            <div id="main_content">
                <div id="message_box">
                    <h3>
                        <?php 
                            $mode= $_GET['mode'];
                            if( $mode=="send") echo "송신 쪽지함 > 목록보기";
                            else echo "수신 쪽지함 > 목록보기";
                        ?>
                    </h3>

                    <!-- 쪽지 리스트가 보여지는 영역(게시판 모양) -->
                    <div>
                        <ul id="message">
                            <!-- 리스트의 제목줄 -->
                            <li>
                                <span class="col1">번호</span>
                                <span class="col2">제목</span>
                                <span class="col3"><?=($mode=="send")?"받은이":"보낸이"?></span>
                                <span class="col4">등록일</span>
                            </li>

                            <!-- DB에 저장된 데이터들 읽이와서 보여주기 -->
                            <?php

                                include "../lib/dbconn.php";

                                //송신 쪽지함이면 'userid'가 send_id로 저장되어 있는 리스트만 가져오기 : 최신쪽지 순으로.(num 내림차순)
                                if($mode=="send"){
                                    $sql= "SELECT * FROM message WHERE send_id='$userid' ORDER BY num desc";
                                }else{//수신 쪽지함이면 'userid'가 rv_id로 저장되어 있는 리스트만
                                    $sql= "SELECT * FROM message WHERE rv_id='$userid' ORDER BY num desc";
                                }

                                $result= mysqli_query($conn, $sql);
                                //전체 쪽지 수
                                $rowNum= mysqli_num_rows($result);

                                //한페이지안에 모든 쪽지를 리스트로 보여주면 너무 길어서..
                                // 최대 한페이지에 10개까지만 보여지게하고
                                // 리스트의 하단에 페이지네이션 을 표시해서 선택할 수 있도록
                                if( isset($_GET['page']) ) $page= $_GET['page'];
                                else $page=1;

                                // 전체 페이지 수 계산
                                //(1~10: 1page, 11~20:2page, 21~30:3page ..... )
                                if( $rowNum % 10 == 0 ) $total_page= floor($rowNum/10);
                                else $total_page= floor($rowNum/10)+ 1;
                                
                                if($total_page==0) $total_page=1;

                                //현재페이지에서 시작할 쪽지글의 row번호 (num값 아님)
                                $start= ($page -1 ) * 10; 

                                $number=$rowNum-$start;

                                for($i=$start; $i<$start+10 && $i<$rowNum; $i++){

                                    //가져올 레코드의 위치(row 위치) 이동
                                    mysqli_data_seek($result, $i);

                                    $row= mysqli_fetch_array($result, MYSQLI_ASSOC);
                                    $num= $row['num'];
                                    $subject= $row['subject'];
                                    $content= $row['num'];
                                    $msg_id= ($mode=="send")? $row['rv_id']: $row['send_id'];
                                    $regist_day = $row['regist_day'];

                                    //화면에 보여주는 작업 html문법이 더 쉬워서..
                                ?>
                                    <!-- 이 영역은 html영역 -->
                                    <li>
                                        <span class="col1"><?=$number?></span>
                                        <span class="col2"><a href="./message_view.php?mode=<?=$mode?>&num=<?=$num?>"><?=$subject?></a></span>
                                        <span class="col3"><?=$msg_id?></span>
                                        <span class="col4"><?=$regist_day?></span>
                                    </li>
                                <?php
                                    $number--;
                                }
                                mysqli_close($conn);
                                ?>                                                            
                        </ul>
                        <!-- 메지지 출력 END -->

                        <!-- 페이지네이션 (페이지번호 표시) -->
                        <ul id="page_num">
                            <?php
                                if($page!=1){
                                    $newPage= $page-1;
                                    echo "<li><a href='./message_box.php?mode=$mode&page=$newPage'>◀이전</a> </li>";
                                }else{
                                    echo "<li>◀이전 </li>";
                                }

                                //페이지 수만큼 페이지 번호 출력
                                for($i=1; $i<=$total_page; $i++){
                                    if($i==$page) echo "<li><strong> $i </strong></li>";
                                    else echo "<li><a href='./message_box.php?mode=$mode&page=$i'> $i </a></li>";
                                }

                                if($page != $total_page){
                                    $newPage= $page+1;
                                    echo "<li><a href='./message_box.php?mode=$mode&page=$newPage'> 다음▶</a></li>";
                                }else{
                                    echo "<li> 다음▶</li>";
                                }
                            ?>
                        </ul>

                        <!-- 쪽지함 이동 버튼들 -->
                        <ul class="buttons">
                            <li><button onclick="location.href='./message_box.php?mode=rv'">수신 쪽지함</button></li>
                            <li><button onclick="location.href='./message_box.php?mode=send'">송신 쪽지함</button></li>
                            <li><button onclick="location.href='./message_form.php'">쪽지 보내기</button></li>
                        </ul>


                    </div>
                </div>
            </div>
        </section>
        <footer>
            <?php include "../lib/footer.php"; ?>
        </footer>
        
    </body>
</html>