<!-- Dernière modif par dan à 18:00 le 18/11/2017 merci à max pour l'aide ;-) -->
<?php if(session_status() == PHP_SESSION_NONE){session_start();}
include('securimage/securimage.php');
$securimage = new Securimage();?>
<!DOCTYPE html>
<html>
<?php include("includes/head.php");
include("includes/header.php"); ?>
    <main>
<?php
include('includes/bdd/bdd.php');
$securimage = new Securimage();

if(isset($_POST['email']) && isset($_POST['identity']) && ($_POST['password']) && isset($_POST['password1']) && isset($_POST['captchaText'])){
  //Si la page reçoie les données du formulaires alors on les traite puis on les ajoutes à la bdd
  //Sinon on affiche le formulaire d'inscription
  // #1 vérification de l'email
  $check = $bdd->query('SELECT COUNT(*) AS verif FROM virtual_users WHERE email ='.'"'.$_POST['email'].'"');
  $email = $check->fetch();
  $check->closeCursor();
  if (preg_match("#^[a-z0-9._-]+@libmail.eu$#", $_POST['email'])) {
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

      <div class="row">
        <div class="col s10 offset-s1 m8 offset-m2 l6 offset-l3 center">
          <h3 class="teal-text">INSCRIPTION À LIBMAIL TERMINÉE</h3>
          <p>Connectez-vous dès maintenant sur roundcube</p>
          <a href="https://web.libmail.eu" class="btn-large waves-effect waves-light">C'est parti !</a>
        </div>
      </div>

<?php  }else{ ?>

      <div class="row">
        <div class="col s10 offset-s1 m8 offset-m2 l6 offset-l3 center">
          <h3 class="red-text">INSCRIPTION À LIBMAIL ÉCHOUÉE</h3>
          <p>L'email demandé existe déjà ou une des informations renseignées ne répond pas aux normes techniques. Veuillez réessayer ...</p>
          <a href="user.php" class="btn-large waves-effect waves-light">Retour</a>
        </div>
      </div>

<?php } }else{ ?>

      <script type="text/javascript" src="includes/form_javascript.js"></script>
      <div class="row">
        <div class="col s10 offset-s1 m8 offset-m2 l6 offset-l3 center">
          <br>
          <h3 class="teal-text">INSCRIPTION À LIBMAIL</h3>
          <br><br>
          <form  name="registerForm" action="user.php" method="post">
            <div class="input-field col s12">
              <i class="material-icons prefix">send</i>
              <input placeholder="sous la forme : user@libmail.eu" id="email" type="text" name="email" onchange='emailCheck();'>
              <label for="email" data-error="L'adresse Libmail renseignée ne convient pas.">Votre adresse Libmail</label>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">account_circle</i>
              <input id="identity" type="text" name="identity" onchange='identityCheck();'>
              <label for="identity" data-error="L'identité renseignée ne convient pas.">Nom et Prénom</label>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">vpn_key</i>
              <input id="password" type="password" name="password" onchange='passwordCheck();'>
              <label for="password" data-error="Votre mot de passe doit faire au moins 8 caractères.">Mot de passe</label>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">vpn_key</i>
              <input id="confirmPassword" type="password" name="password1" onchange='confirmPasswordCheck();'>
              <label for="confirmPassword" data-error="Les mots de passe ne correspondent pas.">Confirmation</label>
            </div>
            <div class="col s8 offset-s2">
              <div class="card-panel grey lighten-3">
                <input type="checkbox" id="captchaCheckbox" onclick="captchaOpen();"/>
                <label for="captchaCheckbox">Je ne suis pas un robot.</label>
                <script type="text/javascript">
                  function captchaOpen(){
                    $('#modal1').modal('open');
                    document.getElementById("captchaCheckbox").checked = false;
                  }
                </script>
              </div>
            </div>
            <!-- modal du captcha -->
            <div id="modal1" class="modal">
              <div class="row">
                <div class="col s10 offset-s1 m8 offset-m2 l6 offset-l3 center">
                  <br>
                  <h3 class="teal-text">VÉRIFICATION CAPTCHA</h3>
                  <br><br>
                  <div class="col s12 center">
                    <img class="center" id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
                  </div>
                  <div class="input-field col s12">
                    <i class="material-icons prefix">security</i>
                    <input placeholder="" id="captcha" type="text" name="captchaText" onchange='captchaCheck();' maxlength="6">
                    <label for="captchaText" data-error="Le code renseigné ne convient pas.">Entrer le texte visible ci-dessus.</label>
                  </div>
                  <div class="input-field col s12 center">
                    <p>En cliquant sur ce bouton vous acceptez les <a href="cgu.php" target="_blank">conditions génerales d'utilisation</a></p>
                    <button class="btn waves-effect waves-light green" type="submit" name="submitActionBt" disabled=""><i class="material-icons left">done_all</i>S'inscrire</button>
                  </div>
                </div>
              </div>
            </div>
            <script type="text/javascript">
              $(document).ready(function(){
                $('.modal').modal();
              });
            </script>
          </form>
        </div>
        <div class="col s10 offset-s1 m8 offset-m2 l4 offset-l4">
          <br>
          <div class="card grey darken-1">
            <div class="card-content white-text">
              <span class="card-title">À propos des données personnelles ...</span>
                <li>Les informations recueillies sur ce formulaire sont enregistrées dans un fichier informatisé par Libmail pour le fonctionnement de vos services mail.</li>
                <li>Elles sont conservées pendant toute la durée de validité de votre compte Libmail et ne sont destinées à aucune entité tierce.</li>
                <li>Conformément à la loi « informatique et libertés », vous pouvez exercer votre droit d'accès aux données vous concernant et les faire rectifier en contactant : L'équipe Libmail <a class="orange-text lighten-2" href="mailto:team@libmail.eu?subject=Question_relative_aux_données_personelles">team@libmail.eu</a>.</li>
            </div>
            <div class="card-action">
              <a class="white-text" href="https://www.cnil.fr/" target="_blank">Plus d'information</a>
            </div>
          </div>
        </div>
      </div>


<?php } ?>
    </main>
<?php include("includes/footer.php"); ?>
  </body>
</html>
