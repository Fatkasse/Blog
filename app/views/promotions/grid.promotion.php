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
         <h1> Promotions </h1>
         <h3>Gérer les promotions de l'école</h3>
       </div>
       <div class="ajout">
       <img class="icons-topbar" src="assets/icons/plus.png"  alt="">
       <a href="index.php?menu=promotion&action=creation_page" class="ajout-link">ajouter une promotions </a>
       
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
    <input type="hidden" name="menu" value="promotion">
    <input type="hidden" name="action" value="<?= isset($_GET['action']) && $_GET['action'] == 'lister' ? 'rechercher_liste' : 'rechercher_grid' ?>">        
    <input type="text" classe="input-recherche" name="query" value="<?= htmlspecialchars($query ?? '') ?>" placeholder="Rechercher par nom..." style="width: 10% border:none">
    
    <select name="status">
        <option value="">Tous</option>
        <option value="active" <?= ($status_filter ?? '') === 'active' ? 'selected' : '' ?>>active</option>
        <option value="inactive" <?= ($status_filter ?? '') === 'inactive' ? 'selected' : '' ?>>inactive</option>
    </select>
    
    <button type="submit" class="recherche-button">Rechercher</button>
</form>
    <div class="grid">
        <h3>Grid</h3>
    </div>
    <div class="list">
        <a href="index.php?menu=promotion&action=lister<?= !empty($query) ? '&query='.urlencode($query) : '' ?><?= !empty($status_filter) ? '&status='.urlencode($status_filter) : '' ?>" style="text-decoration: none;color:black"><h3>List</h3></a>
    </div>      
</div>
         <br><br>

       <div class="four">
         <?php foreach($promotions as $prom): ?>
          <div class="prom-grid">
             <div class="lign1">
                  <div <?php if($prom['status'] == "active"): ?> class="etat-active"  <?php else :  ?>  class="etat-inactive"   <?php endif ?> >
                    <h3><?= htmlspecialchars($prom['status']) ?></h3>
                  </div>
                  <div class="<?= $prom['status'] === 'active'  ? 'button-active'  : 'button-inactive' ?>" >
                  <a href="index.php?menu=promotion&action=changer_status&nom=<?= urlencode($prom['nom']) ?>" title="Changer le statut">
                     <img src="<?= $prom['status'] === 'active'  ? 'assets/icons/on.png' : 'assets/icons/off.png' ?>" 
                        class="<?= $prom['status'] === 'active'  ? 'gril-icon-active' : 'gril-icon-inactive' ?>" alt="Changer statut">
                  </a>
                  </div>
             </div>
             <div class="lign2">
                <div class="img-prom">
                  <img src="<?= htmlspecialchars($prom['photo']) ?>" alt="">
                    
                </div>
                <div class="info-prom">
                   <h2>   <?= htmlspecialchars($prom['nom']) ?></h2>
                    <div class="date-prom">
                    <img class="date-icon" src="assets/icons/calendrier.png"   alt="">
                    <p><?= htmlspecialchars($prom['date-debut']) ?> - <?= htmlspecialchars($prom['date-fin']) ?></p>
                    </div>
                </div>
             </div>
             <br>
             <div class="lign3">
    <img class="appr-icon" src="assets/icons/icone1.png" alt="dashbord">
    <h2><?= $prom["apprenants"] ?? 0 ?> <strong> Apprenants </strong>  </h2>
</div>
             <br>
             <div class="lign4">
                <a href="#">Voir details</a>
                <img class="arrow" src="assets/icons/arrow.png" alt="suivant">
             </div>
          </div>
        
          <?php endforeach ?>  
          
          <div class="pagination-container">
    <form method="get" class="page-selector" style="display: flex; align-items: center;">
        <input type="hidden" name="menu" value="promotion">
        <!-- Utilisez l'action appropriée selon le contexte -->
        <input type="hidden" name="action" value="<?= $current_action ?? ($_GET['action'] ?? '') ?>">
        <?php if(!empty($query)): ?>
        <input type="hidden" name="query" value="<?= htmlspecialchars($query) ?>">
        <?php endif; ?>
        <?php if(!empty($status_filter)): ?>
        <input type="hidden" name="status" value="<?= htmlspecialchars($status_filter) ?>">
        <?php endif; ?>
        
        <span style="color:black; margin-right: 5px;">page</span>
        
        <input 
            type="number" 
            class="page-input" 
            name="page" 
            min="1" 
            max="<?= $pagination['total_pages'] ?>" 
            value="<?= $pagination['page_actuelle'] ?>" 
            style="width: 50px;"
        >
    </form>

    <div class="page-info">
        <?= $pagination['start'] ?> à <?= $pagination['end'] ?> pour <?= $pagination['total'] ?>
    </div>

    <div class="navigation">
        <?php if ($pagination['precedente']): ?>
            <!-- Utilisez l'action appropriée selon le contexte -->
            <a href="index.php?menu=promotion&action=<?= $current_action ?? ($_GET['action'] ?? '') ?>&page=<?= $pagination['precedente'] ?><?= !empty($query) ? '&query='.urlencode($query) : '' ?><?= !empty($status_filter) ? '&status='.urlencode($status_filter) : '' ?>" class="nav-button" title="Page précédente">
                <div class="nav-arrow">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </a>
        <?php endif; ?>

        <?php foreach ($pagination['pages'] as $page): ?>
            <!-- Utilisez l'action appropriée selon le contexte -->
            <a href="index.php?menu=promotion&action=<?= $current_action ?? ($_GET['action'] ?? '') ?>&page=<?= $page ?><?= !empty($query) ? '&query='.urlencode($query) : '' ?><?= !empty($status_filter) ? '&status='.urlencode($status_filter) : '' ?>" class="nav-button <?= $page == $pagination['page_actuelle'] ? 'active' : '' ?>">
                <?= $page ?>
            </a>
        <?php endforeach; ?>

        <?php if ($pagination['suivante']): ?>
            <!-- Utilisez l'action appropriée selon le contexte -->
            <a href="index.php?menu=promotion&action=<?= $current_action ?? ($_GET['action'] ?? '') ?>&page=<?= $pagination['suivante'] ?><?= !empty($query) ? '&query='.urlencode($query) : '' ?><?= !empty($status_filter) ? '&status='.urlencode($status_filter) : '' ?>" class="nav-button" title="Page suivante">
                <div class="nav-arrow">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </a>
        <?php endif; ?>
    </div>
</div>
       </div>

       <br> <br>
 </div>
    
  </main>
  </div>

  
















  