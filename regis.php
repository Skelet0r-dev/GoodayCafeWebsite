<?php 
$serverName="ANGELO\SQLEXPRESS"; 
$connectionOptions=[ 
"Database"=>"WEBAPP", 
"Uid"=>"", 
"PWD"=>"" 
]; 
$conn =sqlsrv_connect($serverName, $connectionOptions); 
if($conn==false) 
die(print_r(sqlsrv_errors(),true)); 
else echo 'Connection Success'; 

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$bday = $_POST['bday'];
$emailReg = $_POST['emailReg'];
$passReg = $_POST['passReg'];

$checksql = "SELECT EMAIL FROM USER_FORM WHERE EMAIL = '$emailReg'";
$checksqlResult = sqlsrv_query($conn, $checksql);
$emailcheck = sqlsrv_fetch_array($checksqlResult);

if ($emailcheck==true){
    header('Location: emailtaken.html');
}else{
$sqlinsert = "INSERT INTO USER_FORM ([FIRST_NAME], [LAST_NAME], [BIRTHDAY], [EMAIL], [PASSWORD])
      VALUES ('$fname', '$lname','$bday', '$emailReg','$passReg')";

$sqlresult = sqlsrv_query($conn,$sqlinsert);

if($sqlresult==true){
    
    echo "Successful Insertion";
} else{
    die(print_r(sqlsrv_errors(),true)); 
} 
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Good Day Cafe</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts (Playfair, Montserrat, Poppins) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

    <style>
        /* --- Hero & Video Styles --- */
        #hero {
            width: 100%;
            height: 100vh; 
            position: relative;
            overflow: hidden; 
            padding: 0;
            background-color: #000; /* Fallback color if video doesn't load */
        }

        #myVideo {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; 
            z-index: 0; 
        }
        
        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4); 
            z-index: 1; 
        }

        .container-content {
            position: relative;
            z-index: 2; 
            color: white;
            font-family: 'Montserrat', sans-serif;
        }
        
        .logo-img {
            max-width: 300px; 
            height: auto;
        }

        /* --- Dark Modal CSS (Added) --- */
        .modal-content-dark {
            background-color: #1f1f1f;
            border: 1px solid #333;
            color: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            font-family: 'Montserrat', sans-serif; /* Matches your site font */
        }

        .modal-header-dark {
            border-bottom: 1px solid #333;
        }

        .modal-footer-dark {
            border-top: 1px solid #333;
        }

        /* Custom Dark Inputs */
        .form-control-dark {
            background-color: #2b2b2b;
            border: 1px solid #444;
            color: #e0e0e0;
        }

        .form-control-date{
            background-color: #2b2b2b;
            border: 1px solid #444;
            color: #888;
        }
        

        .form-control-dark:focus {
            background-color: #333;
            border-color: #fff; 
            color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
        }

        .form-control-dark::placeholder {
            color: #888;
        }
        
        /* Custom Link Styling */
        .link-light-custom {
            color: #aaa;
            text-decoration: none;
            transition: color 0.2s;
        }
        .link-light-custom:hover {
            color: #fff;
            text-decoration: underline;
        }

        /* Helper for Playfair Font */
        .font-playfair {
            font-family: 'Playfair Display', serif;
        }

        /* Montserrat Font*/
        .font-montserrat{
            font-family: 'Montserrat', serif;
        }
    


    </style>
</head>

<body>
    <main>
        <section id="hero" class="d-flex align-items-center justify-content-center">
            
            <!-- Background Video -->
            <video autoplay muted loop id="myVideo">
                <source src="Cafe_Video_Generation_Request.mp4" type="video/mp4">
            </video>
            
            <div class="video-overlay"></div>

            <div class="container container-content text-center" data-aos="fade-up" data-aos-delay="500">
                <!-- Logo -->
                <img src="468427386_541638218699106_1919132418059209058_n-removebg-preview.png" class="img-fluid logo-img" alt="Cafe Logo">
                
                <!-- Spacing below logo -->
                <div class="my-5"></div>

                

                <!-- MODAL Buttons -->
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-dark btn-lg px-4 font-montserrat" data-bs-toggle="modal" data-bs-target="#regisModal">
                        Register
                    </button>        

                    <button type="button" class="btn btn-secondary btn-lg px-4 font-montserrat" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Log in
                    </button>
                </div>
            </div>
        </section>

    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 