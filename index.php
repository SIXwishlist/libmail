<!DOCTYPE html>
<html>
<?php include("includes/head.php"); ?>

<?php include("includes/header.php"); ?>
    <div class="container">
      <div class="jumbotron text-center">
        <h1 class="display-4 text-primary"><strong>Libmail</strong></h1>
        <h2 class="">Un service de courrier électronique simple, rapide, libre et respectueux de la vie privée.</h2>
        <br>
        <a href="user.php" class="btn btn-lg btn-warning">inscription</a>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-4 text-center padding">
          <h1 class="text-primary display-3"><span class="oi oi-flash" title="flash" aria-hidden="true"></span></h1>
          <h2>Facile et Performant</h2>
          <p class="text-justify">Nous proposons un service mail (imap, imaps, pop, pops, smtp) configurable avec tous les clients de messagerie standards, ainsi qu'une interface roundcube pour consulter votre messagerie directement depuis votre navigateur web.</p>
        </div>
        <div class="col-md-4 text-center padding">
          <h1 class="text-primary display-3"><span class="oi oi-people" title="people" aria-hidden="true"></span></h1>
          <h2>Un Projet Communautaire</h2>
          <p class="text-justify">La démarche est résolument militante car aujourd'hui il est très difficile de trouver un service de courrier électronique indépendant et fonctionnant uniquement avec des logiciels libres. Nous comptons également sur la communauté pour améliorer notre service.</p>
        </div>
        <div class="col-md-4 text-center padding">
          <h1 class="text-primary display-3"><span class="oi oi-wrench" title="wrench" aria-hidden="true"></span></h1>
          <h2>Une conception solide</h2>
          <p class="text-justify">Les infrastructures sont basées sur un VPS hébergé chez OVH. Le serveur fonctionne avec le système d'exploitation Debian 9, connu pour sa stabilité. Les données stockées sont chiffrées pour ganrantir la sécurité et la confidentialité.</p>
        </div>
      </div>
    </div>
  <?php include("includes/footer.php"); ?>
  </body>
</html>
