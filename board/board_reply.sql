CREATE TABLE board_reply (
    num INTEGER AUTO_INCREMENT PRIMARY KEY,
    board_num INTEGER NOT NULL,
    id VARCHAR(15) NOT NULL,
    name VARCHAR(20) NOT NULL,
    content TEXT,
    regist_day VARCHAR(20),
    FOREIGN KEY (board_num) REFERENCES board(num),
    FOREIGN KEY (id) REFERENCES member(id)
);