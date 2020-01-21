<?php
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
interface IStorage
{
    public function save($type = null);
    public function read($type = null);
}
