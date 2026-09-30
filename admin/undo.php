<?php
session_start();

if (!isset($_SESSION['deleted_book']) || !isset($_SESSION['deleted_time']) || time() - $_SESSION['deleted_time'] > 60) {
    // No undo or expired
    header("Location: book_view_admin.php");
    exit();
}

$book = $_SESSION['deleted_book'];

$conn = new mysqli('localhost', 'root', '', 'book_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert book back
$stmt = $conn->prepare("INSERT INTO books (book_id, book_name, no_of_pages, illustration, author, publisher, summary, genre) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    "isisssss",
    $book['book_id'],
    $book['book_name'],
    $book['no_of_pages'],
    $book['illustration'],
    $book['author'],
    $book['publisher'],
    $book['summary'],
    $book['genre']
);
$stmt->execute();
$stmt->close();
$conn->close();

// Save restored for redo
$_SESSION['restored_book'] = $book;
$_SESSION['restored_time'] = time();

// Clear deleted undo
unset($_SESSION['deleted_book'], $_SESSION['deleted_time']);

header("Location: book_view_admin.php");
exit();
?>