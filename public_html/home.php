<?php
  define('BASE_PATH', realpath(__DIR__));
  include BASE_PATH  . "/../app/Controllers/redirect_to_login.php";
  include BASE_PATH  . "/../app/Controllers/books_controller.php";
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
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/master.css">
    <link rel="stylesheet" href="assets/css/main-master.css">
    <!-- google font  -->
    <title>Book Club</title>
    <script type="text/javascript">
    </script>
  </head>
  <body class="home">
    <div class="nav">
      <nav class="container">
          <div class="logo">
            <a href="home.php" style="all:inherit; cursor:pointer;">Book Club</a>
          </div>
          <div class="links">
            <a href="/home.php" class="btn bg-wh"><i class="fas fa-book-reader"></i><span>Browse</span></a>
            <a href="/upload.php" class="btn"><i class="fas fa-cloud-upload-alt"></i><span>Upload</span></a>
            <a href="/profile.php"><img src="./assets/images/avater.svg" alt="" srcset=""></a>
          </div>
      </nav>
    </div>

    <div class="main">
      <div class="container">

        <!-- Search Form -->
        <form action="" method="get" class="search">
          <input type="search" name="searchFor" placeholder="Looking For Something" required>
          <!-- <input type="submit" value=""> -->
          <!-- <button type="reset" class="bg-wh"><i class="fas fa-times"></i></button> -->
          <button type="submit" class="bg-wh"><i class="fas fa-search"></i></button>
        </form>
        <div>
          <?php
            try {
              $myBooks = new BookController();
              $books = ($_REQUEST)? $myBooks->searchForBooks($_REQUEST["searchFor"]): $myBooks->getBooks();
              if (!$books)
                echo "<div class='text-white d-flex flex-column'> <b>No Books Founds</b> </div>";
              foreach ($books as $book) {
                // $bookPDFName = basename($book["book_path"]);
                echo<<<"bookBox"
                  <div class="text-white d-flex flex-column">
                    <figure>
                      <img src="$book[book_cover_image]" alt="book cover img" >
                      <!-- <figcaption>$book[book_title]</figcaption> -->
                    </figure>
                    <article>
                      <div>
                        <h3>$book[book_title]</h3>
                        <p>$book[author_name]</p>
                      </div>
                      <p>$book[book_description]</p>
                    </article>
                    <section>
                      <a href="./download.php?file=$book[book_path]"><i class="fas fa-download"></i></a>
                      <a href="read.php?book_id=$book[book_id]" class="btn bg-wh">Read</a>
                    </section>
                  </div>
                bookBox;
              }
            } catch (\Throwable $th) {
              echo "<br>We face Error: ";
              echo $th;
            }
          ?>
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
