<?php include("db.php");

    session_start();

    $userID = $_SESSION['User_ID'];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //set the target directory for the files to go to and then take the file name and place it in the directory
        $target = "images/";
        $target_file = $target . basename($_FILES["fileUpload"]["name"]);
        $imageType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        //set the security for the file to be accessible by the system so it can be placed into the file directory
        //'0777' is refering to the permission level the file has, 7 being read, write and execute premission
        chmod("images", 0777);

        //if the file has been successfully moved then update the User_pfp column in the database to have the new image directory
        if(move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)){
            
            $stmt = $db->prepare('UPDATE User SET User_pfp = :fileUpload WHERE User_ID = :userID');
            $stmt->bindValue(":userID", $userID, SQLITE3_INTEGER);
            $stmt->bindValue(":fileUpload", $target_file, SQLITE3_TEXT);

            if ($stmt->execute()){
                echo '<div class="echo-style">Profile picture updated!</div>';
            } else {
                echo '<div class="echo-style">There was an error updating the profile picture. Please try again later!</div>';
            }
        }
        
    }
?>