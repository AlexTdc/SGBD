<?php 
// session_start();
$conn = oci_connect('STUDENT', 'STUDENT', 'localhost/xe');

if(!$conn){
    echo 'connection error';
}else{
    
    $id = $_SESSION["id"];

    $s = oci_parse($conn, "BEGIN :p2 := reduceri('$id' ); end;");

    oci_bind_by_name($s, ':p2', $p2, 3000);
   
    oci_execute($s);
    
  

    echo '<br>';
    if($p2 > 0){
        echo 'Felicitari, poti beneficia de o reducere de '. $p2 . ' de lei!';
    }else{
        echo 'Din pacate in acest moment nu poti beneficia de nici o reducere.';
    }
 
    
}
oci_free_statement($s);
oci_close($conn);
?>