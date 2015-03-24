<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";

    $DB = new PDO('pgsql:host=localhost;dbname=registrar_test');

    class CourseTest extends PHPUnit_Framework_TestCase
    {

        function tearDown()
        {
            Course::deleteAll();
        }


        function test_find()
        {
            //arrange
            $test_course = new Course("Theoretical Phys Ed", 500, 4);

            //act
            $test_course->save();
            $result = Course::find($test_course->getId());

            //assert
            $this->assertEquals($test_course, $result);

        }
        function test_save()
        {
            //arrange
            $test_course = new Course("Databases", 234);

            //act
            $test_course->save();
            $result = Course::getAll();

            //assert
            $this->assertEquals([$test_course], $result);
        }

        function test_getId_database()
        {
            //arrange
            $test_course = new Course("Mathematics", 115);
            $test_course->save();

            //act
            $result = $test_course->getId();

            //assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getName()
        {
            //arrange
            $name = 'History';
            $course_number = 1;
            $test_course = new Course($name, $course_number);

            //actå
            $result = $test_course->getName();

            //assert
            $this->assertEquals('History', $result);
        }

        function test_setName()
        {
            //arrange
            $name = 'History';
            $course_number = 1;
            $test_course = new Course($name, $course_number);
            $new_name = 'Gym';
            //act
            $test_course->setName($new_name);
            $result= $test_course->getName();

            //assert
            $this->assertEquals('Gym', $result);
        }

        function test_getId()
        {
            //arrange
            $test_course = new Course("Math", 104, 1);

            //act
            $result = $test_course->getId();

            //assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //arrange
            $test_course = new Course("Science", 115, 3);

            //act
            $test_course->setId(15);
            $result = $test_course->getId();

            //assert
            $this->assertEquals(15, $result);
        }

        function test_getCourseNumber()
        {
            //arrange
            $test_course = new Course("Discrete Datastructures", 325);

            //act
            $result = $test_course->getCourseNumber();

            //assert
            $this->assertEquals(325, $result);
        }

        function test_setCourseNumber()
        {
            //arrange
            $test_course = new Course("Discrete Datastructures", 325);

            //act
            $test_course->setCourseNumber(425);
            $result = $test_course->getCourseNumber();

            //assert
            $this->assertEquals(425, $result);
        }
    }

 ?>
