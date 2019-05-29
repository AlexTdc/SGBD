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


<div class='container'>
    <form action='add1.php' method='get' name="personal">
        
        Email:<br>
        <input type="text" name="email"><br>
        First name:<br>
        <input type="text" name="firstname"><br>
        Last name:<br>
        <input type="text" name="lastname"><br>
        Inaltime:<br>
        <input type="number" name="inaltime"><br>
        Data-nastere:<br>
        <input type="date" name="data"><br>
        Greutate<br>
        <input type="number" name="greutate"><br>
        Experienta<br>
        <select name = 'exp'>
            <option value="Untrained">Untrained</option>
            <option value="Novice">Novice</option>
            <option value="Intermediate">Intermediate</option>
            <option value="Advanced">Advanced</option>
            <option value="Elite">Elite</option>
        </select> <br>
        Sex<br>
        <input type="radio" name="gender" value="barbat"> Barbat
        <input type="radio" name="gender" value="femeie"> Femeie<br>

        Ce vrei sa lucrezi? <br>
        <select name = 'pref'>
            <option value="Tot">Tot corpul</option>
            <option value="Upper">Upper body</option>
            <option value="Core">Core</option>
            <option value="Lower">Lower body</option>
            
        </select> <br>
        <input type="submit" name="submit1" value="Inregistreaza-te" />
        
    </form>

    <!-- <form action='add2.php' method='get' name='pref'>
       
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
        
        <input type="submit" name="submit2" value="Introdu date despre tine" />

    </form> -->
</div>


</body>
</html>