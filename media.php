<html>
<head>
    <title>Programma scuola</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .contenitore {
            text-align: center;
            margin-top: 25px;
        }
        h2 {
            color: #0088ff;
            text-align: center;
        }
    </style>
</head>
<body>
<h2>PROGRAMMA STUDENTI</h2>
<?php

$nome = isset($_POST['search']) ? $_POST['search'] : '';
$cognome = isset($_POST['search1']) ? $_POST['search1'] : '';
$materia = isset($_POST['search2']) ? $_POST['search2'] : '';
$classe = isset($_POST['search3']) ? $_POST['search3'] : '';
$voto = isset($_POST['votoaggiungere']) ? $_POST['votoaggiungere'] : '';
$tipo = isset($_POST['tipovoto']) ? $_POST['tipovoto'] : '';

function MatchStudente($a, $nome, $cognome, $classe, $materia) {
    if (count($a) < 6) return false;
    return (
            ($nome === '' || $a[1] == $nome) &&
            ($cognome === '' || $a[0] == $cognome) &&
            ($classe === '' || $a[2] == $classe) &&
            ($materia === '' || $a[3] == $materia)
    );
}

function Leggi_mediatot($nome, $cognome, $classe, $materia){
    if ($nome === '' && $cognome === '' && $classe === '' && $materia === '') return 0;

    $linee = array_map('trim', file("random-grades 1.csv"));
    $voti = [];

    foreach($linee as $line){
        $a = explode(",", $line);
        if (count($a) >= 6 && MatchStudente($a, $nome, $cognome, $classe, $materia)){
            $voti[] = (int)$a[5];
        }
    }

    return (count($voti) > 0) ? round(array_sum($voti) / count($voti), 2) : 0;
}

function Cerca_Studente($nome, $cognome, $classe, $materia){
    if ($nome === '' && $cognome === '' && $classe === '' && $materia === '') return '';

    $risultati = [];
    foreach(file("random-grades 1.csv") as $line){
        $a = explode(",", trim($line));
        if (MatchStudente($a, $nome, $cognome, $classe, $materia)){
            $risultati[] = trim($line);
        }
    }

    return implode("<br>", $risultati);
}

$result = Cerca_Studente($nome, $cognome, $classe, $materia);
$media = Leggi_mediatot($nome, $cognome, $classe, $materia);
?>

<div class="contenitore";>
    <form action ="media.php" method = "post">
        INSERISCI NOME:<input type="text" name="search" ><br><br>

        INSERISCI COGNOME:<input type="text" name="search1" ><br><br>

        INSERISCI MATERIA:<input type="text" name="search2" ><br><br>

        INSERISCI CLASSE:<input type="text" name="search3" ><br><br>
        <input type="Submit" name="Cerca"><br><br><br>


        MEDIA TOTALE DELLO STUDENTE:
        <input type="text" value="<?php echo $media; ?>">
    </form>

    <h2>RICERCA RISULTATI</h2>
    <?php
    if(isset($_POST['Submit'])){
        echo $result !== "" ? $result : "NESSUN RISULTATO - RIPROVA";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
