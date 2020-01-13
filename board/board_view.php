<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>게시판</title>
        <link rel="stylesheet" href="../css/common.css">
        <link rel="stylesheet" href="../css/board.css">
    </head>
    <body>
        <header>
            <?php include "../lib/header2.php" ?>;
        </header>
        <section>
            <div id="main_content">
                <div id="board_box">
                    <h3>게시판 > 내용보기</h3>
                <?php
                    $num = $_GET['num'];
                    //목록으로 돌아갈 때 필요한 페이지 번호
                    $page= $_GET['page'];

                    include "../lib/dbconn.php";

                    //해당 num의 게시글 필드값들 읽어오기
                    $sql= "SELECT * FROM board WHERE num='$num'";
                    $result= mysqli_query($conn, $sql);

                    $row= mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $id  = $row['id'];
                    $name  = $row['name'];
                    $subject  = $row['subject'];
                    $content  = $row['content'];
                    $regist_day  = $row['regist_day'];
                    $hit  = $row['hit'];
                    $srcName  = $row['file_name']; //원본파일명
                    $fileType  = $row['file_type'];//파일타입
                    $cpyName  = $row['file_copied'];//경로를 제외한 저장된 파일명

                    $content = nl2br($content);

                    //조회수 증가
                    $hit = $hit+1;
                    mysqli_query($conn, "UPDATE board SET hit=$hit WHERE num=$num");
                ?>

                    <!-- 읽어온 값들 화면에 표시 -->
                    <ul id="view_content">
                        <li>
                            <span class="col1"><strong>제목 : </strong><?=$subject?></span>
                            <span class="col2"><?=$name?> | <?=$regist_day?></span>
                        </li>
                        <li>
                            <?php 
                                // 첨부파일이 있다면 관련 표시
                                if($srcName){
                                    //파일사이즈 계산함수 : filesize()
                                    $filePath= "./uploads/".$cpyName;
                                    $fileSize= filesize($filePath);

                                    echo "▷ 첨부파일 : $srcName ($fileSize Byte)&nbsp;&nbsp;&nbsp;&nbsp; 
                                    <a href='./download.php?src_name=$srcName&file_path=$filePath&file_size=$fileSize'>[저장]</a>
                                    <a href='$filePath' target='_blank'>[미리보기]</a>";

                                    echo "<br><br>";

                                }
                            ?>                            
                            <p><?= $content ?></p>                            
                        </li>
                    </ul>

                    <ul class="buttons">
                        <li><button onclick="location.href='./board_list.php?page=<?=$page?>'">목록</button></li>
                        <li><button onclick="location.href='./board_modify_form.php?num=<?=$num?>'">수정</button></li>
                        <li><button onclick="location.href='./board_delete.php?num=<?=$num?>'">삭제</button></li>
                        <li><button onclick="location.href='./board_form.php'">글씨기</button></li>

                    </ul>

                </div>
            </div>
        </section>
        <footer>
         <?php include "../lib/footer.php" ?>;
        </footer>
        
    </body>
</html>