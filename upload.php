<?php include("db.php");

    session_start();

    $userID = $_SESSION['User_ID'];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $target = "images/";
        $target_file = $target . basename($_FILES["fileUpload"]["name"]);
        $imageType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        chmod("images", 0777);

        
        if(move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)){
            
            $stmt = $db->prepare('UPDATE User SET User_pfp = :fileUpload WHERE User_ID = :userID');
            $stmt->bindValue(":userID", $userID, SQLITE3_INTEGER);
            $stmt->bindValue(":fileUpload", $target_file, SQLITE3_TEXT);

            if ($stmt->execute()){
                echo "<br>Profile picture updated!";
            } else {
                echo "<br>There was an error updating the profile picture. Please try again later.";
            }
        }
        
    }
?>