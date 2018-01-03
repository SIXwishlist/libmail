<!DOCTYPE html>
<html>
<?php include("includes/head.php"); ?>

<?php include("includes/header.php"); ?>
    <main>
      <div class="section no-pad-bot" id="index-banner">
        <div class="container">
          <br>
          <h1 class="header center teal-text">Libmail</h1>
          <div class="row center">
            <h5 class="header col s12 light">Un service de courrier électronique simple, rapide, libre et respectueux de la vie privée.</h5>
          </div>
          <div class="row center">
            <a href="user.php" id="download-button" class="btn-large waves-effect waves-light">inscription</a>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="section">
          <div class="row">

            <div class="col s12 m4">
              <div class="icon-block">
                <h2 class="center light-blue-text large"><i class="material-icons">flash_on</i></h2>
                <h5 class="center">Facile et Performant</h5>

                <p class="light">Nous proposons un service mail (imap, imaps, pop, pops, smtp) configurable avec tous les clients de messagerie standards, ainsi qu'une interface roundcube pour consulter votre messagerie directement depuis votre navigateur web.</p>
              </div>
            </div>

            <div class="col s12 m4">
              <div class="icon-block">
                <h2 class="center light-blue-text large"><i class="material-icons">group</i></h2>
                <h5 class="center">Un projet totalement libre !</h5>

                <p class="light">La démarche est résolument militante car aujourd'hui il est très difficile de trouver un service de courrier électronique indépendant et fonctionnant uniquement avec des logiciels libres. Nous comptons également sur la communauté pour améliorer notre service.</p>
              </div>
            </div>

            <div class="col s12 m4">
              <div class="icon-block">
                <h2 class="center light-blue-text large"><i class="material-icons">settings</i></h2>
                <h5 class="center">Une conception solide</h5>

                <p class="light">Les infrastructures sont basées sur un VPS hébergé chez OVH. Le serveur fonctionne avec le système d'exploitation Debian 9, connu pour sa stabilité. Les données stockées sont chiffrées pour ganrantir la sécurité et la confidentialité.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <br />
  <?php include("includes/footer.php"); ?>
  </body>
</html>
