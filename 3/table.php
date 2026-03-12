<?php
    function createTable($x = 10, $y = 10) {
        if(!is_int($x) || !is_int($y)) {
            return '';
        }
        if($x < 0 || $y < 0) {
            return '';
        }
        if($x > 20) $x = 20;
        if($y > 20) $y = 20;
        $table = '<table border="1">';

        for($i = 0; $i <= $y; $i++) {
            $table .= '<tr>';
            for($j = 0; $j <= $x; $j++) {
                $class = '';
                if ($x === $y && $i === $j && $i > 0 && $j > 0) {
                    $class = ' class="diagonal"';
                }
                $table .= '<td' . $class . '>';
                if ($i === 0 && $j === 0) {
                    $table .= ' ';
                } 
                elseif ($i === 0 || $j === 0) {
                    $table .= $i + $j;
                } 
                else {
                    $table .= $i * $j;
                }
                $table .= '</td>';
            }
            $table .= '</tr>';
        }
        $table .= '</table>';
        return $table;
    }
?>