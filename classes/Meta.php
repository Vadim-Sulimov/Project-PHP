<?php

abstract class Meta //Класс,отвечающий за управление пользовательской частью.
{

    protected $db;

// Установка соединения с БД
    public function __construct()
    {
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

// Вывод меню (Пункты меню и выпадающее меню с категориями)
    protected function get_menu()
    {
        $query = "SELECT idcategory_test,category_test_name FROM category_test";
        $result = mysqli_query($this->db, $query);
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) ;
        echo '<nav>
      <ul class="topmenu">
        <li><a href="?option=main">Главная</a></li>  
        <li><a href="" class="submenu-link">Тесты</a>
        <ul class="submenu">';
        foreach ($data as $item) {
            printf("
            <li><a href='?option=category&idcategory_test=%s'>%s</a></li>",
                $item['idcategory_test'], $item['category_test_name']);
        }
        echo '</li></ul>';
        echo '<li><a href="" class="submenu-link">Статьи</a>
        <ul class="submenu">';
        $query = "SELECT idcategory_article,category_article_name FROM category_article";
        $result = mysqli_query($this->db, $query);
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) ;
        foreach ($data as $item) {
            printf("
            <li><a href='?option=category&idcategory_article=%s'>%s</a></li>",
                $item['idcategory_article'], $item['category_article_name']);
        }

        echo '
</li></ul>';
        echo '<li><a href="?option=login">Авторизация</a>';
        echo '</ul>
    </nav>';
    }

//Метод вывода основной структуры пользовательской части
    public function get_body()
    {
        if ($_POST) {
            $this->processor();
        }
        $this->get_header();
        $this->get_menu();
        $this->get_content();

    }

// Метод вывода содержания дочерних классов пользовательской части
    abstract function get_content();

    protected function pagination($count_questions, $test_data)
    {
        $keys = array_keys($test_data);
        $pagination = '<div class="pagination">';
        for ($i = 1; $i <= $count_questions; $i++) {
            $key = array_shift($keys);
            if ($i == 1) {
                $pagination .= '<a class="nav-active" href="#question-' . $key . '">' . $i . '</a>';
            } else {
                $pagination .= '<a href="#question-' . $key . '">' . $i . '</a>';
            }
        }
        $pagination .= '</div>';
        return $pagination;
    }

    protected function processor()
    {

        if (isset($_POST['test'])) {
            $test = (int)($_POST['test']);
            unset($_POST['test']);
            $answers = $this->get_answers($test);
            if (!is_array($answers)) exit('Error');
            $test_result = $this->get_test_result($test);
            $points = $this->get_points($answers);
            printf("<div class='block'>
<h2>Количество баллов: $points</h2><hr>
<h3>Интерпретация:</h3>
<p>$test_result</p>
</div>");
            die;
        }
    }

    protected function get_answers($test)
    {
        if (!$test) return false;
        global $db;
        $query = "SELECT a.id AS answer_id, a.value
FROM answers a 
INNER JOIN questions 
ON questions.idquestion = a.parent_question 
WHERE questions.idtest = $test";
        $res = mysqli_query($db, $query);
        $data = null;
        while ($row = mysqli_fetch_assoc($res)) {
            $data[$row['answer_id']] = $row['value'];
        }
        return $data;
    }

    protected function get_test_result($test)
    {
        global $db;
        $query = "SELECT test_results 
FROM test
WHERE test.idtest = $test";
        $res = mysqli_query($db, $query);
        $row = null;
        while ($row = mysqli_fetch_assoc($res)) {
            $test_result = $row['test_results'];
        }
        return $test_result;

    }

    protected function get_points($answers)
    {
        $pre_result = array();
        foreach ($_POST as $v)
            array_push($pre_result, $answers[$v]);
        $points = array_sum($pre_result);
        return $points;
    }
}
