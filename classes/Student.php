<?php

class Student
{
    // Expected input for adding a student
    private $student_id;
    private $student_name;
    private $student_surname;
    private $student_age;
    private $student_curriculum;

    /**
     * Student constructor
     * @param $student_id
     * @param $student_name
     * @param $student_surname
     * @param $student_age
     * @param $student_curriculum
     */

    public function __construct($student_id, $student_name, $student_surname, $student_age, $student_curriculum)
    {
        $this->student_id = $student_id;
        $this->student_name = $student_name;
        $this->student_surname = $student_surname;
        $this->student_age = $student_age;
        $this->student_curriculum = $student_curriculum;
    }

    /**
     * @return mixed
     */
    public function toString(){
        $array = array("id"         => $this->student_id,
                       "name"       => $this->student_name,
                       "surname"    => $this->student_surname,
                       "age"        => $this->student_age,
                       "curriculum" => $this->student_curriculum);

        return json_encode($array);
    }

    /**
     * @return mixed
     */
    public function getStudentId()
    {
        return $this->student_id;
    }

    /**
     * @param mixed $student_id
     */
    public function setStudentId($student_id)
    {
        $this->student_id = $student_id;
    }

    /**
     * @return mixed
     */
    public function getStudentName()
    {
        return $this->student_name;
    }

    /**
     * @param mixed $student_name
     */
    public function setStudentName($student_name)
    {
        $this->student_name = $student_name;
    }

    /**
     * @return mixed
     */
    public function getStudentSurname()
    {
        return $this->student_surname;
    }

    /**
     * @param mixed $student_surname
     */
    public function setStudentSurname($student_surname)
    {
        $this->student_surname = $student_surname;
    }

    /**
     * @return mixed
     */
    public function getStudentAge()
    {
        return $this->student_age;
    }

    /**
     * @param mixed $student_age
     */
    public function setStudentAge($student_age)
    {
        $this->student_age = $student_age;
    }

    /**
     * @return mixed
     */
    public function getStudentCurriculum()
    {
        return $this->student_curriculum;
    }

    /**
     * @param mixed $student_curriculum
     */
    public function setStudentCurriculum($student_curriculum)
    {
        $this->student_curriculum = $student_curriculum;
    }
}