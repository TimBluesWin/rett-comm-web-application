<?php
include("config.php");
?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <title> Untuk pengasuh </title>
    </head>
    <body>
    <a href="addCustomActivity.html">Tambah aktivitas</a>
    <br>
    <a href="addPatient.html">Tambah Pasien</a>
    <h2>Kebiasaan Pasien:</h2>
    <br>
    Nama pasien:
    <select id="patientName">
        <?php
        $sqlPasien = "Select id, nama_depan, nama_belakang from pasien";
        $result = mysqli_query($con, $sqlPasien);
        while($row = mysqli_fetch_array($result))
        {
            echo "<option value=".$row['id'].">".$row['nama_depan']." ".$row['nama_belakang']."</option>";
        }
        ?>
    </select>
    Aktivitas paling sering dilakukan antara jam <input type="time" id="startTime"> hingga jam <input type="time" id="endTime">
    adalah: <div class="timeHabit"></div>
    <br>
    <br>
    Pasien tersebut paling sering
    <select id="activities">
        <?php

        $sql = "SELECT activity_id, activity_name, activity_file_name from list_activities";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($result)) {
            if ($row['activity_name'] == "Minum") {
                echo "<option selected='selected' value=" . $row['activity_id'] . ">" . $row['activity_name'] . "</option>";
            } else {
                echo "<option value=" . $row['activity_id'] . ">" . $row['activity_name'] . "</option>";
            }
        }

        ?>
    </select>
    pada <div class="activityHabit"></div>
    </body>
</html>