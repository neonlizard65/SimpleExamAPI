<?php

//Multiple choice
class MPQuestion
{
    // подключение к базе данных
    private $conn;
    private $table_name = "multiplechoice";

    // свойства объекта
    public $QuestionID;
    public $Question;
    public $Choice1;
    public $Choice2; 
    public $Choice3; 
    public $Choice4;
    public $Choice5;
    public $RightChoice;
    public $CategoryId;
    public $ImagePath;


    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readOne(){
        // запрос для чтения одной записи 
    $query = "SELECT * FROM " . $this->table_name . " WHERE QuestionID = ? LIMIT 0,1";
        
    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // привязываем id, который будет получен
    $stmt->bindParam(1, $this->QuestionID);

    // выполняем запрос
    $stmt->execute();

    // получаем извлеченную строку
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // установим значения свойств объекта
    $this->Question = $row["Question"];
    $this->Choice1 = $row["Choice1"];
    $this->Choice2 = $row["Choice2"];
    $this->Choice3 = $row["Choice3"];
    $this->Choice4 = $row["Choice4"];
    $this->Choice5 = $row["Choice5"];
    $this->RightChoice = $row["RightChoice"];
    $this->CategoryId = $row["CategoryId"];
    $this->ImagePath = $row["ImagePath"];
    }
}
?>