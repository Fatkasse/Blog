<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <title>Gestion apprenant</title>
</head>
<body>
  <div class="layout">
  <section class="left-sidebar">
     <img class="img-sidebar" src="assets/images/logo.jpg" alt="">

     <div class="box-sidebar">
  
         <h4><?= $nomPromoActive = isset($nomPromoActive) ? $nomPromoActive : ''; ?></h4>
         
     </div>
     
     <br> <br>  <br>  <br>

    <div class="container-menu">

     <div class="menu">
      
       <a href="index.php?menu=promotion"> 
       <h4 ><i class='bx bx-home-alt' style="color: #707275; font-size: 18px;"></i> <b></b>Tableau de bord</h4>
       </a>
     </div>

     <div class="menu">
     
       <a  href="index.php?menu=promotion">
       <h4><i class="fa-regular fa-folder" style="color: #707275; font-size: 18px;"></i> <b></b>Promotions</h4>
       </a>
     </div>

     <div class="menu">
      
     <a href="index.php?menu=referentiel">
       <h4><i class="fas fa-book" style="color: #707275; font-size: 18px; "></i> <b></b>Réferentiels</h4>
       </a>
     </div>

     <div class="menu">
     <a href="index.php?menu=apprenant">
     <h4><i class="fas fa-users" style="color: #707275; font-size: 18px; "></i> <b></b>Apprenants</h4>
     </a>
     </div>

     <div class="menu">
     
       <a href=""> 
       <h4><i class='bx bx-file' style="color: #707275; font-size: 18px;"></i><b></b>Gestion des presences</h4>
       </a>
     </div>

     <div class="menu">
            <a href=""> 
       <h4 class=><i class="fas fa-laptop" style="color: #707275; font-size: 18px;"></i><b></b>Kits & Laptops</h4>
       </a>
     </div>

     <div class="menu">
             <a href=""> 
       <h4><i class='bx bx-signal-3' style="color: #707275; font-size: 18px;"></i><b></b>Rapports & Stats</h4>
       </a>
     </div>
     </div>
     <div class="deconnection">
         <a href="index.php"><i class="fa-solid fa-arrow-right-from-bracket"></i>Deconnection</a>
     </div>
   
  </section>
  
</body>
</html>