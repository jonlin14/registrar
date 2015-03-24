<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";

    $DB = new PDO('pgsql:host=localhost;dbname=registrar');
    
    class CourseTest extends PHPUnit_Framework_TestCase
    {
        function testSave()
        {

        }
    }

 ?>
