
        <?php
// Lire les données JSON
$apprenants = json_decode(file_get_contents('apprenants.json'), true);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des Apprenants</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Apprenants <span class="count"><?= count($apprenants) ?> apprenants</span></h1>

    <div class="actions">
      <input type="text" placeholder="Rechercher...">
      <select><option>Filtre par classe</option></select>
      <select><option>Filtre par statut</option></select>
      <button class="btn">Télécharger</button>
      <button class="btn add">+ Ajouter apprenant</button>
    </div>

    <table>
    <div class="list-headers">
            <h2>Liste des relevés</h2>
            <h2>Liste d'attente</h2>
        </div>
      <thead>
        <tr>
          <th>Photo</th>
          <th>Matricule</th>
          <th>Nom Complet</th>
          <th>Adresse</th>
          <th>Téléphone</th>
          <th>Référentiel</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($apprenants as $apprenant): ?>
          <tr>
            <td><img src="assets/images/<?= $apprenant['photo'] ?>" class="avatar"></td>
            <td><?= $apprenant['matricule'] ?></td>
            <td><?= $apprenant['nom'] ?></td>
            <td><?= $apprenant['adresse'] ?></td>
            <td><?= $apprenant['telephone'] ?></td>
            <td><span class="tag"><?= $apprenant['referentiel'] ?></span></td>
            <td><span class="status <?= strtolower($apprenant['statut']) ?>"><?= $apprenant['statut'] ?></span></td>
            <td><button class="dots">...</button></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>