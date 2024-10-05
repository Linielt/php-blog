DROP TABLE IF EXISTS post;
CREATE TABLE post (
                      id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
                      title VARCHAR(255) NOT NULL,
                      body TEXT NOT NULL,
                      user_id INTEGER NOT NULL,
                      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
INSERT INTO post
(
    title, body, user_id, created_at
)
VALUES (
           "This is my first post",
           "This is the body of my first post.",
           1,
           '2024-06-06 12:00:00'
       );
INSERT INTO post
(
    title, body, user_id, created_at
)
VALUES (
           "This is my second post",
           "This is the body of my second post.",
           1,
           '2024-03-03 12:00:00'
       );
INSERT INTO post
(
    title, body, user_id, created_at
)
VALUES (
           "This is my third post",
           "This is the body of my third post.",
           1,
           '2024-01-01 12:00:00'
       );

DROP TABLE IF EXISTS comment;

CREATE TABLE comment (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    post_id INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    name VARCHAR(45) NOT NULL,
    website VARCHAR(255) NOT NULL,
    text VARCHAR(500) NOT NULL
);

INSERT INTO comment (post_id, created_at, name, website, text)
VALUES
    (
     1,
     "2024-01-01 12:00:00",
     "John",
     "http://example.com",
     "Hello, I am John!"
    )
;