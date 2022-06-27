<?php 

require('dbConnection.php');
session_start();
if(!isset($_SESSION['username']))
{
    header("Location: ../index.php?error=someError");
    exit();
}

if(isset($_POST['apmoketi']))
{
    if(empty($_POST['kaina']))
    {
        header("Location: ../vartotojas.php?error=emptyFields");
        exit();
    }

    $fk = 'fk_Tevasvartotojo_vardas';
    if($_SESSION['statusas'] === 'Vaikai')
        $fk = 'fk_Vaikasvartotojo_vardas';


    $kaina = intval($_POST['kaina']);
    $username = $_SESSION['username'];
    $idIslaidos = intval($_POST['id']);
    
    $sql = "INSERT INTO Mokejimai(data_mokejimo, mokejimo_suma, $fk, fk_islaidos)
            VALUES(NOW(), ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$kaina, $username, $idIslaidos]);

    $sql = "UPDATE Islaidos
            SET likutis = likutis - ?
            WHERE id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$kaina, $idIslaidos]);

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