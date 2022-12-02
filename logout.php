<?php
    //create a session, put in an array and destroy the session
    session_start();
    $_SESSION = array();
    session_destroy();
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset = "utf-8">
    <meta name = "viewport" content = "width=device-width, initial-scale = 1">
    <title> CSJeopardy! logout</title>
</head>

<body>
    <div class = "col-lg-6 pt-5 px-5">
        <h4>You have logged out</h4>
    </div>

    <form>
        <div class = "form-row">
            <p class="mb-0"> To log back in, click <a href = "Login.php">here</a>.</p>
        </div>
    </form>
</body>

</html>
