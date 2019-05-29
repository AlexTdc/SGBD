
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



$conn = oci_connect('STUDENT', 'STUDENT', 'localhost/xe');


$squats = $_GET['squats']; $bicep = $_GET['bicep']; $skull = $_GET['skull']; $leg = $_GET['leg']; $hamstring = $_GET['hamstring']; $crunches = $_GET['crunches'];
$deadlift = $_GET['deadlift']; $shoulder = $_GET['shoulder']; $flies = $_GET['flies']; $rows = $_GET['rows'];
$pull  = $_GET['pull'];
$bench = $_GET['bench'];
$ohp = $_GET['ohp'];

$exer = array($squats, $deadlift, $bench, $pull, $ohp, $bicep, $skull, $leg, $hamstring, $crunches, $shoulder, $flies , $rows);

$id = $_SESSION["id"];

if(!$conn){
    echo 'connection error';
}else{
    
   

        for ($x = 1; $x <= 13; $x++){
            $ex = $exer[$x-1];
            $a = oci_parse($conn, "insert into onerpm(id_exercitiu, id_client, rpm) values ('$x', '$id', '$ex')" ); 
            oci_execute($a);
        
        }
        oci_free_statement($a);
    


}


 $id = $_SESSION['id'];
 
 $k = oci_parse($conn, "BEGIN select client_top('$id') into :p1 from dual;  end;");
 oci_bind_by_name($k, ':p1', $p1);
 oci_execute($k);
 
if($p1 == 1){
    echo '<p class="top"> Felicitari esti client de top si poti beneficia de functionalitatile noastre speciale! </p>';
}else{
    echo '<p class="not_top"> din pacate nu te incadrezi la statutul de client de top si nu poti beneficia de functionalitatile noastre! </p>';
}

 oci_free_statement($k);


if($p1 == 1){
 $k = oci_parse($conn, "BEGIN select count(*) into :p1 from oneRPM where id_client = :p2; end;");


 oci_bind_by_name($k, ':p1', $p1);
  oci_bind_by_name($k, ':p2', $id);
 oci_execute($k);

 
 
 // echo '<form action="oracle.php"> <input type="submit" name="submit2" value="Afiseaza antrenamentul" />  </form>';
}

oci_close($conn);
?>

<?php include 'antrenament.php'; ?>

</body>

</html>