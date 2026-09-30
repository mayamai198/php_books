<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'book_db';

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if (isset($_POST['signup'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {

        $check = $conn->prepare("SELECT admin_id FROM admin WHERE admin_username=?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {

            $message = "Username already exists.";

        } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO admin (admin_username, admin_password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {

                header("Location: sign_up_response.php");
                exit();

            } else {
                $message = "Registration failed.";
            }

            $stmt->close();
        }

        $check->close();

    } else {
        $message = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Signup</title>

<style>

body{
    font-family: Arial;
    background: linear-gradient(135deg,#4e73df,#1cc88a);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

form{
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 10px 20px rgba(0,0,0,0.2);
    width:300px;
}

h2{
    text-align:center;
}

input{
    width:100%;
    padding:10px;
    margin-top:5px;
    border-radius:5px;
    border:1px solid #ccc;
}

button{
    width:100%;
    padding:10px;
    background:#4e73df;
    border:none;
    color:white;
    border-radius:5px;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    background:#2e59d9;
}

</style>

</head>

<body>

<form method="POST">

<h2>Admin Signup</h2>

<?php if($message != "") { echo "<p style='color:red;'>$message</p>"; } ?>

<label>Username:</label><br>
<input type="text" name="username" required><br><br>

<label>Password:</label><br>

<div style="position: relative;">
<input type="password" id="password" name="password" required style="padding-right:30px;">
<span id="togglePassword" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);cursor:pointer;">👁️</span>
</div>

<br><br>

<button type="submit" name="signup">Signup</button>

</form>

<script>

const password = document.getElementById('password');
const toggle = document.getElementById('togglePassword');

toggle.addEventListener('click', () => {

    if(password.type === 'password'){
        password.type = 'text';
        toggle.textContent = '🙈';
    }else{
        password.type = 'password';
        toggle.textContent = '👁️';
    }

});

</script>

</body>
</html>