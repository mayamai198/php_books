<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book View Details</title>

</head>
<body>

    <div class="banner">
        Book View Details
    </div>

    <table>
        <tr>
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
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
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
            echo "<tr><td colspan='7'>No books found.</td></tr>";
        }

        $conn->close();
        ?>
    </table>

</body>
</html>