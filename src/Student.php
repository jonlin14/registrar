<?php

    //turn the returned date into american format
    function formatDate($new_date)
    {
        $db_date = explode("-", $new_date);

        $formatted_date_array = array($db_date[1], $db_date[2], $db_date[0]);

        return implode("/", $formatted_date_array);
    }

    class Student {
        private $name;
        private $enrollment_date;
        private $id;

        function __construct($new_name, $new_enrollment, $id = null)
        {
            $this->name = $new_name;
            $this->enrollment_date = $new_enrollment;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getEnrollment()
        {
            return $this->enrollment_date;
        }

        //this function requires date to be formatted as follow
        //Ex. YYYY-MM-DD -> 2015-03-22
        function setEnrollment($new_enrollment)
        {
            //format our date to match the database
            $this->enrollment_date = formatDate($new_enrollment);
        }



        function getId()
        {
            return $this->id;
        }

        function setId($new_id)
        {
            $this->id = $new_id;
        }

        //DATABASE METHODS
        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO students (name, enrollment) VALUES ('{$this->getName()}', '{$this->getEnrollment()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);

            //set our enrollment equal to the database version
            $enrollment_db = $GLOBALS['DB']->query("SELECT enrollment FROM students WHERE id = {$this->getId()};");
            $result = $enrollment_db->fetch(PDO::FETCH_ASSOC);
            $this->setEnrollment($result['enrollment']);
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE students SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM students WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM courses_students WHERE student_id = {$this->getId()};");
        }

        function addCourse($new_course)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses_students (course_id, student_id) VALUES ({$new_course->getId()}, {$this->getId()});");
        }

        function getCourses()
        {
            $query = $GLOBALS['DB']->query("SELECT course_id FROM courses_students WHERE student_id = {$this->getId()};");
            $course_id_array = $query->fetchAll(PDO::FETCH_ASSOC);

            $query = $GLOBALS['DB']->query("SELECT courses.* FROM students
                JOIN courses_students ON (students.id = courses_students.student_id)
                JOIN courses ON (courses_students.course_id = courses.id)
                WHERE students.id = {$this->getId()};");

            $course_rows = $query->fetchAll(PDO::FETCH_ASSOC);

            $courses = array();
            foreach($course_rows as $row)
            {
                $id = $row['id'];
                $name = $row['name'];
                $course_number = $row['number'];
                $new_course = new Course($name, $course_number, $id);
                array_push($courses, $new_course);
            }

            return $courses;
        }

        static function find($search_id)
        {
            //query to find the Student
            $query = $GLOBALS['DB']->query("SELECT * FROM students WHERE id = {$search_id};");
            $found_student = null;

            foreach($query as $row)
            {
                $id = $row['id'];
                $name = $row['name'];
                $enrollment = formatDate($row['enrollment']);
                $new_student = new Student($name, $enrollment, $id);
                $found_student = $new_student;
            }
            return $found_student;
        }

        static function nameSearch($search_name)
        {
            $query = $GLOBALS['DB']->query("SELECT id FROM students where name = '{$search_name}';");
            $hello = $query->fetch(PDO::FETCH_ASSOC);
            return Student::find($hello['id']);
        }

        static function enrollmentSearch($search_enrollment)
        {
            $query = $GLOBALS["DB"]->query("SELECT id FROM students WHERE enrollment = '{$search_enrollment}';");
            $results = $query->fetch(PDO::FETCH_ASSOC);
            return Student::find($results['id']);


        }
        static function getAll()
        {
            $rows = $GLOBALS['DB']->query("SELECT * FROM students;");

            $students = array();
            foreach($rows as $row)
            {
                $id = $row['id'];
                $name = $row['name'];
                $enrollment = formatDate($row['enrollment']);
                $new_student = new Student($name, $enrollment, $id);
                array_push($students, $new_student);
            }
            return $students;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM students *;");
        }
    }

 ?>
