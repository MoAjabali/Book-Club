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
  <body class="upload">
    <div class="nav">
      <nav class="container">
          <div class="logo">
            <a href="home.php" style="all:inherit; cursor:pointer;">Book Club</a>
          </div>
          <div class="links">
            <a href="/home.php" class="btn"><i class="fas fa-book-reader"></i><span>Browse</span></a>
            <a href="/upload.php" class="btn bg-wh"><i class="fas fa-cloud-upload-alt"></i><span>Upload</span></a>
            <a href="/profile.php"><img src="./assets/images/avater.svg" alt="" srcset=""></a>
          </div>
      </nav>
    </div>

    <div class="main">
      <div class="container">
        <form action="" method="post" class="upload-book d-flex flex-column" enctype="multipart/form-data">
          <!-- Upload Book Cover -->
          <div class="input-group mb-3">
            <label class="input-group-text" for="bookCover">Upload Book Cover</label>
            <input type="file" class="form-control" name="book_cover_image" accept="image/*" id="bookCover">
          </div>
          
          <!-- Upload The Book -->
          <div class="input-group mb-3">
            <label class="input-group-text" for="bookPDF">Upload The Book</label>
            <input type="file" class="form-control" name="book_path" accept="application/pdf" id="bookPDF" required>
          </div>

          <!-- Book Title -->
          <div class="input-group mb-3">
            <span class="input-group-text">Book Title</span>
            <input type="text" aria-label="Book Title" name="book_title" class="form-control" placeholder="Harry Potter" required>
          </div>
          
          <!-- Book Author -->
          <div class="input-group mb-3">
            <span class="input-group-text">Author Name</span>
            <!-- <input type="hidden" name=""> -->
            <input type="text" aria-label="Author Name" name="author_name" class="form-control" placeholder="Mohammed Al-Jabali" required>
          </div>

          <!-- Book Publish Date -->
          <div class="input-group mb-3">
            <span class="input-group-text">Book Publish Date</span>
            <input type="Date" aria-label="Book Publish Date" name="book_published_date" class="form-control">
          </div>

          <!-- Book Description -->
          <div class="input-group mb-3">
            <span class="input-group-text">Book Description</span>
            <textarea class="form-control" name="book_description" aria-label="With textarea"></textarea>
          </div>

          <?php
          // Handle file upload
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
              $bookController = new BookController();
              $inputs = $_POST;
              $inputs += [
                "book_path"=> $bookController->uploadFile("book_path", "pdfs"), 
                "book_cover_image" => ($_FILES["book_cover_image"]['error']==0)? $bookController->uploadFile("book_cover_image", "imgs") :""
              ];
              $bookController->addBook($inputs);
              echo<<<"succussUpload"
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>you have Successfully Added The Book :)</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>      
              succussUpload;
            } catch (Exception $e) {
              $msg = $e->getMessage();
              echo<<<"failedUpload"
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>We Have face Exception: </strong> $msg
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              failedUpload;
            }
          }
        ?>
          <div class="d-flex justify-content-evenly mt-3">
            <button type="submit" class="btn btn-success">Add</button>
            <button type="reset" class="btn btn-danger">Cancel</button>
          </div>
        </form>
      </div>
    </div>

    <footer class="container">
      <div>
        All Right Receved for <span>Book Club ®</span>
      </div>
    </footer>

    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
