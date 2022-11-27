<?php

//Multiple choice
class ExtQuestion
{
    // подключение к базе данных
    private $conn;
    private $table_name = "extendedanswer";

    // свойства объекта
    public $QuestionID;
    public $Question;
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
        $this->CategoryId = $row["CategoryId"];
        $this->ImagePath = $row["ImagePath"];
    }
}