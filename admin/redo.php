<?php
session_start();

if (!isset($_SESSION['restored_book']) || !isset($_SESSION['restored_time']) || time() - $_SESSION['restored_time'] > 60) {
    // No redo or expired
    header("Location: book_view_admin.php");
    exit();
}

$book_id = $_SESSION['restored_book']['book_id'];

$conn = new mysqli('localhost', 'root', '', 'book_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("DELETE FROM books WHERE book_id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$stmt->close();
$conn->close();

// Clear redo session
unset($_SESSION['restored_book'], $_SESSION['restored_time']);

header("Location: book_view_admin.php");
exit();
?>