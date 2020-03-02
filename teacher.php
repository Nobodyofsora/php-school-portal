<?php
include_once("abstract.php");
include_once("interface.php");

class Professor extends Degree implements IStorage
{
    use PersonalData;
    public $subjectsTeached = [];
    public static $filePointer;
    public static $mysql;

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
        $s = $this->name . " " . $this->surname . " (" . $this->sex . ") born in " . $this->dateOfBirth;
        if ($this->degree == null) {
            $s .= " has no degree. ";
        } else {
            $s .= " has a $this->degree ( $this->dateOfDegree ) with a score of $this->degreeScore. ";
        }
        if ($this->subjectsTeached == null) {
            $s .= "They passed no subjects. ";
        } else {
            for ($i = 0; $i < count($this->subjectsTeached); $i++) {
                $s .= "They teach " . $this->subjectsTeached[$i]->getSubName() . " (" . $this->subjectsTeached[$i]->getSubHours() . " hours): " . $this->subjectsTeached[$i]->getSubDesc() . ". ";
            }
        }
        return $s;
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
    function save($type = null)
    {
        if ($type == null) {

            $file = "html/ITIS SteveJobs/php-school-portal/TeacherStorage.txt";
            file_put_contents($file, $this->infoCareer() . "\n", FILE_APPEND);
        } else if ($type == "db") {
            connect();
        }
    }
    function read($type = null)
    {
        if ($type == null) {
            $file = file("html/ITIS SteveJobs/php-school-portal/StudentStorage.txt");
            print_r($file[0]);
        } else if ($type == "db") {
            connect();
        }
    }
}
