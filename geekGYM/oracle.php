<?php 
// session_start();
$conn = oci_connect('STUDENT', 'STUDENT', 'localhost/xe');

if(!$conn){
    echo 'connection error';
}else{
    
    $id = $_SESSION["id"];

    $s = oci_parse($conn, "BEGIN show_statistic('$id', :p2); end;");

    // $i = oci_parse($conn, 'insert into oneRPM(id_exercitiu, id_client, rm) values (1,2, 100)');
    // oci_execute($i);
    oci_bind_by_name($s, ':p2', $p2, 3000);
   
    oci_execute($s);
    
    // print '<table border="1">';
    // while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) {
    // print '<tr>';
    // foreach ($row as $item) {
    //     print '<td>'.($item !== null ? htmlentities($item, ENT_QUOTES) : '&nbsp').'</td>';
    // }
    // print '</tr>';
    // }
    // print '</table>';

    echo '<br>';
    echo $p2;

}
oci_free_statement($s);
oci_close($conn);
?>