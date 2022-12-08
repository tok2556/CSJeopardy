<!DOCTYPE html>
<html>
    <head>
        <title>CSJeopardy LeaderBoard</title>
        <style>
            html, body, table {margin: 0; padding: 0; background-color: #0000ff; color: #ffffff;}
		    h2 {text-align: center; color:#ffff33; font-size: 5vh; text-shadow: black 5px 5px 5px; font-weight: bold; font-family:"HelveticaNeue-CondensedBold";}
            td, th {text-align: center; background-color: #011BA9; vertical-align: middle; border: 1px #ccccff solid;}
            th {color: #ffff33; font-weight: bold; font-family: "Korinna";}
            table {width: 100vw; height: 10vh; border-spacing: 0; border-collapse: collapse;}
            input {background-color: White; border-radius: 6px; text-align: center; font-size: 13px; transition-duration: 0.1s;}
            input:hover {background-color: #ffff33; color: black;}
        </style>
    </head>
  
    <body>
        <h2>Jeopardy Leaders</h2>
        <table>
            <tr>
                <th>Ranking</th>
                <th>Player</th>
                <th>Highscore</th>
            </tr>
            
            <div class="form-row mb-8">
            <input type="button" onclick="window.location.href='jeopardyWelcomepage.php';" class="btn btn-warning btn-lg" value="Return"/>
            </div>
        
            <br>
            </br>
        
        <?php
                /* Connection Variable ("Servername",
                "username","password","database") */
                $con = mysqli_connect("localhost", 
                "root", "", "jeopardydb");
    
                /* Mysqli query to fetch rows 
                in descending order of marks */
                $result = mysqli_query($con, "SELECT username, 
                wins FROM leaderboard ORDER BY wins DESC");
    
                /* First rank will be 1 and 
                second be 2 and so on */
                $ranking = 1;
    
                /* Fetch Rows from the SQL query */
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr style=height:100%>
                                <td>{$ranking}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['wins']}</td>
                            </tr>";
                                $ranking++;
                    }
                }
            ?>

        </table>
    </body>
</html>
