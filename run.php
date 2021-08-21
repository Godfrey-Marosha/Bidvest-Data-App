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
                echo "The student age must be numeric.";
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

        echo "Record updated.";
    }
}

/**	Delete an existing student (--action=delete --id=1234567):
* Student must be identified by student id for editing.
*/
else if ($actionInput == ACTION_DELETE) {
    if ($actionId == "") {
        echo "Please provide an ID in order to delete.";
    } else {
        $student_id = $actionId;

        if (!doesStudentExist($student_id)) {
            echo "The Student does not exist. Please use a valid ID or add the student first.";
        }
        else{
            $status = delete($student_id);

            if ($status){
                echo "The student was deleted successfully.";
            }
            else{
                echo "The student could not be deleted.";
            }
        }
    }
}

/**	Search for a student (--action=search):
* User will be prompted for the search criteria.
*/
else if ($actionInput == ACTION_SEARCH) {
    $students = getAll();

    $searchValue = readInput("Enter search criteria: ",true);

    // $searchValue = "name=Godfrey";

    if (strpos($searchValue,"name=") >= 0){
        $searchValue = getSearchCriteria($searchValue,"name=");
        $searchCriteria = "name";
    }
    else if (strpos($searchValue,"id=") >= 0){
        $searchValue = getSearchCriteria($searchValue,"id=");
        $searchCriteria = "id";
    }
    else if (strpos($searchValue,"surname=") >= 0){
        $searchValue = getSearchCriteria($searchValue,"surname=");
        $searchCriteria = "surname";
    }
    else if (strpos($searchValue,"curriculum=") >= 0){
        $searchValue = getSearchCriteria($searchValue,"curriculum=");
        $searchCriteria = "curriculum";
    }

    // Expected search input and output:
    echo "---------------------------------------------------------------------------------------------------\n";
    echo "|     ID     |      Name     |     Surname     |        Age        |          Curriculum          |\n";
    echo "---------------------------------------------------------------------------------------------------\n";

    if (sizeof($students) == 0){
        echo "No data found!";
    }

    $isFound = false;

    foreach ($students as $student){

        if (isSearchFound($searchCriteria,$searchValue,$student) || $searchValue == ""){
            echo "|" . $student->getStudentId()
                . "\t|\t" . $student->getStudentName()
                . "\t|\t" . $student->getStudentSurname()
                . "\t|\t" . $student->getStudentAge()
                . "\t|\t" . $student->getStudentCurriculum()
                . "|\n";
            $isFound = true;
        }
    }

    if (!$isFound){
        echo "|                  No data found!\n";
    }

    echo "---------------------------------------------------------------------------------------------------";
    //var_dump($students);
}
else{
    echo "Hi! Please provide an action.";
}

function isSearchFound($searchCriteria, $searchKey, $student){

    echo $searchKey . "\n";
    if ($searchCriteria = "name"){
        if ($searchKey == $student->getStudentName()){
            return true;
        }
    }
    else if ($searchCriteria = "surname"){
        if ($searchKey == $student->getStudentSurname()){
            return true;
        }
    }
    else if ($searchCriteria = "id"){
        if ($searchKey == $student->getStudentId()){
            return true;
        }
    }
    else if ($searchCriteria = "curriculum"){
        if ($searchKey == $student->getStudentCurriculum()){
            return true;
        }
    }

    return false;
}

//Extracts a search value from the search criteria.
function getSearchCriteria($searchValue, $searchCriteria){
    echo  $searchValue . "\n";
    echo  $searchCriteria . "\n";
    if (strpos($searchValue,$searchCriteria) >= 0){
        return str_replace($searchCriteria,"", $searchValue);
    }
}

/**	Fetches all DIR then inner files then JSON files
* and extract JSON into Student class.
*/
function getAll(){
    $dirArr = array();

    $finalDir = getCurrentDirectory() . "\\" . PROJECT_DIR;
    if (!file_exists($finalDir)){
        return null;
    }
    else{
        $dir = new DirectoryIterator($finalDir);
        foreach ($dir as $fileinfo) {
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                $recDir = $fileinfo->getPathName();

                $files = scandir($recDir);

                foreach ($files as $file) {
                    if (strpos($file,".json")){
                        $file = $recDir . "\\" . $file;
                        array_push($dirArr,$file);
                    }
                }
            }
        }
    }

    $students = array();

    if (sizeof($dirArr) > 0){
        foreach ($dirArr as $file){
            array_push($students,jsonToStudent(getFile($file)));
        }
    }

    if (sizeof($students) > 0){
        return $students;
    }
    else{
        return false;
    }
}

function jsonToStudent($jsonStr){
    $jsonObject = json_decode($jsonStr, true);

    $student = new Student($jsonObject['id'], $jsonObject['name'], $jsonObject['surname'], $jsonObject['age'], $jsonObject['curriculum']);

    return $student;
}

function delete($student_id){
    $finalDir    =  getCurrentDirectory() . "\\" . PROJECT_DIR;
    $studentDir  =  $finalDir . "\\" . substr($student_id,0,2);

    $dir = $studentDir;

    $studentDir .= "\\" . $student_id . ".json";

    $status = false;

    if (!unlink($studentDir)) {
    }
    else {
        $status = true;
    }

    return $status && rmdir($dir);
}

function getFile($studentDir){

    if (file_exists($studentDir)){
        $tempFile = fopen($studentDir, "r") or die("Unable to open file.");
        $record = fread($tempFile,filesize($studentDir));
        fclose($tempFile);

        return $record;
    }

    return "";
}

function get($student_id){
    $finalDir    =  getCurrentDirectory() . "\\" . PROJECT_DIR;
    $studentDir  =  $finalDir . "\\" . substr($student_id,0,2);
    $studentDir .= "\\" . $student_id . ".json";

    if (file_exists($studentDir)){
        $tempFile = fopen($studentDir, "r") or die("Unable to open file.");
        $record = fread($tempFile,filesize($studentDir));
        fclose($tempFile);

        return $record;
    }

    return "";
}

function add($student){
    $jsonObject = $student->toString();

    return SaveToFile($student->getStudentId(), $jsonObject);
}

function doesStudentExist($filename){
    $finalDir    =  getCurrentDirectory() . "\\" . PROJECT_DIR;
    $studentDir  =  $finalDir . "\\" . substr($filename,0,2);
    $studentDir .= "\\" . $filename . ".json";

    if (file_exists($studentDir)){
        return true;
    }

    return false;
}

function SaveToFile($file_name, $contents){
    $finalDir =  getCurrentDirectory() . "\\" . PROJECT_DIR;

    $studentDir = $finalDir . "\\" . substr($file_name,0,2);

    if (!file_exists($studentDir)){
        mkdir($studentDir, 0777, true);
    }

    $studentDir .= "\\" . $file_name . ".json";

    $myfile = fopen($studentDir, "w") or die("Unable to open file.");

    fwrite($myfile, $contents);

    fclose($myfile);

    return true;
}

function getCurrentDirectory() {
    $path = dirname($_SERVER['PHP_SELF']);
    $position = strrpos($path,'/');
    return substr($path,$position);
}

/** Student IDs must be unique and consist of 7 digits.
 * Because tudent must be identified by student ID for editing.
 */
function isValueADigit($studentId){
    $arr = str_split($studentId, 1);

    foreach ($arr as $arr_digit){
        if (!is_numeric($arr_digit)){
            return false;
        }
    }
    return true;
}

function readInput($promptMessage, $isUpdateMode){
    $line = "";
    $counter = 0;

    do{
        if ($counter > 0){
            echo $promptMessage . "(" . $counter . ") No input was provided: ";
        }
        else{
            echo $promptMessage . ": ";
        }

        $handle = fopen ("php://stdin","r");
        $line = trim(fgets($handle));
        $counter++;

        if (trim($line) == "" && $isUpdateMode){
            break;
        }
    } while (trim($line) == "");

    fclose($handle);

    return $line;
}