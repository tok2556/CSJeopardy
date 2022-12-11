<?php
    session_start();
    

    require('jeopardyDB.php');

    //connect to database
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $passwordInput = $_POST['password'];
        $emptyUP = false;
        
        //prompt user to enter login info 
        //added input validation to check DB for confirmation
        if(empty($username) || empty($passwordInput)) {
            echo "<div class=echo><h6>Fill out all forms completely!<h6></div>";
        } else {
            $query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
            $result = mysqli_query($jeopdb, $query);
            $user = mysqli_fetch_assoc($result);
            $passwordHash = $user['passcode'];
            $isVerified = password_verify($passwordInput, $passwordHash);

            if(!$user){
                echo "<div class=echo><h9 id=malign>Your username or password was incorrect!</h9></div>";
            } else if(!$isVerified){
                echo "<div class=echo><h9 id=malign>Your username or password was incorrect! man</h9></div>";
            } else {
                if(isset($_SESSION['username'])) {
                    header('Location: jeopardyWelcomepage.php');
                    $_SESSION['loggedin'] = true;
                    exit();
                } else if(isset($_POST['username'])) {
                    $username = $_POST['username'];
                    $_SESSION['username'] = $username;
                    $_SESSION['loggedin'] = true;
                    $url = "jeopardyWelcomepage.php";
                    header('Location: jeopardyWelcomepage.php');
                    //fix line above, implement file passage
                    exit();
                }
            }
        }

    }
?>

<!DOCTYPE html>

<!--style needed, implement css-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@700&display=swap" rel="stylesheet">

    <title>CSJeopardy! Login</title>
</head>

<style>
    html, body, table {margin: 0; padding: 0; background-color: #0000ff; color: #ffffff;}
    body {text-align: center;}
    h1 {text-align: center; color:#ffff33; font-size: 75px; text-shadow: black 3px 3px; font-weight: bold; font-family:"HelveticaNeue-CondensedBold";}
    input {background-color: White; border-radius: 6px; text-align: center; font-size: 25px; transition-duration: 0.1s;}
    input:hover {background-color: #ffff33; color: black;}
    button {background-color: White; border-radius: 6px; text-align: center; font-size: 16px; transition-duration: 0.1s;}
    button:hover {background-color: #ffff33; color: black;}
    p {font-size: 20px;}
    a {color:#ffff33;}
</style>

<!--implement font and fix line 69 ie. implement registration form -->
<body>
    <div class="col-ls-6 pt-5 px-5">
    <h1>CSJeopardy! Log In</h1>
    <p>Welcome back!<p>
        <form method="post">
            <div class="form-row mb-3 mt-4">
                <input type="text" placeholder="Username" name="username" required>
            </div>
            <div class="form-row mb-4">
                <input type="password" placeholder="Password" name="password" required>
            </div>  
            <div class="form-row">
                <button class="accbtn mb-2" type="submit">Submit</button>
                <p class="mb-0">No account? Create an account <a href="registration.php">here.</a></p> 
            </div>
        </form>
    </div>

</body>
</html>
