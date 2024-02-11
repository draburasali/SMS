<!DOCTYPE html>
<html>

<head>
  <title>Tripoli Library Book Entry Results</title>
</head>

<body>
  <h1>Tripoli Library Book Entry Results</h1>
  <?php
  require_once $_SERVER["DOCUMENT_ROOT"] . "/sql_connection_class/bookphp/Book.php";


  try {

    if (
      !isset($_POST['ISBN']) || !isset($_POST['Author'])
      || !isset($_POST['Title']) || !isset($_POST['Price'])
    ) {
      throw new Exception("<p>You have not entered all the required details.<br />
                        Please go back and try again.</p>");
    }
    // create short variable names
    $isbn = $_POST['ISBN'];
    $author = $_POST['Author'];
    $title = $_POST['Title'];
    $price = $_POST['Price'];
    $price = doubleval($price);
    //create a book object
    $book = new Book($isbn, $author, $title, $price);
    echo ($book->dispaly_book_details());
    $query = $book->insert_book_into_db();
    echo ($query);
    //create a db object
    $myDB = new Database();
    $conn = $myDB->establishConnection();
    $mySqlServices = new SqlServices($conn);
    $result = $mySqlServices->insert_record($query);

  } catch (Exception $e) {
    //catch exception
    echo '<BR>Message: ' . $e->getMessage();
  } finally {
    $myDB->closeConnection();

  }
  /*
  require_once 'dbConn.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) {
        echo "<p>Error: Could not connect to database.<br/>
        Please try again later.</p>";
          die($conn -> error);
      }
   
      $query = "INSERT INTO Books (ISBN, Author, Title, Price)  VALUES 
      ( '$isbn', '$author', '$title', $price)" ;
          $result = $conn->query($query);

      if ($result) {
          echo  "<p>Book inserted into the database.</p>";
      } else {
          echo   $conn -> error ;
          echo   "<br/>.The item was not added.";
          echo    "<br/>$query ";
      }
    
         //close connection
         $conn -> close();
         */
  ?>
</body>

</html>