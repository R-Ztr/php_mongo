<?php


namespace src\repository;

use src\model\Student;

interface StudentRepositoryInterface
{
	public function findAll();
	
	public function findById(int $id): Student|false;
	
	public function save(Student $student);
	
	public function update(Student $student);
	
	public function deleteById($id);
	
	public function findAllByName($input);
}
