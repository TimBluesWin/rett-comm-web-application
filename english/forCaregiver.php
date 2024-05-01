<?php
include("config.php");
?>

<!DOCTYPE html>
<html lang="en-gb">
    <head>
        <title> For caregiver </title>
    </head>
    <body>
    <script src="jquery-3.4.1.min.js"></script>
    <a href="addCustomActivity.html">Add activity</a>
    <br>
    <a href="addPatient.html">Add patient</a>
    <h2>Patient's habit:</h2>
    <br>
    Nama pasien:
    <select id="patientName" onchange="determineFromName()">
        <?php
        $sqlPasien = "Select id, nama_depan, nama_belakang from pasien";
        $result = mysqli_query($con, $sqlPasien);
        while($row = mysqli_fetch_array($result))
        {
            echo "<option value=".$row['id'].">".$row['nama_depan']." ".$row['nama_belakang']."</option>";
        }
        ?>
    </select>
    <br>
    Activities most often done between <input type="number" value="12" min="0" max="23" id="startTime" onchange="determineFromTime()"> to <input type="number" value="18" min="0" max="23" id="endTime" onchange="determineFromTime()">
    are: <div id="timeHabit"></div>
    <br>
    <br>
    That patient does:
    <select id="activities" onchange="determineFromActivity()">
        <?php

        $sql = "SELECT activity_id, activity_name_indonesian, activity_name_english, activity_file_name from list_activities";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($result)) {
            if ($row['activity_name_english'] == "Drink") {
                echo "<option selected='selected' value=" . $row['activity_id'] . ">" . $row['activity_name_english'] . "</option>";
            } 
            else if(empty($row['activity_name_english']))
            {
                echo "<option selected='selected' value=" . $row['activity_id'] . ">" . $row['activity_name_indonesian'] . "</option>";
            }
            else {
                echo "<option value=" . $row['activity_id'] . ">" . $row['activity_name_english'] . "</option>";
            }
        }

        ?>
    </select>
    the most often at the following time: <br>
    <div id="activityHabit"></div>
    <a href="mainMenu3.php">Go back to the main menu</a>
    <script>
        function determineFromTime()
        {
            let patient_id = $('#patientName option:selected').val();
            let start_time = $('#startTime').val();
            //alert(start_time);
            let end_time = $('#endTime').val();
            //alert(end_time);
            $.ajax({
                type:"POST",
                url:"determineTime.php",
                dataType:'json',
                data:{patient_id:patient_id,start_time:start_time,end_time:end_time},
                success:function(data) {
                    if(data != "fail")
                    {
                        let result = data;
                        let htmlTable = "<table><tr><th>Activity_name</th><th>Jumlah</th></tr>";
                        $.each(result, function(key, value){
                            htmlTable += "<tr><td>" + !empty(value['activity_name_english']) ? value['activity_name_english'] : value['activity_name_indonesian'] + "</td><td>" + value['amount'] + "</td></tr>";
                        });
                        htmlTable += "</table>";
                        $('#timeHabit').html(htmlTable);

                    }
                    else
                    {
                        document.getElementById('timeHabit').innerHTML = "-";
                    }
                }


            })
        }

        function determineFromActivity()
        {
            //alert("activity changed");
            let patient_id = $('#patientName option:selected').val();
            let activity_id = $('#activities option:selected').val();
            $.ajax({
                type:"POST",
                url:"determineActivity.php",
                dataType:'json',
                data:{patient_id:patient_id, activity_id:activity_id},
                success:function(data) {
                    if(data != "fail")
                    {
                        let result = data;
                        let htmlTable = "<table><tr><th>Time interval</th><th>Amount</th></tr>";
                        $.each(result, function(key, value){
                            htmlTable += "<tr><td>" + value['intervals'] + "</td><td>" + value['count'] + "</td></tr>";
                        });
                        htmlTable += "</table>";
                        $('#activityHabit').html(htmlTable);
                    }
                    else
                    {
                        document.getElementById('activityHabit').innerHTML = "-";
                    }

                }


            })
        }

        function determineFromName()
        {
            determineFromActivity();
            determineFromTime();
        }
        determineFromName();

    </script>
    </body>
</html>