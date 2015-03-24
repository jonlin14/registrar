<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Student.php";

    $DB = new PDO('pgsql:host=localhost;dbname=registrar_test');

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        function test_getName()
        {
            //arrange
            $name = 'Conor';
            $enrollment = 2018;
            $test_student = new Student($name, $enrollment);

            //act
            $result = $test_student->getName();

            //assert
            $this->assertEquals('Conor', $result);
        }

        function test_setName()
        {
            //arrange
            $name = 'Rachel';
            $enrollment = 2020;
            $test_student = new Student($name, $enrollment);
            $new_name = 'Guy';
            //act
            $test_student->setName($new_name);
            $result= $test_student->getName();

            //assert
            $this->assertEquals('Guy', $result);
        }

        function test_getId()
        {
            //arrange
            $test_student = new Student("Isaac", 2019, 1);

            //act
            $result = $test_student->getId();

            //assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //arrange
            $test_student = new Student("Science", 2025, 3);

            //act
            $test_student->setId(15);
            $result = $test_student->getId();

            //assert
            $this->assertEquals(15, $result);
        }

        function test_getEnrollment()
        {
            //arrange
            $test_student = new Student("Discrete Datastructures", 2035);

            //act
            $result = $test_student->getEnrollment();

            //assert
            $this->assertEquals(2035, $result);
        }

        function test_setEnrollment()
        {
            //arrange
            $test_student = new Student("Discrete Datastructures", 2325);

            //act
            $test_student->setEnrollment(2425);
            $result = $test_student->getEnrollment();

            //assert
            $this->assertEquals(2425, $result);
        }
    }

 ?>
