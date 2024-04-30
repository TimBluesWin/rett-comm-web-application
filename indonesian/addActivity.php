<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rett-comm";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error)
{
	die("Kesalahan koneksi: " . $conn->connect_error);
}
else
{
	echo "Koneksi sukses";
}
$activity = $_POST['activity'];

$current_date = date("Y-m-d H:i:s");
$mean = $_POST['meanX'];
$std = $_POST['std'];

$sql = "INSERT INTO activities (activity_name_indonesian, activity_time, x_coordinate, std_dev)
        VALUES ('$activity','$current_date',$mean,$std)";

if ($conn->query($sql) === TRUE) {
    echo "Record berhasil ditambah";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

