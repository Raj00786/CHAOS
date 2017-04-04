<?php include 'database.php';?>
<?php
 $ques_query ="SELECT * 
FROM  `leader` 
ORDER BY  `score` DESC ,  `id` ASC ";
 $ques_result = mysqli_query($conn,$ques_query); 
 $total = mysqli_num_rows($ques_result);
 
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Techkriti</title>
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <script src="jquery.js"></script>
        <style type="text/css">
            body{
                background-color: #fafafa
            }
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 60%;
                margin: auto;
            }

            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #dddddd;
            }
        </style>
    </head>
    <body>
        <header>
            <div class="container">
                <h1><a href="index.php">CHAOS 17</a></h1>
            </div>
        </header>
        <main> 
    <marquee style="color:red">Please logout and login again for one time</marquee>
            <table>
              <tr>
                <th>Name</th>
                <th>Score</th>
              </tr>
             
            <?php
                if (mysqli_num_rows($ques_result) > 0) {
                    while ($row = mysqli_fetch_assoc($ques_result)) {
                        echo '<tr>';
                        echo '<td>'.$row['name'].'</td>'; 
                        echo '<td>'.$row['score'].'</td>'; 
                        echo '</tr>';
                    }
                }
            ?>
            </table>            
        </main>
    </body>
</html>
