<?php 
// session_start();
$conn = oci_connect('STUDENT', 'STUDENT', 'localhost/xe');

if(!$conn){
    echo 'connection error';
}else{
    
    $id = $_SESSION["id"];

    $s = oci_parse($conn, "BEGIN get_training('$id', :p2); end;");

    oci_bind_by_name($s, ':p2', $p2, 32000);
   
    oci_execute($s);
    
  

    echo '<br>';
    echo $p2;

}
oci_free_statement($s);
oci_close($conn);
?>