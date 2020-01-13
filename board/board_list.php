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
        <?php include "../lib/header2.php"; ?>
    </header>
    <section>
        <div id="main_content">
            <!-- messge_box.php와 비슷하게 제작 : 크게 4개영역-->
            <div id="board_box">
                <!-- 1. 제목 영역 -->
                <h3>게시판 > 목록보기</h3>

                <!-- 2. 리스트 영역 -->
                <ul id="board_list">
                    <!-- 2.1 제목줄 :  .col 클래스속성을 이용해서 컬룸(칸)에 대한 스타일링 -->
                    <li>
                        <span class="col1">번호</span>
                        <span class="col2">제목</span>
                        <span class="col3">글쓴이</span>
                        <span class="col4">첨부</span>
                        <span class="col5">등록일</span>
                        <span class="col6">조회</span>
                    </li>

                    <!-- 2.2 게시글들 영역 : DB에서 읽어와서 표시 -->
                    <?php 
                        include "../lib/dbconn.php";

                        //최신글 순(num칸을 내림차순)으로 보여주도록 쿼리문 작성
                        $sql= "SELECT * FROM board ORDER BY num desc";
                        $result= mysqli_query($conn, $sql);

                        // 전체 게시글 수
                        $rowNum= mysqli_num_rows($result);

                        // 한페이지에 10개씩 보여줄 것임
                        // 현재 보열줄 페이지 번호
                        if( isset($_GET['page']) ) $page= $_GET['page'];
                        else $page= 1;

                        // 전체 페이지 수 계산
                        if( $rowNum % 10 ==0 ) $totalPage= floor($rowNum/10);
                        else $totalPage= floor($rowNum/10)+1;

                        if($totalPage==0) $totalPage=1;

                        //현재 페이지의 시작 레코드 row번호(num 번호 아님)
                        $start= ($page-1) * 10;

                        for($i=$start; $i<$start+10 && $i<$rowNum; $i++){
                            //해당하는 row 위치로 커서 이동
                            mysqli_data_seek($result, $i);

                            //이동한 위치의 레코드를 연관배열로 읽어오기
                            $row= mysqli_fetch_array($result, MYSQLI_ASSOC);
                            //읽어온 하나의 레코드 필드값들 가져오기
                            $num = $row['num'];
                            $id = $row['id'];
                            $name = $row['name'];
                            $subject = $row['subject'];
                            $regist_day = $row['regist_day'];
                            $hit = $row['hit'];

                            if($row['file_name']) $file_image="<img src='../img/file.gif'>";
                            else $file_image="";
                    ?>

                            <!-- html문법으로 화면에 필드값들 출력 -->
                            <li>
                                <span class="col1"><?=$num?></span>
                                <span class="col2"><a href="./board_view.php?num=<?=$num?>&page=<?=$page?>"><?=$subject?></a></span>
                                <span class="col3"><?=$name?></span>
                                <span class="col4"><?=$file_image?></span>
                                <span class="col5"><?=$regist_day?></span>
                                <span class="col6"><?=$hit?></span>
                            </li>
                    <?php
                        }

                        mysqli_close($conn);
                    ?>
                </ul>

                <!-- 3. 페이지네이션 -->
                <ul id="page_num">
                    <?php
                        if($page!=1){
                            $newPage= $page-1;
                            echo "<li><a href='./board_list.php?page=$newPage'>◀이전</a> </li>";
                        }else{
                            echo "<li>◀이전 </li>";
                        }

                                //페이지 수만큼 페이지 번호 출력
                                for($i=1; $i<=$totalPage; $i++){
                                    if($i==$page) echo "<li><strong> $i </strong></li>";
                                    else echo "<li><a href='./board_list.php?page=$i'> $i </a></li>";
                                }

                                if($page != $totalPage){
                                    $newPage= $page+1;
                                    echo "<li><a href='./board_list.php?page=$newPage'> 다음▶</a></li>";
                                }else{
                                    echo "<li> 다음▶</li>";
                                }
                            ?>   
                        
                </ul>

                <!-- 4. 버튼들 -->
                <ul class="buttons">
                    <li><button onclick="location.href='./board_list.php'">첫페이지로</button></li>
                    <li>
                <?php if($userid){ ?>
                    <li><button onclick="location.href='./board_form.php'">글쓰기</button></li>                     
                <?php }else{ ?>
                    <li><button onclick="alert('로그인 후 이용해 주세요')">글쓰기</button></li>                     
                <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <footer>
        <?php include "../lib/footer.php"; ?>
    </footer>    
</body>
</html>