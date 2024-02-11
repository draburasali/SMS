<!DOCTYPE html>
<html>

<head>
    <title>Tripoli Library Search Results</title>
</head>

<body>
    <h1>Tripoli Library Search Results</h1>

    <?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/sql_connection_class/bookphp/Book.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/sql_connection_class/database/Database.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/sql_connection_class/database/SqlServices.php";

    // create short variable names
    try {
        if (
            !isset($_POST['searchtype']) || !isset($_POST['searchterm'])
        ) {
            throw new Exception("<p>You have not entered all the required details.<br />
                        Please go back to SearchBook.html and try again.</p>");
        }
        // create short variable names
        $searchtype = $_POST['searchtype'];
        $searchterm = $_POST['searchterm'];
        // whitelist the searchtype
        switch ($searchtype) {
            case 'Title':
            case 'Author':
            case 'ISBN':
                break;
            default:
                throw new Exception('<p>That is not a valid search type. <br/>');
        }
        $query = "SELECT ISBN, Author, Title, Price FROM Books 
        WHERE $searchtype Like  '%$searchterm%'  ";
        echo $query;
        //create a db object
        $myDB = new Database();
        $conn = $myDB->establishConnection();
        $mySqlServices = new SqlServices($conn);
        $result = $mySqlServices->query($query);
        echo "<p>Number of books found: " . $result->num_rows . "</p>";
        $rows = $result->num_rows;
        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            echo ("book-" . $j);
            echo "<p><strong>Title: " . $row['Title'] . "</strong>";
            echo "<br />Author: " . $row['Author'];
            echo "<br />ISBN: " . $row['ISBN'];
            echo "<br />Price: " . number_format($row['Price'], 2) . " LYD </p>";

        }


    } catch (Exception $e) {
        //catch exception
        echo '<BR>Message: ' . $e->getMessage();
    } finally {
        $myDB->closeConnection();
    }





    ?>
</body>
<!--     
            $book = new Book($row['ISBN'], $row['Author'], $row['Title'], $row['Price']);
            $book->dispaly_book_details();
-->

</html>