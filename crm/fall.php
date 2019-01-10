<?php

include("config.php");
//Variablen deklarieren und mit leeren Werten initalisieren
$mitarbeiterEingabe = $_POST["mitarbeiter"];
$beschreibung = "";
$beschreibungError = "";
$art = "";
$artError = "";
$mitarbeiter = "";
$mitarbeiterError = "";
$status = "";
$statusError = "";
$prioritat = "";
$prioritatError = "";
$grund = "";
$grundError = "";

//Diese IF Abfrage weil ich sonst Fehler bekommen, da beim ersten Aufruf noch kein post geschehen ist
if($_SERVER["REQUEST_METHOD"] == "POST") {
    //Beschreibung
    if (empty(trim($_POST["beschreibung"]))) {
        $beschreibungError = "Bitte eine Beschreibung angeben";
    }
    elseif (strlen(trim($_POST["beschreibung"])) < 2) {
        $beschreibungError = "Die Beschreibung muss 2 Buchstaben oder mehr enthalten";
    } elseif (strlen(trim($_POST["beschreibung"])) > 40) {
        $beschreibungError = "Die Beschreibung muss 40 Buchstaben oder weniger enthalten";
    } else {
        $beschreibung = trim($_POST["beschreibung"]);
    }
    //Art
    if (empty(trim($_POST["art"]))) {
        $artError = "Bitte eine Art angeben";
    }
    elseif (strlen(trim($_POST["art"])) < 2) {
        $artError = "Die Art muss 2 Buchstaben oder mehr enthalten";
    } elseif (strlen(trim($_POST["art"])) > 40) {
        $artError = "Die Art muss 40 Buchstaben oder weniger enthalten";
    } else {
        $art = trim($_POST["art"]);
    }
    //Zuständiger Mitarbeiter
    if (empty(trim($_POST["mitarbeiter"]))) {
        $mitarbeiterError = "Bitte geben Sie einen Mitarbeiter ein";
    }
    // SQL select für den Nachnamen des Mitarbeiter
    $sqlselect = "SELECT nachname FROM mitarbeiter WHERE nachname = '$mitarbeiterEingabe'";
    // schaut wie viele Spalten es hat
    $result = mysqli_query($connection, $sqlSelect);
    //schaut ob es jetzt eine oder mehr eintragungen für den Nachnamen in Mitarbeiter gibt
    if(mysqli_num_rows($result) >= 1){
        $mitarbeiter = $mitarbeiterEingabe;
    }
    else {
        $mitarbeiterError = "Bitte geben Sie einen vorhandenen Mitarbeiter ein";
    }
    //Status
    if($_POST["status"] == "offen") {
        $status = "offen";
    }
    else if($_POST["status"] == "geschlossen") {
        $status = "geschlossen";
    }
    else if($_POST["status"] == "in Bearbeitung") {
        $status = "in Bearbeitung";
    }
    else {
        $statusError = "Bitte geben Sie einen gültigen Status ein";
    }
    //Priorität
    if($_POST["priorität"] == "wichtig") {
        $prioritat = "wichtig";
    }
    else if($_POST["priorität"] == "mittel") {
        $prioritat = "mittel";
    }
    else if($_POST["priorität"] == "gering") {
        $prioritat = "gering";
    }
    else {
        $prioritatError = "Bitte geben Sie eine gültige Priorität ein";
    }
    //Grund
    if (empty(trim($_POST["grund"]))) {
        $grundError = "Bitte einen Grund angeben";
    }
    elseif (strlen(trim($_POST["grund"])) < 2) {
        $grundError = "Der Grund muss 2 Buchstaben oder mehr enthalten";
    } elseif (strlen(trim($_POST["grund"])) > 40) {
        $grundError = "Der Grund muss 40 Buchstaben oder weniger enthalten";
    } else {
        $grund = trim($_POST["grund"]);
    }
    //Vordem Insert überprüfen ob Fehler vorhanden sind
    if(empty($beschreibungError) && empty($artError) && empty($mitarbeiterError) && empty($statusError) && empty($prioritatError) && empty($grundError)) {
        //SQL Statement Variable übergeben
        $sqlStatement = "INSERT INTO fall (Beschreibung, Art, Mitarbeiter, Status, Priorität, Grund) 
                     VALUES ('$beschreibung','$art','$mitarbeiter', '$status', '$prioritat', '$grund')";
        //SQL Insert durchführen mit mysqli query
        if(mysqli_query($connection, $sqlStatement)) {
            echo "Account erfolgreich angelegt";
        } else {
            echo "Error:" .$sqlStatement . "<br>" . mysqli_error($connection);
        }
    }



}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fall anlegen</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="assets/css/Sidebar-Menu.css">
    <link rel="stylesheet" href="assets/css/Sidebar-Menu.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
<div id="wrapper">
    <?php
    include 'navigation.php';
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col text-right" style="background-color:#37434d;"><input type="search" placeholder="Suchbegriff eingeben" id="grossesFeld"><button class="btn btn-primary ml-2 mt-1 mb-1" type="Suche">Suche</button><a class="btn  btn-primary ml-2 mt-1 mb-1" type="Suche" href="logout.php">Logout</a></div>
        </div>
        <div class="row">
            <div class="col">
                <form action="fall.php" method="post">
                    <h1>Fall anlegen</h1>
                    <div class="one"><h4>Allgemeine Daten</h4></div>
                    <div class="one-container">
                        <div>
                            <label style="width:109.6px;">Beschreibung</label>
                            <input type="text" name="beschreibung" value="<?php echo $beschreibung; ?>" class="ml-2" style="background-color:#ffffff;">
                            <span class="help-block"><?php echo $beschreibungError; ?></span>
                        </div>
                        <div>
                            <label style="width:109.6px;">Art</label>
                            <input type="text" name="art" value="<?php echo $art; ?>" class="ml-2">
                            <span class="help-block"><?php echo $artError; ?></span>
                        </div>
                        <div>
                            <label style="width:109.6px;">Zuständiger Mitarbeiter</label>
                            <input type="text" name="mitarbeiter" value="<?php echo $mitarbeiter; ?>" class="ml-2">
                        <span class="help-block"><?php echo $mitarbeiterError; ?></span>
                        </div>
                    </div>
            </div>
            <div class="col">
                <h1>&nbsp;</h1>
                <div class="one"><h4>Zusatzinformationen</h4></div>
                <div class="one-container">
                    <div>
                        <label style="width:109.6px;">Status</label>
                        <input type="text" name="status" value="<?php echo $status; ?>" class="ml-2">
                        <span class="help-block"><?php echo $statusError; ?></span>
                    </div>
                    <div>
                        <label style="width:109.6px;">Prioriät</label>
                        <input type="text" name="priorität" value="<?php echo $prioritat; ?>" class="ml-2">
                        <span class="help-block"><?php echo $prioritatError; ?></span>
                    </div>
                    <div>
                        <label style="width:109.6px;">Grund</label>
                        <input type="text" name="grund" value="<?php echo $grund;?>" class="ml-2">
                        <span class="help-block"><?php echo $grundError; ?></span>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>