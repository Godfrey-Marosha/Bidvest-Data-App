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

