        <!-- 메인 이미지 영역 -->
        <div id="main_img_bar" style="background-color: #000000;" >
            <img src="./img/main_img2.jpg" style="width:1000px; height:180px;">
        </div>
        <!-- 이미지 아래 최신게시글 표시 영역 -->
        <div id="main_content">
            <!-- 1. 최신게시글 목록 -->
            <article id="latest">
                <h4>최신 게시글</h4>
                <ul>
                <!-- 최근 게시 글 DB에서 불러오기 -->
                    <?php
                        $conn= mysqli_connect('localhost', 'devshyeon', '1234', 'hp_db');
                        $sql = "select * from board order by num desc limit 5";
                        $result = mysqli_query($conn, $sql);

                        if (!$result)
                            echo "게시판 DB 테이블(board)이 생성 전이거나 아직 게시글이 없습니다!";
                        else
                        {
                            while( $row = mysqli_fetch_array($result) )
                            {
                                $regist_day = substr($row["regist_day"], 0, 10);
                    ?>
                                    <li style="margin-left:12px;">
                                        <span style="float:left; margint-left:10px;"><?=$row["subject"]?></span>
                                        <span style="margin-left:280px;"><?=$row["name"]?></span>
                                        <span style="float:right;margin-right:15px;"><?=$regist_day?></span>
                                    </li>
                    <?php
                            }
                        }
                    ?>
                </ul>
            </article>

            <!-- 2. 포인트 랭킹 목록 -->
            <article id="point_rank">
                <h4>포인트 랭킹</h4>
                <ul>
                    <?php
                        $rank = 1;
                        $sql = "select * from member order by point desc limit 5";
                        $result = mysqli_query($conn, $sql);

                        if (!$result)
                            echo "회원 DB 테이블(members)이 생성 전이거나 아직 가입된 회원이 없습니다!";
                        else
                        {
                            while( $row = mysqli_fetch_array($result) )
                            {
                                $name  = $row["name"];        
                                $id    = $row["id"];
                                $point = $row["point"];
                                $name = mb_substr($name, 0, 1)." * ".mb_substr($name, 2, 1);
                    ?>
                                   <li style="margin-left:12px;">
                                        <span style="width:100px;margint-left:10px;"><?=$rank?></span>
                                        <span style="width:100px;">&emsp;&emsp;&emsp;&emsp;&emsp;<?=$name?></span>
                                        <span style="width:100px;float:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$id?></span>
                                        <span style="float:right;margin-right:12px;"><?=$point?></span>
                                    </li>
                    <?php
                                $rank++;
                            }
                        }

                        mysqli_close($conn);
                    ?>
                </ul>
            </article>
        </div>