<?php include("db.php");

    session_start();

    $userID = $_SESSION['User_ID'];

    $query = $db->prepare('SELECT F_name, M_name, L_name, User_email, User_TelNo, User_bio, User_pfp FROM User WHERE User_ID=:userID');
    $query->bindValue(':userID', $userID, SQLITE3_INTEGER);
    $result = $query->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);

    $fname = $user['F_name'];
    $mname = $user['M_name'];
    $lname = $user['L_name'];
    $email = $user['User_email'];
    $telNo = $user['User_TelNo'];
    $bio = $user['User_bio'];
    $pfp = $user['User_pfp'];

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        
        $newFname = $_POST["fname"];
        $newMname = $_POST["mname"];
        $newLname = $_POST["lname"];
        $newEmail = $_POST["email"];
        $newPhoneNo = $_POST["phoneNo"];
        $newBio = $_POST["bio"];

        $stmt = $db->prepare("UPDATE User SET F_name=:fname, M_name=:mname, L_name=:lname, User_email=:email, User_TelNo=:phoneNo, User_bio=:bio WHERE User_ID=:userID");
        
        $stmt->bindValue(":userID", $userID, SQLITE3_INTEGER);
        $stmt->bindValue(":fname", $newFname, SQLITE3_TEXT);
        $stmt->bindValue(":mname", $newMname, SQLITE3_TEXT);
        $stmt->bindValue(":lname", $newLname, SQLITE3_TEXT);
        $stmt->bindValue(":email", $newEmail, SQLITE3_TEXT);
        $stmt->bindValue(":phoneNo", $newPhoneNo, SQLITE3_TEXT);
        $stmt->bindValue(":bio", $newBio, SQLITE3_TEXT);

        if ($stmt->execute()){
            echo '<div class="echo-style">Profile updated!</div>';
        } else {
            echo '<div class="echo-style">There was an issue updating your profile, please try again later!</div>';
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyProfile</title>
    <link rel="stylesheet" href="profile.css">
    <script src="script.js">defer</script>

</head>
<body onload="loadsidebar()">
    <div id="sidebar"></div>

    <div class="profile">
        <div class="image-wrapper">
        <img src="<?php echo $pfp ?>">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <!--stuff to be displayed when the user hovers over the profile picture icon -->
            <button>
                <i class='bx bx-user-plus'></i><br />Change Profile <br />Picture
                <input type="file" id="fileUpload" name="fileUpload" class="uploadBtn" accept=".jpg, .png, .jpeg">
                <input type="submit" name="submitPic" value="Upload" class="submitBtn">
            </button>
        </form>
        </div>
        <div class="text">
            <h1><?php echo $fname . ' ' . $mname . ' ' . $lname ?></h1>
            <h2><?php echo $email ?></h2>
            <h3><?php echo $telNo ?></h3>
            <h4><?php echo $bio ?></h4>
        </div>
    </div>
    <hr class="line">


    <div class="edit">
        <form action="profile.php" method="post">
            <div class="left">
                <label for="fname">First Name</label><br />
                <input type="text" id="fname" name="fname" value="<?php echo $fname?>"><br /><br /><br />

                <label for="mname">Middle Name</label><br />
                <input type="text" id="mname" name="mname" value="<?php echo $mname?>"><br /><br /><br />

                <label for="lname">Last Name</label><br />
                <input type="text" id="lname" name="lname" value="<?php echo $lname?>"><br /><br /><br />
            </div>

            <div class="right">
                <label for="email">Email</label><br />
                <input type="text" id="email" name="email" value="<?php echo $email?>"><br /><br /><br />

                <label for="phoneNo">Contact Number</label><br />
                <input type="number" id="phoneNo" name="phoneNo" value="<?php echo $telNo?>"><br /><br /><br />

                <div class="bio">
                <label for="bio">Bio</label><br />
                <input type="text" id="bio" name="bio" value="<?php echo $bio?>"><br /><br /><br />
                </div>
            </div>

            <div class="input">
            <input name="submit" type="submit" value="Save"/>
            </div>
        </form>
    </div>
</body>
</html>