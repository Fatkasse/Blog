<?php 
use function App\Controllers\errors\get_error;
?>
<div class="container-create-promotion">
    
   <div class="content-form-ref">
      <div class="title-form2">
         <h1>ajouter une réferentiel</h1>
         <a href="index.php?menu=referentiel">
            <img class="fermer-icon" src="assets/icons/fermer.png" alt="dashbord">
         </a>
      </div>
      
      <br>
      
      <?php $couleurs = ['#e7f7ef', ' #e6f0ff', '#f0e6ff', '#fff2e0', ' #ffe6f0']; 
            $textcolor = ['#34b47b', '#4d8dff', '#9c6ade','#f5a623', '#e83e8c']; ?>
      
      <form class="affecter-form" action="index.php?menu=referentiel&action=affecter_ref" method="post">
         <div class="form-group">
            <label class="form-label">Libellé référentiel</label>
            <input type="text" class="form-input" name="libelle_referentiel" list="referentiels-disponibles" placeholder="Cloud & CyberSec...">
            <datalist id="referentiels-disponibles">
               <?php foreach ($disponibles as $ref): ?>
                  <option value="<?= htmlspecialchars($ref['nom']) ?>"></option>
               <?php endforeach; ?>
            </datalist>
         </div>
         
         <div class="form-group">
            <label class="form-label">Promotion active</label>
            <div class="tags-container">
               <?php foreach ($referentiels as $i => $ref): ?>
                  <div class="tag" style="background-color: <?= $couleurs[$i % count($couleurs)] ?>; color: <?= $textcolor[$i % count($textcolor)] ?>">
                     <?= htmlspecialchars($ref['nom']) ?>
                     <span class="close">×</span>
                  </div>
               <?php endforeach; ?>
            </div>
         </div>
         
         <button type="submit" class="button-affecter">Terminer</button>
      </form>
   </div>
</div>