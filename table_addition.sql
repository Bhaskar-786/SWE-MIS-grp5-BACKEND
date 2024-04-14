CREATE INDEX idx_departments_id ON departments(id);

CREATE INDEX idx_faculties_id ON faculties(id);


-- table for courses
CREATE TABLE courses (
    id VARCHAR(11) PRIMARY KEY,
    course_code VARCHAR(50),
    name VARCHAR(100),
    dept_id VARCHAR(11),
    faculty_id VARCHAR(11),
    FOREIGN KEY (dept_id) REFERENCES departments(id),
    FOREIGN KEY (faculty_id) REFERENCES faculties(id)
);

-- table for faculties
CREATE TABLE faculties (
    id INT PRIMARY KEY,
    name VARCHAR(100)
);


CREATE TABLE grades (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id VARCHAR(11),
    session_year_id INT,
    session_id INT,
    SGPA DECIMAL(4, 2),
    CGPA DECIMAL(4, 2),
);


ALTER TABLE grades
    ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users(id),
    ADD CONSTRAINT fk_session_year_id FOREIGN KEY (session_year_id) REFERENCES mis_session_year(id),
    ADD CONSTRAINT fk_session_id FOREIGN KEY (session_id) REFERENCES mis_session(id);

