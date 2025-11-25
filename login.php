<?php
$serverName = "ANGELO\\SQLEXPRESS";
$connectionOptions = [
    "Database" => "DLSU",
    "Uid" => "", 
    "PWD" => "",
];

$conn = sqlsrv_connect($serverName, $connectionOptions);
$email = $_POST['emailInput'];
$password = $_POST['passwordInput'];


$sql = "SELECT *
        FROM USER_FORM 
        WHERE USERNAME = '$email'";

$result = sqlsrv_query($conn, $sql);
$rowname = sqlsrv_fetch_array($result);


if ($rowname == null) {
    die("username not found");
}else{
    echo"account found \n";
}

$sqlpassword = "SELECT *
                FROM dbo.[USER] 
                WHERE USERNAME = '$username' AND PASSWORD = '$password'";

$resultpass = sqlsrv_query($conn, $sqlpassword);
$rowpass = sqlsrv_fetch_array($resultpass);


if ($rowpass == null) {
    die("Wrong Password");
}else{
    echo "Log in Success";
}
?>
