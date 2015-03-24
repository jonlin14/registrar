<?php

    class Course {
        private $name
        private $course_number;
        private $id

        function __construct($new_name, $new_course_number, $id = null)
        {
            $this->name = $new_name;
            $this->course_number = $new_course_number;
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
    }

 ?>
