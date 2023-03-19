<?php
session_start();
echo "Имя: " . $_SESSION['name'] . "<br>Фамилия: " . $_SESSION['surname'] . "<br>Возраст: " . $_SESSION['age'];
?>