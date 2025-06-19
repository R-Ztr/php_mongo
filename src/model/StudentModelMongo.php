<?php
require 'vendor/autoload.php'; // Assure-toi que MongoDB PHP lib est installée

use MongoDB\Client;

class StudentModel {
	private $collection;
	
	public function __construct() {
		$client = new Client("mongodb://localhost:27017");
		$db = $client->ecole;
		$this->collection = $db->etudiant;
	}
	
	public function getAllStudents() {
		$result = $this->collection->find([], ['limit' => 50]);
		$students = [];
		
		foreach ($result as $doc) {
			$students[] = [
					'id' => (string)$doc['_id'], // On convertit l'ObjectId en string
					'nom' => $doc['nom'] ?? '',
					'prenom' => $doc['prenom'] ?? '',
					'date_naissance' => $doc['date_naissance'] ?? '',
					'email' => $doc['email'] ?? ''
			];
		}
		
		return $students;
	}
	
	public function addStudent($data) {
		$doc = [];
		
		// Champs obligatoires
		if (!empty($data['nom']) && !empty($data['prenom'])) {
			$doc['nom'] = $data['nom'];
			$doc['prenom'] = $data['prenom'];
			
			// Champs optionnels
			if (!empty($data['date_naissance'])) {
				$doc['date_naissance'] = $data['date_naissance'];
			}
			if (!empty($data['email'])) {
				$doc['email'] = $data['email'];
			}
			
			$this->collection->insertOne($doc);
		}
	}
	
	public function updateStudent($data) {
		if (!isset($data['id'])) return;
		
		$filter = ['_id' => new MongoDB\BSON\ObjectId($data['id'])];
		$update = ['$set' => [
				'nom' => $data['nom'],
				'prenom' => $data['prenom']
		]];
		
		if (!empty($data['date_naissance'])) {
			$update['$set']['date_naissance'] = $data['date_naissance'];
		} else {
			$update['$unset']['date_naissance'] = "";
		}
		
		if (!empty($data['email'])) {
			$update['$set']['email'] = $data['email'];
		} else {
			$update['$unset']['email'] = "";
		}
		
		$this->collection->updateOne($filter, $update);
	}
	
	public function deleteStudent($id) {
		if (!$id) return;
		
		try {
			$objectId = new MongoDB\BSON\ObjectId($id);
			$this->collection->deleteOne(['_id' => $objectId]);
		} catch (Exception $e) {
			// ID invalide (mauvais format), on ignore
		}
	}
}
