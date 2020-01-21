<?php
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
