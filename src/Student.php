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
        //Ex. YYYY-MM-DD - 2015-03-22
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
