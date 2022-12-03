<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=utf-8");

// подключение файла для соединения с базой и файл с объектом
include_once "dbconfig.php";
include_once "question.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();
$question = new Question($db);


$mpq = $question->get_mp();
$exq = $question->get_ex();

$num = $mpq->rowCount() + $exq->rowCount();

if($num > 0){
    $question_array = array();
    $question_array["multiplechoice"] = array();
    $question_array["multiplechoice"]["architecture"] = array();
    $question_array["multiplechoice"]["network"] = array();
    $question_array["multiplechoice"]["os"] = array();
    $question_array["extendedanswer"] = array();
    $question_array["extendedanswer"]["architecture"] = array();
    $question_array["extendedanswer"]["network"] = array();
    $question_array["extendedanswer"]["os"] = array();

    while($row = $mpq->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $question_item = array(
            "QuestionID" => $QuestionID,
            "CategoryName" => $CategoryName,
            "CategoryId" => $CategoryId,
            "Question" => $Question,
            "Choice1" => $Choice1,
            "Choice2" => $Choice2,
            "Choice3" => $Choice3,
            "Choice4" => $Choice4,
            "Choice5" => $Choice5,
            "RightChoice" => $RightChoice,
            "ImagePath" => $ImagePath
        );
        if($question_item["CategoryId"] == 1){
            array_push($question_array["multiplechoice"]["architecture"], $question_item);
        } 
        else if($question_item["CategoryId"] == 2){
            array_push($question_array["multiplechoice"]["network"], $question_item);
        } 
        else if($question_item["CategoryId"] == 3){
            array_push($question_array["multiplechoice"]["os"], $question_item);
        }
    }
    while($row = $exq->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $question_item = array(
            "QuestionID" => $QuestionID,
            "CategoryName" => $CategoryName,
            "CategoryId" => $CategoryId,
            "Question" => $Question,
            "ImagePath" => $ImagePath
        );
        if($question_item["CategoryId"] == 1){
            array_push($question_array["extendedanswer"]["architecture"], $question_item);
        } 
        else if($question_item["CategoryId"] == 2){
            array_push($question_array["extendedanswer"]["network"], $question_item);
        } 
        else if($question_item["CategoryId"] == 3){
            array_push($question_array["extendedanswer"]["os"], $question_item);
        }
    }
    http_response_code(200);
    echo json_encode($question_array);
}
else {
    // код ответа - 404 Не найдено
    http_response_code(404);
    echo("Не найдено");
}
?>