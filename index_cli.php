<?php


require './vendor/autoload.php';

use src\repository\StudentRepository;
use src\service\StudentService;

// Affichage du menu
function menu(): void
{
	echo "
       _             _ _             _
   ___| |_ _   _  __| (_) __ _ _ __ | |_ ___
  / _ \ __| | | |/ _` | |/ _` | '_ \| __/ __|
 |  __/ |_| |_| | (_| | | (_| | | | | |_\__ \
  \___|\__|\__,_|\__,_|_|\__,_|_| |_|\__|___/" . PHP_EOL;
	
	echo "1. Afficher les étudiants
2. Créer un étudiant
3. Editer un étudiant
4. Supprimer un étudiant
5. Chercher par nom ou prénom
6. Quitter" . PHP_EOL;
}


$db = null;
try {
	$db = new PDO("mysql:host=localhost;dbname=php", "root", "");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "La connexion est établie avec notre BDD!", PHP_EOL;
} catch (PDOException $e) {
	echo "Erreur de connexion : " . $e->getMessage(), PHP_EOL;
	return; // Ne continue pas si la connexion échoue.
}

$request = "CREATE TABLE IF NOT EXISTS student (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    date_of_birth DATE,
    email VARCHAR(50)
)";

$db->exec($request);


/*
 *      AJOUTER UNE CONNECTION AVEC MONGODB
 *
 */


// AJOUTER LOG REPO (gérer les acces à la bdd : insertion, récupérer tout les logs et vider les logs)
// AJOUTER LOG SERVICE (afficher, vider)
$studentRepo = new StudentRepository($db);
$studentService = new StudentService($studentRepo); // Ajouter le Log repo à student service

while (true) {
	menu();
	$input = readline("Saisir une option: ");
	match ($input) {
		"1" => $studentService->displayStudents(),
		"2" => $studentService->createStudent(),
		"3" => $studentService->editStudent(),
		"4" => $studentService->deleteStudent(),
		"5" => $studentService->searchStudentsByIdentity(),
		// Ajout afficher log
		// Ajout vider log
		"6" => exit(),
		default => print("saisie invalide"),
	};
	
	echo "\n---Press enter to continue---\n";
	readline();
}