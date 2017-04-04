<?php header('Access-Control-Allow-Origin: *'); ?>
<?php header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');?>
<?php header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT'); ?>
<?php include 'database.php';?>
<?php session_start(); 
  if($_SESSION["name"]==''){
    header('Location: index.php');
  }
  else{
    
  }
      header('Location: logout.php');
  $name=$_SESSION["name"];
  $pre = $_GET['num'];
  $select_query ="SELECT * FROM leader WHERE name='$name'";  
  $select_result = mysqli_query($conn,$select_query); 
  $select  = mysqli_fetch_assoc($select_result);
  $skip = $select['skip'];
  $skip = explode(",", $skip);

?>
</!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8 ">
  <meta http-equiv="cache-control" content="no-cache, must-revalidate, post-check=0, pre-check=0">
  <meta http-equiv="expires" content="Sat, 31 Oct 2014 00:00:00 GMT">
  <meta http-equiv="pragma" content="no-cache">
  	<title>CHAOS | Techkriti 17</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <script src="jquery.js"></script>
    <style type="text/css">
            body{
                background-color: #fafafa
            }
        textarea {
          width: 100%;
          height: 250px;
          border: 3px solid #cccccc;
          padding: 5px;
          font-family: Tahoma, sans-serif;
          background-position: bottom right;
          background-repeat: no-repeat;
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
          header>div{
             width: 60%;
            display: flex;
            margin: auto;
          }
        #time{
          width: 140px;
          background-color: blue;
          text-align: center;
          padding: 10px;
          color: white;
          font-size: 30px;
          position: absolute;
        }
        #time strong{
          font-size: 20px;
          display: block;
          padding: 10px 0px;

        }
        #time p{
          font-size: 10px
        }
        .danger{
            color: red;
        }
        .right{
          background-color: green;
          padding: 12px;
          width: 100%;
        }
        .wrong{
          background-color: red;
          width: 100%;
          font-size: 20px;
          padding: 12px;
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
        .top{
          display: block;
          margin: auto;
        }
        .questions{
          padding: 15px;
        }
        .questions h3{
          font-weight: initial;
        }
        .questions strong{
          font-size: 20px;
        }
        .block{
          pointer-events: none;
        }
        #result{
              width: 60%;
    margin: auto;
    text-align: center;
        }
        .wrong{
          margin: auto;
          padding: 10px;
          background-color: red;
          color: white;
        }
        .correct{
          margin: auto;
          padding: 10px;
          background-color: green;
          color: white;
        }
        #skipped li{
          width: 100px;
    text-align: center;
    background-color: white;
        }
        #skipped{
           display: -webkit-inline-box;
        }


    </style>
    <script type="text/javascript">
        $(document).ready(function(){

            var start_time ='';             
             var data = "data="+'<?php echo $pre ;?>';
            console.log(data);
    	      $.ajax({
                url: "process.php", 
                type: 'POST',
                 data:data,
                 dataType:'json',
                success: function(result){
                    if(result=='done'){
                      window.location.assign("done.php");                      
                    }
                  //  result = JSON.parse(result);
                    console.log(result);
                    //var length = Object.keys(result).length;
                    var list='';
                         $(".questions h3").html(result.mess2);
                         $(".questions h2").html(parseInt(result.points)+1);
                         $(".questions p").html(result.text_case);

                        start_time =result.time;
                        var current = "<?php echo date("H:i:s") ?>";
                        console.log(current);
                        var differnce = (current.substr(0,2)-start_time.substr(0,2))*3600+(current.substr(3,2)-start_time.substr(3,2))*60+(current.substr(6,2)-start_time.substr(6,2));
                      differnce=parseInt(differnce);
                                            console.log(differnce);

                      console.log(differnce+1);

                        var sub_hours = Math.floor(differnce / 3600);
                        var sub_minutes =Math.floor((differnce-sub_hours*3600)/60);
                        var sub_seconds =differnce-sub_hours*3600-sub_minutes*60;
                        var hour = 3;
                        var min = 45;
                        var sec=00;
                        var total_hour=(hour*3600+min*60+sec)-differnce;
                        if(total_hour<0)
                        {
                          window.location.href="logout.php";

                        }

                      hour = 0;
                      min =2;
                       sec =0;

                        var interval = setInterval(function() {

                            if (sec===0){
                              if(min===0)
                                {
                                  min=60;
                                  hour--;
                                }
                                min --;
                                sec =60;

                            } 
                                sec --;

                                if((hour==0)&&(min==0)&&(sec==0))
                                {
                                  window.location.href='logout.php'

                                }
                                $('.sec').text(sec);
                                $('.min').text(min);
                                $('.hour').text(hour);
                            if(min===1){$('#time span').toggleClass("danger");}
                        }, 1000);
                        
                      }
            });
        });
         
        function run(){
            var data=$('#raw').val();
            $('#runn').addClass('block');
              data=encodeURIComponent(data);
          var datastring  ="datastring="+ data+"&num="+'<?php echo $pre; ?>';
          $.ajax({
                url: "bin/befunge.php", 
                type: 'POST',
                data:datastring,
                timeout:3000,
                error: function(jqXHR, textStatus, errorThrown) {
                if(textStatus==="timeout") {
                       $('#result').html('<p class="wrong">Time Limit Exceeded</p>');
                      $('#runn').removeClass('block');
                 } 
                 
                     else{
                       $('#result').html('<p class="wrong">Wrong Answer</p>'); 
                      $('#runn').removeClass('block');                        
}

                },

                success: function(result){
                    console.log(result);
                    if(result=='not'){
                       $('#result').html('<p class="wrong">Your code does not pass all the test cases</p>');
                      $('#runn').removeClass('block');
                    }
                    else if(result=='yes'){
                       $('#result').html('<p class="correct">Success</p>'); 
                      window.location.assign("que.php");
                       }
                     else{

                       $('#result').html('<p class="wrong">Wrong Answer</p>'); 
                        }

                  }
           });
        }
        
        function next(){
          var retVal = confirm("Do you want to Skip This Ques.?");
          if('<?php echo $pre; ?>'){
             retVal=false;
          }
               if( retVal == true ){
                  $.ajax({
                        url: "next.php", 
                        type: 'POST',
                        success: function(result){
                            console.log(result);
                            if(result){
                              window.location.assign("que.php");
                            }
                            else{
                            }
                          }
                   });
               }
               else{
                              window.location.assign("que.php");
               }
        }
        
    </script>
</head>
<body>
    <header>
        <div class="container">
            <h1>CHAOS 17</h1>
            <a href="leader_board.php">Leader Board</a>
        </div>
    </header>
    <main>
        <div class="top">
          <div id="time">
            <strong>Time left</strong>
            <span class="hour"></span>:<span class="min"></span><span>:</span><span class="sec"></span>
            <p>Hour &nbsp;&nbsp; Minutes &nbsp;&nbsp; Seconds</p>
          </div>
          <a id="logout" href="logout.php">LOG OUT</a>
        </div>
        <div class="container questions">
     <a style="top: -50px;width: 100px;background-color: blue;color: white;padding: 11px;text-align: center;border-radius: 4px;" target="_blank" href="documentation.html">Documentation</a>
    <marquee style="color:red">Please logout and login again for one time</marquee>
            <h2 style="visibility: hidden;"></h2>
            <h3>Question.:</h3>
            <strong>Test Case:</strong>
            <p></p>
        </div>

        <div id="compiler">
          <br>
          <textarea value="@" placeholder="write your code here...................." id="raw" rows="25" cols="80"></textarea>

          <p id="buttons" style="position: relative;">
            <input id="runn" type="button" value="Submit" onclick="run();" />
            <input id="runn1" type="button" value="Next" onclick="next();" />
         </p>
          <span style="display: flex;position: relative;top: 60px;" class="result"></span>
          <pre style="visibility: hidden;" id="output"></pre>
        </div>
        <div id="result">
          <p ></p>
        </div>
        <ul id="skipped">
            <span>Skipped Questions:</span>
            <?php
               if($skip[0]){
                  echo'<li><a href="que.php?num='.$skip[0].'">Ques.'.$skip[0].'</a></li>'; 
               }
               if($skip[1]){                
                  echo'<li><a href="que.php?num='.$skip[1].'">Ques.'.$skip[1].'</a></li>'; 
               }
             ?>
       </ul>
    </main>
</body>
<script type="text/javascript">

</script>
</html>

<!-- 

var current = new Date();
       var ch = current.getHours();
       var cm = current.getMinutes();
       var cs =current.getSeconds();
    var interval = setInterval(function() {
       var today =new Date();
       var h = today.getHours();
       var m = today.getMinutes();
       var s =today.getSeconds();
       $('.hour').text();
       $('.min').text();
       $('.sec').text();
       console.log(h+":"+m+":"+s);
    }, 1000); -->
