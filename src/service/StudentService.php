<?php

namespace src\service;

use PDOException;
use src\model\Student;
use src\repository\StudentRepositoryInterface;

class StudentService
{
	const DATE_PATTERN = "/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/";
	const EMAIL_PATTERN = "/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,}$/";
	
	public function __construct(private StudentRepositoryInterface $studentRepository)
	{}
	
	public function displayStudents(): void
	{
		try {
			$students = $this->studentRepository->findAll();
		} catch (PDOException $e) {
			echo "Erreur lors de findAll : " . $e->getMessage();
			return;
		}
		
		echo "=== Affichage des étudiants ===\n";
		if (empty($students)) {
			echo "Aucun étudiant\n";
			return;
		}
		
		foreach ($students as $student) {
			echo $student . PHP_EOL;
		}
	}
	
	public function createStudent(): bool
	{
		echo "Saisir le prénom : ";
		$firstname = readline();
		if (empty($firstname)) {
			echo "Prénom incorrect\n";
			return false;
		}
		
		echo "Saisir le nom : ";
		$lastname = readline();
		if (empty($lastname)) {
			echo "Nom incorrect\n";
			return false;
		}
		
		echo "Saisir date naissance (aaaa-mm-jj): ";
		$dob = readline();
		if (!preg_match(self::DATE_PATTERN, $dob)) {
			echo "Date incorrecte\n";
			return false;
		}
		
		echo "Saisir email: ";
		$email = readline();
		if (!preg_match(self::EMAIL_PATTERN, $email)) {
			echo "Email incorrect\n";
			return false;
		}
		
		try {
			$this->studentRepository->save(new Student(null, $firstname, $lastname, $dob, $email));
			return true;
		} catch (PDOException $e) {
			echo "Erreur lors de save : " . $e->getMessage();
			return false;
		}
	}
	
	public function editStudent(): void
	{
		echo "Saisir l'id de l'étudiant: ";
		$id = (int)readline();
		
		try {
			$student = $this->studentRepository->findById($id);
		} catch (PDOException $e) {
			echo "Erreur lors de findById : " . $e->getMessage();
			return;
		}
		
		if (!$student) {
			echo "Aucun étudiant trouvé avec l'id {$id}\n";
			return;
		}
		
		echo "Saisir prénom: ";
		$firstname = readline();
		if (!empty($firstname)) $student->firstname = $firstname;
		
		echo "Saisir nom: ";
		$lastname = readline();
		if (!empty($lastname)) $student->lastname = $lastname;
		
		echo "Saisir date naissance: ";
		$dob = readline();
		if (!empty($dob) && preg_match(self::DATE_PATTERN, $dob)) {
			$student->date_of_birth = $dob;
		}
		
		echo "Saisir email: ";
		$email = readline();
		if (!empty($email) && preg_match(self::EMAIL_PATTERN, $email)) {
			$student->email = $email;
		}
		
		try {
			$this->studentRepository->update($student);
		} catch (PDOException $e) {
			echo "Erreur lors de update : " . $e->getMessage();
		}
	}
	
	public function deleteStudent(): void
	{
		echo "Saisir l'id de l'étudiant: ";
		$id = (int)readline();
		
		try {
			$success = $this->studentRepository->deleteById($id);
		} catch (PDOException $e) {
			echo "Erreur lors de deleteById : " . $e->getMessage();
			return;
		}
		
		echo $success
				? "L'étudiant avec l'ID $id a été supprimé.\n"
				: "L'id est incorrect.\n";
	}
	
	public function searchStudentsByIdentity(): void
	{
		echo "Saisir le nom ou prénom de l'étudiant: ";
		$input = '%' . readline() . '%';
		
		try {
			$students = $this->studentRepository->findAllByName($input);
		} catch (PDOException $e) {
			echo "Erreur lors de findAllByName : " . $e->getMessage();
			return;
		}
		
		echo "=== Étudiants correspondants ===\n";
		foreach ($students as $student) {
			echo $student . PHP_EOL;
		}
	}
	
	public function addStudent(array $data): void
	{
		$student = new Student(
				null,
				$data['prenom'] ?? '',
				$data['nom'] ?? '',
				$data['date_naissance'] ?? '',
				$data['email'] ?? ''
		);
		
		$this->studentRepository->save($student);
	}
	
	public function updateStudent(array $data): void
	{
		$student = new Student(
				$data['id'] ?? null,
				$data['prenom'] ?? '',
				$data['nom'] ?? '',
				$data['date_naissance'] ?? '',
				$data['email'] ?? ''
		);
		
		$this->studentRepository->update($student);
	}
	
	public function deleteStudentConsole(int|string $id): void
	{
		$this->studentRepository->deleteById($id);
	}
	
	public function getAllStudents(): array
	{
		$cursor = $this->studentRepository->findAll();
		return iterator_to_array($cursor);	}
}
