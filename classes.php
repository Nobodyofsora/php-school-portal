<?php
const CURRENT_YEAR = 2020;
interface Person
{
    public function getName();
    public function getSurname();
    public function getBirthday();
    public function getSex();
    function setName($x);
    function setSurname($y);
    function setBirthday($z);
    function setSex($w);
    function getAge();
    public function infoCareer();
}
trait PersonalData
{
    protected $name;
    protected $surname;
    protected $dateOfBirth;
    protected $sex;
    function getAge()
    {
        return CURRENT_YEAR - explode("/", $this->dateOfBirth)[2];
    }
    public function getName()
    {
        return $this->name;
    }
    public function getSurname()
    {
        return $this->surname;
    }
    public function getBirthday()
    {
        return $this->dateOfBirth;
    }
    public function getSex()
    {
        return $this->sex;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }
    public function setBirthday($date)
    {
        $this->dateOfBirth = $date;
    }
    public function setSex($sex)
    {
        $this->sex = $sex;
    }
}
abstract class Degree implements Person
{
    private $degree;
    private $dateOfDegree;
    private $degreeScore;
    protected function setDegree($name)
    {
        if (is_string($name)) {
            $this->degree = $name;
        } else return "Error"; //todo
    }
    protected function setDateOfDegree($date)
    {
        $array = explode("/", $date);
        if ($array[0] < 1 || $array[0] > 31 || $array[1] < 1 || $array[1] > 12 || $array[2] < 0 || $array[2] > CURRENT_YEAR)
            $this->dateOfDegree = $date;
        else return "Error"; //todo
    }
    protected function setDegreeScore($score)
    {
        if (is_int($score))
            $this->degreeScore = $score;
        else return "Error"; //todo
    }
    protected function getDegree()
    {
        return $this->degree;
    }
    protected function getDegreeDate()
    {
        return $this->dateOfDegree;
    }
    protected function getDegreeScore()
    {
        return $this->degreeScore;
    }
}
class Student extends Degree
{
    use PersonalData;
    private $subjectsDone = [];

    public function __construct($name, $surname, $date, $sex)
    {
        $this->setName($name);
        $this->setSurname($surname);
        $this->setBirthday($date);
        $this->setSex($sex);
    }

    public function addSubject($name, $hours, $description, $date, $mark)
    {
        $subject = new passedSubject($name, $hours, $description, $date, $mark);
        array_push($this->subjectsDone, $subject);
    }
    public function infoCareer()
    {
        if ($this->degree == null) {
            echo $this->name . " has no degree";
        } else {
            echo $this->name . " has a $this->degree ( $this->dateOfDegree ) with a score of $this->degreeScore";
        }
    }
    public function showMySubjects()
    {
        for ($i = 0; $i < count($this->subjectsDone); $i++) {
            echo "\n" . $this->name . " passed " . $this->subjectsDone[$i]->getSubName() . " on " . $this->subjectsDone[$i]->getSubDate() . " with a score of " . $this->subjectsDone[$i]->getSubGrade();
        }
        echo "\n" . $this->name . " passed " . count($this->subjectsDone) . " subject(/s) in total";
    }
    public function averageOfSubjectsGrades()
    {
        try {
            $average = 0;
            for ($i = 0; $i < count($this->subjectsDone); $i++) {
                $average += $this->subjectsDone[$i]->getSubGrade();
            }
            $average /= count($this->subjectsDone);
            if ($average >= 6 && $average <= 7) throw new Exception(" is between 6 and 7", 1);
            return $average;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
class Professor extends Degree
{
    use PersonalData;
    public $subjectsTeached = [];
    public function __construct($name, $surname, $date, $sex, $subjectsTeached)
    {
        $this->subjectsTeached = $subjectsTeached;
        $this->setName($name);
        $this->setSurname($surname);
        $this->setBirthday($date);
        $this->setSex($sex);
    }
    public function infoCareer()
    {
        return "I have a $this->whichDegree in ";
    }

    public function allTeachedSubj()
    {
        return count($this->subjectsTeached);
    }
    public function subjectDetails()
    {
        for ($i = 0; $i < count($this->subjectsTeached); $i++) {
            echo "\n" . $this->subjectsTeached[$i]->printAll();
        }
    }
}
class Subject
{
    protected $name;
    protected $hours;
    protected $description;
    function __construct($name, $hours, $desc)
    {
        $this->name = $name;
        $this->hours = $hours;
        $this->description = $desc;
    }
    function getSubName()
    {
        return $this->name;
    }
    function getSubHours()
    {
        return $this->hours;
    }
    function getSubDesc()
    {
        return $this->description;
    }
    public function printAll()
    {
        echo "\n$this->name ($this->hours hours):  $this->description\n";
    }
}
class passedSubject extends Subject
{
    protected $date;
    protected $grade;

    function __construct($name, $hours, $description, $date, $result)
    {
        parent::__construct($name, $hours, $description);
        $this->date = $date;
        $this->grade = $result;
    }
    function getSubGrade()
    {
        return $this->grade;
    }
    function getSubDate()
    {
        return $this->date;
    }
}
//students
$manuel = new Student("Manuel", "Amato", "02/05/1996", "male");
$enrico = new Student("Enrico", "Terranova", "15/02/2000", "male");
$davide = new Student("Davide", "Flex", "02/05/1996", "male");
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
$manuel->addSubject($back->getSubName(), $back->getSubHours(), $back->getSubDesc(), "today", 9);
$enrico->addSubject($back->getSubName(), $back->getSubHours(), $back->getSubDesc(), "today", 9);
$davide->addSubject($back->getSubName(), $back->getSubHours(), $back->getSubDesc(), "today", 7);
//numbers of subjects passed by a student

$manuel->showMySubjects();
//avarage of grades
echo "\nAvarage of Grades: " . $davide->averageOfSubjectsGrades();
//number of subjects teached by a teacher
echo "\nNumber of Subjected Teached by " . $leo->getName() . ": " . $leo->allTeachedSubj();
$grasso->subjectDetails();
