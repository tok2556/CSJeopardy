<?php
    Session_start();

    require("jeopardyDB.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        //Check if all fields are filled out
        //Password must be longer than 9 characters
        //check for duplicate users
        //If checklist is passed, initiate a query to insert data into the db
        if(empty($username) || empty($password) || empty($email)) {
            echo "<div class=echo><h6 id=malign>Fill out all forms completely</h6></div>";
        } else if(strlen($password) < 9) {
            echo "<div class=echo><h6 id=malign>Password must be longer than 9 characters</h6></div>";
        } else {
            $duplicateUser = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
            $duplicateUserresult = mysqli_query($jeopdb, $duplicateUser);

            $user = mysqli_fetch_assoc($duplicateUserresult);

            //user exists in DB already
            if($user) {
                if($user['username' === $username]) {
                    echo "<div class=echo><h6 id malign>Username is already taken</h6></div>";
                }

                if($user['email'] === $email) {
                    echo "<div class=echo><h6 id malign> Email is registered to an existing account!</h6></div>";
                }
                } else {
                    //user does not exist already and can be registered and transfered to the login page
                    $query = "INSERT INTO users(username, passcode, email)
                    VALUES('$username', '$password', '$email')";
                    mysqli_query($jeopdb, $query);
                    if(isset($_SESSION['username'])) {
                        header('Location: Login.php');
                        exit();
                    } else if(isset($_POST['username'])) {
                        $username = $_POST['username'];
                        $_SESSION['username'] = $username;
                        $url = "Login.php";
                        header('Location: Login.php');

                        exit();
                    }
                }
            }
        }
    


?>
<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@700&display=swap" rel="stylesheet">

    <title>CSJeopardy! Register</title>
</head>

<!--implement font and fix line 69 ie. implement registration form -->
<body>
    <div class="mainbody d-flex">
        <div class="container d-flex justify-conent-center my-auto">
            <div class="row g-0">
                <div class="col-ls-6 pt-5 px-5">
                    <h1>CSJeopardy! Register</h1>
                    <p>Sign up for an account below by entering your email, username, and password<p>
                    <p>Your password must be at least 9 characters<p>
                    <form method="post">
                        <div class="form-row mb-2 mt-4">
                            <input type="text" placeholder="Email" name="email" required>
                        </div>
                        <div class="form-row mb-2">
                            <input type="text" placeholder="Username" name="username" required>
                        </div>
                        <div class="form-row mb-2">
                            <input type="password" placeholder="Password" name="password" required>
                        </div>  
                        <div class="form-row mb-2">
                            <button class="accbtn mb-2" type="submit">Submit</button>
                        </div>
                        <div class="form-row">
                            <p class="mb-0">Already have an account? Login <a href="Login.php">here.</a></p> 
                        </div>
                    </form>
                </div>
            </div>
        </div>

</body>
</html>
