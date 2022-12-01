<!DOCTYPE html>
<html>
    <head>
        <title>CSJeopardy LeaderBoard</title>
    </head>
  
    <body>
        <h2>Jeopardy Leaders</h2>
        <table>
            <tr>
                <th>Ranking</th>
                <th>Player</th>
                <th>Matches Won</th>
            </tr>

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