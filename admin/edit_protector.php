<?php
session_start();

// Initialize edit logs array if not exists
if (!isset($_SESSION['edit_protector_logs'])) {
    $_SESSION['edit_protector_logs'] = [];
}

// Accept GET parameters from edit.php
$username = $_SESSION['admin_username'] ?? "admin";
$book_id = $_GET['book_id'] ?? null;
$field = $_GET['field'] ?? null;
$old_value = $_GET['old'] ?? null;
$new_value = $_GET['new'] ?? null;

// Only add to log if all info exists
if ($book_id && $field && $old_value !== null && $new_value !== null) {
    // Format: book_id (X) field_name from 'old' to 'new'
    $log_entry = "{$username} edited book_id ({$book_id}) {$field} from '{$old_value}' to '{$new_value}'";
    $_SESSION['edit_protector_logs'][] = $log_entry;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Protector Logs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .log-container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .log-entry {
            background: #ecf0f1;
            margin: 10px 0;
            padding: 12px;
            border-radius: 5px;
            font-size: 15px;
            color: #2c3e50;
        }
        .log-entry:nth-child(odd) {
            background: #dce6f0;
        }
        a {
            display: inline-block;
            margin: 10px 10px 0 0;
            text-decoration: none;
            padding: 10px 15px;
            background: #3498db;
            color: white;
            border-radius: 5px;
        }
        a:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <h1>Edit Protector Logs</h1>
    <div class="log-container">
        <?php if (!empty($_SESSION['edit_protector_logs'])): ?>
            <?php foreach ($_SESSION['edit_protector_logs'] as $entry): ?>
                <div class="log-entry"><?php echo htmlspecialchars($entry); ?></div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center; font-weight:bold;">No edits yet!</p>
        <?php endif; ?>
    </div>
    <div style="text-align:center; margin-top:15px;">
        <a href="?clear=1">Clear Logs</a>
    </div>

    <?php
    // Clear logs if requested
    if (isset($_GET['clear']) && $_GET['clear'] == 1) {
        $_SESSION['edit_protector_logs'] = [];
        echo "<script>location.href='edit_protector.php';</script>";
    }
    ?>
</body>
</html>