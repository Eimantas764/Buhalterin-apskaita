<?php
session_start();
if(isset($_SESSION['username']))
{
    require('controller/dbConnection.php');
    $username = $_SESSION['username'];
    $fk = 'fk_Tevasvartotojo_vardas';
    $table = $_SESSION['statusas'];
    if($_SESSION['statusas'] === 'Vaikai')
        $fk = 'fk_Vaikasvartotojo_vardas';
    
    if(!isset($_POST['islaidos_submit']))
    {
        $sql = "SELECT pavadinimas, Mokejimai.mokejimo_suma, data_mokejimo
                FROM $table
                INNER JOIN Mokejimai ON vartotojo_vardas = Mokejimai.$fk
                INNER JOIN Islaidos ON Mokejimai.fk_Islaidos = Islaidos.id
                WHERE vartotojo_vardas = '$username'
                ORDER BY data_mokejimo DESC";

        $stmt = $pdo->query($sql);
    }
    else
    {
        $islaida = $_POST['islaida'];
        $sql = "SELECT pavadinimas, Mokejimai.mokejimo_suma, data_mokejimo
        FROM $table
        INNER JOIN Mokejimai ON vartotojo_vardas = Mokejimai.$fk
        INNER JOIN Islaidos ON Mokejimai.fk_Islaidos = Islaidos.id
        WHERE vartotojo_vardas = '$username' AND pavadinimas = '$islaida'
        ORDER BY data_mokejimo DESC";

$stmt = $pdo->query($sql);
        
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
                    <li class="item"><a class="link-item selected" href='krepselis.php'>Pinigų krepšelis</a></li>
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
                <p class ='username'><?php echo $_SESSION['vardas'] .' ' .$_SESSION['pavarde'] ?></p>
        </nav>

        <main>      
            
             <div class='container'>

                 <form action='krepselis.php' method ='POST'>
                        <input type="text" placeholder="Įveskite išlaidos pavadinimą" name='islaida'>
                        <input type="submit" class ='button' value="Filtruoti" name='islaidos_submit'>
                </form>
                <table>
                        <caption> Pinigų krepšelis </caption>
                            <tr>
                                <th class='bold'>Išlaidos pavadinimas</th>
                                <th class='bold'>Mokėjimo suma</th>
                                <th class='bold'>Data</th>
                            </tr>
                            <?php
                            while($row = $stmt->fetch())
                            {
                                echo "<tr>";
                                echo "<td>" . $row->pavadinimas . "</td>";
                                echo "<td class='right'>" . $row->mokejimo_suma . "$</td>";
                                echo "<td class='right'>" . $row->data_mokejimo . "</td>";
                                echo "</tr>";
                            }
                            ?>
                    </table>
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