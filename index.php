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
        <h1>Toets Resultaten</h1>
        <table>
            <tr>
                <th>Naam</th>
                <th>Klas</th>
                <th>Cijfers</th>
            </tr>
            <?php 
                foreach($result as &$data) {
                    echo "
                    <tr>
                        <td>".$data['naam']."</td>
                        <td>".$data['klas']."</td>
                        <td><a href='./detail.php?id=".$data['id']."'>cijfers</a></td>
                    </tr>
                    ";
                }
            ?>
        </table>
        <?php 
            echo "Aantal leerlingen: ", count($result);
        ?>
        <a href="./insert.php">Leerling toevoegen</a>
        <a href="./average.php">Gemiddeldes bekijken</a>
    </body>
</html>