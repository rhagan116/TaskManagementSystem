<?php include("db.php");

    session_start();
    $userID = $_SESSION['User_ID'];

    if (isset($_GET['taskID'])) {

        $taskID = intval($_GET['taskID']);
        if ($taskID > 0) {
            $query = $db->prepare('DELETE FROM Tasks WHERE Task_ID=:taskID AND User_ID=:userID');
            $query->bindValue(':taskID', $taskID, SQLITE3_INTEGER);
            $query->bindValue(':userID', $userID, SQLITE3_INTEGER);

            if($query->execute()) {

                echo "Task marked as completed";
                header("Location: task.php");
        
            } else{
                echo "There was an error, please try again later!";
            }
        }
    }
?>