<?php
  include_once "database.php";
  class BookDB {
    // todo: Security & better & Error
    private $db;
    function __construct() {
      $this->db = new theDatabase();
    }
    /*
      Array (
        [book_title] => Free Lancer 
        [author_name] => Houseb 
        [book_published_date] => 
        [book_description] => 
        [book_path] => uploads/pdfs/file_67f9fcd9e7c77.pdf 
        [book_cover_image] => 
      )
    */
    function uploadBook($data){
      $data["book_description"] = ($data["book_description"]) ? $data["book_description"] : null ;
      $data["book_cover_image"] = ($data["book_cover_image"]) ? $data["book_cover_image"] : "uploads/imgs/default.png" ;
      $data["book_published_date"] = ($data["book_published_date"]) ? $data["book_published_date"] : null ;
      $data["author_id"] = ($data["author_id"]) ? $data["author_id"] : 0 ;
      
      $sqlStatement=
        "INSERT INTO books(book_path, book_title, book_description, book_cover_image, book_published_date, author_id) 
        VALUES (?,?,?,?,?,?)";
      $stmt = $this->db->getConnection()->prepare($sqlStatement);
      $stmt->bindParam(1, $data["book_path"], PDO::PARAM_STR);
      $stmt->bindParam(2, $data["book_title"], PDO::PARAM_STR);
      $stmt->bindParam(3, $data["book_description"], PDO::PARAM_STR);
      $stmt->bindParam(4, $data["book_cover_image"], PDO::PARAM_STR);
      $stmt->bindParam(5, $data["book_published_date"], PDO::PARAM_STR);
      $stmt->bindParam(6, $data["author_id"], PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll();
      $this->db->close();
      return $result;
    }

    function getBooks(){
      $stmt = $this->db->getConnection()->prepare(
        "SELECT books.book_cover_image, books.book_id,books.book_path, books.book_title, books.book_description, authors.author_name 
        FROM books LEFT JOIN authors ON books.author_id = authors.author_id 
        ORDER BY books.book_uploaded_at"
      );
      $stmt->execute();
      $result = $stmt->fetchAll();
      $this->db->close();
      return $result;
    }

    function searchForBooks($book){
      $book = "%$book%";
      $stmt = $this->db->getConnection()->prepare(
        "SELECT books.book_path, books.book_title, books.book_description, authors.author_name
        FROM books LEFT JOIN authors ON books.author_id = authors.author_id 
        WHERE books.book_title LIKE ? || authors.author_name LIKE ? 
        ORDER BY books.book_uploaded_at "
      );
      $stmt->bindParam(1, $book, PDO::PARAM_STR);
      $stmt->bindParam(2, $book, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetchAll();
      $this->db->close();
      return $result;
    }

    function getBook($book_name, $book_author){
      $stmt = $this->db->getConnection()->prepare(
        "SELECT books.book_cover_image, books.book_path, books.book_title, books.book_description, authors.author_name
        FROM books LEFT JOIN authors ON books.author_id = authors.author_id 
        ORDER BY books.book_uploaded_at 
        WHERE books.book_title LIKE ? || authors.author_name LIKE ? "
      );
      $stmt->bindParam(1, $book_name, PDO::PARAM_STR);
      $stmt->bindParam(2, $book_author, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetchAll();
      $this->db->close();
      return $result[0];
    }
    function getBookById($book_id){
      $stmt = $this->db->getConnection()->prepare(
        "SELECT books.*, authors.author_name
        FROM books 
        LEFT JOIN authors ON books.author_id = authors.author_id 
        WHERE books.book_id = ?"
      );
      $stmt->bindParam(1, $book_id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll();
      $this->db->close();
      return $result[0];
    }

    function getAuthor($author_name) {
      // Search for existing author
      $stmt = $this->db->getConnection()->prepare("SELECT author_id FROM authors WHERE author_name = ?");
      $stmt->bindParam(1, $author_name, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetchAll();
      $this->db->close();
      if ($result)
          return $result[0]['author_id']; // Author exists, return their ID
      else 
          return $this->createAuthor($author_name); // Author doesn't exist, create new one
    }

    function createAuthor($author_name) {
      $stmt = $this->db->getConnection()->prepare("INSERT INTO authors (author_name) VALUES (?)");
      $stmt->bindParam(1, $author_name, PDO::PARAM_STR);
      $stmt->execute();
      $this->db->close();
      return $this->getAuthor($author_name);
    }
  }