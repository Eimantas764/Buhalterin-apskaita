<?php

if(isset($_POST['submit']))
{
    if(empty($_POST['vardas']) || empty($_POST['pavarde']) || empty($_POST['username']) || empty($_POST['password']) || 
        empty($_POST['repeatPassword'] || empty($_POST['kodas'])))
    {
        header("Location: ../index.php?error=emptyFields");
        exit();
    }
    
    else if($_POST['password'] !== $_POST['repeatPassword'])
    {
        header("Location: ../index.php?error=emptyFields?error=passwordNotMatch");
        exit();
    }

    else if(strlen($_POST['password']) < 8)
    {
        header("Location: ../index.php?error=emptyFields?error=passwordTooShort");
        exit();
    }

    else if(preg_match("/[0-9]/", $_POST['vardas']) || preg_match("/[0-9]/", $_POST['pavarde']))
    {
        header("Location: ../index.php?error=emptyFields?error=incorrectName");
        exit();
    }

    require('dbConnection.php');
    $vardas = $_POST['vardas'];
    $pavarde = $_POST['pavarde'];
    $vartotojo_vardas = $_POST['username'];
    $slaptazodis = $_POST['password'];
    $hashedPassword = password_hash($slaptazodis, PASSWORD_DEFAULT);
    $asmens_kodas = $_POST['kodas'];

    if($_POST['statusas'] === 'Suages')
    {
        $sql = 'INSERT INTO Tevai(vardas, pavarde, vartotojo_vardas, slaptazodis, asmens_kodas)
                VALUES (?, ?, ?, ?, ?)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$vardas, $pavarde, $vartotojo_vardas, $hashedPassword, $asmens_kodas]);
        if($stmt)
        {
            session_start();
            $_SESSION['vardas'] = $vardas;
            $_SESSION['pavarde'] = $pavarde;
            $_SESSION['username'] = $vartotojo_vardas;
            $_SESSION['statusas'] = 'Tevai';
            echo 'Statement execution success';
            header("Location: ../vartotojas.php");
            exit();
        }
        else{
            echo 'Statement execution failed';
            header("Location: ../index.php?error=SomeError");
            exit();
        }
    }
    else
    {
        $sql = 'INSERT INTO Vaikai(vardas, pavarde, vartotojo_vardas, slaptazodis, asmens_kodas)
                VALUES (?, ?, ?, ?, ?)';

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$vardas, $pavarde, $vartotojo_vardas, $hashedPassword, $asmens_kodas]);
        if($stmt)
        {
            session_start();
            $_SESSION['vardas'] = $vardas;
            $_SESSION['pavarde'] = $pavarde;
            $_SESSION['username'] = $vartotojo_vardas;
            $_SESSION['statusas'] = 'Vaikai';
            header("Location: ../vartotojas.php");
        }
        else
        {
            header("Location: ../index.php?error=someError");
            exit();
        }
    }
}
else
{
    header("Location: ../index.php");
}