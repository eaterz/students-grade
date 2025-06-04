CREATE DATABASE students_grade;

USE students_grade;

CREATE TABLE user(
    id int primary key auto_increment,
    personal_code varchar(12) NOT NULL,
    password varchar(255) NOT NULL,
    first_name varchar(255) NOT NULL,
    last_name varchar(255) NOT NULL,
    role enum('teacher', 'student') NOT NULL
);

CREATE TABLE subject(
    id int primary key auto_increment,
    subject_name varchar(255) NOT NULL
);


CREATE TABLE grades(
    id int primary key auto_increment,
    user_id int NOT NULL,
    subject_id int NOT NULL,
    grade int NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (subject_id) REFERENCES subject(id),
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Insert data into USER table
INSERT INTO user (personal_code, password, first_name, last_name, role) VALUES
('020491-25234', 'password1', 'John', 'Doe', 'teacher'),
('210685-23126', 'password2', 'Samanta', 'Joe', 'teacher'),
('210685-23127', 'password3', 'Emily', 'Smith', 'student'),
('210685-23128', 'myp@ssw0rd', 'Liam', 'Johnson', 'student'),
('210685-23129', 'pass1234', 'Olivia', 'Williams', 'student'),
('210685-23130', 'student1', 'Noah', 'Brown', 'student'),
('210685-23131', 'qwerty123', 'Emma', 'Jones', 'student'),
('210685-23132', 'letmein', 'Ava', 'Garcia', 'student'),
('210685-23133', 'abc12345', 'Sophia', 'Martinez', 'student'),
('210685-23134', 'iloveschool', 'Isabella', 'Rodriguez', 'student'),
('210685-23135', 'password99', 'Mason', 'Hernandez', 'student'),
('210685-23136', 'login2024', 'James', 'Lopez', 'student'),
('210685-23137', 'school123', 'Benjamin', 'Gonzalez', 'student'),
('210685-23138', 'passme789', 'Charlotte', 'Wilson', 'student'),
('210685-23139', 'securepass', 'Amelia', 'Anderson', 'student'),
('210685-23140', 'zxcvbnm1', 'Evelyn', 'Thomas', 'student'),
('210685-23141', 'testpass', 'Lucas', 'Taylor', 'student');


-- Insert data into CATEGORY table
INSERT INTO subject (subject_name) VALUES
('Mathematics'),
('Science'),
('English'),
('History'),
('Geography');

-- Insert sample grades for specific students in various subjects

INSERT INTO grades (user_id, subject_id, grade) VALUES
    (3, 1, 9),  -- Emily Smith - Mathematics
    (3, 2, 7),  -- Emily Smith - Science
    (4, 1, 8),  -- Liam Johnson - Mathematics
    (4, 3, 6),  -- Liam Johnson - English
    (5, 1, 7),  -- Olivia Williams - Mathematics
    (5, 4, 8),  -- Olivia Williams - History
    (6, 2, 9),  -- Noah Brown - Science
    (6, 3, 7),  -- Noah Brown - English
    (7, 5, 6),  -- Emma Jones - Geography
    (8, 1, 10), -- Ava Garcia - Mathematics
    (9, 2, 5),  -- Sophia Martinez - Science
    (10, 3, 6), -- Isabella Rodriguez - English
    (11, 4, 7), -- Mason Hernandez - History
    (12, 5, 8), -- James Lopez - Geography
    (13, 1, 9), -- Benjamin Gonzalez - Mathematics
    (14, 2, 10),-- Charlotte Wilson - Science
    (15, 3, 7), -- Amelia Anderson - English
    (16, 4, 6); -- Evelyn Thomas - History
    


-- insert in user table profile image column

ALTER TABLE user
    ADD profile_image VARCHAR(255) NULL;





