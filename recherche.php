<?php
$result = [];

$bdd = new PDO('mysql:host:=localhost;dbname=meetic;charset=utf8', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION);
try{
session_start();

	
	$getid = intval($_SESSION['id']);
if(isset($_SESSION['id']))
{
	$requser = $bdd->prepare("SELECT * FROM inscription WHERE id = ?");
	$requser->execute(array($_SESSION['id']));
	$user = $requser->fetch();
	$nom = strtoupper($user['nom']);
	$prenom = strtoupper($user['prenom']);
}

    if (isset($_GET["sexe"]) && isset($_GET["age_min"])) {
			
            $sexe = $_GET["sexe"];
            $age_min = $_GET["age_min"];
			$ville = $_GET['ville'];
			$age_max = $_GET["age_max"];
			$loisir = $_GET["loisir"];
        $search = $bdd->prepare("SELECT * FROM inscription WHERE sexe=:sexe AND nais >= :age AND nais <= :age_max AND ville = :ville AND loisir = :loisir");
		
        $search->bindParam(':sexe', $sexe, PDO::PARAM_STR);
        $search->bindParam(':age', $age_min, PDO::PARAM_INT);
		$search->bindParam(':ville', $ville, PDO::PARAM_STR);
		$search->bindParam(':age_max', $age_max, PDO::PARAM_INT);
		$search->bindParam(':loisir', $loisir, PDO::PARAM_STR);
        $search->execute();
        $result = $search->fetchAll();
    }
	else{
		$erreur =  "aucun membre";
	}
}catch (PDOException $e) {
      die("Erreur de connexion à la base :".$e->getMessage());
      exit();//quitter le script
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Recherche</title>
		<link href="css/cssrecherche.css" rel="stylesheet" type="text/css">
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
	
<div class="container" align=center> 
  <!-- Navigation -->
  <header> <a href="indexco.php?id=<?php echo $getid;?>">
    <h4 class="logo">My MEETIC</h4>
    </a>
    <nav>
      <ul class="navigation">
        <li><a href="indexco.php?id=<?php echo $getid;?>">HOME</a></li>
        <li><a href="#about">RECHERCHE</a></li>
         <li class="menu"><span><?php echo $prenom;?> <?php echo $nom;?></span>
			 <ul class="sousmenu">
		  	<li><a href="Profil.php?id=<?php echo $getid;?>">Mon profil</a></li>
		 	 <li><a href="Deconnexion.php">Déconnexion</a></li>
			 </ul>
		  
      </ul>
    </nav>
  </header>
</head>
<body>
    <h1>Recherche</h1>
    <form method="GET">
        <div>
            <input type="radio" id="homme" name="sexe" value="Homme"class="radio">
            <label for = "homme">Un homme</label>

            <input type="radio" id="femme" name="sexe" value="Femme"class="radio">
            <label for = "femme">Une femme</label>

            <input type="radio" id="autre" name="sexe" value="Autre"class="radio">
            <label for = "autre">Autre</label><br>
        </div>
        <div>
            <label for="age_min">age minimum :</label><br>
            <input type="number" id="age_min" name="age_min" value="" class="input">
        </div>
		        <div>
            <label for="age_max">age max :</label><br>
            <input type="number" id="age_max" name="age_max" value="" class="input">
        </div>
		 <div>
            <label for="ville">ville :</label><br>
            <input type="text" id="ville" name="ville" value="" class="input"><br>
        </div>
		<div>
			<label for="loisir">loisirs:</label><br><br>
			<input type="checkbox" id="jeuxvideo" name="loisir" value="jeuxvideo" >
			<label for="jeuxvideo">Jeux vidéo</label>
			
						<input type="checkbox" id="cinema" name="loisir" value="cinema">
			<label for="cinema">Cinema</label>
			
						<input type="checkbox" id="lecture" name="loisir" value="lecture">
			<label for="lecture">Lecture</label>
			
						<input type="checkbox" id="sport" name="loisir" value="sport">
			<label for="sport">Sport</label>
			
						<input type="checkbox" id="informatique" name="loisir" value="informatique">
			<label for="informatique">Informatique</label>
			
		</div>
           <input type="submit" value="rechercher" /><br><br>                
        </form>  
			  <?php
		  if(isset($erreur))
		  {
			  echo '<font color="red">'.$erreur. "</font>";
		  }
		  ?>
        <div id="carrousel" style="background-color: #E0ADFD">
			<br>
            <?php foreach ($result as $key => $value): ?>
                
                <ul style="list-style-type: none; display: block; text-align: left;">
                    <li style="text-transform: uppercase; font-weight: bold; font-size: 20px;"> <?= $value["prenom"] ?>  <?=$value["nom"]?></li>
                    <li style="font-size: 20px;">mail : <?= $value["mail"]  ?></li>
                    <li style="font-size: 20px;">sexe : <?= $value["sexe"]  ?></li>
                    <li style="font-size: 20px;">age : <?= $value["nais"]  ?></li>
					<li style="font-size: 20px;">ville : <?=$value["ville"] ?></li>
                </ul>
            <?php endforeach; ?>
        </div>

	
	<script>$(document).ready(function(){
    
var $carrousel = $('#carrousel'),
    $img = $('#carrousel li'), 
    indexImg = $img.length - 1,
	indexImg1 = $img.length - 2,
	indexImg2 = $img.length - 3,
	indexImg3 = $img.length - 4,
	indexImg4 = $img.length - 5,
    i = 0,
	i1= 1,
	i2= 2,
	i3= 3,
	i4= 4,
    $currentImg = $img.eq(i); 
	$currentImg1 = $img.eq(i1); 
	$currentImg2 = $img.eq(i2); 
	$currentImg3 = $img.eq(i3); 
	$currentImg4 = $img.eq(i4); 

$img.css('display', 'none'); 
$currentImg.css('display', 'block');
$currentImg1.css('display', 'block');
$currentImg2.css('display', 'block');
$currentImg3.css('display', 'block');
$currentImg4.css('display', 'block');

$carrousel.append('<div class="controls" style="cursor: pointer"> <span class="prev">Precedent |</span> <span class="next"> Suivant</span> </div>');

$('.next').click(function(){ 

    i = i+5; 
	i1 = i1+5;
	i2 = i2+5;
	i3 = i3+5;
	i4 = i4+5;

    if( i <= indexImg ){
        $img.css('display', 'none'); 
        $currentImg = $img.eq(i);
		$currentImg1 = $img.eq(i1); 
		$currentImg2 = $img.eq(i2); 
		$currentImg3 = $img.eq(i3); 
		$currentImg4 = $img.eq(i4); 
        $currentImg.css('display', 'block');
		$currentImg1.css('display', 'block');
		$currentImg2.css('display', 'block');
		$currentImg3.css('display', 'block');
		$currentImg4.css('display', 'block');
    }
    else{
        i = indexImg;
		i1 = indexImg1;
		i2 = indexImg2;
		i3 = indexImg3;
		i4 = indexImg4;
		
		
    }

});

$('.prev').click(function(){ 

    i = i-5; 
	i1 = i1-5;
	i2 = i2-5;
	i3 = i3-5;
	i4 = i4-5;

    if( i >= 0 ){
        $img.css('display', 'none');
        $currentImg = $img.eq(i);
		$currentImg1 = $img.eq(i1); 
		$currentImg2 = $img.eq(i2); 
		$currentImg3 = $img.eq(i3); 
		$currentImg4 = $img.eq(i4); 
        $currentImg.css('display', 'block');
		$currentImg1.css('display', 'block');
		$currentImg2.css('display', 'block');
		$currentImg3.css('display', 'block');
		$currentImg4.css('display', 'block');
    }
    else{
        i = 0;
		i1= 1;
		i2= 2;
		i3= 3;
		i4= 4;
    }

});


});
</script>

  <section class="footer_banner" id="contact">
    <h2 class="hidden">Footer Banner Section </h2>
    <p class="hero_header">N'ATTENDEZ PLUS, INSCRIVEZ VOUS</p>
    <div class="button"><a href="Inscription.php" id="textbutton">S'inscrire</a></div>
  </section>

  <div class="copyright">&copy;2021- <strong>My Meetic</strong></div>
</div>
</body>
</html>