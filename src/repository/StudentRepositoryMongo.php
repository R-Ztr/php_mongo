<?php


namespace src\repository;

use MongoDB\Client;
use src\model\Student;

class StudentRepositoryMongo implements StudentRepositoryInterface
{
	private $collection;
	
	public function __construct()
	{
		$client = new Client("mongodb://localhost:27017");
		$this->collection = $client->ecole->etudiant;
	}
	
	public function findAll()
	{
		return $this->collection->find([], ['limit' => 50]);
	}
	
	public function insert($data)
	{
		return $this->collection->insertOne($data);
	}
	
	public function update($student)
	{
		
		$id = $student->getId();
		$data = $student->toArray();
	}
	
	public function delete($id)
	{
		return $this->collection->deleteOne(
				['_id' => new \MongoDB\BSON\ObjectId($id)]
		);
	}
	
	public function findById(int $id): Student|false
	{
		// TODO: Implement findById() method.
	}
	
	public function save(Student $student)
	{
		// TODO: Implement save() method.
	}
	
	public function deleteById($id)
	{
		// TODO: Implement deleteById() method.
	}
	
	public function findAllByName($input)
	{
		// TODO: Implement findAllByName() method.
	}
}
