<?php

    class Course {
        private $name
        private $course_number;

        function __construct($new_name, $new_course_number)
        {
            $this->name = $new_name;
            $this->course_number = $new_course_number;
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

        
    }

 ?>
