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
    

      

    $a = oci_parse($conn, "select zi, startora, endora, instructori.nume,  instructori.prenume, durata || ' minute', activitati.nume  from orar join activitati on orar.id_activitate = activitati.id join instructori on orar.id_instructor = instructori.id order by zi");
   
    oci_execute($a);
    
    print '<table border="1">';
    while ($row = oci_fetch_array($a, OCI_RETURN_NULLS+OCI_ASSOC)) {
        print '<tr>';
            foreach ($row as $item) {
                print '<td>'.($item !== null ? htmlentities($item, ENT_QUOTES) : '&nbsp').'</td>';
            }
        print '</tr>';
    }
    print '</table>';
    oci_close($conn);
}

?>

</body>

</html>