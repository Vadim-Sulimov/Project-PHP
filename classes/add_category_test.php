<?php

class add_category_test extends Meta_Admin
{ // Класс, отвечающий за добавление категорий тестов

    protected function form_processor()
    {

        $text = $_POST['test_category'];


        if (empty($text)) {
            exit("Не заполнены обязательные поля");
        }
        $query = " INSERT INTO category_test
						(category_test_name)
					VALUES ('$text')";
        if (!mysqli_query($this->db, $query)) {
            exit(mysqli_error());
        } else {
            $_SESSION['res'] = "Изменения сохранены";
            header("Location:?option=admin_articles");
            exit;
        }
    }

    public function get_content()
    {
        echo "<div id ='main'>";
        if ($_SESSION['res']) {
            echo $_SESSION['res'];
            unset($_SESSION['res']);
        }
        print <<<HEREDOC
<form action='' method='POST'>
<p>Название категории:<br/>
<input type='text' name='test_category' style='width:420px;'>
</p>
<p><input type='submit' name='button' value='Сохранить'></p></form>
HEREDOC;
        echo "</div>";
    }
}