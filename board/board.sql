CREATE TABLE board (
    num INTEGER AUTO_INCREMENT,
    id VARCHAR(15) NOT NULL,
    name VARCHAR(20) NOT NULL,
    subject VARCHAR(80) NOT NULL,
    content TEXT,
    regist_day VARCHAR(20),
    hit INTEGER,
    file_name VARCHAR(40),
    file_type VARCHAR(40),
    file_copied VARCHAR(40),
    PRIMARY KEY(num),
    -- INDEX(id)
    FOREIGN KEY(id) REFERENCES member(id)
);