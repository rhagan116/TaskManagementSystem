<?php include('db.php');

    session_start();

    $userID = $_SESSION['User_ID'];

    //sql for displaying the groups
    $viewQuery = $db->prepare('SELECT Group_ID, Group_name FROM Groups WHERE User_ID = :userID');
    $viewQuery->bindValue(':userID', $userID, SQLITE3_INTEGER);
    $result = $viewQuery->execute();


    //sql for creating a new group
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $groupName = $_POST["title"];

        $stmt = $db->prepare("INSERT INTO Groups (Group_name, User_ID) 
        VALUES (:title, :userID)");

        $stmt->bindValue(':title', $groupName, SQLITE3_TEXT);
        $stmt->bindValue(':userID', $userID, SQLITE3_INTEGER);

        if ($stmt->execute()) {
            echo "Group Created!";
        } else{
            echo "There was an error creating your group, Please try again later!";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="group.css">
    <script src="script.js" defer></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>createGroup</title>
</head>
<body onload="loadsidebar()">
    <div id="sidebar"></div>
    <h2>Here are your group's!</h2>
    <h3>Select a group to modify it or add tasks and users</h3>

    <div class="container">
        <div class="boxes">
            <!-- loop through the users tasks in the database and store them in an array -->
            <?php while ($group = $result->fetchArray(SQLITE3_ASSOC)): ?>
                <div class="box">
                    <div class="box-title"><a href="groupTasks.php?groupID=<?php echo $group['Group_ID']; ?>"> <?php echo $group['Group_name']; ?> </a></div>
                    <div class="line"></div>
                    <div class="editGroup"><a href="editGroup.php?groupID=<?php echo $group['Group_ID']; ?>"><i class='bx bxs-edit'></a></i></div>

                    <div class="trash">
                        <a href="delGroup.php?groupID=<?php echo $group['Group_ID']; ?>" onclick="return confirm('Are you sure you want to delete this group?');"><i class='bx bx-trash-alt' ></i></a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <hr class="seperator">

    <div class="addForm">
        <form action="group.php" method="post">
            <label for="title">Create a group:</label><br /><br />
            <input type="text" id="title" name="title" placeholder="Group Name" required><br /><br />

            <input type="submit" name="submit" value="Create"> <br /><br />
    </div>

</body>
</html>