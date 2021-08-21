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
}