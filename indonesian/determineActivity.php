<?php
include_once("config.php");
$data = array();
if(!empty($_POST['activity_id']) && !empty($_POST['patient_id'])) {
    $activity_id = $_POST['activity_id'];
    $patient_id = $_POST['patient_id'];
    //echo $activity_id;
    $sql = "SELECT sec_to_time(time_to_sec(activity_time)- time_to_sec(activity_time)%(30*60)) as intervals, count(sec_to_time(time_to_sec(activity_time)- time_to_sec(activity_time)%(30*60))) as count from patient_activity where activity_id = $activity_id and patient_id = $patient_id group by intervals order by count desc limit 5;";
    $result = mysqli_query($con, $sql);
    $result_array=array();
    if ($result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            array_push($result_array, $row);
        }
        echo json_encode($result_array);
    } else {
        echo json_encode("Gagal");
    }
}
else
{
    echo json_encode("fail");
}
//echo json_encode($data);

$con->close();

