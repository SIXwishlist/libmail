<?php if(session_status() == PHP_SESSION_NONE){session_start();}
include('securimage/securimage.php');
$securimage = new Securimage();?>
<!DOCTYPE html>
<html>
<?php include("includes/head.php");
include("includes/header.php");
include("includes/bdd/bdd.php");
$securimage = new Securimage();

if(isset($_POST['email']) && isset($_POST['identity']) && ($_POST['password']) && isset($_POST['password1']) && isset($_POST['captchaText'])){
  //Si la page reçoie les données du formulaires alors on les traite puis on les ajoutes à la bdd
  //Sinon on affiche le formulaire d'inscription
  // #1 vérification de l'email
  $_POST['email'] = $_POST['email'].'@libmail.eu';
  $check = $bdd->query('SELECT COUNT(*) AS verif FROM virtual_users WHERE email ='.'"'.$_POST['email'].'"');
  $email = $check->fetch();
  $check->closeCursor();
  if (preg_match("#[a-z0-9._-]+@libmail.eu$#", $_POST['email'])) {
    $regmail = TRUE;
  }else{
    $regmail = FALSE;
  }// regex pour tous les types de mails "#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#"
  // #2 vérification de l'identité
  if (preg_match("#[a-zA-Z]#", $_POST['identity'])) {
    $regidentity = TRUE;
  }else{
    $regidentity = FALSE;
  }
  if ($regmail == TRUE && $email['verif'] == 0 && strlen($_POST['email']) >= 14 && $regidentity = TRUE && strlen($_POST['password']) >= 8 && strlen($_POST['email']) <= 35 && $_POST['password'] == $_POST['password1'] && $securimage->check($_POST['captchaText']) == true) {
    // #3 traitement de la phrase de passe
    $salt = '$5$'.bin2hex(random_bytes(16)).'$';
    $passhash = '{SHA256-CRYPT}'.crypt($_POST['password'], $salt);
    //requetes à la bdd
    // #4 ajout infos nécessaires à dovecot
    $req = $bdd->prepare('INSERT INTO virtual_users (domain_id, email, password)
    VALUES(?, ?, ?)');
    $req->execute(array('1', $_POST['email'], $passhash));
    // #5 mise à jour de l'identité
    $req1 = $bdd->prepare('UPDATE virtual_users SET identity = :identity WHERE email = :email');
    $req1->execute(array('identity' => $_POST['identity'], 'email' => $_POST['email']));
  ?>

      <div class="container">
        <div class="row">
          <div class="col-md-10 offset-md-1 text-center">
            <h3 class="text-success">INSCRIPTION À LIBMAIL TERMINÉE</h3>
            <p>Connectez-vous dès maintenant sur roundcube</p>
            <a href="https://web.libmail.eu" class="btn btn-lg btn-success">C'est parti !</a>
          </div>
        </div>
      </div>

<?php  }else{ ?>

      <div class="container">
        <div class="row">
          <div class="col-md-10 offset-md-1 text-center">
            <h3 class="text-danger">INSCRIPTION À LIBMAIL ÉCHOUÉE</h3>
            <p>L'email demandé existe déjà ou une des informations renseignées ne répond pas aux normes techniques. Veuillez réessayer ...</p>
            <a href="user.php" class="btn btn-lg btn-success">Retour</a>
          </div>
        </div>
      </div>

<?php } }else{ ?>

  <script type="text/javascript" src="includes/form_javascript.js"></script>
  <div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
        <h1 class="text-primary text-center">INSCRIPTION À LIBMAIL</h3>
        <br><br>
        <form  name="registerForm" action="user.php" method="post">
          <div class="form-group col-12">
            <label for="email" data-error="L'adresse Libmail renseignée ne convient pas.">Votre adresse Libmail</label>
            <div class="input-group">
              <input type="text" name="email" class="form-control" id="email" placeholder="Nom d'utilisateur" aria-label="email" aria-describedby="domain" onchange='emailCheck();'>
              <div class="input-group-append">
                <span class="input-group-text" id="domain">@libmail.eu</span>
              </div>
            </div>
          </div>
          <div class="form-group col-12">
            <label for="identity" data-error="L'identité renseignée ne convient pas.">Nom et Prénom</label>
            <input type="text" name="identity" class="form-control" id="identity" placeholder="Renseignez votre identité" onchange='identityCheck();'>
          </div>
          <div class="form-group col-12">
            <label for="password" data-error="Votre mot de passe doit faire au moins 8 caractères.">Mot de Passe</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Entrez votre Mot de Passe" onchange='passwordCheck();'>
          </div>
          <div class="form-group col-12">
            <label for="confirmPassword" data-error="Les mots de passe ne correspondent pas.">Confirmation de Mot de Passe</label>
            <input type="password" name="password1" class="form-control" id="confirmPassword" placeholder="Confirmez votre Mot de Passe" onchange='confirmPasswordCheck();'>
          </div>
          <div class="form-group col-12 text-center">
            <img class="center" id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
          </div>
          <div class="form-group col-12">
            <label for="captchaText" data-error="Le code renseigné ne convient pas.">Captcha</label>
            <input type="text" name="captchaText" class="form-control" id="captcha" placeholder="Entrer le texte visible ci-dessus." onchange='captchaCheck();' maxlength="6">
          </div>
          <div class="form-group col-12 text-center">
            <p>En cliquant sur "S'incrire" vous acceptez les <a href="cgu.php" target="_blank">conditions génerales d'utilisation</a></p>
            <button class="btn btn-lg btn-primary" type="submit" name="submitActionBt" disabled="">S'inscrire</button>
          </div>
          <div class="form-group col-lg-10 offset-lg-1">
            <div class="card text-white" style="background-color: #616161">
              <div class="card-body">
                <h4 class="card-title">À propos des données personnelles ...</h4>
                <li>Les informations recueillies sur ce formulaire sont enregistrées dans un fichier informatisé par Libmail pour le fonctionnement de vos services mail.</li>
                <li>Elles sont conservées pendant toute la durée de validité de votre compte Libmail et ne sont destinées à aucune entité tierce.</li>
                <li>Conformément à la loi « informatique et libertés », vous pouvez exercer votre droit d'accès aux données vous concernant et les faire rectifier en contactant : L'équipe Libmail <a class="orange-text lighten-2" href="mailto:team@libmail.eu?subject=Question_relative_aux_données_personelles">team@libmail.eu</a>.</li>
              </div>
              <div class="card-footer">
                <a class="white-text" href="https://www.cnil.fr/" target="_blank">Plus d'information</a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>


<?php }
include("includes/footer.php"); ?>
  </body>
</html>
