<?php include("db.php");

    session_start();

    $userID = ['User_ID'];

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
            <label for="title">Task Title</label><br /><br />
            <input type="text" id="title" name="title" required><br /><br />

            <label for="info">Task Info</label><br /><br />
            <input type="text" id="info" name="info" required><br /><br />

            <label for="date">Due Date</label><br /><br />
            <input type="text" id="date" name="date" placeholder="Please formate YYYY-MM-DD" required><br /><br />

            <input type="submit" name="submit" value="Add"> <br /><br />
    </div>


</body>
</html>