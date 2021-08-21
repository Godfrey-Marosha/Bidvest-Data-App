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
     * Student constructor.
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

    public function getStudentId()
    {
    }

    public function setStudentId()
    {
    }

    public function getStudentName()
    {
    }

    public function setStudentName()
    {
    }

    public function getStudentSurname()
    {
    }

    public function setStudentSurname()
    {
    }

    public function getStudentAge()
    {
    }

    public function setStudentAge()
    {
    }

    public function getStudentCurriculum()
    {
    }

    public function setStudentCurriculum()
    {
    }
}