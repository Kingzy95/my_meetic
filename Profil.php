<?php
session_start();
    $bdd = new PDO('mysql:host:=localhost;dbname=meetic;charset=utf8', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION);//pour visualiser les erreurs/avertissements
if(isset($_GET['id']) AND $_GET['id'] > 0)
{
	$getid = intval($_GET['id']);
	$requser = $bdd-> prepare('SELECT * FROM inscription WHERE id=?');
	$requser->execute(array($getid));
	$userinfo = $requser->fetch();
	$nom = strtoupper($userinfo['nom']);
	$prenom = strtoupper($userinfo['prenom']);
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Profil</title>
	<link href="css/csspro.css" rel="stylesheet" type="text/css">
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
	<!-- Main Container -->
<div class="container"> 
  <!-- Navigation -->
  <header> <a href="indexco.php?id=<?php echo $getid;?>">
    <h4 class="logo">My MEETIC</h4>
    </a>
    <nav>
      <ul class="navigation">
        <li><a href="indexco.php?id=<?php echo $getid;?>">HOME</a></li>
        <li><a href="recherche.php?id=<?php echo $getid;?>">RECHERCHE</a></li>
         <li class="menu"><span><?php echo $prenom;?> <?php echo $nom;?></span>
			 <ul class="sousmenu">
		  	<li><a href="Profil.php?id=<?php echo $getid;?>">Mon profil</a></li>
		 	 <li><a href="Deconnexion.php">Déconnexion</a></li>
			 </ul>
		  
      </ul>
    </nav>
  </header>

<body><br><br><br><br><br><br><br><br><br><br><br><br>
	<div align="center" id="profil">
	<h1>Bonjour <?php echo $userinfo['prenom'];?> <?php echo $userinfo['nom'];?></h1>
	<p>Votre adresse mail: <?php echo $userinfo['mail'];?></p>
	<p>Votre genre: <?php echo $userinfo['sexe'];?></p>
	<p>Votre ville: <?php echo $userinfo['ville'];?></p>
	<?php
	if(isset($_SESSION['id']) AND $userinfo['id'] === $_SESSION['id']){
	?>
	<a href="edition.php">Modifiez mon profil |</a>
		<a href="deconnexion.php">Se déconnecter</a><br><br></div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<?php
	}
	?>
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
<?php
}
?>