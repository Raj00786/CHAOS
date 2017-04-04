<?php
session_start(); 
$response="";
$flag =0;
  if (empty($_POST["username"])) {
    $response="false";
    $flag = 1;
  } 
  if (empty($_POST["pass"])&&($flag==0)) {
    $response= "false";
    $flag = 1;
  } 

  if ($flag!=1){
  

$servername = "localhost";
$username = "root";
$password = "sAhArAnTech1Kriti16";
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "USE events";
if ($conn->query($sql) === TRUE) {

} else {

}

$k=0;
$username= mysqli_real_escape_string($conn, $_POST["username"]);

$token = bin2hex(openssl_random_pseudo_bytes(16));
$pass = mysqli_real_escape_string($conn, $_POST["pass"]);
$pass=md5($pass);
$sql="SELECT * FROM `users17` WHERE username='$username'  AND password='$pass' AND confirm=1";
$result=$conn->query($sql);
  if (mysqli_num_rows($result) > 0)
   {


$k=1;
while ($row = mysqli_fetch_array($result)) {

 $access = $row["confirm_token"];
$id=$row["id"];
$name=$row["name"];
}

$sql="UPDATE `users17` SET confirm_token='$token' WHERE username='$username'  AND password='$pass'";
$result=$conn->query($sql);
$_SESSION["token"] = $token;
$_SESSION["id"]=$id;
$_SESSION["name"]=$name;

$sql = "USE `kios17`";
if ($conn->query($sql) === TRUE) {

} else {

}
$sql="UPDATE `leader` SET techid='$id' WHERE name='$name'";
$result=$conn->query($sql);

$response=$name;
    
 }


if($k==0)

{

$sql="SELECT * FROM `users17` WHERE email='$username'  AND password='$pass' AND confirm=1";
$result=$conn->query($sql);
  if (mysqli_num_rows($result) > 0)
   {


$k=1;
while ($row = mysqli_fetch_array($result)) {

 $access = $row["confirm_token"];
$id=$row["id"];
$name=$row["name"];
}

$sql="UPDATE `users17` SET confirm_token='$token' WHERE email='$username'  AND password='$pass'";
$result=$conn->query($sql);
$_SESSION["token"] = $token;
$_SESSION["id"]=$id;
$_SESSION["name"]=$name;
$sql = "USE `kios17`";
if ($conn->query($sql) === TRUE) {

} else {

}
$sql="UPDATE `leader` SET techid='$id' WHERE name='$name'";
$result=$conn->query($sql);


$response=$name;
    
 }














}



if($k==0)
 { $response="false";
 }
$conn->close();
}
 echo json_encode($response);






?>


