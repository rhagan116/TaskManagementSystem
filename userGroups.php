<?php include('db.php');

    session_start();

    $userID = $_SESSION['User_ID'];

    //get the group task that the user is working on
    $getQuery = $db->prepare('SELECT GroupTask_ID FROM Group_Task_Users WHERE User_ID = :userID');
    $getQuery->bindValue(':userID', $userID, SQLITE3_INTEGER);
    $getResult = $getQuery->execute();

    $groupNames = [];

    while ($row = $getResult->fetchArray(SQLITE3_ASSOC)) {
        $grpTaskID = $row['GroupTask_ID'];

        //with the group task id get the group id
        $idQuery = $db->prepare('SELECT Group_ID FROM Group_Tasks WHERE GroupTask_ID = :grpTaskID');
        $idQuery->bindValue(':grpTaskID', $grpTaskID, SQLITE3_INTEGER);
        $idResult = $idQuery->execute();

        $groupIDRow = $idResult->fetchArray(SQLITE3_ASSOC);
    
        $groupID = $groupIDRow['Group_ID'];

        //get the group name with the group id
        $nameQuery = $db->prepare('SELECT Group_name FROM Groups WHERE Group_ID = :groupID');
        $nameQuery->bindValue(':groupID', $groupID, SQLITE3_INTEGER);
        $nameResult = $nameQuery->execute();
        $groupNameRow = $nameResult->fetchArray(SQLITE3_ASSOC);

        //gett the group name and insert it into the groupNames array
        if ($groupNameRow) {
            $groupNames[] = [
                'Group_ID' => $groupID,
                'Group_name' => $groupNameRow['Group_name']
            ];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="UserGroups.css">
    <script src="script.js" defer></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>userGroups</title>
</head>
<body onload="loadsidebar()">
    <div id="sidebar"></div>

    <h2>Here are the groups you are apart of!</h2>

    <div class="container">
        <div class="boxes">
            <!-- loop through the users tasks in the database and store them in an array -->
            <?php foreach ($groupNames as $group): ?>
                <div class="box">
                    <div class="box-title"><a href="userGroupTask.php?groupID=<?php echo $group['Group_ID']; ?>"> <?php echo $group['Group_name']; ?> </a></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>