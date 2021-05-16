<?php
session_start();
    $bdd = new PDO('mysql:host:=localhost;dbname=meetic;charset=utf8', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION);//pour visualiser les erreurs/avertissements
if(isset($_SESSION['id']))
{
	$requser = $bdd->prepare("SELECT * FROM inscription WHERE id = ?");
	$requser->execute(array($_SESSION['id']));
	$user = $requser->fetch();
	$nom = strtoupper($user['nom']);
	$prenom = strtoupper($user['prenom']);
	$id=($user['id']);
	
	if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND ($_POST['newmail']) != $user['mail'])
			 {
				$mail = ($_POST['newmail']);
				$reqmail = $bdd->prepare("SELECT * FROM inscription WHERE mail = ?");
				$reqmail->execute(array($mail));
				$mailexist = $reqmail->rowCount();
				if($mailexist === 0)
				{
				 	$newmail = ($_POST['newmail']);
				 	$insertmail = $bdd->prepare ("UPDATE inscription SET mail = ? WHERE id = ?");
				 	$insertmail->execute(array($newmail, $_SESSION['id']));
				 	header('Location: profil.php?id='.$_SESSION['id']);
				}
				else
				{
					$msg = "l'adresse e-mail est déja utilisé";
				}
			 }
	
		
	if(isset($_POST['newville']) AND !empty($_POST['newville']) AND ($_POST['newville']) != $user['ville'])
			 {
				 $newville = ($_POST['newville']);
				 $insertville = $bdd->prepare ("UPDATE inscription SET ville = ? WHERE id = ?");
				 $insertville->execute(array($newville, $_SESSION['id']));
				 header('Location: profil.php?id='.$_SESSION['id']);
			 }
	
		if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) 
			 {
			 	 $mdp1 = sha1($_POST['newmdp1']);
				 $mdp2 = sha1($_POST['newmdp2']);
				 if($mdp1 ===$mdp2)
				 {
					 $insertmdp = $bdd->prepare("UPDATE inscription SET mdp = ? WHERE id = ?");
					 $insertmdp->execute(array($mdp1, $_SESSION['id']));
					 header('Location: profil.php?id='.$_SESSION['id']);
				 }
			else
			{
				$msg = "Vos mot de passe ne correspondent pas.";
			}
		 }
	
	if(isset($_POST['newmail']) AND $_POST['newmail'] === $user['mail'])
	{
		header('Location: profil.php?id='.$_SESSION['id']);
	}
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Profil</title>
	
		<link href="css/cssedit.css" rel="stylesheet" type="text/css">
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
  <header> <a href="indexco.php?id=<?php echo $id;?>">
    <h4 class="logo">My MEETIC</h4>
    </a>
    <nav>
      <ul class="navigation">
        <li><a href="indexco.php?id=<?php echo $id;?>">HOME</a></li>
        <li><a href="#about">RECHERCHE</a></li>
         <li class="menu"><span><?php echo $prenom;?> <?php echo $nom;?></span>
			 <ul class="sousmenu">
		  	<li><a href="Profil.php?id=<?php echo $id;?>">Mon profil</a></li>
		 	 <li><a href="Deconnexion.php">Déconnexion</a></li>
			 </ul>
		  
      </ul>
    </nav>
  </header>

<body><br><br><br><br><br><br><br><br><br>
	<div id="profil" align="center">
		<h1>Edition du profil</h1>
		<form method="post" action="">
		<label>Votre email:</label>
		<input type="text" name="newmail" placeholder="nouvelle adresse mail" class="input" value="<?php echo $user['mail']; ?>"/><br/><br/>
		<label>Changer votre mot de passe:</label>
		<input type="password" name="newmdp1" placeholder="mot de passe" class="input"/><br/><br/>
		<label>Confirmez votre mot de passe:</label>
		<input type="password" name="newmdp2" placeholder="confirmation mot de passe" class="input" /><br/><br/>
		<label>Votre ville:</label>
		<input type="text" name="newville" placeholder="Ville" value="<?php echo $user['ville']; ?>" class="input"/><br/><br/>
		<input type="submit" value="mettre a jour"/><br/><br><br>
	</form>
		</div><br><br><br><br><br><br><br><br><br>
<?php if(isset($msg)) {echo $msg;} ?>
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
else
{
	header("Location: connexion.php");
}
?>