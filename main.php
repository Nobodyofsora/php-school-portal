<?php
const CURRENT_YEAR = 2020;
include_once("subject.php");
include_once("student.php");
include_once("teacher.php");

// class filePointer
// {

//     private static $filePointer;
//     private static $_instance = null;

//     private function __construct()
//     {
//     }

//     public static function getInstance()
//     {
//         if (self::$_instance == null)
//             self::$_instance = new filePointer();
//         return self::$_instance;
//     }
// }

//students
$manuel = Student::constructByFile("html/ITIS SteveJobs/php-school-portal/StudentStorage.txt");
$enrico = Student::defaultConstruct("Enrico", "Terranova", "15/02/2000", "male");
$davide = Student::defaultConstruct("Davide", "Flex", "02/05/1994", "male");
echo $manuel->infoCareer();
//subjects
$php = new Subject("PHP", 130, "Developing an PHP page");
$back = new Subject("Back-End", 100, "Developing a Back-End Server");
$front = new Subject("Front-End", 80, "Developing a Front-End Client");
$nonNative = new Subject("Mobile: Non Native", 40, "Developing a Non-Native Application");
$english = new Subject("English", 70, "Learning work-oriented basic english");
//teachers
$leo = new Professor("Carlo", "Leonardi", "00/00/000", "male", [$back]);
$cruz = new Professor("Vivian", "De la Cruz", "00/00/000", "female", [$english]);
$grasso = new Professor("Giuseppe", "Grasso", "00/00/000", "male", [$php]);
$leo->subjectsTeached[0]->printAll();
//subjects passed in each student
$manuel->addSubject($back->getSubName(), $back->getSubHours(), $back->getSubDesc(), "20/01/2020", 9);
$enrico->addSubject($back->getSubName(), $back->getSubHours(), $back->getSubDesc(), "20/01/2020", 8);
$davide->addSubject($back->getSubName(), $back->getSubHours(), $back->getSubDesc(), "20/01/2020", 7);
//numbers of subjects passed by a student

$manuel->showMySubjects();
//avarage of grades
echo "\nAvarage of Grades: " . $davide->averageOfSubjectsGrades();
//number of subjects teached by a teacher
echo "\nNumber of Subjected Teached by " . $leo->getName() . ": " . $leo->allTeachedSubj();
$grasso->subjectDetails();

$manuel->read();
