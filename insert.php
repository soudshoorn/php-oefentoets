<?php 
    include_once('./dbConnection.php');

    try {
        $query = $db->prepare("SELECT * FROM leerling");
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo $e->getMessage();
    }


    if(isset($_POST['submit'])) {
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
        $class = filter_input(INPUT_POST, "class", FILTER_SANITIZE_STRING);

        $studentcheck = $db->prepare("SELECT * FROM leerling WHERE naam=:name");
        $studentcheck->bindParam("name", $name);
        $studentcheck->execute(); 
        $studentexists = $studentcheck->fetch();


        if((!$name) && (!$class)) {
            echo "Geen leerling gegevens ingevoerd.";
        } else if (!$studentexists) {
            try{
                echo $studentexists;
                $newstudent = $db->prepare("INSERT INTO leerling(naam, klas) VALUES(:name, :class)");

                $newstudent->bindParam("name", $name);
                $newstudent->bindParam("class", $class);

                if($newstudent->execute()) {
                    echo "".$name." in klas ".$class." is toegevoegd.";
                } else {
                    echo "Iets is fout gegaan bij het toevoegen van de leerling.";               
                }

            } catch(PDOException $e) {
                    echo "error! " . $e->getMessage();
            }
        } else {
            echo "Deze leerling is al bekend.";
        }
    } 




?>
<html>
    <head>
        <link rel="stylesheet" href="./css/style.css">
    </head>
    <body>
        <h3>Invoeren van een nieuwe leerling</h3>
        <form method="POST" class="insert">
            <div class="form__sub">
                <label>Naam:</label>
                <input type="text" name="name">
            </div>

            <div class="form__sub">
                <label>Klas:</label>
                <input type="text" name="class">
            </div>

            <input type="submit" name="submit">
        </form>
        <a href="./index.php">Terug naar overzicht</a>
    </body>
</html>