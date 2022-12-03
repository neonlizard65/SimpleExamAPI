<?php

//Multiple choice
class Question
{
    // подключение к базе данных
    private $conn;

    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function get_mp(){
        // запрос
        $query = "SELECT q.QuestionID, c.CategoryName, m.CategoryId, m.Question, m.Choice1, m.Choice2, m.Choice3, m.Choice4, m.Choice5, m.RightChoice, m.ImagePath 
        FROM `question` AS q 
        LEFT JOIN multiplechoice AS m ON q.QuestionID = m.QuestionID 
        LEFT JOIN category AS c ON m.CategoryId = c.CategoryID
        WHERE m.Question IS NOT NULL";
            
        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();
        return $stmt;
    }
    public function get_ex(){
        // запрос
        $query = "SELECT q.QuestionID, c.CategoryName, e.CategoryId, e.Question, e.ImagePath 
        FROM `question` AS q 
        LEFT JOIN extendedanswer AS e ON q.QuestionID = e.QuestionID 
        LEFT JOIN category AS c ON e.CategoryId = c.CategoryID
        WHERE e.Question IS NOT NULL";
            
        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();
        return $stmt;
    }
}
?>