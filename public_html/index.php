<?php 
  define('BASE_PATH', realpath(__DIR__));
  require_once BASE_PATH . "/../app/Controllers/redirect_to_home.php"; 
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- icon file css -->
    <link rel="stylesheet" href="assets/css/all.min.css">
    <!-- render file css -->
    <link rel="stylesheet" href="assets/css/normalize.css">
    <!-- main file css --> 
    <link rel="stylesheet" href="assets/css/master.css">
    <link rel="stylesheet" href="assets/css/main-master.css">
    <!-- google font  -->
    <title>Book Club</title>
    <script type="text/javascript">
    </script>
  </head>
  <body>
    <header>
      <nav class="container">
          <div class="logo">
            Book Club
          </div>
          <div class="links">
            <a href="/login.php" class="btn bg-wh">login</a>
            <a href="/sing-up.php" class="btn bg-wh">sing up</a>
          </div>
      </nav>
    </header>

    <div class="container">
      <main>
        <div class="box">
          <i class="fas fa-users"></i>
          <p class="box-heading">
            Who are <span>we?</span>
          </p>
          <p class="box-details">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
            Quae illo repellat, eveniet voluptatum quam aspernatur nesciunt perspiciatis, 
            odit iure quidem officiis non esse reprehenderit rem minima 
            exercitationem temporibus labore atque?
          </p>
        </div>

        <div class="box">
          <i class="fas fa-users"></i>
          <p class="box-heading">
            Why <span>us?</span>
          </p>
          <p class="box-details">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
            Quae illo repellat, eveniet voluptatum quam aspernatur nesciunt perspiciatis, 
            odit iure quidem officiis non esse reprehenderit rem minima 
            exercitationem temporibus labore atque?
          </p>
        </div>

        <div class="box">
          <i class="fas fa-users"></i>
          <p class="box-heading">
            How to be one of <span>us?</span>
          </p>
       
          <p class="box-details">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
            Quae illo repellat, eveniet voluptatum quam aspernatur nesciunt perspiciatis, 
            odit iure quidem officiis non esse reprehenderit rem minima 
            exercitationem temporibus labore atque?
          </p>
        </div>
      </main>
    </div>

    <footer class="container">
      <div>
        All Right Received for <span>Book Club &copy;</span>
      </div>
    </footer>
  </body>
</html>