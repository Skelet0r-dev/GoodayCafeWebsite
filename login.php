<?php

$serverName = "ANGELO\\SQLEXPRESS";
$connectionOptions = [
    "Database" => "Good_Day_Cafe",
    "Uid" => "", 
    "PWD" => "",
];

$conn = sqlsrv_connect($serverName, $connectionOptions);
$email = $_POST['emailInput'];
$password = $_POST['passwordInput'];


$sql = "SELECT *
        FROM dbo.[USERS] 
        WHERE EMAIL = '$email'";

$result = sqlsrv_query($conn, $sql);
$rowname = sqlsrv_fetch_array($result);


if ($rowname == null) {
    die("<script>
                alert('Email Not Found');
                window.location.href='loginandregis.html';
              </script>");
}


$sqlpassword = "SELECT *
                FROM dbo.[USERS] 
                WHERE EMAIL = '$email' AND PASS = '$password'";


$resultpass = sqlsrv_query($conn, $sqlpassword);
$rowpass = sqlsrv_fetch_array($resultpass);


if ($rowpass == null) {
    die("<script>
                alert('Wrong Password');
                window.location.href='loginandregis.html';
              </script>");

}else if ($rowpass['STATUS'] == "STAFF"){
    session_start();
    $_SESSION['fname'] = $rowpass['FIRSTNAME'];
    $_SESSION['lname'] = $rowpass['LASTNAME'];
    header("Location: admin\adminpage.php");
    exit;
}else{
    session_start();
    $_SESSION['user_id'] = $rowpass['USER_ID'];
    $_SESSION['fname'] = $rowpass['FIRSTNAME'];
    $_SESSION['lname'] = $rowpass['LASTNAME'];
    $_SESSION['email'] = $rowpass['EMAIL'];
    $_SESSION['status'] = $rowpass['STATUS'];
    header("Location: menupage.php");
    exit;
}

?>
