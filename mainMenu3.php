<meta charset="utf-8"/>
<html lang="id">
<head title="Mau melakukan apa?">
    <style type="text/css">

        .iWantTo {
            position:absolute;
            top: 15%;
            left:50%;
            transform: translate(-50%, -50%);
            background-color: white;
            font-size: 36px;
        }
        /*
        .selectOptionLeft {
            position:absolute;
            top: 25%;
            left: 25%;
        }

        .selectOptionRight {
            position:absolute;
            top: 25%;
            left: 75%;
        }*/

        .optionTextLeft {
            position: absolute;
            bottom: 5%;
            left: 25%;
            transform: translate(-50%, -50%);
            background-color: white;
            font-size: 36px
        }

        .optionTextRight {
            position: absolute;
            bottom: 5%;
            left: 75%;
            transform: translate(-50%, -50%);
            background-color: white;
            font-size: 36px
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
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap-4.0.0-dist/css/bootstrap.min.css">
</head>
<body>
<script src="jquery-3.4.1.min.js"></script>
<script src="bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
<?php
include_once("config.php");
?>
<div class="pictures" style="width:100%; height:100%; z-index:1;">
    <div class="row">
        <div class="col-sm-3" id="makan-minum" style="background-color:aquamarine;">
            <a href="mainMenu3.html">Makan-Minum</a>
        </div>
        <div class="col-sm-3" id="papa-mama" style="background-color:LightPink;">
            <a href="papa-mama.html">Papa-Mama</a>
        </div>
        <div class="col-sm-3" id="sepupu" style="background-color:GreenYellow;">
            <a href="sepupu.html">Sepupu</a>
        </div>
        <div class="col-sm-3" id="tidur-mandi" style="background-color:BlanchedAlmond;">
            <a href="adl2.html">Tidur-Mandi</a>
        </div>
    </div>
    <div class="iWantTo" id="iWantTo" style="z-index:2; position:absolute"></div>
    <div class="option">
        <img src="images/makan.jpeg" style="width:100%; height:100%" alt="makan">
        <div class="optionTextLeft" id="optionTextLeft">
            <select id="chosenLeftOption">
                <?php
                $sql = "SELECT activity_name, activity_file_name from list_activities";
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
        </div>
    </div>
    <div class="option">
        <img src="images/minum.jpeg" style="width:100%; height:100%" alt="minum">
        <div class="optionTextRight" id="optionTextRight">
            <select id="chosenRightOption">
                <?php
                $sql = "SELECT activity_name, activity_file_name from list_activities";
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
        </div>
    </div>
</div>

<script>
    function getActivityImage(activity_id)
    {

    }
    $(document).ready(function () {
        $(".col-sm-3").hover(function(){
            $(this).animate({opacity:0.5}, 100)
        }, function(){
            $(this).animate({opacity:1.0}, 100)
        });

    });
    $(document).ready(function () {
        $("#makan-minum").click(function(){

        })

    });



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
            console.log("Left: " + timesLeft + "\n");
            timesLeft = timesLeft + 1;

        }
        else if(lastX >= width * 0.55)
        {
            console.log("Right: " + timesRight + "\n");
            timesRight = timesRight + 1;
        }
        else
        {
            console.log("Not Detected: " + notDetected + "\n");
            notDetected = notDetected + 1;
        }
    };

    setInterval(function()
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
    },10*1000)
</script>
</body>
