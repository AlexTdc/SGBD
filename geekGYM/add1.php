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

$email = $_GET['email'];
$nume = $_GET['firstname'];
$prenume = $_GET['lastname'];
$h = $_GET['inaltime'];
$greu = $_GET['greutate'];
$exp = $_GET['exp'];
$sex = $_GET['gender'];
$pref = $_GET['pref'];
$data = $_GET['data'];

if($sex == 'femeie'){
    $sex = 0;
}else{
    $sex = 1;
}

if($exp == 'Untrained'){
    $exp = 1;
}else if($exp == 'Novice'){
    $exp = 2;
}else if($exp == 'Intermediate'){
    $exp = 3;
}else if($exp == 'Advanced'){
    $exp = 4;
}else if($exp == 'Elite'){
    $exp = 5;
}
if($pref == 'Tot'){
    $pref = 0;
}else if($pref == 'Upper'){
    $pref = 1;
}else if($pref == 'Core'){
    $pref = 2;
}else{
    $pref = 3;
}

$id = 1000000000;



if(!$conn){
    echo 'connection error';
}else{
    
    if(1==1){

        // $k = oci_parse($conn, "delete from onerpm where id_client = 2000000");
        // oci_execute($k);
    
        
        // $k = oci_parse($conn, "delete from clienti where id = 2000000");
        // oci_execute($k);

        $k = oci_parse($conn, "BEGIN select max(id) into :p1 from clienti; end;");
        oci_bind_by_name($k, ':p1', $id);
        oci_execute($k);
        
        $id = $id + 1;
        $_SESSION["id"] = $id;

        oci_free_statement($k);

        $s = oci_parse( $conn, "insert into clienti(id, nume, prenume, data_nastere, inaltime, greutate, experienta, sex, prefer, email) values ('$id', '$nume', '$prenume', DATE '$data', '$h',  '$greu', '$exp', '$sex', '$pref', '$email')" );
        
        oci_execute($s);
        oci_free_statement($s);
    }else if(1==0){

        for ($x = 1; $x <= 13; $x++){
            $ex = $exer[$x-1];
            $a = oci_parse($conn, "insert into onerpm(id_exercitiu, id_client, rpm) values ('$x', '$id', '$ex')" ); 
            oci_execute($a);
        
        }
        oci_free_statement($a);
    }

    // // $i = oci_parse($conn, 'insert into oneRPM(id_exercitiu, id_client, rm) values (1,2, 100)');
    // // oci_execute($i);
    // // oci_bind_by_name($s, ':p1', 2000000);
   
    // // oci_bind_by_name($s, ':p2', $nume);
    // // oci_bind_by_name($s, ':p1', $prenume);
    // // oci_bind_by_name($s, ':p1', $h);
    // // oci_bind_by_name($s, ':p1', $greu);
    // // oci_bind_by_name($s, ':p1', $exp);
    // // oci_bind_by_name($s, ':p1', $sex);
    // // oci_bind_by_name($s, ':p1', $pref);

   
    // oci_execute($a);
    
    // // print '<table border="1">';
    // // while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) {
    // // print '<tr>';
    // // foreach ($row as $item) {
    // //     print '<td>'.($item !== null ? htmlentities($item, ENT_QUOTES) : '&nbsp').'</td>';
    // // }
    // // print '</tr>';
    // // }
    // // print '</table>';


}


oci_close($conn);
?>
<div class="msg">
<?php
echo 'inregistrare completa! redirectionare pagina principala...';
?>
</div>

</body>
<script>
    function donothing(){
        window.location.replace("main.php");
    }
    setTimeout(donothing,3000); // run donothing after 0.5 seconds
    
    

</script>

<style>
    body{
        position: relative;
    }
    .msg{
        position: absolute;
        top:200px;
        left: 30%;
       padding: 20px;
       border: solid 0.2px black;

        font-size:20px;

    }
    </style>

</html>