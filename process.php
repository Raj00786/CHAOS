<?php include 'database.php';?>
<?php session_start(); ?>
<?php

  $points = 0;
  $time = "00:00:00";
mysqli_set_charset($conn, 'utf8');
  $name  =  $_SESSION['name'];
  $user_query ="SELECT * FROM leader WHERE name ='$name'";
  $user_result = mysqli_query($conn,$user_query); 
  $user= mysqli_fetch_assoc($user_result);
 
  if(!$user){
//    $date=date("H:i:s"); 
//     $time = $date;
      $insert_query = "INSERT INTO leader (name) VALUES ('$name')";;      
      mysqli_query($conn,$insert_query); 
      $ques_query ="SELECT * FROM questions WHERE id =1";
  }
  else{
      $select_query ="SELECT * FROM leader WHERE name='$name'";  
      $select_result = mysqli_query($conn,$select_query); 
      $select  = mysqli_fetch_assoc($select_result);
      $skip = $select['skip'];
      $points = $select['points'];
      $time = $select['start_time'];
      if($points==='9'){
        $end_time =date("H:i:s"); 
        $end_query = "UPDATE leader SET end_time='$end_time' WHERE name='$name'";    
        mysqli_query($conn,$end_query); 
        echo "done";
        die();
      }
      $points=$points+1;
      $ques_query ="SELECT * FROM questions WHERE id = '$points'";
  }
  
  if($_POST['data']!==''){
    $num = $_POST['data'];
     $pieces = explode(",", $skip);
     $skip1 = $pieces[0]; 
     $skip2 = $pieces[1]; 
     if($num==$skip1){
        $ques_query ="SELECT * FROM questions WHERE id = '$skip1'";
     }
     else if($num==$skip2){
        $ques_query ="SELECT * FROM questions WHERE id = '$skip2'";
     }
     else{
      $ques_query ="SELECT * FROM questions WHERE id = $points";
     }
  }

	$ques_result = mysqli_query($conn,$ques_query); 
	$question= mysqli_fetch_assoc($ques_result); 
  //print_r($question);
  $choices_list=array();
  $choices_list['time'] =  $time; 
  $choices_list['points'] =  $points; 
  $choices_list["mess2"] = $question['text'];
  $choices_list["text_case"] = $question['text_case']; 
  echo json_encode($choices_list);


    // print_r($list);
 ?>
