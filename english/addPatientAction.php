<?php
try {
    include('changeLanguage.php');
    include_once('config.php');
    $firstName = $_POST['namaDepan'];
    $lastName = $_POST['namaBelakang'];
    $dateOfBirth = $_POST['tanggalLahir'];
    $address = $_POST['alamat'];
    $difability = $_POST['difabilitas'];
    $query = "Insert into pasien(nama_depan, nama_belakang, tanggal_lahir, alamat, difabilitas) values (?,?,?,?,?)";

    $statement = $con->prepare($query);
    if ( false===$statement ) {
        die('prepare() failed: ' . htmlspecialchars($con->error));
    }

    $rc = $statement->bind_param('sssss',$firstName, $lastName, $dateOfBirth, $address, $difability);
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
    else{
        changeLanguageDropDown();
        echo "<br>Success.<br> <a href='forCaregiver.php'>Go back to caregiver menu.</a><br>";
        echo "<a href='addPatient.html'>Add another patient<br>";
        echo "<a href='mainMenu.php'>Go back to main menu</a>";
    }
}
catch (PDOException $e)
{
    changeLanguageDropDown();
    echo "<br>Error. ".$e->getMessage()."<br><br><a href='forCaregiver.php'>Go back to caregiver menu.</a><br>";
    echo "<a href='addPatient.html'>Add another patient<br>";
    echo "<a href='mainMenu.php'>Go back to main menu</a>";
}




