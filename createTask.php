<?php include("db.php");

    session_start();

    $userID = $_SESSION['User_ID'];

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        //take the information from the form 
        $newTitle = $_POST["title"];
        $newInfo = $_POST["info"];
        $newDate = $_POST["dueDate"];

        //insert the task into the database
        $stmt = $db->prepare("INSERT INTO Tasks (Task_title, Task_info, Due_date, User_ID)
        VALUES (:title, :info, :dueDate, :userID)");

        
        $stmt->bindValue(':title', $newTitle, SQLITE3_TEXT);
        $stmt->bindValue('info', $newInfo, SQLITE3_TEXT);
        $stmt->bindValue(':dueDate', $newDate, SQLITE3_TEXT);
        $stmt->bindValue(':userID', $userID, SQLITE3_INTEGER);

        if ($stmt->execute()) {
            echo '<div class="echo-style">Task added!</div>';
        } else{
            echo '<div class="echo-style">There was an error adding your task. Please try again later!</div>'
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="createTask.css">
    <script src="script.js">defer</script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>CreateTask</title>
</head>
<body onload="loadsidebar()">
<div id="sidebar"></div>
    
    <h2>Add a new task!</h2>
    <div class="addForm">
        <form action="createTask.php" method="post">
            <label for="title">Task Title:</label><br /><br />
            <input type="text" id="title" name="title" required><br /><br />

            <label for="info">Task Info:</label><br /><br />
            <input type="text" id="info" name="info" required><br /><br />

            <label for="date">Due Date:</label><br /><br />
            <input type="text" id="dueDate" name="dueDate" placeholder="Please format YYYY-MM-DD" required><br /><br />

            <input type="submit" name="submit" value="Add"> <br /><br />
    </div>


</body>
</html>