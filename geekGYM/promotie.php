<?php 
// session_start();
$conn = oci_connect('STUDENT', 'STUDENT', 'localhost/xe');

if(!$conn){
    echo 'connection error';
}else{
    
    $id = $_SESSION["id"];

    $s = oci_parse($conn, "BEGIN :p2 := promotii('$id'); end;");

    // $i = oci_parse($conn, 'insert into oneRPM(id_exercitiu, id_client, rm) values (1,2, 100)');
    // oci_execute($i);
    oci_bind_by_name($s, ':p2', $p2, 3000);
   
    oci_execute($s);
    
    echo '<br>';
    if($p2 == 1){
        echo 'Felicitari, nivelul tau de experienta impreuna cu bmi-ul tau te fac eligibil pentru promotia noastra! Ai 1 abonament full-inclusive gratuit!';
    }else{
        echo 'Din pacate in acest moment nu esti eligibil pentru aceasta promotie.';
    }


}
oci_free_statement($s);
oci_close($conn);
?>