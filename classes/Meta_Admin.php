<?php

abstract class Meta_Admin //Класс,отвечающий за управление административной частью.
{

    protected $db;

// Установка соединения с БД
    public function __construct()
    {
        if (!$_SESSION['user']) {
            header("Location:?option=login");
        }
        $this->db = mysqli_connect(HOST, USER, PASSWORD, DB);
        if (!$this->db) {
            exit("Ошибка соединения с базой данных" . mysqli_error());
        }
        mysqli_query($this->db, "SET NAMES 'utf8'");
    }

// Вывод шапки сайта
    protected function get_header()
    {
        include "header.php";
    }

// Вывод меню административной части
    protected function get_menu()
    {

        echo '<nav>
      <ul class="topmenu">
        <li><a href="?option=admin_main">Главная</a></li>  
        <li><a href="?option=admin_articles">Статьи</a></li>  
        <li><a href="?option=admin_tests" >Тесты</a></li> 
        <li><a href="?option=main">Выйти</a></li>  
      </ul>
   </nav>';
    }

//Метод вывода основной структуры административной части
    public function get_body()
    {
        if ($_POST || $_GET['del']) {
            $this->form_processor(); // Метод для обработки данных для форм
        }
        $this->get_header();
        $this->get_menu();
        $this->get_content();

    }

// Метод вывода содержания дочерних классов административной части
    abstract function get_content();

// Метод для вывода выпадающего списка категорий статей для формы класса add_articles и update_article
    protected function get_article_categories()
    {
        $query = "SELECT idcategory_article, category_article_name FROM category_article";
        $result = mysqli_query($this->db, $query);
        if (!$result) {
            exit(mysqli_error());
        }
        $row = array();
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row[] = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        return $row;
    }
// Метод, который выбирает данные для класса update_article
    protected function get_text_article($id_text)
    {
        $query = "SELECT idarticle,article_title,article_description,article_text,idcategory_article FROM article WHERE idarticle='$id_text'";
        $result = mysqli_query($this->db, $query);
        if (!$result) {
            exit(mysqli_error());
        }
        $row = array();
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return $row;
    }
// Метод для класса update_article_category
    protected function get_category_article($id_category)
    {
        $query = "SELECT idcategory_article, category_article_name FROM category_article WHERE idcategory_article='$id_category'";
        $result = mysqli_query($this->db, $query);
        if (!$result) {
            exit(mysqli_error());
        }
        $row = array();
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return $row;
    }
// Метод для получения категорий тестов (класс add_test)
    protected function get_test_categories()
    {
        $query = "SELECT idcategory_test, category_test_name FROM category_test";
        $result = mysqli_query($this->db, $query);
        if (!$result) {
            exit(mysqli_error());
        }
        $row = array();
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row[] = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        return $row;
    }
// Метод для получения идентификатора теста, который добавляется, чтобы привязать к нему вопросы (для класса add_test_part2)
    protected function get_test_id()
    {
        $query = "SELECT idtest FROM test ORDER BY idtest DESC LIMIT 1";
        $result = mysqli_query($this->db, $query);
        if (!$result) {
            exit(mysqli_error());
        }
        $idtest = mysqli_fetch_assoc($result)['idtest'];
        return $idtest;
    }
//Метод для получения идентификатора вопроса, который добавляется, чтобы привязать к нему ответы и значения (для класса add_test_part3)
    protected function get_question_id()
    {
        $query = "SELECT idquestion FROM questions ORDER BY idquestion DESC LIMIT 1";
        $result = mysqli_query($this->db, $query);
        if (!$result) {
            exit(mysqli_error());
        }
        $idquestion = mysqli_fetch_assoc($result)['idquestion'];
        return $idquestion;
    }
/*
    protected function get_test_data($id_text)
    {
        $query = "SELECT idtest,test_name,test_description,test_instruction,test_results FROM test WHERE idtest='$id_text'";
        $result = mysqli_query($this->db, $query);
        if (!$result) {
            exit(mysqli_error());
        }
        $row = array();
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return $row;
    }
*/
// Метод для класса update_test_category
    protected function get_test_category($id_category)
    {

            $query = "SELECT idcategory_test, category_test_name FROM category_test WHERE idcategory_test='$id_category'";
            $result = mysqli_query($this->db, $query);
            if (!$result) {
                exit(mysqli_error());
            }
            $row = array();
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            return $row;

    }
    /*
    protected function get_answers_and_questions($id_text)
    {
        $query = "SELECT q.idquestion, q.question,q.idtest,a.id,a.answer,a.parent_question,a.value
    FROM questions q
    INNER JOIN test
    ON test.idtest = q.idtest
    INNER JOIN answers a 
    ON a.parent_question = q.idquestion
    WHERE test.idtest = $id_text";
        $result = mysqli_query($this->db, $query);
        $answers_and_questions = null;
        while ($row = mysqli_fetch_assoc($result)) {
            if (!$row['parent_question']) return false;
            $answers_and_questions[$row['parent_question']][0] = $row['question'];
            $answers_and_questions[$row['parent_question']][$row['id']] = $row['answer'];
        }
        return $answers_and_questions;
    }
    */
}