<?php include("db.php");

    session_start();

    $userID = $_SESSION['User_ID'];
    $query = $db->prepare('SELECT F_name, L_name, User_pfp, User_role FROM User WHERE User_ID = :userID');
    $query->bindValue(':userID', $userID, SQLITE3_INTEGER);
    $result = $query->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);

    $fname = ($user['F_name']);
    $lname = ($user['L_name']);
    $pfp = ($user['User_pfp']);
    $role = ($user['User_role']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="sidebar.css">
    <title>Home</title>
</head>
<body>

<div class="home">
    <div class="sidebar">
        <h1>Tuesday.com</h1>
        <ul>
            <li><a href="home.php"><i class='bx bx-building-house'></i> Home</a></li>
            <li><a href="task.php"><i class='bx bx-book-bookmark'></i> My Tasks</a></li>
            <!--check if the user is an admin if they are then display the groups option on the sidebar -->
            <!-- using conditional statements with php and html code https://stackoverflow.com/questions/3812526/conditional-statements-in-php-code-between-html-code -->
            <?php if($role == "Team Admin"): ?>
                <li><a href="group.php"><i class='bx bx-group'></i></i> Groups</a></li>
                <!--change how far down the sign out button is on the sidebar this is needed because adding in the Groups section messus up the positioning -->
                <style>
                    .sidebar .signout{
                        margin-top: 100%;
                    }
                </style>
            <?php endif; ?>
            <li><a href="profile.php"><i class='bx bx-user-circle'></i> My Profile</a></li>
            <div class="signout"><li><a href="login.php"><i class='bx bx-log-out'></i> Sign Out</a></li></div>
        </ul>
    </div>
    <div class="main-content">
        
        
    </div>
    
    <div class="user-info">
        <div class="create"><a href="createTask.php">Create new task</a></div>
        <img src="<?php echo $pfp ?>">
        <p class="name"><?php echo $fname . ' ' . $lname .  ' (' . $role . ')'; ?></p>
    </div>

</div>
</body>
</html>