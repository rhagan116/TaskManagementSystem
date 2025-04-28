<?php include("db.php");

    session_start();

    //take the task id and change it from being GET method to SESSION so it can be updated with the form
    if (isset($_GET['GroupTaskID'])) {
        $_SESSION['GroupTaskID'] = $_GET['GroupTaskID'];
    }

    $taskID = $_SESSION['GroupTaskID'];
    
    $query = $db->prepare('SELECT groupTask_title, groupTask_info, taskDue_date 
    FROM Group_Tasks 
    WHERE GroupTask_ID=:taskID');
    $query->bindValue(':taskID', $taskID, SQLITE3_INTEGER);

    $result = $query->execute();
    $task = $result->fetchArray(SQLITE3_ASSOC);

    $title = $task['groupTask_title'];
    $info = $task['groupTask_info'];
    $dueDate = $task['taskDue_date'];

    //updating task form
    if (isset($_POST['updateTask']))
        if ($_SERVER["REQUEST_METHOD"] == "POST"){

            $newTitle = $_POST["title"];
            $newInfo = $_POST["info"];
            $newDate = $_POST["dueDate"];

            $stmt = $db->prepare("UPDATE Group_Tasks 
            SET groupTask_title=:newTitle, groupTask_info=:newInfo, taskDue_date=:newDate 
            WHERE GroupTask_ID =:taskID");

            $stmt->bindValue(":newTitle", $newTitle, SQLITE3_TEXT);
            $stmt->bindValue(":newInfo", $newInfo, SQLITE3_TEXT);
            $stmt->bindValue(":newDate", $newDate, SQLITE3_TEXT);
            $stmt->bindValue(":taskID", $taskID, SQLITE3_INTEGER);

            if ($stmt->execute()){
                echo "Task Updated!";
            } else {
                echo "There was an issue updating your task, please try again later!";
            }
        }

    //adding user form
    if (isset($_POST['addUser'])){
        if ($_SERVER["REQUEST_METHOD"] == "POST"){

            $username = $_POST['username'];

            //get the user id that belongs to the username
            $getQuery = $db->prepare("SELECT User_ID FROM User WHERE Username = :user");
            $getQuery->bindValue(':user', $username, SQLITE3_TEXT);
            $getResult = $getQuery->execute();
            $user = $getResult->fetchArray(SQLITE3_ASSOC);

            $userID = $user['User_ID'];

            //put the user id into the group task users database 
            $addQuery = $db->prepare('INSERT INTO Group_Task_Users (GroupTask_ID, User_ID)
            VALUES (:groupTaskID, :userID)');

            $addQuery->bindValue(':groupTaskID', $taskID, SQLITE3_INTEGER);
            $addQuery->bindValue(':userID', $userID, SQLITE3_INTEGER);

            if ($addQuery->execute()) {
                echo "User Added!";
            } else{
                echo "There was an error adding the user, Please try again later!";
            }



            
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editGroupTask.css">
    <script src="script.js">defer</script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>editGroupTasks</title>
</head>
<body onload="loadsidebar()">
    <div id="sidebar"></div>

    <h2>Edit the group task,
        or add a user!
    </h2>

    <div class="editForm">
        <form action="editGroupTask.php" method="post">

            <label for="title">Task Title:</label><br /><br />
            <input type="text" id="title" name="title" value ="<?php echo $title ?>"required><br /><br />

            <label for="info">Task Info:</label><br /><br />
            <input type="text" id="info" name="info" value="<?php echo $info ?>"required><br /><br />

            <label for="date">Due Date:</label><br /><br />
            <input type="text" id="dueDate" name="dueDate" placeholder="Please format YYYY-MM-DD" value="<?php echo $dueDate?>"required><br /><br />

            <input type="submit" name="updateTask" value="Update"> <br /><br />
        </form>
    </div>

    <div class="addUser">
        <form action="editGroupTask.php" method="post">

            <label for="username">Username:</label><br /><br />
            <input type="text" id="username" name="username" placeholder="Username" required><br /><br />

            <input type="submit" name="addUser" value="Add"> <br /><br />
        </form>
    </div>
</body>
</html>