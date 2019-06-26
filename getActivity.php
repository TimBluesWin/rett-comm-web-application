<?php
include_once("config.php");
$data = array();
if(!empty($_POST['activity_id'])) {
    $activity_id = $_POST['activity_id'];
    //echo $activity_id;
    $sql = "select activity_id, activity_name, activity_file_name from list_activities where activity_id = $activity_id";
    $result = mysqli_query($con, $sql);
    if ($result->num_rows > 0) {
        $activity_data = $result->fetch_assoc();
        echo json_encode($activity_data);
    } else {
        echo json_encode("fail");
    }
}
else
{
    echo json_encode("fail");
}
//echo json_encode($data);

$con->close();
