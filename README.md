# CSJeopardy

//Tables 

CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    passcode VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
);

CREATE TABLE leaderboard (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    wins INT(10) NOT NULL
);

CREATE TABLE question (
    qid INT(100) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    qname VARCHAR(255) NOT NULL UNIQUE,
    topicid INT(10) NOT NULL,
    lvlofdifficulty INT(5) NOT NULL,
    answerid INT(100) NOT NULL
);

CREATE TABLE topic (
    topicid INT(10) NOT NULL PRIMARY KEY,
    tname INT(50) NOT NULL
);

CREATE TABLE answer (
    answerid INT(100) NOT NULL PRIMARY KEY,
    aname VARCHAR(255) NOT NULL UNIQUE
);


//Triggers

CREATE TRIGGER `userTrigger` AFTER INSERT ON `users`
FOR EACH ROW insert into leaderboard(username) values (new.username)


//For the questions table add these alterations

ALTER TABLE `question` ADD CONSTRAINT `topic` FOREIGN KEY (`topicid`) REFERENCES `topic`(`topicid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `question` ADD CONSTRAINT `answer` FOREIGN KEY (`answerid`) REFERENCES `answer`(`answerid`) ON DELETE CASCADE ON UPDATE CASCADE;
