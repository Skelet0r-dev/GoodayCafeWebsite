<?php 
$serverName = "ANGELO\\SQLEXPRESS";

$connectionOptions = [
    "Database" => "Good_Day_Cafe",
    "TrustServerCertificate" => true
];

$conn =sqlsrv_connect($serverName, $connectionOptions); 
if($conn==false) 
die(print_r(sqlsrv_errors(),true)); 
else echo 'Connection Success'; 

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$bday = $_POST['bday'];
$emailReg = $_POST['emailReg'];
$status =  $_POST['statusReg'];
$passReg = $_POST['passReg'];

$checksql = "SELECT EMAIL FROM USERS WHERE EMAIL = '$emailReg'";
$checksqlResult = sqlsrv_query($conn, $checksql);
$emailcheck = sqlsrv_fetch_array($checksqlResult);

if ($emailcheck==true){
     echo "<script>
                alert('Email Already Taken');
                window.location.href='loginandregis.html';
              </script>";
        exit;
}else{
$sqlinsert = "INSERT INTO USERS ([FIRSTNAME], [LASTNAME], [DATEOFBIRTH], [EMAIL], [PASS], [STATUS])
      VALUES ('$fname', '$lname','$bday', '$emailReg','$passReg', '$status')";

$sqlresult = sqlsrv_query($conn,$sqlinsert);

if($sqlresult==true){
    echo "<script>
                alert('Registration Successful');
                window.location.href='loginandregis.html';
              </script>";
} else{
    die(print_r(sqlsrv_errors(),true)); 
} 
}
?>
