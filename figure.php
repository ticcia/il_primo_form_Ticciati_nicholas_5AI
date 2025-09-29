<?php
    $n = $_POST["num"];
    $figura = $_POST["figura"];

    echo "<h2>Figura scelta: $figura (N = $n)</h2>";

    switch ($figura) {
        case "triangolo":
            for ($i = 1; $i <= $n; $i++) {
                for ($j = 1; $j <= $i; $j++) {
                    echo "* ";
                }
                echo "<br>";
            }
            break;

        case "quadrato":
            for ($i = 1; $i <= $n; $i++) {
                for ($j = 1; $j <= $n; $j++) {
                    echo "* ";
                }
                echo "<br>";
            }
            break;

        case "specchiato":
            echo "<pre>";
            for ($i = $n; $i >= 1; $i--) {
                // stampo spazi per spostare il triangolo a destra
                for ($s = 1; $s <= $n - $i; $s++) {
                    echo "  "; // due spazi
                }
                // stampo gli asterischi
                for ($j = 1; $j <= $i; $j++) {
                    echo "* ";
                }
                echo "\n";
            }
            echo "</pre>";

            break;

        case "cornice":
            echo "<pre>";
            for ($i = 1; $i <= $n; $i++) {
                for ($j = 1; $j <= $n; $j++) {
                    if ($i == 1 || $i == $n || $j == 1 || $j == $n) {
                        echo "* ";
                    } else {
                        echo "  "; // spazi vuoti
                    }
                }
                echo "\n";
            }
            echo "</pre>";

            break;

        default:
            echo "Figura non riconosciuta.";
    }
    echo "<a href='figure.html'>Torna alla pagina iniziale</a>";
?>