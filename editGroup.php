<?php include('db.php');

    session_start();

    if (isset($_GET['groupID'])) {
        $_SESSION['groupID'] = $_GET['groupID'];
    }

    $userID = $_SESSION['User_ID'];
    $groupID = $_SESSION['groupID'];

    $titleQuery = $db->prepare("SELECT Group_name FROM Groups WHERE User_ID = :userID AND Group_ID = :groupID");
    $titleQuery->bindValue(':userID', $userID, SQLITE3_INTEGER);
    $titleQuery->bindValue(':groupID', $groupID, SQLITE3_INTEGER);

    $titleResult = $titleQuery->execute();
    $group = $titleResult->fetchArray(SQLITE3_ASSOC);

    $groupName = $group['Group_name'];

    //group name form
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $newName = $_POST["name"];

        $update = $db->prepare("UPDATE Groups SET Group_name=:newName WHERE Group_ID =:groupID AND User_ID=:userID");

        $update->bindValue(":groupID", $groupID, SQLITE3_INTEGER);
        $update->bindValue(":userID", $userID, SQLITE3_INTEGER);
        $update->bindValue(":newName", $newName, SQLITE3_TEXT);


        if ($update->execute()){
            echo "Group name succesfully updated!";
        } else {
            echo "There was an issue updating your group, please try again later!";
        }
    }

    //add task form 
    if (isset($_POST['addTask'])){
        if ($_SERVER["REQUEST_METHOD"] == "POST"){

            $taskTitle = $_POST["title"];
            $taskInfo = $_POST["info"];
            $taskDate = $_POST["dueDate"];
    
            $stmt = $db->prepare("INSERT INTO Group_Tasks (groupTask_title, groupTask_info, taskDue_date, Group_ID)
            VALUES (:title, :info, :dueDate, :groupID)");
    
            
            $stmt->bindValue(':title', $taskTitle, SQLITE3_TEXT);
            $stmt->bindValue(':info', $taskInfo, SQLITE3_TEXT);
            $stmt->bindValue(':dueDate', $taskDate, SQLITE3_TEXT);
            $stmt->bindValue(':groupID', $groupID, SQLITE3_INTEGER);
    
            if ($stmt->execute()) {
                echo "Task added!";
            } else{
                echo "There was an error adding your task. Please try again later!";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editGroup.css">
    <script src="script.js" defer></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>editGroup</title>
</head>
<body>
<body onload="loadsidebar()">
    <div id="sidebar"></div>

    <h2>Edit Group</h2>
    <h3>Change the group name or add tasks to your group</h3>
    <div class="editForm">
        <form action="editGroup.php" method="post">
        
            <label for="name">Group Name:</label><br /><br />
            <input type="text" id="name" name="name" value ="<?php echo $groupName ?>"required><br /><br />

            <input type="submit" name="submit" value="Update"> <br /><br />
    </div>

    <!-- task input form here -->
    <div class="addForm">
        <form action="editGroup.php" method="post">
            
            <label for="title">Task Title:</label><br /><br />
            <input type="text" id="title" name="title" required><br /><br />

            <label for="info">Task Info:</label><br /><br />
            <input type="text" id="info" name="info" required><br /><br />

            <label for="date">Due Date:</label><br /><br />
            <input type="text" id="dueDate" name="dueDate" placeholder="Please format YYYY-MM-DD" required><br /><br />

            <input type="submit" name="addTask" value="Add Task"> <br /><br />
    </div>

</body>
</html>