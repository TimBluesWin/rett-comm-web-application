<meta charset="utf-8"/>
<html lang="id">
<head title="Mau melakukan apa?">
    <title>Mau melakukan apa?</title>
    <style type="text/css">

        .iWantTo {
            position:absolute;
            top: 5%;
            left:50%;
            transform: translate(-50%, -50%);
            background-color: white;
            font-size: 16px;
        }
        #chosenLeftOption {
            position: absolute;
            bottom: 2%;
            left: 15%;
            transform: translate(-50%, -50%);
            background-color: white;
            font-size: 16px
        }
        #chosenRightOption {
            position: absolute;
            bottom: 2%;
            left: 85%;
            transform: translate(-50%, -50%);
            background-color: white;
            font-size: 16px
        }
        #timeRemaining {
            position: absolute;
            left:35%;
            bottom: 2%;
            align-content: center;
            background-color: white;
        }

        .timers{
            left:35%;
            position: absolute;
            bottom: 7%;
            align-content: center;
            background-color: white;
        }
        .option {
            float:left;
            width:50%;
            height:100%;
        }

        .pictures::after {
            content:"";
            clear: both;
            display: table;
        }

        html,body{
            height:100%;
        }

        .forCaregiver{
            right:5%;
            top:2%;
            position:absolute;
        }
        .patients{
            right:5%;
            top:10%;
            position:absolute;
        }
        .soundContainer{
            left:5%;
            top:2%;
            position:absolute;
            background-color:white;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
<script src="https://code.responsivevoice.org/responsivevoice.js?key=Ih6YLiFZ"></script>
<?php
include_once("config.php");
?>
<div class="pictures" style="width:100%; height:100%; z-index:1;">
    <div class="soundContainer">
        Volume: <input type="range" min="1" max="100" value="100" id="volume" onchange="changeVolume()">
        <br>
        Gender Suara:
        <select onChange="changeVoice()" id="voice">
            <option value="f" selected="selected">Perempuan</option>
            <option value="m">Laki-laki</option>
        </select>

    </div>
    <div class="iWantTo" id="iWantTo" style="z-index:2; position:absolute"></div>
    <div class="timers">
        Durasi melihat:
        <input type="number" label="Time Left" id="time" value="10" min="4" required>
        <input type="button" value="Ubah waktu" onclick="changeSomething()"> <br>
        Durasi sebelum refresh:
        <input type="number" label="Delay to refresh" id="refresh" value="10" min="1" required>
        <input type="button" value="Ubah waktu" onclick="changeSomething()">
    </div>
    <div class="option">
        <img id="optionLeftImage" style="width:100%; height:100%" alt="makan">
        <select id="chosenLeftOption">
            <?php
            $sql = "SELECT activity_id, activity_name_indonesian, activity_file_name from list_activities";
            $result = mysqli_query($con, $sql);
            while($row = mysqli_fetch_array($result)) {
                if($row['activity_name_indonesian'] == "Makan")
                {
                    echo "<option selected='selected' value=".$row['activity_id'].">".$row['activity_name_indonesian']."</option>";
                }
                else
                {
                    echo "<option value=".$row['activity_id'].">".$row['activity_name_indonesian']."</option>";
                }

            }
            ?>
        </select>
        <a href="forCaregiver.php"><button class="forCaregiver" value="Add Activity">Untuk Pengasuh</button></a>
        <div class="patients">
            <select id="patients">
            <?php
            $sqlPasien = "Select id, nama_depan, nama_belakang from pasien";
            $result = mysqli_query($con, $sqlPasien);
            while($row = mysqli_fetch_array($result))
            {
                echo "<option value=".$row['id'].">".$row['nama_depan']." ".$row['nama_belakang']."</option>";
            }
            ?>
        </select>
        </div>
    </div>
    <div id="timeRemaining">Waktu untuk melihat aktivitas: 10</div>
    <div class="option">
        <img id="optionRightImage" style="width:100%; height:100%" alt="minum">
        <select id="chosenRightOption">
            <?php
            $sql = "SELECT activity_id, activity_name_indonesian, activity_file_name from list_activities";
            $result = mysqli_query($con, $sql);
            while($row = mysqli_fetch_array($result)) {
                if($row['activity_name_indonesian'] == "Minum")
                {
                    echo "<option selected='selected' value=".$row['activity_id'].">".$row['activity_name_indonesian']."</option>";
                }
                else
                {
                    echo "<option value=".$row['activity_id'].">".$row['activity_name_indonesian']."</option>";
                }
            }
            ?>
        </select>
    </div>

</div>

<script>
    $(document).ready(function(){
        let activity_id_left = $('#chosenLeftOption').val();
        $.ajax({
            type:"POST",
            url:"getActivity.php",
            dataType:'json',
            data:{activity_id:activity_id_left},
            success:function(data) {
                if(data != "fail")
                {
                    $('#optionLeftImage').attr('src', "../images/" + data.activity_file_name);
                }
                else
                {
                    $('#optionLeftImage').attr('src', "../images/questionMark.jpg");
                }
            }

        })
    });
    $(document).ready(function(){
        let activity_id_right = $('#chosenRightOption').val();
        $.ajax({
            type:"POST",
            url:"getActivity.php",
            dataType:'json',
            data:{activity_id:activity_id_right},
            success:function(data) {
                if(data != "fail")
                {
                    $('#optionRightImage').attr('src', "../images/" + data.activity_file_name);
                }
                else
                {
                    $('#optionRightImage').attr('src', "../images/questionMark.jpg");
                }
            }

        })
    });

    $("#chosenLeftOption").change(function(){
        let activity_id_left = $('#chosenLeftOption').val();
        $.ajax({
            type:"POST",
            url:"getActivity.php",
            dataType:'json',
            data:{activity_id:activity_id_left},
            success:function(data) {
                if(data != "fail")
                {
                    $('#optionLeftImage').attr('src', "../images/" + data.activity_file_name);
                }
                else
                {
                    $('#optionLeftImage').attr('src', "../images/questionMark.jpg");
                }
                changeSomething();
            }

        })
    });

    $("#chosenRightOption").change(function(){
        let activity_id_left = $('#chosenRightOption').val();
        $.ajax({
            type:"POST",
            url:"getActivity.php",
            dataType:'json',
            data:{activity_id:activity_id_left},
            success:function(data) {
                if(data != "fail")
                {
                    $('#optionRightImage').attr('src', "../images/" + data.activity_file_name);
                }
                else
                {
                    $('#optionRightImage').attr('src', "../images/questionMark.jpg");
                }
                changeSomething();
            }


        })
    });

    $(document).ready(function () {
        $(".col-sm-3").hover(function(){
            $(this).animate({opacity:0.5}, 100)
        }, function(){
            $(this).animate({opacity:1.0}, 100)
        });

    });

    function changeVoice()
    {
        determineVoice();
        changeSomething();
    }

    function changeVolume()
    {
        determineVolume();
        changeSomething();
    }

    function determineVoice()
    {
        let gender = document.getElementById("voice").value;
        if(gender == "m")
        {
            voice = "Indonesian Male";
        }
        else if(gender == "f")
        {
            voice = "Indonesian Female";
        }

    }

    function determineVolume()
    {
        volume = document.getElementById("volume").value / 100;
    }

    function timeToReload(interval, timeRefresh)
    {
        timeRefresh -= 1;
        jQuery("#timeRemaining").html("Waktu sebelum refresh: " + timeRefresh);
        if(timeRefresh <= 0)
        {
            clearInterval(interval);
            location.reload();
        }
        return timeRefresh;
    }

    function storeToDatabase(patient, activity)
    {
        //alert("Yay!");
        fetch("addPatientActivity.php", {
            method:"POST",
            headers:{
                "Content-type":"application/x-www-form-urlencoded"
            },
            body:"activity_id=" + activity + '&patient_id=' + patient
        }).then(function(res){
            if(res.ok)
            {
                console.log("Patient's activity added.");
            }
            else if(res.status == 401)
            {
                console.log("Aktivitas gagal ditambah ke database");
            }
        }, function(e){
            console.log(e);
        }).catch(function(error){
            console.log(error);
        })
    }

    function countdownRemaining(interval, timeRemaining, timeRefresh)
    {
        timeRemaining -= 1;
        jQuery("#timeRemaining").html("Waktu untuk melihat aktivitas: " + timeRemaining);
        let text = null;
        if(timeRemaining <= 0)
        {
            let cbo = null;
            //jQuery("#timeRemaining").html("Countdown ended.");
            clearInterval(interval);
            let selected_activity = 0;
            if(timesLeft < 10 && timesRight < 10)
            {
                text = "Belum tahu mau ngapain";
                document.getElementById("iWantTo").style.backgroundColor = "pink";
            }
            else if(timesLeft >= timesRight * 7/3 && timesLeft >= notDetected * 7/3)
            {
                cbo = document.getElementById("chosenLeftOption");
                let leftActivity = cbo.options[cbo.selectedIndex].text;
                text = "Saya mau " + leftActivity;
                //window.location.href = 'makanApa.php'
                document.getElementById("iWantTo").style.backgroundColor = "deepskyblue";
                selected_activity = $('#chosenLeftOption option:selected').val();
            }
            else if(timesRight >= timesLeft * 7/3 && timesRight >= notDetected * 7/3)
            {
                cbo = document.getElementById("chosenRightOption");
                let rightActivity = cbo.options[cbo.selectedIndex].text;
                text = "Saya mau " + rightActivity;
                document.getElementById("iWantTo").style.backgroundColor = "yellow";
                //window.location.href = 'minumApa.php'
                selected_activity = $('#chosenRightOption option:selected').val();
            }
            else
            {
                document.getElementById("iWantTo").innerHTML = "Belum tahu mau ngapain";
                text = "Belum tahu mau ngapain";
                //window.location.href = 'adl2.html';
            }
            responsiveVoice.speak(text, voice, {volume:volume});
            document.getElementById("iWantTo").innerHTML = text;
            timesLeft = 0;
            timesRight = 0;
            let selected_patient = $('#patients option:selected').val();
            //alert(selected_activity);
            storeToDatabase(selected_patient, selected_activity);
            refreshInterval = setInterval(function() {
                timeRefresh = timeToReload(interval, timeRefresh);
            }, 1000)

        }
        return timeRemaining;
    }
    let timeRemaining = $('#time').val();
	document.getElementById("time").innerHTML = "Waktu untuk melihat aktivitas: " + timeRemaining;
    let timeRefresh = $('#refresh').val();
    let refreshInterval = null;
    let countdownInterval = setInterval(function () {
        timeRemaining = countdownRemaining(countdownInterval, timeRemaining, timeRefresh);
    }, 1000);


    function changeSomething()
    {
        timesLeft = 0;
        timesRight = 0;
        notDetected = 0;
        clearInterval(countdownInterval);
        clearInterval(refreshInterval);
        countdownInterval = null;
        refreshInterval = null;
        timeRemaining = document.getElementById("time").value;
		document.getElementById("time").innerHTML= "Time remaining: " + timeRemaining;
		if(timeRemaining <= 4 && timeRemaining > 0)
        {
            timeRemaining = 4;
        }
        else if(timeRemaining == null || timeRemaining <= 0)
        {
            timeRemaining = 10;
        }
        timeRefresh = document.getElementById("refresh").value;
        if(timeRefresh == null || timeRefresh <= 0)
        {
            timeRefresh = 10;
        }
        countdownInterval = setInterval(function () {
            timeRemaining = countdownRemaining(countdownInterval, timeRemaining, timeRefresh);
        }, 1000);

        

    }

    window.requestAnimationFrame = (function(){
        return  window.requestAnimationFrame       ||
            window.webkitRequestAnimationFrame ||
            window.mozRequestAnimationFrame    ||
            function( callback ){
                window.setTimeout(callback, 1000 / 60);
            };
    })();
    let timesLeft = 0;
    let timesRight = 0;
    let notDetected = 0;
    // create instance
    let body = document.body;
    let width = body.clientWidth;
    let voice = null;
    let volume = null;
    determineVolume();
    determineVoice();

    let lastX, lastY;

    body.onmousemove = function(ev) {

        lastX = ev.pageX;
        lastY = ev.pageY;
        if(lastX < width * 0.45)
        {
            //console.log("Left: " + timesLeft + "\n");
            timesLeft = timesLeft + 1;

        }
        else if(lastX >= width * 0.55)
        {
            //console.log("Right: " + timesRight + "\n");
            timesRight = timesRight + 1;
        }
        else
        {
            //console.log("Not Detected: " + notDetected + "\n");
            notDetected = notDetected + 1;
        }
    };

    /**setInterval(function()
    {
        if(timesLeft < 10 && timesRight < 10)
        {
            window.location.href = 'adl2.html'
        }
        else if(timesLeft >= timesRight * 7/3 && timesLeft >= notDetected * 7/3)
        {
            window.location.href = 'makanapa.html'

        }
        else if(timesRight >= timesLeft * 7/3 && timesRight >= notDetected * 7/3)
        {
            window.location.href = 'minumapa.html'
        }
        else
        {
            window.location.href = 'adl2.html';
        }
        timesLeft = 0;
        timesRight = 0;
    },10*1000)*/
</script>
</body>
