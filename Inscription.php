<?php
if (isset($_POST['forminscription']))
{

    $bdd = new PDO('mysql:host:=localhost;dbname=meetic;charset=utf8', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION);//pour visualiser les erreurs/avertissements
 
        if (
            !empty($_POST['nom']) and
            !empty($_POST['prenom']) and
            !empty($_POST['sexe']) and
            !empty($_POST['loisir']) and
            !empty($_POST['nais']) and
            !empty($_POST['mail']) and
            !empty($_POST['ville']) and
            !empty($_POST['mdp']) and
            !empty($_POST['mdp2'])
        )
        {
			$nais = ($_POST['nais']);
			$dateNais = new DateTime($nais);
			$dateJour = new DateTime();
			$difference = $dateNais->diff($dateJour);
			$nais = $difference->format('%Y');
            $nom = ($_POST['nom']);
            $prenom = ($_POST['prenom']);
            $sexe = ($_POST['sexe']);
            $loisir = ($_POST['loisir']);
            $mail = ($_POST['mail']);
            $ville = ($_POST['ville']);
            $mdp = ($_POST['mdp']);
            $mdp2 = ($_POST['mdp2']);
            $nomlength = strlen($nom);
            $prenomlength = strlen($prenom);
            if ( $nomlength <= 255 )
            {
             if ((new \DateTime())->diff(new \DateTime($_POST['nais']))->format('%y') < 18)
				{
				 $erreur = "Vous devez avoir 18 ans pour vous inscrire.";

				}
				else{
			    	if ( $prenomlength <= 255 )
                	{
						$reqmail = $bdd->prepare("SELECT *FROM inscription WHERE mail = ?");
						$reqmail->execute(array($mail));
						$mailexist = $reqmail->rowCount();
						if($mailexist === 0)
						{
							if ( $mdp ===  $mdp2 )
                    		{
                        		$mdp = sha1($mdp);
                        		$insertmbr =
                            	$bdd->prepare("INSERT INTO inscription(nom, prenom, sexe, mail, ville, nais, loisir, mdp) VALUES (?,?,?,?,?,?,?,?)");
                        		$insertmbr->execute(array($nom,
                            	$prenom,
                            	$sexe,
                            	$mail,
                            	$ville,
								      $nais,
                            	$loisir,
								$mdp));
								$erreur = "Votre compte a bien été créé";
								header('Location: connexion.php');
							}
							else
                    		{
								$erreur = "Vos mots de passe ne correspondent pas";
                    		}
						}
						else
						{
							$erreur = "L'adresse mail est déja utilisé.";
						}
 
					}
                	else
                	{
						$erreur = "Votre prénom ne doit pas dépasser 255 caractères";
					}
				}
 
            }
            else
            {
                $erreur = "Votre nom ne doit pas dépasser 255 caractères";
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
      <title>Inscription</title>
      <meta charset="utf-8">
	    <link href="css/cssins.css" rel="stylesheet" type="text/css">
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
  <header> <a href=index.php>
    <h4 class="logo">My MEETIC</h4>
    </a>
    <nav>
      <ul class="navigation">
        <li><a href="Index.php">HOME</a></li>
        <li><a href="#about">RECHERCHE</a></li>
         <li class="menu"><span>CONNEXION/INSCRIPTION</span>
			 <ul class="sousmenu">
		  	<li><a href="Connexion.php">Connexion</a></li>
		 	 <li><a href="Inscription.php">Inscription</a></li>
			 </ul>
		  
      </ul>
    </nav>
  </header>
   <body><br><br><br><br>
      <div align="center" id="inscription">
         <h2>Inscription</h2>
         <br /><br />
         <form method="POST" action="">
			 <div>
        <label for="homme">Sexe :</label>
		
                <input type="radio" id="homme" name="sexe" value="Homme"class="radio">
		<label for = "homme">Homme</label>
	
		
		        <input type="radio" id="femme" name="sexe" value="Femme"class="radio">
		<label for = "femme">Femme</label>
		
		        <input type="radio" id="autre" name="sexe" value="Autre"class="radio">
		<label for = "autre">Autre</label>
	</div>
			 <br>
			 <div>
			<label for="jeuxvideo">loisirs:</label>
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
			 <br>
			 		<div>
			<label for="naissance">Date de naissance:</label>
			<input type="date" id="naissance" name="nais" value="<?php if(isset($nais)) { echo $nais; } ?>">
		</div>
			 <br>
            <table>
               <tr>
                  <td align="left">
                     <label for="nom">Nom :</label><br><br>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre nom" id="nom" name="nom" class="input" value="<?php if(isset($nom)) { echo $nom; } ?>"/><br><br>
                  </td>
               </tr>
               <tr>
                  <td align="left">
                     <label for="prenom">Prénom :</label><br><br>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre prénom" id="prenom" name="prenom" class="input" value="<?php if(isset($prenom)) { echo $prenom; } ?>"/><br><br>
                  </td>
               </tr>
			   <tr>
                  <td align="left">
                     <label for="ville">Ville :</label><br><br>
                  </td>
				   
                  <td>
                     <input type="text" placeholder="Votre ville" id="ville" name="ville" class="input" value="<?php if(isset($ville)) { echo $ville; } ?>"/><br><br>
                  </td>
               </tr>
               <tr>
                  <td align="left">
                     <label for="mail">mail :</label><br><br>
                  </td>
                  <td>
                     <input type="email" placeholder="votre mail" id="mail" name="mail" class="input" value="<?php if(isset($mail)) { echo $mail; } ?>"/><br><br>
                  </td>
               </tr>
               <tr>
                  <td align="left">
                     <label for="mdp">Mot de passe :</label><br><br>
                  </td>
                  <td>
                     <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp"class="input" /><br><br>
                  </td>
               </tr>
               <tr>
                  <td align="left">
                     <label for="mdp2">Confirmation du mot de passe :</label><br><br>
                  </td>
                  <td>
                     <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" class="input" /><br><br>
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td align="left">
                     <br />
                     <input type="submit" name="forminscription" value="Je m'inscris" /><br><br>
                  </td>
               </tr>
            </table>
         </form>
		  <a href="Connexion.php">Déja un compte ? Connexion</a><br><br>
		  
		  
		  <?php
		  if(isset($erreur))
		  {
			  echo '<font color="red">'.$erreur. "</font>";
		  }
		  ?>
      </div>
	   <br><br><br><br>
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