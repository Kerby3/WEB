<?php
class dataForDataBase { //класс для хранения данных для базы данных
    public $host;
    public $db;
    public $user;
    public $pass;
}
$dataForDB = new dataForDataBase();
$dataForDB->host = "db";
$dataForDB->db = "web";
$dataForDB->user = "root";
$dataForDB->pass= "qwerty";
$dsn = "mysql:host=$dataForDB->host;dbname=$dataForDB->db;"; //задаем свойства для БД
$opt = [  //
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = createPDO($dsn, $dataForDB->user, $dataForDB->pass, $opt); //объект подлючения к БД
$stmt = $pdo->query("SELECT * FROM `ad`;"); //запрос для получения всех объявлений
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>lab_5/8</title>
</head>
<body>
<div class="advertisements">
    <div class="formForAdvertisements">
        <form action="" method="POST" class="form">
            <div class="emailContainer container">
                <input type="text" name="email"> Электронная почта
            </div>
            <div class="categoryContainer container">
                <input type="text" name="category"> Категория
            </div>
            <div class="headerContainer container">
                <input type="text" name="header"> Заголовок
            </div>
            <div class="contentContainer container">
                <input type="text" name="content"> Текст объявления
            </div>
            <input class="advertisementBtn" type="submit" name="btn" value="AddAdvertisement">
        </form>
    </div>
    <div class="advertisementsField">
        <table class="advertisementsTable">
            <tr class="tableRow">
                <th class="tableHeader">ID</th>
                <th class="tableHeader">Электронная почта</th>
                <th class="tableHeader">Заголовок</th>
                <th class="tableHeader">Текст</th>
                <th class="tableHeader">Категория</th>
                <th class="tableHeader">Время добавления</th>
            </tr>
            <?php
            $arrStrTable = buildTable($stmt); //массив подготовленных для вывода строк
            printTable($arrStrTable); //отрисовка таблицы
            checkData($pdo); //проверка введенных полей на пустоту

            function createPDO($dsn, $user, $password, $opt) { //функция создания объекта подключения
                return new PDO($dsn, $user, $password, $opt);
            }

            function buildTable($stmt) { //функция построения таблицы
                $arrOfStrRows = []; //массив подготовленных для вывода строк
                while ($arrOfRows = $stmt->fetch()) { //пока есть строки
                    $strRow = '<tr class="tableRow">'; //формируем временную строку
                    foreach ($arrOfRows as $row) { // проходимся по всем полям таблицы
                        $strRow .= '<td class="tableCell">' . $row . '</td>'; // и добавляем в временную строку
                    }
                    $strRow .= '</tr>'; //заканчиваем формирование строки
                    array_push($arrOfStrRows, $strRow); //добавляем строку в массив
                }
                return $arrOfStrRows;
            }

            function printTable($arrStrTable) { //функция отрисовки таблицы
                foreach ($arrStrTable as $strTable) { //проходимся по всем элементам массива подготовленных строк
                    echo $strTable; //отрисовываем строку
                }
            }

            function checkData($pdo) //функция проверки заполнения полей формы
            {
                if (isset($_POST['btn'])) {
                    addDataToDB($pdo, $_POST['email'], $_POST['category'], $_POST['header'], $_POST['content']);
                }
            }
            function addDataToDB($pdo, $email, $category, $header, $content) { //функция добавления данных в БД
                switch ($_POST['btn']) {
                    case 'AddAdvertisement':

                        if ($email && $category && $header && $content) {
                            $stmt = $pdo->prepare('INSERT ad (category, title, description, email) VALUES (:category, :title, :description, :email)'); //готовим SQL запрос
                            $stmt->execute(array('category' => $category, 'title' => $header, 'description' => $content, 'email' => $email));

                        }
                }
            }


            ?>
        </table>
    </div>
</div>
</body>
</html>
