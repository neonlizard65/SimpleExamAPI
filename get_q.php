<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=utf-8");

// подключение файла для соединения с базой и файл с объектом
include_once "dbconfig.php";
include_once "mpq.php";
include_once "extq.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$mpq = new MPQuestion($db);
$extq = new ExtQuestion($db);

$id = isset($_GET["id"]) ? $_GET["id"] : die();

if($id >= 77){
    // установим свойство ID записи для чтения
    $extq->QuestionID = $id;
    // получим детали 
    $extq->readOne();

    if ($extq->Question != null) {

        // создание массива
        $extq_arr = array(
            "QuestionID" =>  $extq->QuestionID,
            "Question" => $extq->Question,
            "CategoryId" => $extq->CategoryId,
            "ImagePath" => $extq->ImagePath
        );

        // код ответа - 200 OK
        http_response_code(200);

        // вывод в формате json
        echo json_encode($extq_arr);
    }
}
else if ($id > 0 && $id < 77)
{
    // установим свойство ID записи для чтения
    $mpq->QuestionID = $id;
    // получим детали 
    $mpq->readOne();

    if ($mpq->Choice1 != null) {

        // создание массива
        $mpq_arr = array(
            "QuestionID" =>  $mpq->QuestionID,
            "Question" => $mpq->Question,
            "Choice1" => $mpq->Choice1,
            "Choice2" => $mpq->Choice2,
            "Choice3" => $mpq->Choice3,
            "Choice4" => $mpq->Choice4,
            "Choice5" => $mpq->Choice5,
            "RightChoice" => $mpq->RightChoice,
            "CategoryId" => $mpq->CategoryId,
            "ImagePath" => $mpq->ImagePath
        );

        // код ответа - 200 OK
        http_response_code(200);

        // вывод в формате json
        echo json_encode($mpq_arr);
    }
} 
else {
    // код ответа - 404 Не найдено
    http_response_code(404);

    // сообщим пользователю, что такой вопрос не существует
    echo json_encode(array("message" => "Вопрос не существует"), JSON_UNESCAPED_UNICODE);
}
?>