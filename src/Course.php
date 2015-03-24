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
