<!-- message_form.php 와 비슷하게 작성 -->
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
                <div id="board_box">
                    <!-- 1. 제목영역 -->
                    <h3>게시판 > 글쓰기</h3>

                    <!-- 2. 글작성 영역 -->
                    <form action="./board_insert.php" method="post" enctype="multipart/form-data">
                        <ul id="board_form">
                            <li>
                                <span class="col1">이름 : </span>
                                <span class="col2"><?=$username?></span>
                            </li>
                            <li>
                                <span class="col1">제목 : </span>
                                <span class="col2"><input type="text" name="subject"></span>
                            </li>
                            <li id="text_area">
                                <span class="col1">내용 : </span>
                                <span class="col2"><textarea name="content"></textarea></span>
                            </li>
                            <li>
                                <span class="col1">첨부 : </span>
                                <span class="col2"><input type="file" name="attach_file"></span>
                            </li>
                        </ul>
                        <ul class="buttons">
                            <li><input type="submit" value="완료"></li>
                            <li><button type="button" onclick="location.href='./board_list.php'">목록</button></li>
                        </ul>
                    </form>

                </div>
            </div>
        </section>
        <footer>
            <?php include "../lib/footer.php"; ?>
        </footer>
        
    </body>
</html>