<?php
    echo '<table border="1">';
    for($i = 0; $i <= 10; $i++) {
        echo '<tr>';
        for($j = 0; $j <= 10; $j++) {
            $class = '';

            if ($i === $j && $i > 0 && $j > 0) {
                $class = ' class="diagonal"';
            }
            echo '<td' . $class . '>';
            if ($i === 0 && $j === 0) {
                echo ' ';
            }
            elseif ($i === 0 || $j === 0) {
                echo $i + $j;
            }
            else {
                echo $i * $j;
            }
            echo '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
?>
