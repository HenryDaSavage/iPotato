<?php
// Your code here!
$username = $_POST['username'];
$pass = $_POST['password'];
$gender = $_POST['gender'];
$email = $_POST['email'];

if (!empty($username) ||!empty($pass) ||!empty($email)) {
    $host = "sql9.freesqldatabase.com";
    $dbUsername = "sql9354050";
    $dbPassword = "mlXVVZK56e";
    $dbname = "sql9354050";
    
    //Create connection
    $conn = new mysqli($host,$dbUsername, $dbPassword, $dbname);
    
    if (mysqli_connect_error()) {
        die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
    } else {

       $SELECT = "SELECT email From users Where cataphractes = ? Limit 1";
       $INSERT = "INSERT Into users (nomen, signum, cataphractes, sex) values(?,?,?,?,?)";
       
       //Prepare Statement
       $stmt = $conn->prepare($SELECT);
       $stmt->bind_param("s", $email);
       $stmt->execute();
       $stmt->bind_result($email);
       $stmt->store_result();
       $rnum = $stmt->num_rows;
       
       if ($rnum==0) {
           $stmt->close();
           
           $stmt = $conn->prepare($INSERT);
           $stmt->bind_param("ssss",$username, $pass, $gender, $email);
           $stmt->execute();
           echo "New record inserted sucessfully";
       } else {
           echo "Someone else already is using that email address";
       }
       $stmt->close();
       $conn->close();
    }
} else {
    echo "Please answer the required questions";
    die();
}
?>
