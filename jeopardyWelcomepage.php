<?php
    require('jeopardyDB.php');
    session_start();

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo "Welcome to CSJeopardy, " . htmlspecialchars($_SESSION['username']) . "!";
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

<body>
    <div class="col-ls-7 pt-6 px-6">
    <h1>CSJeopardy!</h1>
        <form method="post">
            <div class="form-row mb-5"> 
                <input type="button" onclick="window.location.href='playgame.php';" 
                class="btn btn-warning btn-lg" value="PLAY GAME"/>
            
            </div>
            <div class="form-row mb-6">
                <input type="button" onclick="window.location.href='leaderboard.php';" 
                class="btn btn-warning btn-lg" value="LEADERBOARD"/>

            </div>  
            <div class="form-row mb-7">
                <input type="button" onclick="window.location.href='logout.php';" 
                class="btn btn-warning btn-lg" value="QUIT"/>
               
            </div>
        </form>
    </div>

</body>
