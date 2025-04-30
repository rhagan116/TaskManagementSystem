<?php include('db.php');

    session_start();

    $userID = $_SESSION['User_ID'];

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        //take the group name from the form 
        $groupName = $_POST["title"];


        $stmt = $db->prepare("INSERT INTO Groups (Group_name, User_ID) 
        VALUES (:title, :userID)");

        $stmt->bindValue(':title', $groupName, SQLITE3_TEXT);
        $stmt->bindValue(':userID', $userID, SQLITE3_INTEGER);

        if ($stmt->execute()) {
            echo '<div class="echo-style">Group Created!</div>';
        } else{
            echo '<div class="echo-style">There was an error creating your group, please try again later!</div>';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="createGroup.css">
    <script src="script.js" defer></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>createGroup</title>
</head>
<body onload="loadsidebar()">
    <div id="sidebar"></div>
    <h2>Create a new group!</h2>
    
    <div class="addForm">
        <form action="createGroup.php" method="post">
            <label for="title">Group Name:</label><br /><br />
            <input type="text" id="title" name="title" required><br /><br />

            <input type="submit" name="submit" value="Create"> <br /><br />
    </div>

    <div class="create">
        <div class=button><a href="createGroupTask.php" style="text-decoration:none;"> <i class='bx bx-user-plus' ></i> Create a group task</a></div>
    </div>
</body>
</html>