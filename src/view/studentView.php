<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Gestion Étudiants</title>
	<style>
        body { font-family: sans-serif; margin: 20px; }
        input, button { margin: 5px; padding: 5px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
	</style>
</head>
<body>

<h2>Ajouter / Modifier un étudiant</h2>
<form method="POST">
	<input type="number" name="id" placeholder="ID (pour modifier)">
	<input type="text" name="nom" placeholder="Nom" required>
	<input type="text" name="prenom" placeholder="Prénom" required>
	<input type="date" name="date_naissance" placeholder="Date de naissance">
	<input type="email" name="email" placeholder="Email">
	<button type="submit" name="action" value="add">Ajouter</button>
	<button type="submit" name="action" value="update">Modifier</button>
</form>

<h2>Supprimer un étudiant</h2>
<form method="POST">
	<input type="number" name="id_supp" placeholder="ID à supprimer" required>
	<button type="submit" name="action" value="delete">Supprimer</button>
</form>

<h2>Liste des étudiants</h2>
<table>
	<tr>
		<th>ID</th><th>Nom</th><th>Prénom</th><th>Date de naissance</th><th>Email</th>
	</tr>
	<?php foreach ($controller->getAllStudents() as $etudiant): ?>
		<tr>
			<td><?= htmlspecialchars($etudiant['id']) ?></td>
			<td><?= htmlspecialchars($etudiant['nom']) ?></td>
			<td><?= htmlspecialchars($etudiant['prenom']) ?></td>
			<td><?= htmlspecialchars($etudiant['date_naissance'] ?? '') ?></td>
			<td><?= htmlspecialchars($etudiant['email'] ?? '') ?></td>
		</tr>
	<?php endforeach; ?>
</table>

</body>
</html>
