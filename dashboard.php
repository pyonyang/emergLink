<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ambulance_web";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_status"])) {
    $status = $_POST["status"];
    $orderId = $_POST["order_id"];

    // Update status in the ambulance_orders table
    $sql = "UPDATE ambulance_orders SET status = '$status' WHERE id = $orderId";

    if ($conn->query($sql) === TRUE) {
        // Status updated successfully
        header("Location:dashboard.php");
        exit();
    } else {
        echo "Error updating status: " . $conn->error;
    }
}

// Retrieve form submissions with status information
$sql = "SELECT id, nama, telp, alamat, detail, status, created_at FROM ambulance_orders";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>

<h1>Admin Dashboard</h1>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Telepon</th>
        <th>Alamat</th>
        <th>Detail</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Action</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["nama"] . "</td>";
            echo "<td>" . $row["telp"] . "</td>";
            echo "<td>" . $row["alamat"] . "</td>";
            echo "<td>" . $row["detail"] . "</td>";
            echo "<td>" . $row["status"] . "</td>";
            echo "<td>" . $row["created_at"] . "</td>";
            echo "<td>";
            echo "<form method='post' action='dashboard.php'>";
            echo "<input type='hidden' name='order_id' value='" . $row["id"] . "' />";
            echo "<select name='status'>";
            echo "<option value='pending' " . ($row["status"] == "pending" ? "selected" : "") . ">Pending</option>";
            echo "<option value='on progress' " . ($row["status"] == "on progress" ? "selected" : "") . ">On Progress</option>";
            echo "<option value='completed' " . ($row["status"] == "completed" ? "selected" : "") . ">Completed</option>";
            echo "</select>";
            echo "<input type='submit' name='update_status' value='Update' />";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No records found</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php
$conn->close();
?>
