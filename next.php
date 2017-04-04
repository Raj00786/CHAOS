<?php include 'database.php';?>
<?php session_start(); ?>
<?php
  
  $name  =  $_SESSION['name'];
  $skip='';
  $select_query ="SELECT * FROM leader WHERE name='$name'";  
  $select_result = mysqli_query($conn,$select_query); 
  $select  = mysqli_fetch_assoc($select_result);
  $skip=$select['skip'];
  if($select['penalty']>1){
  	echo "no";
  }
  else{
	  $points_query ="UPDATE leader SET points = points+1 WHERE name ='$name'";
	  $points_result = mysqli_query($conn,$points_query); 
	  mysqli_fetch_assoc($points_result);

	  $user_query ="UPDATE leader SET penalty = penalty+1 WHERE name ='$name'";
	  $user_result = mysqli_query($conn,$user_query); 
	  mysqli_fetch_assoc($user_result);

      $points = $select['points']+1;
      $skip = $skip.$points.',';
      $skip_query ="UPDATE leader SET skip = '$skip' WHERE name ='$name'";
	  $skip_result = mysqli_query($conn,$skip_query); 
	  mysqli_fetch_assoc($skip_result);

      
	  echo $points;
  }

?>