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

 <form action='logged.php' method='post' name='pref'>
       
       Introdu e-mailul<br>
       <input type="text" name="email"><br>
       <input type="submit" name="submit2" value="Login" />
      
   </form>

</body>
</html>