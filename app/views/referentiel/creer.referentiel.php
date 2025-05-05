<?php use function App\Controllers\errors\get_error; ?>

<div class="container-create-referentiel">
    
   <div class="content-form">
      <div class="title-form2">
         <h1>créer un nouveau reférentiel</h1>
         <a href="index.php?menu=referentiel">
            <img class="fermer-icon" src="assets/icons/fermer.png" alt="dashbord">
         </a>
      </div>
      <br><br><br><br><br><br>
      <form class="create-form" action="index.php?menu=referentiel&action=creation_page" method="POST" enctype="multipart/form-data">
         <div class="upload-wrapper">
            <input type="file" name="photo" accept="assets/image/" class="upload-input" />
            <div class="upload-box">
               <span class="upload-text">
                  <h3>Cliquer pour ajouter</h3><br>
                  <h3>une photo</h3>
               </span>
            </div>
            <p class="error"><?= get_error('photo') ?></p>
         </div>
         
         <label class="create-label" for="nom"> Nom *</label>
         <input class="create-input" name="nom" type="text" value="<?= $_POST['nom'] ?? '' ?>">
         <p class="error"><?= get_error('nom') ?></p>
         
         <label class="create-label" for="referentiel"> Description</label>
         <input class="create-input-textarea" name="description" type="textarea" class="icon-input" placeholder=" " value="<?= $_POST['description'] ?? '' ?>" >
         <p class="error"><?= get_error('description') ?></p>
         
         <div class="date-create">
            <div class="debut">
               <label class="create-label" for="date debut"> Capacité</label>
               <input class="create-input-date" name="capacite" type="text" placeholder="25" >
               <p class="error"><?= get_error('capacite') ?></p>
            </div>
            
            <div class="debut">
               <label class="create-label" for="nombre-session">Nombre de session</label>
               <select name="nombre-session" class="create-input-date">
                  <option value="">-- Choisir une option --</option>
                  <option value="1">1 Session</option>
                  <option value="2">2 Session</option>
               </select>
               <p class="error"><?= get_error('nombre-session') ?></p>
            </div>
         </div>
         
         <div class="buttons">
            <a href="index.php?menu=referentiel">Annuler</a>
            <button class="create-button" type="submit" style="background-color:var(--vert);color:white"> créer</button>
         </div>
      </form>
   </div>
</div>