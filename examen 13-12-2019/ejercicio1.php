<?php
	

if(isset($_POST["00"])&& isset($_POST["01"])&&isset($_POST["10"])&&isset($_POST["11"])&&isset($_POST["20"])&&isset($_POST["21"])){

    $error = false;

    $errortext = "";
    
    if(($_POST["00"]<1 || $_POST["00"]>100)||($_POST["01"]<1 || $_POST["01"]>100)||($_POST["10"]<1 || $_POST["10"]>100 )|| ($_POST["11"]<1 || $_POST["11"]>100 )||($_POST["20"]<1 || $_POST["20"]>100)||($_POST["21"]<1 || $_POST["21"]>100 )){

        $error = true;
        $errortext = "<p style= 'color: red;'>*el valor deve de estar entre 1 y 100</p>";

    }else{

        $error = false;

    }
    

    if($error){

       echo<<<_END

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form method = "post" action="ejercicio1.php">
    <table>
_END;
    for($i=0; $i<=2; $i++){
        echo "<tr>";
        for($j=0; $j<=1; $j++){

            echo<<<_END
                    <th>
                        <lavel>E.$i.$j<lavel>
                        <input type="number" name="$i$j">
                    </th>

            _END;

        }
        echo "</tr>";

    }
echo<<<_END
    </table>
    $errortext
    <input type="submit" value = "calcular">

</form>
    
</body>
</html>

_END;

    }else{

        $bin00 = decbin($_POST["00"]);
        $bin01 = decbin($_POST["01"]);
        $bin10 = decbin($_POST["10"]);
        $bin11 = decbin($_POST["11"]);
        $bin20 = decbin($_POST["20"]);
        $bin21 = decbin($_POST["21"]);

        $n00 =  $_POST["00"];
        $n01 =  $_POST["01"];
        $n10 =  $_POST["10"];
        $n11 =  $_POST["11"];
        $n20 =  $_POST["20"];
        $n21 =  $_POST["21"];

        echo<<<_END

            $n00 = '$bin00'
            <br>
            $n01 = '$bin01'
            <br>
            $n10 = '$bin10'
            <br>
            $n11 = '$bin11'
            <br>
            $n20 = '$bin20'
            <br>
            $n21 = '$bin21'

        _END;

    }

}else{

echo<<<_END

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form method = "post" action="ejercicio1.php">
    <table>
_END;
    for($i=0; $i<=2; $i++){
        echo "<tr>";
        for($j=0; $j<=1; $j++){

            echo<<<_END
                    <th>
                        <lavel>E.$i.$j<lavel>
                        <input type="number" name="$i$j">
                    </th>

            _END;

        }
        echo "</tr>";

    }
echo<<<_END
    </table>
    
    <input type="submit" value = "calcular">

</form>
    
</body>
</html>

_END;

}

?>