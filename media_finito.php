<html>
<head>
    <title>Programma scuola</title>
</head>
<body>
<h2>PROGRAMMA STUDENTI</h2>

<?php

// Prendo i dati dal form
$nome = '';
$cognome = '';
$materia = '';
$classe = '';
$raggruppa = 'nessuno';

if (isset($_POST['search'])) {
    $nome = $_POST['search'];
}
if (isset($_POST['search1'])) {
    $cognome = $_POST['search1'];
}
if (isset($_POST['search2'])) {
    $materia = $_POST['search2'];
}
if (isset($_POST['search3'])) {
    $classe = $_POST['search3'];
}
if (isset($_POST['raggruppa'])) {
    $raggruppa = $_POST['raggruppa'];
}

// Controllo se il pulsante Cerca è stato premuto
$cercato = false;
if (isset($_POST['Cerca'])) {
    $cercato = true;
}

// Leggo il file CSV
$file = "random-grades 1.csv";
$righe = array();

if (file_exists($file)) {
    $handle = fopen($file, "r");
    while (($riga = fgets($handle)) !== false) {
        $righe[] = $riga;
    }
    fclose($handle);
}

// CASO 1: NESSUN RAGGRUPPAMENTO - CALCOLO MEDIA SINGOLA
if ($cercato && $raggruppa == 'nessuno') {
    $somma = 0;
    $contatore = 0;

    foreach ($righe as $riga) {
        $dati = explode(",", $riga);

        // Controllo se corrisponde ai filtri
        $ok = true;

        if ($cognome != '' && $dati[0] != $cognome) {
            $ok = false;
        }
        if ($nome != '' && $dati[1] != $nome) {
            $ok = false;
        }
        if ($classe != '' && $dati[2] != $classe) {
            $ok = false;
        }
        if ($materia != '' && $dati[3] != $materia) {
            $ok = false;
        }

        if ($ok) {
            $voto = $dati[5];
            $somma = $somma + $voto;
            $contatore = $contatore + 1;
        }
    }

    $media = 0;
    if ($contatore > 0) {
        $media = round($somma / $contatore, 2);
    }
}

// CASO 2: RAGGRUPPAMENTO PER STUDENTE, CLASSE O MATERIA
if ($cercato && ($raggruppa == 'studente' || $raggruppa == 'classe' || $raggruppa == 'materia')) {
    $gruppi = array();

    foreach ($righe as $riga) {
        $dati = explode(",", $riga);

        // Controllo se corrisponde ai filtri
        $ok = true;

        if ($cognome != '' && $dati[0] != $cognome) {
            $ok = false;
        }
        if ($nome != '' && $dati[1] != $nome) {
            $ok = false;
        }
        if ($classe != '' && $dati[2] != $classe) {
            $ok = false;
        }
        if ($materia != '' && $dati[3] != $materia) {
            $ok = false;
        }

        if ($ok) {
            // Decido la chiave del gruppo
            $chiave = '';
            if ($raggruppa == 'studente') {
                $chiave = $dati[0] . ' ' . $dati[1];
            }
            if ($raggruppa == 'classe') {
                $chiave = $dati[2];
            }
            if ($raggruppa == 'materia') {
                $chiave = $dati[3];
            }

            // Aggiungo al gruppo
            if (!isset($gruppi[$chiave])) {
                $gruppi[$chiave] = array();
            }
            $gruppi[$chiave][] = $dati[5];
        }
    }
}

// CASO 3: TABELLONE CLASSE
if ($cercato && $raggruppa == 'tabellone') {
    $studenti = array();
    $elenco_materie = array();

    foreach ($righe as $riga) {
        $dati = explode(",", $riga);

        // Controllo se corrisponde ai filtri
        $ok = true;

        if ($cognome != '' && $dati[0] != $cognome) {
            $ok = false;
        }
        if ($nome != '' && $dati[1] != $nome) {
            $ok = false;
        }
        if ($classe != '' && $dati[2] != $classe) {
            $ok = false;
        }
        if ($materia != '' && $dati[3] != $materia) {
            $ok = false;
        }

        if ($ok) {
            $studente = $dati[0] . ' ' . $dati[1];
            $mat = $dati[3];
            $voto = $dati[5];

            // Creo lo studente se non esiste
            if (!isset($studenti[$studente])) {
                $studenti[$studente] = array();
            }

            // Creo la materia per lo studente se non esiste
            if (!isset($studenti[$studente][$mat])) {
                $studenti[$studente][$mat] = array();
            }

            // Aggiungo il voto
            $studenti[$studente][$mat][] = $voto;

            // Aggiungo la materia alla lista se non c'è già
            if (!in_array($mat, $elenco_materie)) {
                $elenco_materie[] = $mat;
            }
        }
    }

    sort($elenco_materie);
}

?>

<form action="media.php" method="post">
    INSERISCI NOME: <input type="text" name="search" value="<?php echo $nome; ?>"><br><br>

    INSERISCI COGNOME: <input type="text" name="search1" value="<?php echo $cognome; ?>"><br><br>

    INSERISCI MATERIA: <input type="text" name="search2" value="<?php echo $materia; ?>"><br><br>

    INSERISCI CLASSE: <input type="text" name="search3" value="<?php echo $classe; ?>"><br><br>

    RAGGRUPPA PER:
    <select name="raggruppa">
        <option value="nessuno">Nessun raggruppamento</option>
        <option value="studente">Per Studente</option>
        <option value="classe">Per Classe</option>
        <option value="materia">Per Materia</option>
        <option value="tabellone">Tabellone Classe</option>
    </select>
    <br><br>

    <input type="submit" name="Cerca" value="Cerca"><br><br>

    <?php if ($cercato && $raggruppa == 'nessuno'): ?>
        MEDIA TOTALE: <input type="text" value="<?php echo $media; ?>" readonly>
    <?php endif; ?>
</form>

<hr>

<?php if ($cercato): ?>

    <?php if ($raggruppa == 'nessuno'): ?>
        <!-- Già mostrato sopra -->

    <?php elseif ($raggruppa == 'tabellone'): ?>
        <h3>TABELLONE CLASSE</h3>
        <?php if (!empty($studenti)): ?>
            <table border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th>STUDENTE</th>
                    <?php foreach ($elenco_materie as $mat): ?>
                        <th><?php echo $mat; ?></th>
                    <?php endforeach; ?>
                    <th>MEDIA GENERALE</th>
                </tr>

                <?php foreach ($studenti as $studente => $materie_studente): ?>
                    <tr>
                        <td><b><?php echo $studente; ?></b></td>

                        <?php
                        $somma_medie = 0;
                        $conta_materie = 0;

                        foreach ($elenco_materie as $mat):
                            ?>
                            <td>
                                <?php
                                if (isset($materie_studente[$mat])) {
                                    $voti_materia = $materie_studente[$mat];
                                    $somma_voti = 0;
                                    foreach ($voti_materia as $v) {
                                        $somma_voti = $somma_voti + $v;
                                    }
                                    $media_materia = round($somma_voti / count($voti_materia), 2);
                                    echo $media_materia;

                                    $somma_medie = $somma_medie + $media_materia;
                                    $conta_materie = $conta_materie + 1;
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                        <?php endforeach; ?>

                        <td><b>
                                <?php
                                if ($conta_materie > 0) {
                                    echo round($somma_medie / $conta_materie, 2);
                                } else {
                                    echo '0';
                                }
                                ?>
                            </b></td>
                    </tr>
                <?php endforeach; ?>

            </table>
        <?php else: ?>
            <p>Nessun dato disponibile</p>
        <?php endif; ?>

    <?php else: ?>
        <h3>MEDIE RAGGRUPPATE</h3>
        <?php if (!empty($gruppi)): ?>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <th>GRUPPO</th>
                    <th>NUMERO VOTI</th>
                    <th>MEDIA</th>
                </tr>
                <?php foreach ($gruppi as $nome_gruppo => $voti): ?>
                    <tr>
                        <td><b><?php echo $nome_gruppo; ?></b></td>
                        <td><?php echo count($voti); ?></td>
                        <td><b>
                                <?php
                                $somma = 0;
                                foreach ($voti as $v) {
                                    $somma = $somma + $v;
                                }
                                echo round($somma / count($voti), 2);
                                ?>
                            </b></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Nessun risultato trovato</p>
        <?php endif; ?>
    <?php endif; ?>

<?php endif; ?>

</body>
</html>