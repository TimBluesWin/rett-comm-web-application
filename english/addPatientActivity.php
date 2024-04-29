<?php
include_once ('config.php');
date_default_timezone_set ( "Asia/Jakarta");
$patient_id = $_POST['patient_id'];
$activity_id = $_POST['activity_id'];
$time = date("Y-m-d H:i:s");

$sql = "insert into patient_activity (patient_id, activity_id, activity_time) values(?,?,?)";
$statement = $con->prepare($sql);
if ( false===$statement ) {
    die('prepare() failed: ' . htmlspecialchars($con->error));
}

$rc = $statement->bind_param('iis',$patient_id, $activity_id, $time);
// bind_param() can fail because the number of parameter doesn't match the placeholders in the statement
// or there's a type conflict(?), or ....
if ( false===$rc ) {
    // again execute() is useless if you can't bind the parameters. Bail out somehow.
    die('bind_param() failed: ' . htmlspecialchars($statement->error));
}

$rc = $statement->execute();
// execute() can fail for various reasons. And may it be as stupid as someone tripping over the network cable
// 2006 "server gone away" is always an option
if ( false===$rc ) {
    die('execute() failed: ' . htmlspecialchars($statement->error));
}
else
{
    echo "success";
}
/*
$timezone_identifiers = DateTimeZone::listIdentifiers();

foreach($timezone_identifiers as $key => $list) {

    echo $list . "<br/>";
}
*/

