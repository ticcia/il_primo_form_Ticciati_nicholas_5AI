<?php
$risultato = "";
$somma = 0;
$voti = 0;

$cognome = isset($_POST['cognome']) ? trim($_POST['cognome']) : "";
$classe = isset($_POST['classe']) ? trim($_POST['classe']) : "";
$disciplina = isset($_POST['disciplina']) ? trim($_POST['disciplina']) : "";

if (isset($_POST['send'])) {
    $file = fopen("random-grades 1.csv", "r");

    if (!$file) {
        $risultato = "Errore: impossibile aprire il file CSV.";
    } else {
        // Salta la prima riga (intestazione)
        fgets($file);

        while (($line = fgets($file)) !== false) {
            $line = trim($line);
            if ($line === "") continue;


            $campi = explode(",", $line);


            if (count($campi) < 6) continue;

            $cognome_riga = $campi[0];
            $classe_riga = $campi[2];
            $disciplina_riga = $campi[3];
            $voto_riga = str_replace(",", ".", $campi[5]);

            $match = true;
            if ($cognome !== "" && strcasecmp($cognome, $cognome_riga) !== 0) $match = false;
            if ($classe !== "" && strcasecmp($classe, $classe_riga) !== 0) $match = false;
            if ($disciplina !== "" && strcasecmp($disciplina, $disciplina_riga) !== 0) $match = false;

            if ($match && is_numeric($voto_riga)) {
                $somma += floatval($voto_riga);
                $voti++;
            }
        }

        fclose($file);

        if ($voti > 0) {
            $media = $somma / $voti;
            $risultato = "Media: " . number_format($media, 2);
        } else {
            $risultato = "Nessun risultato trovato nel file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Calcolo Media Voti</title>
</head>
<body>
<h2>Calcolo media voti</h2>
<form action="calcolomedia.php" method="post">
    <label>Cognome:</label><br>
    <input type="text" name="cognome" value="<?php echo $cognome; ?>"><br><br>

    <label>Classe:</label><br>
    <input type="text" name="classe" value="<?php echo $classe; ?>"><br><br>

    <label>Disciplina:</label><br>
    <input type="text" name="disciplina" value="<?php echo $disciplina; ?>"><br><br>

    <button type="submit" name="send">Calcola Media</button><br><br>

    <input type="text" readonly value="<?php echo $risultato; ?>">
</form>
</body>
</html>
