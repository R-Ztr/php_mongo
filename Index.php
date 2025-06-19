<?php

require_once './vendor/autoload.php';

use src\repository\StudentRepositoryMongo;
use src\service\StudentService;
use src\controller\StudentController;

$studentRepo = new StudentRepositoryMongo();
$studentService = new StudentService($studentRepo);
$controller = new StudentController($studentService);

$controller->handleRequest();

require './src/view/StudentView.php';
