<?php include('db.php');

    session_start();

    //get the group id from the url and pass it into the session
    if (isset($_GET['groupID'])) {
        $_SESSION['Group_ID'] = $_GET['groupID'];
    }
    
    $userID = $_SESSION['User_ID'];
    $groupID = $_SESSION['Group_ID'];

    $query = $db->prepare('SELECT GroupTask_ID, groupTask_title, groupTask_info, groupTask_status, taskDue_date FROM Group_Tasks WHERE Group_ID =:groupID');
    $query->bindValue(':userID', $userID, SQLITE3_INTEGER);
    $query->bindValue(':groupID', $groupID, SQLITE3_INTEGER);
    $result = $query->execute();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>groupTasks</title>
    <link rel="stylesheet" href="groupTasks.css">
    <script src="script.js">defer</script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body onload="loadsidebar()">
    <div id="sidebar"></div>

    <div class="title"><h1>Here are the groups tasks!</h1></div>

    <div class="container">
        <div class="boxes">
            <!-- loop through the users tasks in the database and store them in an array -->
            <?php while ($groupTask = $result->fetchArray(SQLITE3_ASSOC)): ?>
                <div class="box">
                    <div class="box-title"><?php echo $groupTask['groupTask_title']; ?></div>
                    <div class="line"></div>
                    <div class="editTask"><a href="editGroupTask.php?GroupTaskID=<?php echo $groupTask['GroupTask_ID']; ?>"><i class='bx bxs-edit'></a></i></div>
                    <div class="content"><?php echo $groupTask['groupTask_info']; ?></div>
                    <div class="dnt">Date due: <?php echo $groupTask['taskDue_date']; ?></div>
                    <div class="trash">
                        <a href="delGroupTask.php?GroupTaskID=<?php echo $groupTask['GroupTask_ID']; ?>" onclick="return confirm('Are you sure you have completed this task? Once completed the task will be removed!');"><i class='bx bx-trash-alt' ></i></a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>


</body>
</html>