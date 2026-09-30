<?php
session_start();

// Expire undo after 1 min
if (isset($_SESSION['deleted_time']) && time() - $_SESSION['deleted_time'] > 60) {
    unset($_SESSION['deleted_book'], $_SESSION['deleted_time']);
}

// Expire redo after 1 min
if (isset($_SESSION['restored_time']) && time() - $_SESSION['restored_time'] > 60) {
    unset($_SESSION['restored_book'], $_SESSION['restored_time']);
}

$conn = new mysqli('localhost', 'root', '', 'book_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM books ORDER BY book_id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Books Admin Panel</title>
    <link rel="stylesheet" href="book.css" />
</head>
<body>

<h1>Books Admin Panel</h1>

<?php if (isset($_SESSION['deleted_book'])): ?>
    <div id="undo-message">
        Book deleted successfully.
        <a href="undo.php" class="action-button">Undo Delete (1 min)</a>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['restored_book'])): ?>
    <div id="redo-message">
        Undo successful: Book restored.
        <a href="redo.php" class="action-button">Redo Delete (1 min)</a>
    </div>
<?php endif; ?>

<table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse:collapse;">
    <thead>
        <tr>
            <th>Book ID</th>
            <th>Book Name</th>
            <th>No Of Pages</th>
            <th>Illustration</th>
            <th>Author</th>
            <th>Publisher</th>
            <th>Summary</th>
            <th>Genre</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows === 0): ?>
            <tr><td colspan="9" style="text-align:center;">No books found.</td></tr>
        <?php else: ?>
            <?php while ($book = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($book['book_id']) ?></td>
                    <td><?= htmlspecialchars($book['book_name']) ?></td>
                    <td><?= htmlspecialchars($book['no_of_pages']) ?></td>
                    <td><?= htmlspecialchars($book['illustration']) ?></td>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td><?= htmlspecialchars($book['publisher']) ?></td>
                    <td><?= nl2br(htmlspecialchars($book['summary'])) ?></td>
                    <td><?= htmlspecialchars($book['genre']) ?></td>
                    <td>
                        <a href="edit.php?book_id=<?= urlencode($book['book_id']) ?>" class="action-button edit-button">Edit</a>
                        <a href="delete.php?book_id=<?= urlencode($book['book_id']) ?>" class="action-button delete-button" onclick="return confirm('Are you sure you want to delete this book?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </tbody>
</table>

<div style="margin-top:15px;">
    <?php if (isset($_SESSION['deleted_book'])): ?>
        <a href="undo.php" class="action-button">Undo Delete (1 min)</a>
    <?php endif; ?>

    <?php if (isset($_SESSION['restored_book'])): ?>
        <a href="redo.php" class="action-button">Redo Delete (1 min)</a>
    <?php endif; ?>
</div>

<script>
  // Hide Undo/Redo messages and links after 1 minute (60000 ms)
  setTimeout(() => {
    const undoMsg = document.getElementById('undo-message');
    if (undoMsg) undoMsg.style.display = 'none';

    const redoMsg = document.getElementById('redo-message');
    if (redoMsg) redoMsg.style.display = 'none';

    document.querySelectorAll('a[href="undo.php"]').forEach(link => link.style.display = 'none');
    document.querySelectorAll('a[href="redo.php"]').forEach(link => link.style.display = 'none');
  }, 60000);
</script>

</body>
</html>

<?php $conn->close(); ?>