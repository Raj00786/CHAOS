<?php
session_start();
      header('Location: ../logout.php');
$conn=mysqli_connect('localhost','root','sAhArAnTech1Kriti16','kios17');
if(mysqli_connect_errno()){
    echo "failed to connect";
}
else{
}


$code1 = rawurldecode($_POST['datastring']);

$code = file_get_contents('/srv/http/2017.techkriti.org/software/chaos/examples/hello.b98');
$name  = $_SESSION["name"];


require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../vendor/docopt/docopt/src/docopt.php';

use igorw\befunge;



if($_POST['num']){
	$num = $_POST['num'];
    
}
else{
	$que_query ="SELECT * FROM leader WHERE name='$name'";  
	$que_result = mysqli_query($conn,$que_query); 
	$que  = mysqli_fetch_assoc($que_result);
	$num = $que['points'];
	$num=$num+1;
}

$select_query ="SELECT * FROM leader WHERE name='$name'";  
$select_result = mysqli_query($conn,$select_query); 
$select  = mysqli_fetch_assoc($select_result);
$skip_1 = $select['skip'];
$points = $select['points'];
$skip = explode(",", $skip_1);
$skip_2=$skip_1;

$select_query ="SELECT * FROM questions WHERE id=$num";  
$select_result = mysqli_query($conn,$select_query); 
$select  = mysqli_fetch_assoc($select_result);
$que_marks = $select['marks'];
$input = $select['input'];
$output = $select['output'];

$input=explode(',',$input);
$output=explode(',',$output);
$counter=0;
for($i=0;$i<sizeof($input);$i++)
{
	$inp=$input[$i];
	$out=$output[$i];
	$handle = fopen($inp,'r');
$logger= null;
$return = befunge\execute($code1, $logger,$handle);
if(trim($return)!=$out){
$counter=1;
break;

}
}

//$handle = fopen($input,'r');
//$logger= null;


if($counter==0){
	if($_POST['num']){
	  if($num==$skip[0]){
        $skip_2=$skip[1];
	   }
		if($num==$skip[1]){
	        $skip_2=$skip[0];
		}

		$points_query ="UPDATE leader SET skip = '$skip_2' WHERE name ='$name'";
	    mysqli_query($conn,$points_query);    

		$points_query ="UPDATE leader SET score = score+$que_marks WHERE name ='$name'";
	    mysqli_query($conn,$points_query); 
	    echo "yes";
	    die();	
	}
	else{
      $points=$points+1;

		$points_query ="UPDATE leader SET score = score+$que_marks WHERE name ='$name'";
	    mysqli_query($conn,$points_query); 

      $ques_query ="UPDATE leader SET points = '$points' WHERE name ='$name'";
      mysqli_query($conn,$ques_query);
	    echo "yes";

	}

}
else{
   echo "not";
}


// echo "\n";
// exit($return);
