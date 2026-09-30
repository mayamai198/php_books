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

$message = '';

if (!isset($_GET['book_id'])) {
    die("No book_id provided.");
}

$original_book_id = (int)$_GET['book_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // New values from the form
    $book_id = (int)$_POST['book_id'];
    $book_name = trim($_POST['book_name']);
    $no_of_pages = (int)$_POST['no_of_pages'];
    $illustration = trim($_POST['illustration']);
    $author = trim($_POST['author']);
    $publisher = trim($_POST['publisher']);
    $summary = trim($_POST['summary']);
    $genre = trim($_POST['genre']);

    // Optional: Check if new book_id already exists (and is not the original)
    if ($book_id !== $original_book_id) {
        $check_stmt = $conn->prepare("SELECT COUNT(*) FROM books WHERE book_id = ?");
        $check_stmt->bind_param("i", $book_id);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($count > 0) {
            $message = "<p style='color:red;'>Update failed: The new book_id {$book_id} already exists.</p>";
        }
    }

    // Proceed if no duplicate book_id found
    if (empty($message)) {
        $stmt = $conn->prepare("UPDATE books SET book_id=?, book_name=?, no_of_pages=?, illustration=?, author=?, publisher=?, summary=?, genre=? WHERE book_id=?");
        $stmt->bind_param("isisssssi", $book_id, $book_name, $no_of_pages, $illustration, $author, $publisher, $summary, $genre, $original_book_id);

        if ($stmt->execute()) {
            $message = "<p style='color:green;'>Book updated successfully.</p>";
            // Update original_book_id to new book_id so form shows updated info
            $original_book_id = $book_id;
            // Optionally redirect to the new URL with the updated book_id
            header("Location: edit.php?book_id=" . $book_id);
            exit;
        } else {
            $message = "<p style='color:red;'>Update failed: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}

// Fetch the current book data for the form, using the (possibly updated) $original_book_id
$stmt = $conn->prepare("SELECT * FROM books WHERE book_id=?");
$stmt->bind_param("i", $original_book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Book not found.");
}

$book = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Book</title>
<link rel="stylesheet" type="text/css" href="book.css">
</head>
<body>
    <h1>Edit Book</h1>
    <?php echo $message; ?>
    <form method="post" action="edit.php?book_id=<?php echo $original_book_id; ?>">
        <label>Book Id:</label><br>
        <input type="number" name="book_id" value="<?php echo htmlspecialchars($book['book_id']); ?>" required><br><br>

        <label>Book Name:</label><br>
        <input type="text" name="book_name" value="<?php echo htmlspecialchars($book['book_name']); ?>" required><br><br>

        <label>Number of Pages:</label><br>
        <input type="number" name="no_of_pages" value="<?php echo htmlspecialchars($book['no_of_pages']); ?>" required><br><br>

        <label>Illustration:</label><br>
        <input type="text" name="illustration" value="<?php echo htmlspecialchars($book['illustration']); ?>"><br><br>

        <label>Author:</label><br>
        <input type="text" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required><br><br>

        <label>Publisher:</label><br>
        <input type="text" name="publisher" value="<?php echo htmlspecialchars($book['publisher']); ?>"><br><br>

        <label>Summary:</label><br>
        <textarea name="summary" rows="4" cols="50"><?php echo htmlspecialchars($book['summary']); ?></textarea><br><br>

        <label>Genre:</label><br>
        <input type="text" name="genre" value="<?php echo htmlspecialchars($book['genre']); ?>"><br><br>

        <input type="submit" value="Update Book">
        <a href="book_view_admin.php">Cancel</a>
    </form>
</body>
</html>