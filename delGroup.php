<?php include('db.php');

session_start();
$userID = $_SESSION['User_ID'];

if (isset($_GET['groupID'])) {

    // get the group id from the url 
    $groupID = intval($_GET['groupID']);
    if ($groupID > 0) {
        $query = $db->prepare('DELETE FROM Groups WHERE Group_ID=:groupID AND User_ID=:userID');
        $query->bindValue(':groupID', $groupID, SQLITE3_INTEGER);
        $query->bindValue(':userID', $userID, SQLITE3_INTEGER);

        if($query->execute()) {

            //go back to the group page
            header("Location: group.php");
    
        } else{
            echo "There was an error, please try again later!";
        }
    }
}



?>