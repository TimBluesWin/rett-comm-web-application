<?php

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "rett-comm";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error)
        {
            die("Connection error: " . $conn->connect_error);
        }

        $activity = $_POST['activityNameIndonesian'];
        $activityEnglish = $_POST['activityNameEnglish'];
        #specify target directory
        $target_dir = "../images/";
        #specify the path name of the file. The name of the image comes from the 'activity_image'
        #from the html; we just need the name. Then, the obtained name is concatenated with the dir.
        $target_file = $target_dir . basename($_FILES["activityImage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if(isset($_POST["submit"]))
        {
            $check = getimagesize($_FILES["activityImage"]["tmp_name"]);
            if($check !== false)
            {
                //echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            }
            else
            {
                echo "Not a picture file.";
                $uploadOk = 0;
            }
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif")
        {
            echo "Sorry, only files JPG, JPEG, PNG, or GIF are allowed. <br>";
            $uploadOk = 0;
        }
        if($uploadOk == 0)
        {
            echo "Sorry, failed to upload file.<br>";
            echo "<br><a href='addCustomActivity.html'>Add another activity</a><br>";
            echo "<a href='forCaregiver.php'>Go back to the caregiver menu</a><br>";
            echo "<a href=mainMenu.php>Go back to main menu</a>";
        }
        else
        {
            $hashed_file = hash("sha256", time().mt_rand(10,1000)).".".$imageFileType;
            //echo "The file is an image. Its hash is ".$hashed_file;
            $target_file = $target_dir . $hashed_file;
            if(move_uploaded_file($_FILES["activityImage"]["tmp_name"], $target_file))
            {
                echo "Successfully uploaded file<br>";
                $statement = $conn->prepare("Insert into list_activities(activity_name_indonesian, activity_name_english, activity_file_name) values (?,?,?)");
                $name = $activity;
                $nameEnglish = $activityEnglish;
                $file_name = $hashed_file;
                $statement->bind_param("sss", $name, $nameEnglish, $file_name);
                $statement -> execute();
                echo "<br><a href='addCustomActivity.html'>Add another activity</a><br>";
                echo "<a href='forCaregiver.php'>Go back to the caregiver menu</a><br>";
                echo "<a href=mainMenu.php>Go back to main menu</a>";

            }
            else
            {
                echo "Failed to upload file.";
                echo "<br><a href='addCustomActivity.html'>Add another activity</a><br>";
                echo "<a href='forCaregiver.php'>Go back to the caregiver menu</a><br>";
                echo "<a href=mainMenu.php>Go back to main menu</a>";
            }
        }

