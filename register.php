<?php include('db.php');

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $username = $_POST['username'];
        $password = $_POST['pass'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $bio = $_POST['bio'];
        $urole = $_POST['urole'];

        $query = $db->prepare('INSERT INTO User (Username, Password, F_name, M_name, L_name, User_email, User_TelNo, User_bio, User_role)
        VALUES (:username, :pass, :fname, :mname, :lname, :email, :phone, :bio, :urole)');
        
        $query->bindValue(':username', $username, SQLITE3_TEXT);
        $query->bindValue(':pass', $password, SQLITE3_TEXT);
        $query->bindValue(':fname', $fname, SQLITE3_TEXT);
        $query->bindValue(':mname', $mname, SQLITE3_TEXT);
        $query->bindValue(':lname', $lname, SQLITE3_TEXT);
        $query->bindValue(':email', $email, SQLITE3_TEXT);
        $query->bindValue(':phone', $phone, SQLITE3_TEXT);
        $query->bindValue(':bio', $bio, SQLITE3_TEXT);
        $query->bindValue(':urole', $urole, SQLITE3_TEXT);

        if ($query->execute()) {
            echo '<div class="echo-style">Account created successfully!</div>';
        } else{
            echo '<div class="echo-style">There was an error creating your account. Please try again later!</div>';
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register.css">
    <title>Register</title>
</head>
<body>
    <h1>Tuesday.com</h1>
    <h2>Sign Up</h2>
    <div class="register">
        <form action="register.php" method="POST">
            <div class="left">
                <label for="username">Username</label><br /><br />
                <input type="text" id="username" name="username" required><br /><br />

                <label for="password">Password</label><br /><br />
                <input type="password" id="pass" name="pass" required><br /><br />

                <label for="fname">First Name</label><br /><br />
                <input type="text" id="fname" name="fname" required><br /><br />

                <label for="mname">Middle Name</label><br /><br />
                <input type="text" id="mname" name="mname"><br /><br />

                <label for="lname">Last Name</label><br /><br />
                <input type="text" id="lname" name="lname" required><br /><br />
            </div>

            <div class="right">
                <label for="email">Email</label><br /><br />
                <input type="text" id="email" name="email" required><br /><br />

                <label for="phone">Phone No</label><br /><br />
                <input type="text" id="phone" name="phone" required><br /><br />

                <label for="bio">Bio</label><br /><br />
                <input type="text" id="bio" name="bio"><br /><br />
                
                <label for="role">Role</label><br /><br />
                <input type="text" id="urole" name="urole" required><br /><br />
            </div>
            <input type="submit" id="submit" name="submit" value="Register"> <br /><br />
        </form>
    </div>
    <div class="back">
        <a href="login.php"> < </a>
    </div>
</body>
</html>