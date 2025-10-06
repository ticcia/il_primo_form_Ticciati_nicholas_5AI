<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Traduttore Codice Morse</title>
</head>
<body>

<h1>Traduttore Codice Morse</h1>

<form method="post" action="morse.php">

    <!-- Testo -> Morse -->
    <h3>Da Testo a Morse</h3>
    <label>Testo (solo maiuscolo): </label>
    <input type="text" name="testo" value="<?php if(isset($_REQUEST['testo'])) echo $_REQUEST['testo']; ?>">
    <input type="submit" name="azione" value="Testo → Morse">

    <br><br>
    <label>Risultato in Morse: </label>
    <input type="text" readonly
           value="<?php
           if (isset($_REQUEST['azione']) && $_REQUEST['azione'] == 'Testo → Morse' && isset($_REQUEST['testo'])) {
               $codice_morse = array(
                   'A'=>'.-', 'B'=>'-...', 'C'=>'-.-.', 'D'=>'-..', 'E'=>'.',
                   'F'=>'..-.', 'G'=>'--.', 'H'=>'....', 'I'=>'..', 'J'=>'.---',
                   'K'=>'-.-', 'L'=>'.-..', 'M'=>'--', 'N'=>'-.', 'O'=>'---',
                   'P'=>'.--.', 'Q'=>'--.-', 'R'=>'.-.', 'S'=>'...', 'T'=>'-',
                   'U'=>'..-', 'V'=>'...-', 'W'=>'.--', 'X'=>'-..-', 'Y'=>'-.--', 'Z'=>'--..',
                   '1'=>'.----', '2'=>'..---', '3'=>'...--', '4'=>'....-', '5'=>'.....',
                   '6'=>'-....', '7'=>'--...', '8'=>'---..', '9'=>'----.', '0'=>'-----'
               );

               $testo = $_REQUEST['testo'];
               $risultato = "";

               for ($i = 0; $i < strlen($testo); $i++) {
                   $c = $testo[$i];
                   if ($c == " ") {
                       $risultato = $risultato . "/ ";
                   } elseif (isset($codice_morse[$c])) {
                       $risultato = $risultato . $codice_morse[$c] . " ";
                   } else {
                       $risultato = $risultato . "# ";
                   }
               }
               echo $risultato;
           }
           ?>">
    <hr>

    <!-- Morse -> Testo -->
    <h3>Da Morse a Testo</h3>
    <label>Codice Morse: </label>
    <input type="text" name="morse_input" value="<?php if(isset($_REQUEST['morse_input'])) echo $_REQUEST['morse_input']; ?>">
    <input type="submit" name="azione" value="Morse → Testo">

    <br><br>
    <label>Risultato in Testo: </label>
    <input type="text" readonly
           value="<?php
           if (isset($_REQUEST['azione']) && $_REQUEST['azione'] == 'Morse → Testo' && isset($_REQUEST['morse_input'])) {
               $morse_testo = array(
                   '.-'=>'A', '-...'=>'B', '-.-.'=>'C', '-..'=>'D', '.'=>'E',
                   '..-.'=>'F', '--.'=>'G', '....'=>'H', '..'=>'I', '.---'=>'J',
                   '-.-'=>'K', '.-..'=>'L', '--'=>'M', '-.'=>'N', '---'=>'O',
                   '.--.'=>'P', '--.-'=>'Q', '.-.'=>'R', '...'=>'S', '-'=>'T',
                   '..-'=>'U', '...-'=>'V', '.--'=>'W', '-..-'=>'X', '-.--'=>'Y', '--..'=>'Z',
                   '.----'=>'1', '..---'=>'2', '...--'=>'3', '....-'=>'4', '.....'=>'5',
                   '-....'=>'6', '--...'=>'7', '---..'=>'8', '----.'=>'9', '-----'=>'0'
               );

               $morse_input = $_REQUEST['morse_input'];
               $parole = explode('/', $morse_input);
               $risultato = "";

               for ($i = 0; $i < count($parole); $i++) {
                   $simboli = explode(' ', $parole[$i]);
                   for ($j = 0; $j < count($simboli); $j++) {
                       $s = $simboli[$j];
                       if ($s != "" && isset($morse_testo[$s])) {
                           $risultato = $risultato . $morse_testo[$s];
                       } elseif ($s != "") {
                           $risultato = $risultato . "?";
                       }
                   }
                   $risultato = $risultato . " ";
               }
               echo $risultato;
           }
           ?>">
</form>

</body>
</html>
