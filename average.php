<?php 
    include_once('./dbConnection.php');

    try {
        $query = $db->prepare("SELECT * FROM leerling");
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

?>
<html>
    <head>
        <link rel="stylesheet" href="./css/style.css">
    </head>
    <body>
        <h1>Gemiddelde leerlingen</h1>
        <table>
            <tr>
                <th>Naam</th>
                <th>Gemidddelde</th>
            </tr>
            <?php 
                foreach($result as &$data) {
                    $grades = $db->prepare("SELECT * FROM toets WHERE leerling_id = :id");
                    $grades->bindParam("id", $data['id']);
                    $grades->execute();
        
                    $gradesresult = $grades->fetchAll(PDO::FETCH_ASSOC);
                    $sum = 0;
                    foreach($gradesresult as &$average) {
                        $sum = $sum + $average['cijfer'];
                    }

                    if($gradesresult) {
                        echo "
                        <tr>
                            <td>".$data['naam']."</td>
                            <td>".$sum / count($gradesresult)."</td>
                        </tr>
                        ";
                    }
                }
            ?>
        </table>
        <a href="./index.php">Terug naar overzicht</a>
    </body>
</html>