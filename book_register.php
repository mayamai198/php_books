<?php
// Database connection
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'book_db';

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Register a new book
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $book_id = (int)$_POST['book_id'];
    $book_name = $conn->real_escape_string($_POST['book_name']);
    $no_of_pages = (int)$_POST['no_of_pages'];
    $illustration = $conn->real_escape_string($_POST['illustration']);
    $author = $conn->real_escape_string($_POST['author']);
    $publisher = $conn->real_escape_string($_POST['publisher']);
    $summary = $conn->real_escape_string($_POST['summary']);
    $genre = $conn->real_escape_string($_POST['genre']);

    $sql = "INSERT INTO books (book_id, book_name, no_of_pages, illustration, author, publisher, summary, genre)
            VALUES ($book_id, '$book_name', $no_of_pages, '$illustration', '$author', '$publisher', '$summary', '$genre')";

    if ($conn->query($sql) === TRUE) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

// Fetch all books
$books = $conn->query("SELECT * FROM books ORDER BY book_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Manager</title>
</head>
<body>

<h2>Register a New Book</h2>
<form method="POST" action="">
    <input type="hidden" name="register" value="1">

    <label>Book ID:</label><br>
    <input type="number" name="book_id" required><br><br>

    <label>Book Name:</label><br>
    <input type="text" name="book_name" required><br><br>

    <label>No Of Pages:</label><br>
    <input type="number" name="no_of_pages" required><br><br>

    <label>Illustration:</label><br>
    <input type="text" name="illustration" required><br><br>

    <label>Author:</label><br>
    <input type="text" name="author" required><br><br>

    <label>Publisher:</label><br>
    <input type="text" name="publisher" required><br><br>

    <label>Summary:</label><br>
    <textarea name="summary" required></textarea><br><br>

    <label>Genre:</label><br>
    <input type="text" name="genre" required><br><br>

    <input type="submit" value="Register Book">
</form>