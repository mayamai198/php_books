<?php
session_start();

$conn = new mysqli("localhost", "root", "", "book_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all admins
$sql = "SELECT admin_id, admin_username FROM admin ORDER BY admin_id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Panel</title>

<style>

body{
    font-family: Arial, sans-serif;
    background:#f4f4f4;
    margin:0;
    padding:20px;
}

.container{
    width:90%;
    max-width:900px;
    margin:auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

h2{
    text-align:center;
    color:#333;
    margin-bottom:20px;
}

.message{
    background:#d4edda;
    color:#155724;
    padding:12px;
    border-radius:5px;
    margin-bottom:20px;
    text-align:center;
    font-weight:bold;
}

table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    padding:12px;
    border:1px solid #ddd;
    text-align:center;
}

th{
    background:#333;
    color:white;
}

tr:nth-child(even){
    background:#f9f9f9;
}

.action-buttons{
    display:flex;
    justify-content:center;
    gap:10px;
}

button{
    border:none;
    padding:8px 14px;
    border-radius:5px;
    cursor:pointer;
    font-weight:bold;
}

.delete-btn{
    background:#e53935;
    color:white;
}

.delete-btn:hover{
    background:#c62828;
}

.update-btn{
    background:#1e88e5;
    color:white;
}

.update-btn:hover{
    background:#1565c0;
}

.protected{
    color:green;
    font-weight:bold;
}

@media screen and (max-width:600px){

    table{
        font-size:14px;
    }

    .action-buttons{
        flex-direction:column;
    }

}

</style>
</head>

<body>

<div class="container">

<h2>User Panel</h2>

<?php if(isset($_GET['updated'])){ ?>
    <div class="message">
        User updated successfully!
    </div>
<?php } ?>

<table>

<tr>
    <th>No</th>
    <th>Username</th>
    <th>Action</th>
</tr>

<?php

$number = 1;

if($result && $result->num_rows > 0){

    while($row = $result->fetch_assoc()){

?>

<tr>

    <td>
        <?php echo $number++; ?>
    </td>

    <td>
        <?php echo htmlspecialchars($row['admin_username']); ?>
    </td>

    <td>

    <?php if($row['admin_username'] != "hey"){ ?>

        <div class="action-buttons">

            <!-- Delete -->
            <form method="POST"
                  action="delete_user.php"
                  onsubmit="return confirm('Delete this user?');">

                <input type="hidden"
                       name="delete_id"
                       value="<?php echo $row['admin_id']; ?>">

                <button type="submit" class="delete-btn">
                    Delete
                </button>

            </form>

            <!-- Update -->
            <form method="GET"
                  action="update_user.php">

                <input type="hidden"
                       name="id"
                       value="<?php echo $row['admin_id']; ?>">

                <button type="submit" class="update-btn">
                    Update
                </button>

            </form>

        </div>

    <?php } else { ?>

        <span class="protected">
            Protected
        </span>

    <?php } ?>

    </td>

</tr>

<?php

    }

} else {

    echo "
    <tr>
        <td colspan='3'>
            No users found
        </td>
    </tr>
    ";

}

?>

</table>

</div>

</body>
</html>

<?php
$conn->close();
?>