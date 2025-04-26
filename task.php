<?php include("db.php");

    session_start();

    $userID = $_SESSION['User_ID'];
    $query = $db->prepare('SELECT Task_ID, Task_title, Task_info, Due_date FROM Tasks WHERE User_ID = :userID');
    $query->bindValue(':userID', $userID, SQLITE3_INTEGER);
    $result = $query->execute();
    $task = $result->fetchArray(SQLITE3_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyTasks</title>
    <link rel="stylesheet" href="task.css">
    <script src="script.js">defer</script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body onload="loadsidebar()">
    <div id="sidebar"></div>

    <div class="title"><h1>Here are your upcoming tasks!</h1></div>

    <div class="container">
        <div class="boxes">
            <!-- loop through the users tasks in the database and store them in an array -->
            <?php while ($task = $result->fetchArray(SQLITE3_ASSOC)): ?>
                <div class="box">
                    <div class="box-title"><?php echo $task['Task_title']; ?></div>
                    <div class="line"></div>
                    <div class="editTask"><a href="editTask.php?taskID=<?php echo $task['Task_ID']; ?>"><i class='bx bxs-edit'></a></i></div>
                    <div class="content"><?php echo $task['Task_info']; ?></div>
                    <div class="dnt">Date due: <?php echo $task['Due_date']; ?></div>
                    <div class="button">
                        <a href="delTask.php?taskID=<?php echo $task['Task_ID']; ?>" onclick="return confirm('Are you sure you have completed this task? Once completed the task will be removed!');">Complete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

</body>
</html>