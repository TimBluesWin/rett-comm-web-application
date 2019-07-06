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
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap-4.0.0-dist/css/bootstrap.min.css">
</head>
<body>
<script src="jquery-3.4.1.min.js"></script>
<script src="responsiveVoice.js"></script>
<script src="bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
<?php
include_once("config.php");
?>
<div class="pictures" style="width:100%; height:100%; z-index:1;">
    <!--
    <div class="row">
        <div class="col-sm-3" id="makan-minum" style="background-color:aquamarine;">
            <a href="mainMenu3.php">Makan-Minum</a>
        </div>
        <div class="col-sm-3" id="papa-mama" style="background-color:LightPink;">
            <a href="papa-mama.php">Papa-Mama</a>
        </div>
        <div class="col-sm-3" id="sepupu" style="background-color:GreenYellow;">
            <a href="sepupu.php">Sepupu</a>
        </div>
        <div class="col-sm-3" id="tidur-mandi" style="background-color:BlanchedAlmond;">
            <a href="tidur-mandi.php">Tidur-Mandi</a>
        </div>
    </div>-->
    <div class="iWantTo" id="iWantTo" style="z-index:2; position:absolute"></div>
    <div class="timers">
        Durasi melihat:
        <input type="number" label="Time Left" id="time" value="10">
        <input type="button" value="Change time" onclick="changeSomething()"> <br>
        Durasi sebelum refresh:
        <input type="number" label="Delay to refresh" id="refresh" value="10">
        <input type="button" value="Change time" onclick="changeSomething()">
    </div>
    <div class="option">
        <img id="optionLeftImage" style="width:100%; height:100%" alt="makan">
        <select id="chosenLeftOption">
            <?php
            $sql = "SELECT activity_id, activity_name, activity_file_name from list_activities";
            $result = mysqli_query($con, $sql);
            while($row = mysqli_fetch_array($result)) {
                if($row['activity_name'] == "Makan")
                {
                    echo "<option selected=".$row['activity_id']." value=".$row['activity_id'].">".$row['activity_name']."</option>";
                }
                else
                {
                    echo "<option value=".$row['activity_id'].">".$row['activity_name']."</option>";
                }

            }
            ?>
        </select>
        <a href="addCustomActivity.html"><button class="forCaregiver" value="Add Activity">Add Activity</button></a>
    </div>
    <div id="timeRemaining">Time to look: 10</div>
    <div class="option">
        <img id="optionRightImage" style="width:100%; height:100%" alt="minum">
        <select id="chosenRightOption">
            <?php
            $sql = "SELECT activity_id, activity_name, activity_file_name from list_activities";
            $result = mysqli_query($con, $sql);
            while($row = mysqli_fetch_array($result)) {
                if($row['activity_name'] == "Minum")
                {
                    echo "<option selected=".$row['activity_id']." value=".$row['activity_id'].">".$row['activity_name']."</option>";
                }
                else
                {
                    echo "<option value=".$row['activity_id'].">".$row['activity_name']."</option>";
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
                    $('#optionLeftImage').attr('src', "images/" + data.activity_file_name);
                }
                else
                {
                    $('#optionLeftImage').attr('src', "images/questionMark.jpg");
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
                    $('#optionRightImage').attr('src', "images/" + data.activity_file_name);
                }
                else
                {
                    $('#optionRightImage').attr('src', "images/questionMark.jpg");
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
                    $('#optionLeftImage').attr('src', "images/" + data.activity_file_name);
                }
                else
                {
                    $('#optionLeftImage').attr('src', "images/questionMark.jpg");
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
                    $('#optionRightImage').attr('src', "images/" + data.activity_file_name);
                }
                else
                {
                    $('#optionRightImage').attr('src', "images/questionMark.jpg");
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

    function timeToReload(interval, timeRefresh)
    {
        timeRefresh -= 1;
        jQuery("#timeRemaining").html("Time to refresh: " + timeRefresh);
        if(timeRefresh <= 0)
        {
            clearInterval(interval);
            location.reload();
        }
        return timeRefresh;
    }
    function countdownRemaining(interval, timeRemaining, timeRefresh)
    {
        timeRemaining -= 1;
        jQuery("#timeRemaining").html("Time to look: " + timeRemaining);
        if(timeRemaining <= 0)
        {
            let voice = "Indonesian Female";
            let volume = 1;
            let cbo = null;
            //jQuery("#timeRemaining").html("Countdown ended.");
            clearInterval(interval);
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
            }
            else if(timesRight >= timesLeft * 7/3 && timesRight >= notDetected * 7/3)
            {
                cbo = document.getElementById("chosenRightOption");
                let rightActivity = cbo.options[cbo.selectedIndex].text;
                text = "Saya mau " + rightActivity;
                document.getElementById("iWantTo").style.backgroundColor = "yellow";
                //window.location.href = 'minumApa.php'
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
            refreshInterval = setInterval(function() {
                timeRefresh = timeToReload(interval, timeRefresh);
            }, 1000)

        }
        return timeRemaining;
    }
    let timeRemaining = $('#time').val();
	document.getElementById("time").innerHTML = "Time remaining: " + timeRemaining;
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
        if(timeRemaining == null || timeRemaining <= 0)
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
    setInterval(function() {
        trackData = true;
    }, 3);

    let trackData = false;

    let lastX, lastY;

    body.onmousemove = function(ev) {

        if (trackData) {
            lastX = ev.pageX;
            lastY = ev.pageY;
            trackData = false;
        }
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
