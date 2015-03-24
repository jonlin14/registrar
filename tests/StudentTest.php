<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Student.php";

    $DB = new PDO('pgsql:host=localhost;dbname=registrar_test');

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        function tearDown()
        {
            Student::deleteAll();
        }

        function test_find()
        {
            //arrange
            $test_student = new Student("Ben", "5/30/2015");
            $test_student->save();

            //act
            $result = Student::find($test_student->getId());

            //assert
            $this->assertEquals($test_student, $result);
        }

        function test_save()
        {
            //arrange
            $test_student = new Student("Sean", "1/20/2015");

            //act
            $test_student->save();
            $result = Student::getAll();

            //assert
            $this->assertEquals([$test_student], $result);
        }

        function test_formatDate_date()
        {
            //arrange
            $date = "2015-01-20";
            $test_student = new Student("Mark", $date);

            //act
            $result = formatDate($date);

            //assert
            $this->assertEquals("01/20/2015", $result);
        }

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
            $test_student = new Student("Kyle", 2025, 3);

            //act
            $test_student->setId(15);
            $result = $test_student->getId();

            //assert
            $this->assertEquals(15, $result);
        }

        function test_getEnrollment()
        {
            //arrange
            $test_student = new Student("Rick", "01/01/2035");
            $test_student->save();

            //act
            $result = $test_student->getEnrollment();

            //assert
            $this->assertEquals("01/01/2035", $result);
        }

        function test_setEnrollment()
        {
            //arrange
            $test_student = new Student("Marley", '1/1/2325');
            $test_student->save();

            //act
            $test_student->setEnrollment('2014-01-30');
            $result = $test_student->getEnrollment();

            //assert
            $this->assertEquals('01/30/2014', $result);
        }
    }

 ?>
