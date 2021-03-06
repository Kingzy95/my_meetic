<?php
session_start();
    $bdd = new PDO('mysql:host:=localhost;dbname=meetic;charset=utf8', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION);//pour visualiser les erreurs/avertissements
?>

<!doctype html>
<html lang="fr-FR">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>My_Meetic</title>
<link href="css/cssindex.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="jquery/jqueryindex.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>   
<script type="text/javascript">
	$(document).ready( function () {
  $(".navigation ul.sousmenu").hide();     

    $(".navigation li.menu span").each( function () {
        $(this).replaceWith('<a href="" title="Afficher le sous-menu">' + $(this).text() + '<\/a>') ;
    } ) ;   

    $(".navigation li.menu > a").click( function () {

        if ($(this).next("ul.sousmenu:visible").length != 0) {
            $(this).next("ul.sousmenu").slideUp("normal");
        }
        else {
            $(".navigation ul.sousmenu").slideUp("normal");
            $(this).next("ul.sousmenu").slideDown("normal");
        }
        
        return false;
    });    

} ) ;</script>
</head>
<body>
<!-- Main Container -->
<div class="container"> 
  <!-- Navigation -->
  <header> <a href="">
    <h4 class="logo">My MEETIC</h4>
    </a>
    <nav>
      <ul class="navigation">
        <li><a href="#hero">HOME</a></li>
         <li class="menu"><span>CONNEXION/INSCRIPTION</span>
			 <ul class="sousmenu">
		  	<li><a href="Connexion.php">Connexion</a></li>
		 	 <li><a href="Inscription.php">Inscription</a></li>
			 </ul>
		  
      </ul>
    </nav>
  </header>
  <!-- titre Section -->
  <section class="hero" id="hero">
    <h2 class="hero_header">My <span class="meetic">Meetic</span></h2>
    <p class="tagline">Trouvez l'amour parmis nos c??libataires</p>
  </section>
  <!-- texte Section -->
  <section class="about" id="about">
    <h2 class="hidden">About</h2>
    <p class="text_column">Un site de rencontre con??u pour vous, faites des rencontres serieuses, rechercher le profil qui vous correspond gr??ce ?? nos diff??rent filtres, en fonction de votre ville, ??ge, passions, et rencontrer la femme ou l'homme de vos r??ve.</p>
    <p class="text_column">Franchissez le pas et d??cidez vous ?? faires des rencontres ! Nos ateliers danse, cuisine, soir??es salsa, sont con??u pour nos c??libataires. avec environs 60 ??v??nements par mois en France, que vous soyez en province ou que vous habitiez a Lyon, il y aura toujours des ??v??nements pr??s de chez vous.</p>
    <p class="text_column">Chez my Meetic, nous v??rifions les profils de nos c??libataires, pour que vous puissiez ??changez en toute confiance avec les membres, nous supprimons les profils non conformes ?? notre r??glements.</p>
  </section>
  <!-- Stats Gallery Section -->
  <div class="gallery">
    <div class="thumbnail">
      <h1 class="stats">8</h1>
      <h4>MILLIONS</h4>
      <p>?? l'origine de 8 millions de couples</p>
    </div>
    <div class="thumbnail">
      <h1 class="stats">13</h1>
      <h4>MILLIONS</h4>
      <p>plus de 13 millions de profils</p>
    </div>

  </div>
  <!-- Parallax Section -->
  <section class="banner">
    <h2 class="parallax">My Meetic</h2>
    <p class="parallax_description">Le site de rencontre pour une relation durable.</p>
  </section>
  <!-- info Section -->
  <footer>
    <article class="footer_column">
      <h3>NOS AMBITIONS</h3>
      <img src="img/imgpropos.png" alt="" width="400" height="200" class="cards"/>
      <p>Chez my Meetic, nous souhaitons formez des couples s??rieux et durables, c'est pourquoi vous avez acc??s ?? de nombreux filtres pour trouvez votre ??me soeur, parce que la vie est plus belle ?? deux.</p>
    </article>
    <article class="footer_column">
      <h3>LOCALISATION</h3>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5662667.013334631!2d-2.436735174797767!3d46.13134524516567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd54a02933785731%3A0x6bfd3f96c747d9f7!2sFrance!5e0!3m2!1sfr!2sfr!4v1611508763928!5m2!1sfr!2sfr" width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
      <p>L'ensemble des profils de nos utilisateurs, vivents en France, n'attendez plus, chercher votre ??me soeur pr??s de chez vous !</p>
    </article>
  </footer>
  <!-- Footer Section -->
  <section class="footer_banner" id="contact">
    <h2 class="hidden">Footer Banner Section </h2>
    <p class="hero_header">N'ATTENDEZ PLUS, INSCRIVEZ VOUS</p>
    <div class="button"><a href="Inscription.php" id="textbutton">S'inscrire</a></div>
  </section>
  <!-- Copyrights Section -->
  <div class="copyright">&copy;2021- <strong>My Meetic</strong></div>
</div>
</body>
</html>
