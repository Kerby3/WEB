<?php
$host = 'db'; //хост базы данных
$db = 'web'; //название базы данных
$user = 'root'; //пользователь
$pass = 'Aa123456'; //пароль
$dsn = "mysql:host=$host;dbname=$db"; //задаем некоторые параметры
$opt = [  //и свойства
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
$pdo = new PDO($dsn, $user, $pass, $opt); //объект подключения
$stmt = $pdo->query('SELECT * FROM `ad`'); //считываем все объявления из базы данных
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<title>lab5</title>
</head>
<body>
	<div class="ad">
		<div class="form">
			<form action="" method="POST" class="adForm">
				<div class="nameContainer">Электронная почта: <input type="text" name="email">
				</div>
				<div class="surnameContainer">Категория: <input type="text" name="category">
				</div>
				<div class="ageContainer">Заголовок: <input type="text" name="header">
				</div>
				<div class="ageContainer">Текст объявления: <input type="text" name="content">
				</div>
				<input name="btn" type="submit" value="Add">
			</form>
		</div>
		<div class="adField">
			<div class="adItem">
				<div class="idHeader">ID</div>
				<div class="categoryHeader">Категория</div>
				<div class="headerHeader">Заголовок</div>
				<div class="textHeader">Текст</div>
				<div class="emailHeader">Электронная почта</div>
				<div class="addTimeHeader">Время добавления</div>
			</div>
			<?php
			while ($arrayOfRows = $stmt->fetch()) { //сохраняем результат в массив и обходим строчки результата
				$tmpStr = '<div class="adItem">'; //временная строка, в которой постепенно будем создавать строку таблицы html страницы
				foreach ($arrayOfRows as $numOfRow => $row) { //обход строчки результата по полям
					$tmpStr .= "<div>" . $row . "</div>"; //вносим в временную строку информацию из результата
				}
				$tmpStr .= '</div>'; //закончили формирование временной строки
				echo $tmpStr; //вывели ее в таблицу html страницы
			}
			if (isset($_POST['btn'])) { //проверка существования отправленных данных по кнопке
			switch ($_POST['btn']) {
				case 'Add': //по кнопке Add

					if($_POST['email'] && $_POST['category'] && $_POST['header'] && $_POST['content']) {
						$stmt = $pdo->prepare('INSERT ad (category, title, description, email) VALUES (:category, :title, :description, :email)'); //готовим SQL запрос
						$stmt->execute(array('category' => $_POST['category'], 'title' => $_POST['header'], 'description' => $_POST['content'], 'email' => $_POST['email'])); //обращаемся к базе данных обработанным запросом, добавив в заглушки данные

					}
				}
			}
			?>
			
		</div>

	</div>
</body>
</html>