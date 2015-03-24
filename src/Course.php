<?php

    class Course {
        private $name;
        private $course_number;
        private $id;

        function __construct($new_name, $new_course_number, $id = null)
        {
            $this->name = $new_name;
            $this->course_number = $new_course_number;
            $this->id = $id;
        }



        //GETTERS AND SETTERS
        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getCourseNumber()
        {
            return $this->course_number;
        }

        function setCourseNumber($new_course_number)
        {
            $this->course_number = $new_course_number;
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
            $statement = $GLOBALS['DB']->query("INSERT INTO courses (name, number) VALUES ('{$this->getName()}', {$this->getCourseNumber()}) RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        function update($new_name)
        {
                $GLOBALS['DB']->exec("UPDATE courses SET name = '{$new_name}';");
                $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM courses_students WHERE course_id = {$this->getId()};");

        }

        function addStudent($student)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses_students (course_id, student_id) VALUES ({$this->getId()}, {$student->getId()} );");
        }

        function getStudents()
        {
            $query = $GLOBALS['DB']->query("SELECT student_id FROM courses_students WHERE course_id = {$this->getId()};");
            $tasks_id = $query->fetchAll(PDO::FETCH_ASSOC);
            $return_students = array();

            foreach ($tasks_id as $id)
            {
                $new_id = $id['student_id'];
                $hello = $GLOBALS['DB']->query("SELECT * FROM students WHERE id = {$new_id};");
                $result = $hello->fetchAll(PDO::FETCH_ASSOC);

                $new_name = $result[0]['name'];
                $new_enrollment = formatDate($result[0]['enrollment']);
                $new_id = $result[0]['id'];
                $new_student = new Student($new_name, $new_enrollment, $new_id);
                array_push ($return_students, $new_student);

            }
            return $return_students;
        }


        static function getAll()
        {
            $rows = $GLOBALS['DB']->query("SELECT * FROM courses;");

            $courses = array();
            foreach($rows as $row)
            {
                $id = $row['id'];
                $name = $row['name'];
                $course_number = $row['number'];
                $new_course = new Course($name, $course_number, $id);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses *;");
        }

        static function find($search_id)
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM courses WHERE id = {$search_id};");
            $found_course = null;

            foreach ($statement as $element)
            {
                $name = $element['name'];
                $course_number = $element['number'];
                $id = $element['id'];
                $found_course = new Course($name, $course_number, $id);
            }
            return $found_course;

        }

    }

 ?>
