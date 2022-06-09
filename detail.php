<?php 
    include_once('./dbConnection.php');

    try {
        $student = $db->prepare("SELECT * FROM leerling WHERE id = :id");
        $student->bindParam("id", $_GET['id']);
        $student->execute();

        $studentresult = $student->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

?>
<html>
    <head>
        <link rel="stylesheet" href="./css/style.css">
    </head>
    <body>
        <h1><?php echo $studentresult['naam']; ?></h1>

        <?php 
            $grades = $db->prepare("SELECT * FROM toets WHERE leerling_id = :id");
            $grades->bindParam("id", $_GET['id']);
            $grades->execute();

            $gradesresult = $grades->fetchAll(PDO::FETCH_ASSOC);
            if(!$gradesresult) {
                echo "Deze leerling heeft nog geen cijfers.";
            } else {
                $sum = 0;
                foreach($gradesresult as &$data) {
                    echo "<p>".$data['vak']." ".$data['cijfer']."</p>";
                    $sum = $sum + $data['cijfer'];
                }
                echo "<p>gemiddeld: ".$sum / count($gradesresult)." </p>";
            }
        ?>



        <a href="./index.php">Terug naar overzicht</a>
    </body>
</html>