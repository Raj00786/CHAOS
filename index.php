<?php session_start();


 if($_SESSION["name"]!=''){
   echo $_SESSION["name"];
   header('Location: que.php');
 }
 else{
   $_SESSION["name"]='';
   $_SESSION["score"]=0;
 }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>CHAOS | Techkriti 17</title>
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8 ">
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <script src="jquery.js"></script>
        <style type="text/css">
        html{
          height: 100%;
        }
        header{
          background-color: white
        }
          body{
             height: 100%;
            background-image: url(chaos.jpg);
            background-color: #fafafa;
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0px;
          }
          header>div{
             width: 60%;
            display: flex;
            margin: auto;
          }
          ul{
            position: relative;
          }
          .container{
                width: 60%;
                padding: 40px;
                margin: 0% auto;
                background-color: rgba(255, 255, 255, 1);
            }
          ul a{
            position: absolute;
            right: 100px;
            background-color: blue;
            padding: 10px;
            color: white;
            border-radius: 5px;
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
          header h1{
             width: 70%;
          }
          form input{
            width: 75%!important;
          }
          form label{
            width: 25%;
          }
          form>div{
            display: flex;
            padding: 10px;
          }
          form{
            width: 60%;
            background-color: white;
            margin: auto;
            border-radius: 5px;
            padding: 15px;
          }
          #login{
            width: 100%!important;
            padding: 3px;
            cursor: pointer;
          }

        </style>
        <script type="text/javascript">
            $(function(){
                $('#login').on('click',function(){
                var username = $('#username').val();
                var password = $('#password').val();
                var dataString = "username="+username+"&pass="+password;
                $.ajax({
                      url: 'login.php',
                      data:dataString,   
                      type: 'POST',
                      dataType: "json",              
                      success: function(data){
                           if(data!='false'){
                               location.href = "leader_board.php";
                           }
                           else{
                            console.log('not logged');
                           }
                      }
                });
            });
            })
        </script>
    </head>
    <body>
        <header>
            <div>
                <h1>CHAOS 17</h1>
                <a href="leader_board.php">Leader Board</a>
            </div>
        </header>
        <main>
            <div class="container">
                <h2>Instructions:</h2>
                <ul>
                <a style="top: -50px;" target="_blank"  href="documentation.html">Documentation</a>
                <a target="_blank"  href="compiler/">Compiler</a>
          <li><strong>check the documentaion for the the language and commands </li></strong>         <li><strong>One can at most skip two questions and return back to them</strong></li>
<li><strong>Tie breaker would be based on time of last submission.</strong></li>

<li><strong>Number of Questions:8 </strong></li>
                    <li><strong>Time: 3 hours 10 minutes </strong></li>
                </ul>
    <marquee style="color:red">Please logout and login again for one time</marquee>

                <form >
                    <div>
                      <label for="username">Username</label>
                      <input id="username" type="text" name="username">
                    </div>
                    <div>
                       <label for="password">Password</label>
                       <input id="password" type="password" name="password">
                    </div>
                    <div>
                      <input type="button" id="login" value="Login" name="login">
                    </div>
                </form>
            
            </div>
        </main>
    </body>
</html>
