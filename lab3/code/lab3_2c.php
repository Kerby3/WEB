<?php
session_start();
echo '<ul>';
foreach ($_SESSION['user'] as $key => $value) {
	echo "<li>" . $key . ' = ' . $value . "</li><br>";
}
echo '</ul>';
?> 
