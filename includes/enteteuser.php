<nav class="navbar navbar-expand-lg navbar-light p-3 mb-2 bg-info text-white">
  <a class="navbar-brand" style="color:white; font-size:1.2em;" href="#">Menu</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" onclick="return confirm('Voulez vous vraiment quitter cette page ?');" style="color:white; font-size:1.2em;" href="logout.php">Déconnexion[<?php echo(isset($_SESSION['PROFILE'])?$_SESSION['PROFILE']['nom_utilisateur']:"")?>]</a>
      </li>
      <!-- <li class="nav-item active">
        <a class="nav-link" href="authentification_apprenant.php"> Authentification Apprenant</a>
      </li> -->

      <!-- <li class="nav-item active">
        <a class="nav-link" href="creerformation.php"> Formations</a>
      </li> -->
      <!-- <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout[<?php echo(isset($_SESSION['PROFILE'])?$_SESSION['PROFILE']['LOGIN']:"") ?>]</a>
      </li> -->
    </ul>
  </div>
</nav>