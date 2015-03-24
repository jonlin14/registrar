<?php

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

        function setEnrollment($new_enrollment)
        {
            $this->enrollment_date = $new_enrollment;
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
