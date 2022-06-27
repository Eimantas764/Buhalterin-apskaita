<?php

if(isset($_POST['submit']))
{
    if(empty($_POST['username']) || empty($_POST['password']))
    {
        header("Location: ../index.php?error=emptyFields");
        exit();
    }
    
    require('dbConnection.php');

    $vartotojo_vardas = $_POST['username'];
    $slaptazodis = $_POST['password'];

    $sql = 'SELECT * FROM Tevai
            WHERE vartotojo_vardas = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$vartotojo_vardas]);
    
    
    if($stmt->rowCount() > 0)
    {
        $result = $stmt->fetch();
        $check = password_verify($slaptazodis, $result->slaptazodis);
        if($check)
        {
            session_start();
            $_SESSION['vardas'] = $result->vardas;
            $_SESSION['pavarde'] = $result->pavarde;
            $_SESSION['username'] = $result->vartotojo_vardas;
            $_SESSION['statusas'] = 'Tevai';
            header("Location: ../vartotojas.php");
        }
        else
        {
            header("Location: ../index.php?error=incorrectPassword");
            exit();
        }
    }

    else{
        $sql = 'SELECT * FROM Vaikai
        WHERE vartotojo_vardas = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$vartotojo_vardas]);     
        if($stmt->rowCount() > 0)
        {
            $result = $stmt->fetch();
            $check = password_verify($slaptazodis, $result->slaptazodis);
            if($check)
            {
                session_start();
                $_SESSION['vardas'] = $result->vardas;
                $_SESSION['pavarde'] = $result->pavarde;
                $_SESSION['username'] = $result->vartotojo_vardas;
                $_SESSION['statusas'] = 'Vaikai';
                header("Location: ../vartotojas.php");
                exit();
            }
            else
            {
                header("Location: ../index.php?error=incorrectPassword");
                exit();
            }
        }
        else
        {
            header("Location: ../index.php?error=incorrectUsername");
            exit();
        }
    }
}
else
{
    header("Location: ../index.php");
}