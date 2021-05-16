<?php
session_start();
    $bdd = new PDO('mysql:host:=localhost;dbname=meetic;charset=utf8', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION);//pour visualiser les erreurs/avertissements
if(isset($_POST['formconnexion']))
{
    $emailconnect=($_POST['emailconnect']);
    $mdpconnect = sha1($_POST['mdpconnect']);
    if(!empty($emailconnect) AND !empty($mdpconnect))
    {
        $requser = $bdd->prepare("SELECT *FROM inscription WHERE mail = ? AND mdp = ?;");
        $requser->execute(array($emailconnect, $mdpconnect));
        $userexist = $requser->rowCount();
        if($userexist == 1)
        {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['nom'] = $userinfo['nom'];
            $_SESSION['mail'] = $userinfo['mail'];
            header("Location: indexco.php?id=".$_SESSION['id']);
        }
        else
        {
            $erreur = "Le compte n'existe pas";
        }
    }
    else
    {
        $erreur = "Tous les champs doivent être complétés";
    }
}

?>

<!doctype HTML>
<html lang="fr">
<html>
	
   <head>
      <title>Connexion</title>
      <meta charset="utf-8">
	   <link href="css/cssco.css" rel="stylesheet" type="text/css">
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
	   <div class="container"> 
  <!-- Navigation -->
  <header> <a href="Index.php">
    <h4 class="logo">My MEETIC</h4>
    </a>
    <nav>
      <ul class="navigation">
        <li><a href="Index.php">HOME</a></li>
         <li class="menu"><span>CONNEXION/INSCRIPTION</span>
			 <ul class="sousmenu">
		  	<li><a href="Connexion.php">Connexion</a></li>
		 	 <li><a href="Inscription.php">Inscription</a></li>
			 </ul>
		  
      </ul>
    </nav>
  </header>
		   <body>

      <div align="center" >
		  <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
		  <div id="co">
         <h2>Connexion</h2>
         <br /><br />
         <form method="POST" action="">
			 <input type="email" name="emailconnect" placeholder="entrez votre email" /><br><br>
			 <input type="password" name="mdpconnect" placeholder="mot de passe" /><br><br>
			 <input type="submit" name="formconnexion" value="Se connecter" style="background-color: #52bad5;"/><br><br>
			 <a href="Inscription.php">Pas encore de compte ?</a><br>
			 		  <?php
		  if(isset($erreur))
		  {
			  echo '<font color="red">'.$erreur. "</font>";
		  }
		  ?>
			 </div>
			 
      </div>
  </div>

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

	   

   </body>
</html>