<?php
// Recupero valore N inviato dal form
$n = $_POST["n"];

// Funzione per verificare se un numero è primo
function isPrimo($num) {
    if ($num < 2) return false;
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) return false;
    }
    return true;
}

// Calcolo dei primi N numeri primi
$primi = [];
$num = 2; // primo numero da testare
while (count($primi) < $n) {
    if (isPrimo($num) === true){
        $primi[] = $num;
    }
    $num++;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Risultato</title>
</head>
<body>
<h2>I primi <?php echo $n; ?> numeri primi sono:</h2>
<p>
    <?php
    for ($i = 0; $i < count($primi); $i++) {
        echo $primi[$i];
        if ($i < count($primi) - 1) {
            echo ", "; // virgola solo tra i numeri
        }
    }
    ?>
</p>

<br>
<a href="numeri_primi.html">Torna indietro</a>
</body>
</html>
