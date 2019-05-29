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

if(!$conn){
    echo 'connection error';
}else{
    
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

}



echo '<div class="container">';

if($p1 == 1){
    $k = oci_parse($conn, "BEGIN select count(*) into :p1 from oneRPM where id_client = :p2; end;");
   

    oci_bind_by_name($k, ':p1', $p1);
     oci_bind_by_name($k, ':p2', $id);
    oci_execute($k);

    if($p1 < 13){
        echo 'Se pare ca nu aveti toate datele introduse, pentru a obtine un antrenament personalizat completeaza mai jos!';
        echo '
            <form action="add2.php" method="get" name="personal">
                Care este greutatea ce mai mare cu care poti face o repetitie? <br>
                Squats:<br>
                <input type="number" name="squats"><br>
                Deadlift:<br>
                <input type="number" name="deadlift"><br>
                Bench-press<br>
                <input type="number" name="bench"><br>
                Pull ups<br>
                <input type="number" name="pull"><br>
                Over head press<br>
                <input type="number" name="ohp"><br>
                Bicep Curls<br>
                <input type="number" name="bicep"><br>
                Skull crushers<br>
                <input type="number" name="skull"><br>
                Leg extensions<br>
                <input type="number" name="leg"><br>
                Hamstring curls<br>
                <input type="number" name="hamstring"><br>
                Crunches<br>
                <input type="number" name="crunches"><br>
                Shoulder raises<br>
                <input type="number" name="shoulder"><br>
                Dumbell flies<br>
                <input type="number" name="flies"><br>
                Dumbell rows<br>
                <input type="number" name="rows"><br>
                
                <input type="submit" name="submit2" value="Afiseaza antrenamentul" />

            </form>
            <button onclick="stats()">Vezi numerele generale pentru alti clienti de nivelul tau pentru aceste exercitii</button><div id="stats"></div>
            <button onclick="red()">Vezi ce reduceri poti primi in functie de activitatea ta</button><div id="red"></div>
            <button onclick="prom()">Vezi la ce promotii te incadrezi</button><div id="prom"></div>
            ';
    }else{
        echo
        '<button onclick="myFunction()">Genereaza un antrenament</button><div id="rez"></div><button onclick="stats()">Vezi numerele generale pentru alti clienti de nivelul tau pentru aceste exercitii</button><div id="stats"></div>
        <button onclick="red()">Vezi ce reduceri poti primi in functie de activitatea ta</button><div id="red"></div>
        <button onclick="prom()">Vezi la ce promotii te incadrezi</button><div id="prom"></div>';
    }
    // echo '<form action="oracle.php"> <input type="submit" name="submit2" value="Afiseaza antrenamentul" />  </form>';
}

echo '</div>';
oci_close($conn);
?>

</body>
<script>
    function stats(){
        document.getElementById("stats").innerHTML = "<?php include 'oracle.php'; ?>";
    }

    function red(){
        document.getElementById("red").innerHTML = "<?php include 'reducere.php'; ?>";
    }

    function prom(){
        document.getElementById("prom").innerHTML = "<?php include 'promotie.php'; ?>";
    }

    function myFunction(){
        document.getElementById("rez").innerHTML = "<?php include 'antrenament.php'; ?>";
    }

</script>
</html>