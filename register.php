<?php


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

    <div class="register">
        <form action="register.php" method="POST">
            <div class="left">
                <label for="username">Username</label><br /><br />
                <input type="text" id="username" name="username"><br /><br />

                <label for="password">Password</label><br /><br />
                <input type="password" id="password" name="password"><br /><br />

                <label for="fname">First Name</label><br /><br />
                <input type="text" id="fname" name="fname" ><br /><br />

                <label for="mname">Middle Name</label><br /><br />
                <input type="text" id="mname" name="mname"><br /><br />

                <label for="lname">Last Name</label><br /><br />
                <input type="text" id="lname" name="lname"><br /><br />
            </div>

            <div class="right">
                <label for="email">Email</label><br /><br />
                <input type="text" id="email" name="email"><br /><br />

                <label for="phone">Phone No</label><br /><br />
                <input type="text" id="phone" name="phone"><br /><br />

                <label for="bio">Bio</label><br /><br />
                <input type="text" id="bio" name="bio"><br /><br />

                <div class="profile">
                    <label for="pfp">Profile Picture</label><br /><br />
                    <type="file" id="pfp" name="pfp"><br /><br />
                </div>
                <label for="role">Role</label><br /><br />
                <input type="text" id="role" name="role"><br /><br />
            </div>
        </form>
    </div>

</body>
</html>