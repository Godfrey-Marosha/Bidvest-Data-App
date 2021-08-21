#!php
<?php
include_once 'classes\Student.php';

const ACTION_COMMAND = "action";
const ACTION_ID = "id";

// App operations
const ACTION_INSERT = "add";
const ACTION_EDIT   = "edit";
const ACTION_DELETE = "delete";
const ACTION_SEARCH = "search";

const PROJECT_DIR = "students";

$defaultValues = array(ACTION_COMMAND => "", ACTION_ID => "", ACTION_SEARCH => "");
$givenArguments = getopt("", array(ACTION_COMMAND . ":", ACTION_ID . ":", ACTION_SEARCH . ":"));
$options = array_merge($defaultValues, $givenArguments);

$actionInput = $options[ACTION_COMMAND];
$actionId = $options[ACTION_ID];

/**	Add a new student (--action=add):
* User will be prompted to enter the following:
* Student ID, name, surname, age and curriculum
*/

if ($actionInput == ACTION_INSERT){

    $student_id         = readInput("Enter ID",false);
    $student_name       = readInput("Enter Name",false);
    $student_surname    = readInput("Enter Surname",false);
    $student_age        = readInput("Enter Age",false);
    $student_curriculum = readInput("Enter Curriculum",false);
    
    if (!isValueADigit($student_id) || strlen($student_id) != 7){
        echo "The student number is invalid it must have 7 digits!";
        exit;
    }

    if (!isValueADigit($student_age)){
        echo "The student age must be numeric!";
        exit;
    }

    $student = new Student($student_id, $student_name, $student_surname, $student_age, $student_curriculum);

    add($student);
}

/**	UPDATE: Edit an existing student (--action=edit --id=1234567)
* Student must be identified by student id for editing.
*/
else if ($actionInput == ACTION_EDIT){
    if ($actionId == ""){
        echo "Please provide an ID in order to update!";
    }
    else{
        $student_id = $actionId;

        if (!doesStudentExist($student_id)){
            echo "The Student does not exist. Please use a valid ID or add the student first.";
        }

        $jsonStudent = get($student_id);
        $student = jsonToStudent($jsonStudent);

        echo "Please enter the values you want to update. Leave field blank to keep the previous value. \n";

        $student_name       = readInput("Enter Name[" . $student->getStudentName() . "]",true);
        $student_surname    = readInput("Enter Surname[" . $student->getStudentSurname() . "]",true);
        $student_age        = readInput("Enter Age[" . $student->getStudentAge() . "]",true);
        $student_curriculum = readInput("Enter Curriculum[" . $student->getStudentCurriculum() . "]",true);

        if ($student_age != ""){
            if (!isValueADigit($student_age)){
                echo "The student age must be numeric!";
                exit;
            }
        }

        //echo $student->getStudentAge();

        if (trim($student_name) != "")
            $student->setStudentName($student_name);

        if (trim($student_surname) != "")
            $student->setStudentSurname($student_surname);

        if (trim($student_age) != "")
            $student->setStudentAge($student_age);

        if (trim($student_curriculum) != "")
            $student->setStudentCurriculum($student_curriculum);

        SaveToFile($student->getStudentId(), $student->toString());

        echo "Record updated!";
    }
}