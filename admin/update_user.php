<?php
session_start();

$conn = new mysqli("localhost", "root", "", "book_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID exists
if (!isset($_GET['id'])) {
    die("User ID not found.");
}

$id = intval($_GET['id']);

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("User not found.");
}

$user = $result->fetch_assoc();

// Update user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = trim($_POST['username']);

    if (!empty($username)) {

        $update = $conn->prepare(
            "UPDATE admin SET admin_username = ? WHERE admin_id = ?"
        );

        $update->bind_param("si", $username, $id);

        if ($update->execute()) {

            header("Location: user_panel.php?updated=1");
            exit();

        } else {

            $error = "Update failed.";

        }

    } else {

        $error = "Username cannot be empty.";

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update User</title>

<style>

body{
    font-family:Arial, sans-serif;
    background:#f4f4f4;
    margin:0;
    padding:20px;
}

.container{
    width:400px;
    margin:60px auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

h2{
    text-align:center;
    margin-bottom:20px;
    color:#333;
}

input[type="text"]{
    width:100%;
    padding:12px;
    margin-top:10px;
    margin-bottom:20px;
    border:1px solid #ccc;
    border-radius:5px;
    font-size:16px;
}

button{
    width:100%;
    padding:12px;
    border:none;
    background:#1e88e5;
    color:white;
    font-size:16px;
    border-radius:5px;
    cursor:pointer;
}

button:hover{
    background:#1565c0;
}

.error{
    color:red;
    text-align:center;
    margin-bottom:15px;
}

.back{
    display:block;
    text-align:center;
    margin-top:15px;
    text-decoration:none;
    color:#333;
}

.back:hover{
    text-decoration:underline;
}

</style>
</head>

<body>

<div class="container">

<h2>Update User</h2>

<?php if(isset($error)){ ?>
    <div class="error">
        <?php echo $error; ?>
    </div>
<?php } ?>

<form method="POST">

    <label>Username</label>

    <input type="text"
           name="username"
           value="<?php echo htmlspecialchars($user['admin_username']); ?>"
           required>

    <button type="submit">
        Update User
    </button>

</form>

<a class="back" href="user_panel.php">
    ← Back to User Panel
</a>

</div>

</body>
</html>

<?php
$conn->close();
?>