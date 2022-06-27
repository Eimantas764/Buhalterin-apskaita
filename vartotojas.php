<?php
require('controller/dbConnection.php');
session_start();

date_default_timezone_set('Europe/Helsinki');
$sql = "SELECT * FROM Mokejimo_data";
$date1 = $pdo->query($sql)->fetch()->date;
$date2 = date('Y-m-d');
$ts1 = strtotime($date1);
$ts2 = strtotime($date2);
$year1 = date('Y', $ts1);
$year2 = date('Y', $ts2);
$month1 = date('m', $ts1);
$month2 = date('m', $ts2);
$diff = (($year2 - $year1) * 12) + ($month2 - $month1);

if($diff > 0)
{
    $sql = "UPDATE Islaidos SET likutis = likutis + kaina * ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$diff]);
    $sql = "UPDATE Mokejimo_data SET date = NOW()";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([]);
}

if(isset($_SESSION['username']))
{

    $username = $_SESSION['username'];
    $fk = 'fk_Tevasvartotojo_vardas';
    if($_SESSION['statusas'] === 'Vaikai')
         $fk = 'fk_Vaikasvartotojo_vardas';
    $table = $_SESSION['statusas'];
    $query = "SELECT pavadinimas, kaina, likutis, id
              FROM Islaidos 
              INNER JOIN $table
              ON vartotojo_vardas = Islaidos.$fk
              WHERE vartotojo_vardas = '$username'";
    
    $stmt = $pdo->query($query);

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
                    <li class="item"><a class="link-item selected" href='#'>Vartotojo išlaidos</a></li>
                    <li class="item"><a class="link-item" href='krepselis.php'>Pinigų krepšelis</a></li>
                    <?php
                        if($_SESSION['statusas'] === 'Tevai')
                        {
                            ?>
                            <li class="item"><a class="link-item" href='vaikuSaskaitos.php'>Vaikų sąskaitos</a></li>
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
                <table>
                    <caption> Einamųjų išlaidų likučiai </caption>
                        <tr>
                            <th class='bold'>Išlaidos pavadinimas</th>
                            <th class='bold'>Kaina</th>
                            <th class='bold'>Likutis</th>
                            <th> 
                            </th>
                        </tr>
                        <?php
                        while($row = $stmt->fetch())
                        {
                            $id = $row->id;
                            echo "<tr>";
                            echo "<td>" . $row->pavadinimas . "</td>";
                            echo "<td class='right'>" . $row->kaina . "$</td>";
                            echo "<td class='right'>" . $row->likutis . "$</td>";
                            echo "<td> <a class = 'button' href = 'Islaida.php?id=$id'>Apmokėti</a></td>";
                            echo "</tr>";
                        }
                        ?>
                </table>

                <a class = 'button reg-button'>Įtraukti išlaidą</a>

                <form class = 'registration' action='controller/itrauktiIslaida.php' method ='POST'>
                <h1 class='registration-title'> Įtraukti naują išlaidą </h1>
                    <input type="text" class ='' placeholder="Išlaidos pavadinimas" name='pavadinimas'>
                    <input type="number" class ='' placeholder="Išlaidos Kaina" name='kaina'>
                    <input type="submit" class ='button' value="Įtraukti"  name = 'itraukti'>
                </form>
            </div>
        </main>


        <script src='js/scipt-style.js'></script> 
        <script src='js/registration-script.js'></script>
    </body>

</html>
<?php
}
else{
    header("Location: index.php");
}