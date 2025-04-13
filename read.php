<?php
  include "controllers/redirect_to_login.php";
  include "Controllers/books_controller.php";

  // Get book details based on book_id
  if (!isset($_GET['book_id'])) {
    header("Location: home.php");
    exit();
  }
  
  try {
    $myBooks = new BookController();
    $book = $myBooks->getBookById($_GET['book_id']);
    if (!$book) {
      header("Location: home.php");
      exit();
    }
  } catch (\Throwable $th) {
    echo "Error: " . $th->getMessage();
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/master.css">
    <link rel="stylesheet" href="assets/css/main-master.css">
    <title>Read Book - Book Club</title>
  </head>
  <body class="read-book">
    <div class="nav">
      <nav class="container">
          <div class="logo">
            <a href="home.php" style="all:inherit; cursor:pointer;">Book Club</a>
          </div>
          <div class="links">
            <a href="./home.php" class="btn"><i class="fas fa-book-reader"></i><span>Browse</span></a>
            <a href="./upload.php" class="btn"><i class="fas fa-cloud-upload-alt"></i><span>Upload</span></a>
            <a href="./profile.php"><img src="./assets/images/avater.svg" alt="" srcset=""></a>
          </div>
      </nav>
    </div>

    <div class="main">
      <div class="container">
        <div class="book-details">
          <div class="book-info text-white">
            <div class="book-cover">
              <img src="<?php echo $book['book_cover_image']; ?>" alt="Book Cover">
            </div>
            <div class="book-text">
              <h2><?php echo $book['book_title']; ?></h2>
              <h4>By: <?php echo $book['author_name']; ?></h4>
              <p><?php echo $book['book_description']; ?></p>
            </div>
          </div>
          
          <div class="book-reader">
            <iframe src="<?php echo $book['book_path']; ?>" width="100%" height="800px" frameborder="0"></iframe>
          </div>
        </div>
      </div>
    </div>

    <footer class="container">
      <div>
        All Right Receved for <span>Book Club ®</span>
      </div>
    </footer>
  </body>
</html>