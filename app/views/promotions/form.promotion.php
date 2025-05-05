<?php 
use function App\Controllers\errors\get_error;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Document</title>
</head>
<body>
 
<div class="container-create-promotion">
   <div class="content-form">
     <div class="title-form2">
     <h1>créer une nouvelle promotion</h1>
     <a href="index.php?menu=promotion">
     <img class="fermer-icon" src="assets/icons/fermer.png" alt="dashbord">
     </a>
      </div>
      <h4>Remplissez les informations ci-dessous pour créer une nouvelle promotion.</h4>
      <br><br><br><br>
      <form class="create-form" action="index.php?menu=promotion&action=ajouter" method="POST" enctype="multipart/form-data">
    <label class="create-label" for="nom">Nom de la promotion</label>
    <input class="create-input" name="nom" type="text" placeholder="ex: Promotion 2025" value="<?= $_POST['nom'] ?? '' ?>">
    <p class="error"><?= get_error('nom') ?></p>

    <div class="date-create">
        <div class="debut">
            <label class="create-label" for="date-debut">Date de début</label>
            <input class="create-input-date" name="date-debut" type="text" placeholder="jj-mm-aaaa" value="<?= $_POST['date-debut'] ?? '' ?>">
            <p class="error"><?= get_error('date-debut') ?></p>
        </div>

        <div class="debut">
            <label class="create-label" for="date-fin">Date de fin</label>
            <input class="create-input-date" name="date-fin" type="text" placeholder="jj-mm-aaaa" value="<?= $_POST['date-fin'] ?? '' ?>">
            <p class="error"><?= get_error('date-fin') ?></p>
        </div>
    </div>

    <label class="upload-label">Photo de la promotion</label>
    <div class="upload-wrapper-prom">
        <input type="file" name="photo" accept="images/*" class="upload-input" />
        <div class="upload-box-prom">
            <span class="upload-text"><strong>Ajouter</strong><br>ou glisser</span>
        </div>
        <p class="upload-info">Format JPG, PNG. Taille max 2MB</p>
        <p class="error"><?= get_error('photo') ?></p>
    </div>

    <label class="create-label">Référentiels</label>

    <?php foreach ($referentiels as $ref): ?>
    <label>
        <input class="create-input" type="checkbox" name="referentiel[]" 
               value="<?= htmlspecialchars($ref['nom']) ?>"
               <?= isset($_POST['referentiel']) && is_array($_POST['referentiel']) && in_array($ref['nom'], $_POST['referentiel']) ? 'checked' : '' ?>>
        <?= htmlspecialchars($ref['nom']) ?>
    </label><br>
<?php endforeach; ?>
<p class="error"><?= get_error('nom') ?></p>

<?php
$promotion = $_POST; 
$promotion['apprenants'] = $_POST['apprenants'] ?? [];
$promotion['etat'] = $_POST['etat'] ?? '';

$isDisabled = !empty($promotion['apprenants']);
?>

    <div class="buttons">
        <a href="index.php?menu=promotion">Annuler</a>
        <button class="create-button" type="submit">Créer la promotion</button>
    </div>
</form>


   </div>
</div>
    
</body>
</html>