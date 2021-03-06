<?php
include_once("interface.php");
include_once("abstract.php");

class Student extends Degree implements IStorage
{
    use PersonalData;
    private $subjectsDone = [];
    public static $filePointer;
    public static $mysql;

    private function __construct($name, $surname, $date, $sex)
    {
        $this->setName($name);
        $this->setSurname($surname);
        $this->setBirthday($date);
        $this->setSex($sex);
    }
    public static function constructByFile($filename)
    {
        $student = explode(" ", file($filename)[0]);
        $name = $student[0];
        $surname = $student[1];
        $sex = $student[2];
        $date = $student[3];

        return new static($name, $surname, $date, $sex);
    }

    public static function defaultConstruct($name, $surname, $date, $sex)
    {
        return new static($name, $surname, $date, $sex);
    }

    public function addSubject($name, $hours, $description, $date, $mark)
    {
        $subject = new passedSubject($name, $hours, $description, $date, $mark);
        array_push($this->subjectsDone, $subject);
    }
    public function infoCareer()
    {
        $s = $this->name . " " . $this->surname . " " . $this->sex . " " . $this->dateOfBirth;
        if ($this->degree == null) {
            $s .= " has no degree. ";
        } else {
            $s .= " has a $this->degree ( $this->dateOfDegree ) with a score of $this->degreeScore. ";
        }
        if ($this->subjectsDone == null) {
            $s .= "They passed no subjects. ";
        } else {
            for ($i = 0; $i < count($this->subjectsDone); $i++) {
                $s .= "They passed " . $this->subjectsDone[$i]->getSubName() . " ( " . $this->subjectsDone[$i]->getSubDate() . ") with a score of " . $this->subjectsDone[$i]->getSubGrade() . ". ";
            }
        }
        return $s;
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
    function save($type = null)
    {
        if ($type == null) {

            $file = "html/ITIS SteveJobs/php-school-portal/StudentStorage.txt";
            file_put_contents($file, $this->infoCareer() . "\n", FILE_APPEND);
        } else if ($type == "db") {
            connect();
            $rowToAdd = array(
                "id" => null,
                "name" => $this->getName(),
                "surname" => $this->getSurname(),
                "birthday" => $this->getBirthday(),
                "age" => $this->getAge()
            );
            $student = insertRecords("Students", $rowToAdd);
            if ($this->subjectsDone->count != 0) {
                $student->fetch_assoc();
                foreach ($this->subjectsDone as $value) {
                    $rowToAdd = array(
                        "Student_id" => $student["id"],
                        "name" => $value->name,
                        "result" => $value->grade,
                        "date" => $value->date
                    );
                    $subject = insertRecords("Subjects", $rowToAdd);
                }
            }
        }
    }
    function read($type = null)
    {
        if ($type == null) {
            $file = file("html/ITIS SteveJobs/php-school-portal/StudentStorage.txt");
            print_r($file[0]);
        } else if ($type == "db") {
            $arrayFilter = array(
                "name" => $this->getName(),
                "surname" => $this->getSurname(),
                "birthday" => $this->getBirthday()
            );
            return selectAll("Students", $arrayFilter);
        }
    }
}
