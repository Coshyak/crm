<?php
include("config.php");
//Variablen deklarieren und mit leeren Werten initalisieren
$bdatum = "";
$bdatumError = "";
$fdatum = "";
$fdatumError = "";
$beschreibung = "";
$beschreibungError = "";
$wichtigkeit = "";
$wichtigkeitError = "";
$status = "";
$statusError = "";
$auftraggeber = "";
$auftraggeberError = "";
$ansprechpartner = "";
$ansprechpartnerError = "";
$mitarbeiter = "";
$mitarbeiterError = "";
$referenz = "";
$referenzError = "";

//Diese IF Abfrage weil ich sonst Fehler bekommen, da beim ersten Aufruf noch kein post geschehen ist
if($_SERVER["REQUEST_METHOD"] == "POST") {
    //beschreibung
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
    //wichtigkeit
    //Priorität
    if($_POST["wichtigkeit"] == "wichtig") {
        $wichtigkeit = "wichtig";
    }
    else if($_POST["wichtigkeit"] == "mittel") {
        $wichtigkeit = "mittel";
    }
    else if($_POST["wichtigkeit"] == "gering") {
        $wichtigkeit = "gering";
    }
    else {
        $wichtigkeitError = "Bitte geben Sie eine gültige Priorität ein";
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
    //Auftraggeber
    if (empty(trim($_POST["auftraggeber"]))) {
        $auftraggeberError = "Bitte geben Sie einen Auftraggeber ein";
    }
    // SQL select für den Nachnamen des Auftraggebers
    $sqlselect = "SELECT nachname FROM account WHERE nachname = '$auftraggeberEingabe'";
    // schaut wie viele Spalten es hat
    $result = mysqli_query($connection, $sqlSelect);
    //schaut ob es jetzt eine oder mehr eintragungen für den Nachnamen in Accounts gibt
    if(mysqli_num_rows($result) >= 1){
        $auftraggeber = $auftraggeberEingabe;
    }
    else {
        $auftraggeberError = "Bitte geben Sie einen eingetragenen Auftraggeber ein";
    }
    //Ansprechpartner
    if (empty(trim($_POST["ansprechpartner"]))) {
        $ansprechpartnerError = "Bitte geben Sie einen Ansprechpartner ein";
    }
    // SQL select für den Nachnamen des Ansprechpartners
    $sqlselect2 = "SELECT nachname FROM ansprechpartner WHERE nachname = '$ansprechpartnerEingabe'";
    // schaut wie viele Spalten es hat
    $result2 = mysqli_query($connection, $sqlSelect2);
    //schaut ob es jetzt eine oder mehr eintragungen für den Nachnamen in Ansprechpartner gibt
    if(mysqli_num_rows($result2) >= 1){
        $ansprechpartner = $ansprechpartnerEingabe;
    }
    else {
        $ansprechpartnerError = "Bitte geben Sie einen vorhandenen Ansprechpartner ein";
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
    //Vordem Insert überprüfen ob Fehler vorhanden sind
    if(empty($beschreibungError) && empty($wichtigkeitError) && empty($statusError) && empty($auftraggeberError) && empty($ansprechpartnerError) && empty($mitarbeiterError)) {
        //SQL Statement Variable übergeben
        $sqlStatement = "INSERT INTO aktivitat (Beschreibung, Wichtigkeit, Status, Auftraggeber, Ansprechpartner, Mitarbeiter) 
                     VALUES ($beschreibung', '$wichtigkeit', '$status', '$auftraggeber', '$ansprechpartner', '$mitarbeiter')";
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
    <title>Aktivität anlegen</title>
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
                <form action="aktivitat.php" method="post">
                    <h1>Aktivität anlegen</h1>
                    <div class="one"><h4>Allgemeine Daten</h4></div>
                    <div class="one-container">
                        <div>
                            <label style="width:109.6px;">Beginndatum</label>
                            <input type="date" name="bdatum" value="<?php echo $bdatum; ?>" class="ml-2" style="background-color:#ffffff;">
                            <span class="help-block"><?php echo $bdatumError; ?></span>
                        </div>
                        <div>
                            <label style="width:109.6px;">Fälligkeitsdatum</label>
                            <input type="date" name="fdatum" value="<?php echo $fdatum; ?>" class="ml-2">
                            <span class="help-block"><?php echo $fdatumError; ?></span>
                        </div>
                        <div>
                            <label style="width:109.6px;">Beschreibung</label>
                            <input type="text" name="beschreibung" value="<?php echo $beschreibung; ?>" class="ml-2">
                            <span class="help-block"><?php echo $beschreibungError; ?></span>
                        </div>
                        <div>
                            <label style="width:109.6px;">Wichtigkeit</label>
                            <input type="text" name="wichtigkeit" value="<?php echo $wichtigkeit; ?>" class="ml-2">
                            <span class="help-block"><?php echo $wichtigkeitError; ?></span>
                        </div>
                        <div>
                            <label style="width:109.6px;">Status</label>
                            <input type="text" name="status" value="<?php echo $status; ?>" class="ml-2">
                        <span class="help-block"><?php echo $statusError; ?></span>
                        </div>
                    </div>
            </div>
            <div class="col">
                <h1>&nbsp;</h1>
                <div class="one"><h4>Referenzen</h4></div>
                <div class="one-container">
                    <div>
                        <label style="width:109.6px;">Auftraggeber</label>
                        <input type="text" name="auftraggeber" value="<?php echo $auftraggeber; ?>" class="ml-2">
                        <span class="help-block"><?php echo $auftraggeberError; ?></span>
                    </div>
                    <div>
                        <label style="width:109.6px;">Ansprechpartner</label>
                        <input type="text" name="ansprechpartner" value="<?php echo $ansprechpartner; ?>" class="ml-2">
                        <span class="help-block"><?php echo $ansprechpartnerError; ?></span>
                    </div>
                    <div>
                        <label style="width:109.6px;">Zuständiger Mitarbeiter</label>
                        <input type="text" name="mitarbeiter" value="<?php echo $mitarbeiter;?>" class="ml-2">
                        <span class="help-block"><?php echo $mitarbeiterError; ?></span>
                    </div>
                    <div>
                        <label style="width:109.6px;">Referenz</label>
                        <input type="text" name="referenz" value="<?php echo $referenz; ?>" class="ml-2">
                        <span class="help-block"><?php echo $referenzError; ?></span>
                        <button class="btn btn-primary such-button" type="submit">Aktivität anlegen</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>