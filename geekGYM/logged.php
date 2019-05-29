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
 <?php
    $p1 = 1000000000;
    $email = $_POST["email"];
    $conn = oci_connect('STUDENT', 'STUDENT', 'localhost/xe');

    if(!$conn){
        echo 'connection error';
    }else{
        
    
        $s = oci_parse($conn, "BEGIN select id into :p1 from clienti where :p2 = email; EXCEPTION when no_data_found THEN :p1 := null; end; ");
    
       
        oci_bind_by_name($s, ':p1', $p1);
        oci_bind_by_name($s, ':p2', $email);
       
        oci_execute($s);
        

        if(isset($p1)){
            $_SESSION['logged'] = 1;
            echo '<h1>Logare cu succes! Redirectionare spre pagina principala..</h1>';
            $_SESSION['id'] = $p1;
        }else{
            $_SESSION['logged'] = 0;
            echo 'Logare esuata! Redirectionare spre pagina principala..';
        }
      
    
    }
    oci_free_statement($s);
    oci_close($conn);

 ?>
 <style>
h1{
    margin: auto;
    padding-top: 20px;
}
     </style>

     <script>
    function donothing(){
        window.location.replace("main.php");
    }
    setTimeout(donothing,3000); // run donothing after 3 seconds
    
</script>

</body>
</html>