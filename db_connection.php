<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'book_db';

$conn = new mysqli($hostname, $username, $password, $database);

if($conn->connect_error) {
    die("Connection failed:". $conn->connect_error);
} else {
    echo "database connected succesfully";
}

$conn->close();

echo "<br>";

echo "The server host name is {$hostname}.";
echo "<br>";
echo "The user who mannages the database server name is {$username}.";
echo "<br>";
echo "The user password is an empty string {$password}.";
echo "<br>";
echo "The database for our book project name is {$database}.";
echo "<br>";
echo "The {$hostname} is the database enviroment for our {$database} database.
This enviroment is mamged by a user called {$username} and the password for the username is an empty string.";
    

?>
</body>
</html>