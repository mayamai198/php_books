<?php

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'book_db';

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

if($conn->connect_error) {
    die("Connection failed:". $conn->connect_error);
} 

$sql = "SELECT `book_id`, `book_name`, `no_of_pages`, `illustration`, `author`, `publisher`, `summary`, `genre` FROM `books` WHERE 1";
$result = $conn->query($sql);

$conn->close(); // Close the connection after querying
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book View Details</title>
    <style>
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <h1>Book View Details</h1>

    <table>
        <tr>
            <th>book_id</th>
            <th>book_name</th>
            <th>no_of_pages</th>
            <th>illustration</th>
            <th>author</th>
            <th>publisher</th>
            <th>summary</th>
            <th>genre</th>
        </tr>

        <?php 
        if ($result->num_rows > 0) {
            // Loop through each row and display the data
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["book_id"] . "</td>";
                echo "<td>" . $row["book_name"] . "</td>";
                echo "<td>" . $row["no_of_pages"] . "</td>";
                echo "<td>" . $row["illustration"] . "</td>";
                echo "<td>" . $row["author"] . "</td>";
                echo "<td>" . $row["publisher"] . "</td>";
                echo "<td>" . $row["summary"] . "</td>";
                echo "<td>" . $row["genre"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No results found</td></tr>";
        }
        ?>

    </table>
</body>
</html>
