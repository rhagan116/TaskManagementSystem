<?php include("db.php");

    if (isset($_GET['GroupTaskID'])) {

        $groupTaskID = intval($_GET['GroupTaskID']);
        if ($groupTaskID > 0) {
            $query = $db->prepare('DELETE FROM Group_Tasks WHERE GroupTask_ID=:groupTaskID');
            $query->bindValue(':groupTaskID', $groupTaskID, SQLITE3_INTEGER);

            if($query->execute()) {
                
                //go back to the group tasks
                header("Location: groupTasks.php");
        
            } else{
                echo "There was an error, please try again later!";
            }
        }
    }
?>