<?php
session_start();
if(isset($_SESSION['username']))
{
    require('controller/dbConnection.php');
    $number_of_rows = 0;
    if(isset($_POST['saskaita']))
    {
        $asmens_kodas = $_POST['kodas'];
        $query = "SELECT pavadinimas, kaina, likutis, id, vardas, pavarde
              FROM Islaidos 
              INNER JOIN Vaikai
              ON vartotojo_vardas = Islaidos.fk_Vaikasvartotojo_vardas
              WHERE asmens_kodas = '$asmens_kodas'";
    
        $stmt = $pdo->query($query);
        $laik = $pdo->query($query)->fetch();

        $vardas = $laik->vardas;
        $pavarde = $laik->pavarde;
        $number_of_rows = intval($stmt->rowCount());
    }


?>
<!DOCTYPE html>
<html>
    <head>
        <title> Buhalterinė apskaita </title>
        <link rel='stylesheet' href='css/new-style.css'>
        <link rel='stylesheet' href='css/style.css'>
        <link rel='icon' href='images/icon.png'>
    </head>
    <body>
        <nav class="navigation">
                <h1 class="web-name">Namų ūkio buhalterinė apskaita</h1>
                <ul class="items">
                <li class="item"><a class="link-item" href='vartotojas.php'>Vartotojo išlaidos</a></li>
                    <li class="item"><a class="link-item" href='krepselis.php'>Pinigų krepšelis</a></li>
                    <?php
                        if($_SESSION['statusas'] === 'Tevai')
                        {
                            ?>
                            <li class="item"><a class="link-item selected" href='vaikuSaskaitos.php'>Vaikų sąskaitos</a></li>
                            <?php
                        }
                    ?>
                    <li class="item"><a class="button logout-button" href='controller/logout.php'>Atsijungti</a></li>
                </ul>
                <div class="burger">
                    <div class="burger-line"></div>
                    <div class="burger-line"></div>
                    <div class="burger-line"></div>
                </div>
        </nav>

        <main>      
            
             <div class='container'>
                <form action='vaikuSaskaitos.php' method ='POST'>
                        <input type="text" class ='' placeholder="Įveskite vaiko asmens kodą" name='kodas'>
                        <input type="submit" class ='button' value="Ieškoti" name='saskaita'>
                </form>

                <?php
                    if($number_of_rows > 0)
                    {
                ?>
                <table>
                        <caption><?php echo $vardas . ' ' . $pavarde; ?> sąskaitos</caption>
                        <tr>
                            <th class='bold'>Išlaidos pavadinimas</th>
                            <th class='bold'>Kaina</th>
                            <th class='bold'>Likutis</th>
                        </tr>
                        <?php

                            while($row = $stmt->fetch())
                            {
                                $id = $row->id;
                                echo "<tr>";
                                echo "<td>" . $row->pavadinimas . "</td>";
                                echo "<td class='right'>" . $row->kaina . "$</td>";
                                echo "<td class='right'>" . $row->likutis . "$</td>";
                                echo "</tr>";
                            }
                        
                        ?>
                </table>
                <?php
                    }
                    else
                    {
                        if(isset($asmens_kodas))
                             echo "<p>Nerasta informacijos apie vaiką kurio asmens kodas yra " . $asmens_kodas . " </p>";
                    }
                ?>
            </div>
        </main>


        <script src='js/scipt-style.js'></script> 
    </body>

</html>
<?php
}
else{
    header("Location: index.php");
}