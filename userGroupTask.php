<?php include('db.php');

    session_start();

    if (isset($_GET['groupID'])) {
        $_SESSION['Group_ID'] = $_GET['groupID'];
    }

    $groupID = $_SESSION['Group_ID'];
    $userID = $_SESSION['User_ID'];

    //get the group task id 
    $getQuery = $db->prepare('SELECT GroupTask_ID FROM Group_Task_Users WHERE User_ID = :userID');
    $getQuery->bindValue('userID', $userID, SQLITE3_INTEGER);
    $getResult = $getQuery->execute();

    $groupTasks = [];

    while ($row = $getResult->fetchArray(SQLITE3_ASSOC)) {

        $grpTaskID = $row['GroupTask_ID'];
        
        //get the group task information
        $infoQuery = $db->prepare('SELECT groupTask_title, groupTask_info, taskDue_date FROM Group_Tasks WHERE GroupTask_ID = :grpTaskID AND Group_ID =:groupID');
        $infoQuery->bindValue(':grpTaskID', $grpTaskID, SQLITE3_INTEGER);
        $infoQuery->bindValue(':groupID', $groupID, SQLITE3_INTEGER);
        $infoResult = $infoQuery->execute();

        while ($task = $infoResult->fetchArray(SQLITE3_ASSOC)) {
            $groupTasks[] = $task;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="userGroupTask.css">
    <script src="script.js">defer</script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>groupTasks</title>
</head>
<body onload="loadsidebar()">
    <div id="sidebar"></div>

    <div class="title"><h1>Here are your upcoming group Tasks!</h1></div>

    <div class="group"><a href="userGroupTask.php"><i class='bx bx-group'></i>View group tasks</a></div>

    <div class="container">
        <div class="boxes">
            
            <?php foreach ($groupTasks as $task): ?>
                <div class="box">
                    <div class="box-title"><?php echo $task['groupTask_title']; ?></div>
                    <div class="line"></div>
                    <div class="content"><?php echo $task['groupTask_info']; ?></div>
                    <div class="dnt">Date due: <?php echo $task['taskDue_date']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>
