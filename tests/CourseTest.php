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
            Student::deleteAll();
        }

        function test_getStudents()
        {
            $test_course = new Course("Aperture Sciencing", 300, 5);
            $test_course->save();

            $test_student = new Student("Jim Hardy", '12/12/1221');
            $test_student->save();

            $test_student2 = new Student("Tom Payne", '11/11/1111');
            $test_student2->save();

            $test_course->addStudent($test_student);
            $test_course->addStudent($test_student2);

            $this->assertEquals([$test_student, $test_student2], $test_course->getStudents());
        }

        function test_addStudent()
        {
            //arrange
            $test_course = new Course("Dungeon Master-ing", 200, 4);
            $test_course->save();

            $test_student = new Student("Brian Kropff", '01/24/2000', 5);
            $test_student->save();

            //arrange
            $test_course->addStudent($test_student);
            $result = $test_course->getStudents();

            //assert
            $this->assertEquals($test_student, $result[0]);
        }

        function test_deleteStudents()
        {
            //arrange
            $test_course = new Course("Intro to C++", 105);
            $test_course->save();

            $test_student = new Student("Max", "11/11/1111");
            $test_student->save();

            $test_student2 = new Student("Fred", "1/3/2123");
            $test_student2->save();

            //act
            $test_course->addStudent($test_student);
            $test_course->addStudent($test_student2);
            $test_course->delete();

            //assert
            $this->assertEquals([], $test_student->getCourses());
        }

        function test_deleteStudents()
        {
            //arrange
            $test_course = new Course("Intro to C++", 105);
            $test_course->save();

            $test_student = new Student("Max", "11/11/1111");
            $test_student->save();

            $test_student2 = new Student("Fred", "1/3/2123");
            $test_student2->save();

            //act
            $test_course->addStudent($test_student);
            $test_course->addStudent($test_student2);
            $test_course->delete();

            //assert
            $this->assertEquals([], $test_course->getStudents());
        }

        function test_delete()
        {
            //arrange
            $test_course = new Course("Beginner PHP", 100, 2);
            $test_course->save();

            //act
            $test_course->delete();

            //assert
            $this->assertEquals([], Course::getAll());
        }

        function test_updateDatabase()
        {
            //arrange
            $test_course = new Course("Beginner French", 100, 4);
            $new_course_name = "Beginner Spanish";
            $test_course->save();

            $test_course->update($new_course_name);
            $result = Course::getAll();

            $this->assertEquals("Beginner Spanish", $result[0]->getName());

        }
        function test_update()
        {
            //arrange
            $test_course = new Course("Advanced Dungeons and Dragons", 1000, 5);
            $new_course_name = "Intro to Moving";

            //act
            $test_course->update($new_course_name);
            $result = $test_course->getName();

            //assert
            $this->assertEquals("Intro to Moving", $result);
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
