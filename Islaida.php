<?php


session_start();
if(isset($_SESSION['username']))
{
    require('controller/dbConnection.php');
    $username = $_SESSION['username'];
    $query = "SELECT pavadinimas, kaina, likutis, id
              FROM Islaidos 
              INNER JOIN Tevai
              ON Tevai.vartotojo_vardas = Islaidos.fk_Tevasvartotojo_vardas;
              WHERE Tevai.vartotojo_vardas = $username";
    
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
                <li class="item"><a class="link-item" href='vartotojas.php'>Vartotojo išlaidos</a></li>
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
                <form class = 'registration show' action='controller/apmoketiIslaida.php' method ='POST'>
                <h1 class='registration-title'> Apmokėti išlaidą </h1>
                    <input type="number"  placeholder="Įveskita išlaidos apmokėjimo kainą" name='kaina'>
                    <input type="hidden"  value=<?php echo $_GET['id'] ?> name='id'>
                    <input type="submit"  class ='button' value="Apmokėti"  name = 'apmoketi'>
                </form>
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