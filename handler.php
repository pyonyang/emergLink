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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $telp = $_POST["telp"];
    $alamat = $_POST["alamat"];
    $detail = $_POST["detail"];

    // Insert data into the database
    $sql = "INSERT INTO ambulance_orders (nama, telp, alamat, detail) VALUES ('$nama', '$telp', '$alamat', '$detail')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
