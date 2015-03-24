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
            Course::deleteAll();
        }

        function test_nameSearch()
        {
            //arrange
            $test_student = new Student('Franklin', "12/01/2010");
            $test_student->save();
            $test_student1 = new Student('Arnold', "12/05/2010");
            $test_student1->save();

            //act
            $result = Student::nameSearch('Franklin');

            //assert
            $this->assertEquals($test_student, $result);
        }

        function test_enrollmentSearch()
        {
            $test_student = new Student('Harold', "01/01/1000");
            $test_student->save();
            $test_student1 = new Student('Tim', "02/02/2000");
            $test_student1->save();

            $result = Student::enrollmentSearch("01/01/1000");

            $this->assertEquals($test_student, $result);

        }
        function test_addCourse()
        {
            //arrange
            $test_student = new Student("Brian", "12/12/5433");
            $test_student->save();

            $test_course = new Course("Min Maxing", 300);
            $test_course->save();

            //act
            $test_student->addCourse($test_course);
            $result = $test_student->getCourses();

            //assert
            $this->assertEquals($test_course, $result[0]);
        }

        function test_getCourse()
        {
            //arrange
            $test_student = new Student("Brian", "12/12/5433");
            $test_student->save();

            $test_course = new Course("Min Maxing", 300);
            $test_course->save();

            $test_course2 = new Course("Early English Literature", 250);
            $test_course2->save();

            //act
            $test_student->addCourse($test_course);
            $test_student->addCourse($test_course2);
            $result = $test_student->getCourses();

            //assert
            $this->assertEquals([$test_course,$test_course2], $result);
        }

        function test_deleteStudentCourses()
        {
            //arrange
            $test_student = new Student("Jonathan", "5/1/2014");
            $test_student->save();

            $test_course = new Course("Modern Flaming", 345);
            $test_course->save();

            $test_student->addCourse($test_course);

            //act
            $test_student->delete();
            $result = $test_course->getStudents();

            //assert
            $this->assertEquals([], $result);
        }

        function test_deleteStudent()
        {
            //arrange
            $test_student = new Student("Jonathan", "5/1/2014");
            $test_student->save();

            $test_course = new Course("Modern Flaming", 345);
            $test_course->save();

            $test_student->addCourse($test_course);

            //act
            $test_student->delete();
            $result = $test_student->getCourses();

            //assert
            $this->assertEquals([], $result);
        }

        function test_delete()
        {
            //arrange
            $test_student = new Student("Jonathan", "5/1/2014");
            $test_student->save();

            //act
            $test_student->delete();
            $result = Student::getAll();

            //assert
            $this->assertEquals([], $result);
        }

        function test_updateDatabase()
        {
            //arrange
            $test_student = new Student("Robert", "4/1/2111");
            $test_student->save();

            //act
            $test_student->update("Bob");
            $result = Student::find($test_student->getId());

            //assert
            $this->assertEquals("Bob", $result->getName());
        }

        function test_update()
        {
            //arrange
            $test_student = new Student("Daniel", "4/1/2111");
            $test_student->save();

            //act
            $test_student->update("Dan");

            //assert
            $this->assertEquals("Dan", $test_student->getName());
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
            $result = $test_student->getName();

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
