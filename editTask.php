<?php include("db.php");

    session_start();

    //take the task id and change it from being GET method to SESSION so it can be updated with the form
    if (isset($_GET['taskID'])) {
        $_SESSION['taskID'] = $_GET['taskID'];
    }

    $taskID = $_SESSION['taskID'];
    $userID = $_SESSION['User_ID'];
    
    $query = $db->prepare('SELECT Task_title, Task_info, Due_date FROM Tasks WHERE Task_ID=:taskID AND User_ID=:userID');
    $query->bindValue(':taskID', $taskID, SQLITE3_INTEGER);
    $query->bindValue(':userID', $userID, SQLITE3_INTEGER);

    $result = $query->execute();
    $task = $result->fetchArray(SQLITE3_ASSOC);

    $title = $task['Task_title'];
    $info = $task['Task_info'];
    $dueDate = $task['Due_date'];

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $newTitle = $_POST["title"];
        $newInfo = $_POST["info"];
        $newDate = $_POST["dueDate"];

        $stmt = $db->prepare("UPDATE Tasks SET Task_title=:newTitle, Task_info=:info, Due_date=:newDate WHERE Task_ID =:taskID AND User_ID=:userID");

        $stmt->bindValue(":newTitle", $newTitle, SQLITE3_TEXT);
        $stmt->bindValue(":newInfo", $newInfo, SQLITE3_TEXT);
        $stmt->bindValue(":newDate", $newDate, SQLITE3_TEXT);
        $stmt->bindValue(":taskID", $taskID, SQLITE3_INTEGER);
        $stmt->bindValue(":userID", $userID, SQLITE3_INTEGER);

        if ($stmt->execute()){
            echo '<div class="echo-style">Task added!</div>';
        } else {
            echo '<div class="echo-style">There was an issue updating your task, please try again later!</div>';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editTask.css">
    <script src="script.js">defer</script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>editTask</title>
</head>
<body onload="loadsidebar()">
    <div id="sidebar"></div> 
    
    <h2>Edit Task</h2>

    <div class="editForm">
        <form action="editTask.php" method="post">

        
            <label for="title">Task Title:</label><br /><br />
            <input type="text" id="title" name="title" value ="<?php echo $title ?>"required><br /><br />

            <label for="info">Task Info:</label><br /><br />
            <input type="text" id="info" name="info" value="<?php echo $info ?>"required><br /><br />

            <label for="date">Due Date:</label><br /><br />
            <input type="text" id="dueDate" name="dueDate" placeholder="Please format YYYY-MM-DD" value="<?php echo $dueDate?>"required><br /><br />

            <input type="submit" name="submit" value="Update"> <br /><br />
    </div>
</body>
</html>