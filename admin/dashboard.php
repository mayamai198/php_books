<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Dashboard</title>
    <link rel="stylesheet" href="dashboard.css" />
</head>
<body>
    <div class="sidebar">
        <h2>Book Dashboard</h2>
        <ul>
            <li><a href="manage_books.php"><h2>Manage Books</h2></a></li> 
            <li><a href="manage_admin.php"><h2>Manage Admin</h2></a></li> 
            <li><a href="index.php"><h2>Logout</h2></a></li>
        </ul>
    </div>

    <div class="main">
        <div class="header">
            <h1>Welcome <?php echo $_SESSION['admin_username']; ?></h1>
        </div>
        <img src="images/welcome.png" alt="Books Image">
    </div>

<script>
setInterval(function(){
    fetch("check_admin.php")
    .then(res => res.text())
    .then(data => {
        if(data.trim() === "deleted"){ window.location.href = "deleted_admin.php"; }
    });
}, 2000);
</script>

</body>
</html>