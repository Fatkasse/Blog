<div class="right-content">
  <section class="top-sidebar">
    <div class="input-container">
    <input type="text" class="icon-input" placeholder="Rechercher...">
    </div>
    <div class="top-right">
      <img class="icons-topbar" src="assets/icons/notif.png"  alt="">
      <?php if(!empty($user)): ?>
        <div class="profil">
         <img src="assets/images/profil.png" alt="">
      </div>
      <div class="info">
        <p><?= htmlspecialchars($user['login']) ?></p>
        <p><?= htmlspecialchars($user['profil']) ?></p>
      </div>
      <?php endif ?>
    </div>
     
  </section>
  <main class="content-variable">
  <div class="main-container">
       <div class="first">
       <div class="title">
         <h1> Réferentiels </h1>
         <h3>Gérer les réferentiels de la promotion</h3>
       </div>
       
       </div>
       <br><br>
       <div class="second">
           <div class="gril">
               <div class="info-gril">
               <h1><?= $stats["nombre_apprenants"] ?></h1>
                   <h4>apprenants</h4>
               </div>
               <div class="icon-content">
                <img class="gril-icon" src="assets/icons/icone1.png"   alt="">
               </div>
           </div>
           <div class="gril">
               <div class="info-gril">
                   <h1><?= $stats["nombre_referentiels"] ?></h1>
                   <h4>Referentiels</h4>
               </div>
               <div class="icon-content">
                <img class="gril-icon" src="assets/icons/ICONE2.png"   alt="">
               </div>
           </div>
           <div class="gril">
               <div class="info-gril">
               <h1><?= $stats["nombre_promotions_actives"] ?></h1>
                   <h4>Promotions Actives</h4>
               </div>
               <div class="icon-content">
                <img class="gril-icon" src="assets/icons/ICONE3.png"   alt="">
               </div>
           </div>
           <div class="gril">
               <div class="info-gril">
               <h1><?= $stats["nombre_total_promotions"] ?></h1>
                   <h4>Total promotions</h4>
               </div>
               <div class="icon-content">
                <img class="gril-icon" src="assets/icons/ICONE4.png"   alt="">
               </div>
           </div>
       </div>
       <br>
       <div class="third">
       
       <form class="input-third" method="GET" action="index.php" style="display: flex; gap: 10px;">
         <input type="hidden" name="menu" value="referentiel">
         <input type="hidden" name="action" value="rechercher">
         
         <input type="text" classe="input-recherche" name="query"  placeholder="Rechercher par nom..." style="width: 100%;border:none">
            
         </form>

       <div class="grid-referentiel">
       <img class="icons-topbar" src="assets/icons/referent.png"  alt="">
       <a  class="tout-ref-link"  href="index.php?menu=referentiel&action=lister" style="color:white; text-decoration:none">
         <h3>Toutes les référentiels</h3>
         </a>
       </div>
       <div class="ajout-referentiel">
       <img class="icons-topbar" src="assets/icons/plus.png"  alt="">
       <a href="index.php?menu=referentiel&action=affecter" class="ajout-link">ajouter à la promotion </a>
      
       </div>
       </div>
     <br><br>
       <div class="card">
       <?php foreach ($referentiels as $ref): ?>
            <div class="card-content">
              <img class="img-card" src="<?= htmlspecialchars($ref['photo']) ?>" alt="photo referentiel">
              <h3><?= htmlspecialchars($ref['nom']) ?></h3>
              <h4>1 module</h4>
              <p><?= htmlspecialchars($ref['description']) ?></p>
              <br>
              <div class="card-footer">
                 <div class="icon-card">
                         
                 </div>
                 <p><?= htmlspecialchars($ref['capacite']) ?>apprenants </p>
              </div>
            </div>
            <?php endforeach ?>
            </div>
        
    </div>
    
  </main>
  </div>
  </div>