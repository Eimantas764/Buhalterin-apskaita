<?php

session_start();
unset($_SESSION['username']);
unset($_SESSION['vardas']);
unset($_SESSION['pavarde']);

session_destroy();
header("Location: ../index.php");