<?php
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
