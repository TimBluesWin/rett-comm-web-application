<?php
include_once('config.php');
$patient_id = $_POST['patient_id'];
if(!empty($_POST['patient_id'])) {
    if(!empty($_POST['start_time']))
    {
        $start_time = strval($_POST['start_time']);
    }
    else
    {
        $start_time = strval(0);
    }
    if(!empty($_POST['end_time'])) {
        $end_time = strval($_POST['end_time']);
    }
    else{
        $end_time = strval(23);
    }
    $start_time = "'".$start_time.":00:00'";
    //echo $start_time;
    $end_time = "'".$end_time.":00:00'";
    //echo $end_time;
    //var_dump($start_time, $end_time);
    $sql = "select activity_name, count(activity_name) as amount from patient_activity p_a inner join " .
        "list_activities l_a on p_a.activity_id = l_a.activity_id where time(activity_time) >= $start_time " .
        "and patient_id = $patient_id and time(activity_time) <= $end_time group by activity_name ".
        "order by count(activity_name) desc limit 5";
    $result_array = array();
    $result = mysqli_query($con, $sql);

    if ($result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            array_push($result_array, $row);
        }
        echo json_encode($result_array);

    } else {
        echo json_encode("fail");
    }
}
else
{
    echo json_encode("fail");
}
$con->close();