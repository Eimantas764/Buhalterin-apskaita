<?php
require('dbConnection.php');
session_start();
if(!isset($_SESSION['username']))
{
    header("Location: ../index.php?error=someError");
    exit();
}

if(isset($_POST['itraukti']))
{   
    $fk = 'fk_Tevasvartotojo_vardas';
    if($_SESSION['statusas'] === 'Vaikai')
        $fk = 'fk_Vaikasvartotojo_vardas';

    if(empty($_POST['pavadinimas']) || empty($_POST['kaina']))
    {
        header("Location: ../vartotojas.php?error=emptyFields");
        exit();
    }

    $pavadinimas = $_POST['pavadinimas'];
    $kaina = intval($_POST['kaina']);
    $username = $_SESSION['username'];

    $sql = "INSERT INTO Islaidos(pavadinimas, kaina, likutis, $fk)
            VALUES(?, ?, $kaina, ?);";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$pavadinimas, $kaina, $username]);
    if($stmt)
    {
        header("Location: ../vartotojas.php");
        exit();
    }
    else
    {
        header("Location: ../vartotojas.php?error=someerror");
        exit();
    }
    
}
else
    header("Location: ../vartotojas.php");