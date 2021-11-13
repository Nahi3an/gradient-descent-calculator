<?php


if (isset($_GET['calc_btn'])) {

    $row = $_GET['row'];
    $col = $_GET['col'];

    $iterationNum = (int) $_GET['iteration_num'];

    echo "Iteration Num : $iterationNum <br><br>";
    echo "<b>(Precision: 4 decimal points)</b> <br><br>";

    $iterationNum =  $iterationNum + 1;


    // turnig w values into a double value
    $w = array();
    // turning alpha in to a double value
    $alpha = (float) $_GET['alpha'];

    for ($i = 0; $i < $col; $i++) {

        $key = "w" . $i;
        array_push($w, (float)$_GET[$key]);
    }

    // turning input data in a 2d array of float value
    $x = array();

    for ($i = 1; $i <= $row; $i++) {
        $y = array();
        for ($j = 1; $j <= $col; $j++) {

            $key = "value" . $i . $j;
            $_GET[$key];
            array_push($y, (float)$_GET[$key]);
        }


        array_push($x, $y);
    }


    // Predicted and expected value taken
    $pred = array();
    $exp = array();

    for ($i = 0; $i < $row; $i++) {
        $sum = $w[0];
        for ($j = 0; $j < $col; $j++) {

            if ($j == $col - 1) {
                array_push($exp, $x[$i][$j]);
            } else {
                $sum = $sum  + ($w[$j + 1] * $x[$i][$j]);
            }
        }

        $sum =  round($sum, 4);
        array_push($pred, $sum);
    }

    $diff = array();
    for ($i = 0; $i < sizeof($pred); $i++) {
        array_push($diff, $pred[$i] - $exp[$i]);
        //$diff[$i] = $pred[$i] - $exp[$i];
    }

    //echo array_sum($diff);
    $Diff = array();

    $sum = array_sum($diff);
    array_push($Diff, $sum);

    for ($i = 0; $i < $col - 1; $i++) {
        $sum = 0;
        for ($j = 0; $j < sizeof($pred); $j++) {


            $sum = $sum + $diff[$j] * $x[$j][$i];
        }

        $sum = round($sum, 4);

        array_push($Diff, $sum);
    }



    echo "<table border='1'>";

    echo  "<tr><th><h4> Serial </h4></th>";
    echo  "<th><h4>Predicted  </h4></th>";
    echo  "<th><h4>Expected </h4></th>";
    echo  "<th><h4>Diff</h4></th>";


    for ($j = 1; $j < $col; $j++) {



        echo "<td> <h4>Diff X$j</h4></td>";
    }
    echo "</tr>";

    for ($i = 0; $i < sizeof($pred) + 1; $i++) {
        echo "<tr>";
        if ($i < sizeof($pred)) {
            echo  "<td><h4>" .  $i + 1 .   "</h4></td>";
            echo  "<td><h4>" . $pred[$i]  . "</h4></td>";
            echo  "<td><h4>" . $exp[$i]  .  "</h4></td>";
            echo  "<td><h4>" . $diff[$i] .  "</h4></td>";


            for ($j = 0; $j < $col - 1; $j++) {


                $cell = round($diff[$i] * $x[$i][$j], 4);
                echo "<td> <h4>" . $cell . "</h4></td>";
            }
        } else {
            echo  "<td><h4> </h4></td>";
            echo  "<td><h4> </h4></td>";
            echo  "<td><h4> </h4></td>";
            for ($j = 0; $j < $col; $j++) {

                echo "<td> <h4> Σ = " . $Diff[$j] . "</h4></td>";
            }
        }

        echo "</tr>";
    }

    echo "</table>";


    echo "<br>";

    echo " <form method='GET' id='w_form' action='/gradient-descent-calculator/slr_dataset.php'></form>";
    echo "<table>";

    for ($i = 0; $i < $col; $i++) {

        $wnew = round($w[$i] - $alpha * $Diff[$i], 4);
        if ($i == 0) {
            $n = "";
        } else {

            $n = "X" . $i;
        }

        echo "<tr>";
        echo "<td>W$i (new) = W$i (old) - (alpha * Σ Diff $n) = <b>$w[$i] - $alpha * ($Diff[$i]) </b> = 
              <input type='text' name='w$i' value='$wnew' form='w_form'/></td>
            </tr>";
    }

    echo "</table>";
    session_start();
    $_SESSION['data_set'] = $x;

    echo " <input type='text' hidden name='alpha' value='$alpha' form='w_form'/>";
    echo " <input type='text' hidden name='row' value='$row' form='w_form'/>";
    echo " <input type='text' hidden name='col' value='$col' form='w_form'/>";
    echo " <input type='text' hidden name='iteration_num' value='$iterationNum' form='w_form'/>";

    // echo "<input type='hidden' name='data_set' value='<?php echo htmlentities(serialize($x))' form='w_form'



    echo " <br><button type='submit' name='again_btn' form='w_form'>Next Iteration => </button>";
}
