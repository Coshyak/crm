<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account & Produkte</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="../assets/css/Sidebar-Menu.css">
    <link rel="stylesheet" href="../assets/css/Sidebar-Menu.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
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
                <h1>Accounts & Produkte</h1>
                <div class="one"><h4>Suchen</h4></div>
                <div class="one-container">
                    <div><a href="accountsearch.php">Accounts</a></div>
                    <div><a href="mitsearch.php">Mitarbeiter</a></div>
                    <div><a href="ansprechsearch.php">Ansprechpartner</a></div>
                </div>
                <div class="col">
                    <h1>&nbsp;</h1>
                    <div class="one"><h4>Anlegen</h4></div>
                    <div class="one-container">
                        <div><a href="accounts.php">Account</a></div>
                        <div><a href="mitarbeiter.php">Mitarbeiter</a></div>
                        <div><a href="ansprechpartner.php">Ansprechpartner</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>