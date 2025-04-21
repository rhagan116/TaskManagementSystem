<?php include("db.php");

    //check that the data in the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //take the data from the form
        $username = $_POST ['user'];
        $password = $_POST ['password'];

        //check the data the user has entered against the database
        $check = $db-> prepare('SELECT User_ID FROM User WHERE Username = :username AND Password = :password');
        $check->bindValue(':username', $username, SQLITE3_TEXT);
        $check->bindValue(':password', $password, SQLITE3_TEXT);
        $result = $check->execute();

        $user = $result->fetchArray(SQLITE3_ASSOC);
        //send user through or display error message
        if ($user) {
            session_start();
            //store the users id in the session to gather data on other pages
            $_SESSION['User_ID'] = $user['User_ID'];
            
            header("Location: home.php");
            exit();
        } else{
            echo '<script>alert("Error: Incorrect Username or Password")</script>';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="Login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

    <div class="Login">
        <form action="" method="POST">
            <h1>Welcome to Tuesday.com</h1>
            <div class="input-box">
            <input type="text" id="user" name="user"
                placeholder="Username" required>
                <i class='bx bx-user'></i>
            </div>
            
            <div class="input-box">
            <input type="password" id="password" name="password"
                placeholder="Password" required> 
                <i class='bx bx-lock-alt' ></i>
            </div>

            <div class="button">
            <input name="Submit" type="submit" value="login">
            </div>

            <div class="signup-link">
                <p>Don't Have an account?
                <a href="register.php">Sign Up</a></p>
            </div>
        </form>
    </div>
</body>
</html>