<?php
    require('jeopardyDB.php');
    session_start();

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo "<h5>Welcome to CSJeopardy, " . htmlspecialchars($_SESSION['username']) . "!</h5>";
    } else {
        header('Location: Login.php');
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

    <title>CSJeopardy! Menu</title>
</head>
<style>
    html, body, table {margin: 0; padding: 0; background-color: #0000ff; color: #ffffff;}
    h5 {text-align: left; font-family default;}
    body {text-align: center;}
    h1 {text-align: center; color:#ffff33; font-size: 75px; text-shadow: black 3px 3px; font-weight: bold; font-family:"HelveticaNeue-CondensedBold";}
    input {background-color: White; border-radius: 6px; text-align: center; font-size: 25px; transition-duration: 0.1s;}
    input:hover {background-color: #ffff33; color: black;}
</style>
<body>
    <div class="col-ls-7 pt-6 px-6">
    <h1>CSJeopardy!</h1>
        <form method="post">
            <div class="form-row mb-5"> 
                <input type="button" onclick="window.location.href='play.php';" 
                class="btn btn-warning btn-lg" value="PLAY GAME"/>
            <br>

            </br>
            </div>
            <div class="form-row mb-6">
                <input type="button" onclick="window.location.href='leaderboard.php';" 
                class="btn btn-warning btn-lg" value="LEADERBOARD"/>
            <br>

            </br>
            </div>  
            <div class="form-row mb-7">
                <input type="button" onclick="window.location.href='logout.php';" 
                class="btn btn-warning btn-lg" value="QUIT"/>
               
            </div>
        </form>
    </div>

</body>
