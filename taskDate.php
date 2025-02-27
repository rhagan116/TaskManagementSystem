<?php include("db.php");

    session_start();

    $userID = ['User_ID'];

    $query = $db->prepare('SELECT Due_date FROM Tasks WHERE User_ID=:userID');
    $query->bindValue(':userID', $userID, SQLITE3_INTEGER);
    $result = $query->execute();

    $dueDates = [];

    while($date = $result->fetchArray(SQLITE3_ASSOC)){

        $dueDates[] = $date['Due_date'];

    }

    echo json_encode($dueDates);
?>