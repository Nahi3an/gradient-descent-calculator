<?php



$rowNum = $_GET['row'];
$colNum = $_GET['col'];

session_start();
echo " <form method='GET' id='data_form' action='./calculate.php'></form>";

if (isset($_GET['go_btn'])) {
    $iterationNum = 1;
    echo "Iteration Num :  $iterationNum <br> <br>";
    for ($i = 0; $i < $colNum; $i++) {

        echo "<label>Enter w$i : </label>";
        echo "<input type='text' name='w$i' form='data_form'/> <br>";
    }
    echo "<br><label>Enter alpha : </label>";
    echo "<input type='text' name='alpha' form='data_form'/> <br>";

    echo "<table>";

    for ($i = 0; $i <= $rowNum; $i++) {
        if ($i == 0) {
            echo "<tr>";
            for ($j = 1; $j <= $colNum; $j++) {

                if ($j == $colNum) {
                    echo "<th>Y(Output)</th>";
                } else {
                    echo "<th>X$j</th>";
                }
            }
            echo "<tr>";
        } else {
            echo "<tr>";
            for ($j = 1; $j <= $colNum; $j++) {
                echo "<td><input type='text' name='value$i$j' form='data_form'/></td>";
            }
            echo "</tr>";
        }
    }
    echo "</table> ";
}

if (isset($_GET['again_btn'])) {

    $iterationNum = $_GET['iteration_num'];
    echo "Iteration Num :  $iterationNum <br> <br>";

    $x = $_SESSION['data_set'];

    for ($i = 0; $i < $colNum; $i++) {

        $key = "w$i";
        $w = $_GET[$key];
        echo "<label>Enter w$i : </label>";
        echo "<input type='text' name='w$i' value='$w' form='data_form'/> <br>";
    }

    $alpha = $_GET['alpha'];
    echo "<br><label>Enter alpha : </label>";
    echo "<input type='text' name='alpha' value='$alpha'  form='data_form'/> <br>";

    echo "<table>";


    for ($i = 0; $i <= $rowNum; $i++) {

        if ($i == 0) {
            echo "<tr>";
            for ($j = 1; $j <= $colNum; $j++) {

                if ($j == $colNum) {
                    echo "<th>Y(Output)</th>";
                } else {
                    echo "<th>X$j</th>";
                }
            }
            echo "<tr>";
        } else {
            echo "<tr>";
            for ($j = 1; $j <= $colNum; $j++) {

                $val = $x[$i - 1][$j - 1];
                echo "<td><input type='text' name='value$i$j' value='$val' form='data_form'/></td>";
            }
            echo "</tr>";
        }
    }
    echo "</table> ";
}


echo "<br>";


echo "<input type='text' name='row' value='$rowNum' hidden form='data_form'/>";
echo "<input type='text' name='col' value='$colNum' hidden form='data_form'/>";
echo "<input type='text' name='iteration_num' value='$iterationNum' hidden form='data_form'/>";


echo " <button type='submit' name='calc_btn' form='data_form'>ok</button>";

echo "<p>Here SLR EQN : y = w0 + w1X1 + w2X2 + w3X3 + .... + wnXn</p>";
