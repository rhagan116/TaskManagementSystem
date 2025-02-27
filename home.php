<?php include("db.php");

    session_start();
    
    $userID = $_SESSION['User_ID'];
    $query = $db->prepare('SELECT F_name, L_name FROM User WHERE User_ID = :userID');
    $query->bindValue(':userID', $userID, SQLITE3_INTEGER);
    $result = $query->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);

    $fname = $user['F_name'];
    $lname = $user['L_name'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="home.css">
    <script src="script.js" defer></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body onload="loadsidebar()" data-user-id="<?php echo $userID;?>">
    <div id="sidebar"></div>

    <div class="title"><h1>Welcome, <?php echo $fname . ' ' . $lname;?>!</h1></div>
    <div class="calInfo">Here is your month summarised:</div>
    <div class="calWarning">*please note your upcoming tasks are displayed in red</div>

    <div class="container">
        <div class="calendar">
            <div class="header">
                <button id="prevMonth">
                    <i class='bx bx-chevron-left'></i>
                </button>
                <div class="monthYear" id="monthYear"></div>
                <button id="nextMonth">
                    <i class='bx bx-chevron-right' ></i>
                </button>
            </div>
                <div class="days">
                    <div class="day">Mon</div>
                    <div class="day">Tue</div>
                    <div class="day">Wed</div>
                    <div class="day">Thu</div>
                    <div class="day">Fri</div>
                    <div class="day">Sat</div>
                    <div class="day">Sun</div>
                </div>
                <div class="dates" id="dates"></div>
        </div>
    </div>

    <script src="cal.js"></script>

</body>
</html>
