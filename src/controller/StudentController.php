<?php
namespace src\controller;

use src\service\StudentService;

class StudentController {
	private StudentService $service;
	
	public function __construct(StudentService $service) {
		$this->service = $service;
	}
	
	public function handleRequest() {
		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			$action = $_POST['action'] ?? null;
			
			if ($action === 'add') {
				$this->service->addStudent($_POST);
			} elseif ($action === 'update') {
				$this->service->updateStudent($_POST);
			} elseif ($action === 'delete') {
				$this->service->deleteStudent((int)$_POST['id_supp']);
			}
		}
	}
	
	public function getAllStudents() {
		return $this->service->getAllStudents();
	}
}
