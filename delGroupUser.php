<?php include('db.php');

    if (isset($_GET['User_ID']) && isset($_GET['GroupTask_ID'])) {
        $userID = ($_GET['User_ID']);
        $taskID = ($_GET['GroupTask_ID']);

        $query = $db->prepare('DELETE FROM Group_Task_Users WHERE User_ID=:userID AND GroupTask_ID = :taskID');
        $query->bindValue(':userID', $userID, SQLITE3_INTEGER);
        $query->bindValue(':taskID', $taskID, SQLITE3_INTEGER);

            if($query->execute()) {

                //go back to the edit group tasks page
                header("Location: editGroupTask.php");
        
            } else{
                echo "There was an error, please try again later!";
            }    
    }
?>