<?php include("db.php");

    session_start();

    $userID = $_SESSION['User_ID'];
    $query = $db->prepare('SELECT Task_ID, Task_title, Task_info, Due_date FROM Tasks WHERE User_ID = :userID');
    $query->bindValue(':userID', $userID, SQLITE3_INTEGER);
    $result = $query->execute();
    $task = $result->fetchArray(SQLITE3_ASSOC);

    if($task){
        $taskID = $task['Task_ID'];
        $taskTitle = $task['Task_title'];
        $taskInfo = $task['Task_info'];
        $date = $task['Due_date'];
    }
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
            <div class="box">
                <div class="box-title"><?php echo $taskTitle ?? "No Data Available"; ?></div>
                <div class="line"></div>
                <div class="editTask"><a href="editTask.php"><i class='bx bxs-edit'></a></i></div>
                <div class="content"><?php echo $taskInfo ?? "No Data Available"; ?></div>
                <div class="dnt">Date due: <?php echo $date ?? "No Data Available"; ?></div>
                <div class="button">
                    <a href="delTask.php?taskID=<?php echo $task['Task_ID']; ?>" onclick="return confirm('Are you sure you have completed this task? Once completed the task will be removed!');">Complete</a>
                </div>
            </div>
            <div class="box">
                <div class="box-title">Task 2</div>
                <div class="line"></div>
                <div class="content">Task information</div>

          
            </div>
            <div class="box">
                <div class="box-title">Task 3</div>
                <div class="line"></div>
                <div class="content">Task information</div>

        
            </div>
            <div class="box">
                <div class="box-title">Task 4</div>
                <div class="line"></div>
                <div class="content">Task information</div>

          
            </div>
            <div class="box">
                <div class="box-title">Task 5</div>
                <div class="line"></div>
                <div class="content">Task information</div>

    
            </div>
            <div class="box">
                <div class="box-title">Task 6</div>
                <div class="line"></div>
                <div class="content">Task information</div>

            </div>
            <div class="box">
                <div class="box-title">Task 7</div>
                <div class="line"></div>
                <div class="content">Task information</div>

 
            </div>
            <div class="box">
                <div class="box-title">Task 8</div>
                <div class="line"></div>
                <div class="content">Task information</div>

        
            </div>
        </div>
    </div>


</body>
</html>