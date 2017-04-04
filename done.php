<?php include 'database.php';?>
<?php session_start(); 
  if($_SESSION["name"]==''){
    header('Location: index.php');
  }
  $name=$_SESSION["name"];
  $select_query ="SELECT * FROM leader WHERE name='$name'";  
  $select_result = mysqli_query($conn,$select_query); 
  $select  = mysqli_fetch_assoc($select_result);
  $points = $select['points'];
   
  if($points==='9'){
  }
  else{
    header('Location: index.php');    
  }
?>
</!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8 ">
    <title>CHAOS | Techkriti 17</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <style type="text/css">
          header>div{
             width: 60%;
            display: flex;
            margin: auto;
          }
          .container {
             text-align: center;
          }
          header a{
             width: 20%;
            margin: auto;
            width: 100px;
            background-color: blue;
            color: white;
            padding: 11px;
            text-align: center;
            border-radius: 4px;
          }
          .top{
           display: block;
           margin: auto;
          }
          #logout{
	          width: 100px;
	          background-color: blue;
	          color: white;
	          padding: 11px;
	          text-align: center;
	          border-radius: 4px;
	          position: absolute;
	          right: 10px;
          }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Chaos 17</h1>
            <a href="leader_board.php">Leader Board</a>
        </div>
    </header>
    <main>
        <div class="top">
          <a id="logout" href="logout.php">LOG OUT</a>
        </div>
        <div class="container">
               <h1>You have completed Chaos successfully</h1>
        </div>
    </main>
</body>
</html>      