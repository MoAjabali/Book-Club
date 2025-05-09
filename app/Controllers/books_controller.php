<?php
  require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../app/models/model_book.php");
  class BookController {
    private $bookDB;

    // todo: Security & better & Error
    function __construct() {
      $this->bookDB = new BookDB();
    }

    // todo: Upload A book
    function addBook($data){
      $data+=["author_id" => 0];
      // $inputs_array["book_description"] = ($inputs_array["book_description"]) ? $inputs_array["book_description"] : null;
      // echo  ($inputs_array["book_description"]) ? "true" : "false" ;
      return $this->bookDB->uploadBook($data);
    }

    function getBooks(){
      return $this->bookDB->getBooks();
    }

    function searchForBooks($book){
      // Todo: Filter the search input
      return $this->bookDB->searchForBooks($book);
    }

    function getBookById($book_id){
      return $this->bookDB->getBookById($book_id);
    }

    function uploadFile($input_name, $type, $maxSizeInMB = 100) : string {
      if (!isset($_FILES[$input_name])) // Check if the file exist
        throw new Exception("There is no file to upload.");
      if($_FILES[$input_name]['error']!=0)
        throw new Exception("the file dose not uploaded correctly");
        
      // Having file info
      $filepath = $_FILES[$input_name]['tmp_name'];
      $fileSize = filesize($filepath);

      // todo: understand this 2 lines
      $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
      $filetype = finfo_file($fileinfo, $filepath);

      if ($fileSize === 0) // If the File empty
        throw new Exception("The file is empty.");

      if ($fileSize > (1024 * 1024 * $maxSizeInMB)) // 3 MB (1 byte * 1024 * 1024 * 3 (for 3 MB))
        throw new Exception("The file is too large");
      
      if ($type == "pdfs")
        $allowedTypes = [ 'application/pdf' => 'pdf'];
      elseif($type == "imgs")
        $allowedTypes = [ 'image/png' => 'png', 'image/jpeg' => 'jpg' ];
      else
        $allowedTypes = [];
      
      if (!in_array($filetype, array_keys($allowedTypes))) // only allowed Typed
        throw new Exception("File not allowed.");
      
      // make the new path and file
      $filename = uniqid("file_");
      $extension = $allowedTypes[$filetype];
      $targetDirectory = realpath($_SERVER['DOCUMENT_ROOT'] . "/uploads/$type"); // dirname(__DIR__) is the parent directory of the current PHP file  
      $newFilepath = $targetDirectory . "/" . $filename . "." . $extension;
    
      if (!copy($filepath, $newFilepath)) // Copy the file, returns false if failed
        throw new Exception("Can't move file.");
      unlink($filepath); // Delete the temp file
      
      return "uploads/$type/$filename.$extension";
    }

    // function getBook($book_name, $book_author){
    //   // todo: Filter
    //   return $this->bookDB->getBook($book_name, $book_author);
    // }
  }

  // $myBooks = new BookController();
  // print_r( $myBooks->getBooks() );

  // $bookDB = new BookDB("book_club", "root");
  // echo "<pre>";
  // print_r($bookDB->getBooks());
  // print_r($bookDB->searchForBooks("unknown"));
  // print_r($bookDB->getBook("Database deisign", "'unknown'"));
  // echo "</pre>";