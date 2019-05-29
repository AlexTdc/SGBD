<?php
// Start the session
session_start();

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="main-style.css">
</head>
<body>

<?php 
if(isset($_SESSION['logged'])){
include 'header2.php';
}else{
    include 'header1.php';
}
?>


    <div class ="container">
        <div class="flex">
        <div class="w3-container">
     
            <div class="w3-card-4" >
                <img src="p1.jpg" alt="Alps" >
                <div class="w3-container w3-center">
                <p>Inregistreaza-te pe site-ul nostru!</p>
                </div>
            </div>
        </div>

           <div class="w3-container">
        
            <div class="w3-card-4" >
                <img src="p2.jpg" alt="Alps" >
                <div class="w3-container w3-center">
                <p>Obine propriul tau antrenament personalizat!</p>
                </div>
            </div>
        </div>
        <div class="w3-container">
            
            <div class="w3-card-4" >
                <img src="p3.jpg" alt="Alps" >
                <div class="w3-container w3-center">
                <p>Vezi ce oferte poti obtine!</p>
                </div>
            </div>
        </div>
    </div>

    </div>

</body>
</html>