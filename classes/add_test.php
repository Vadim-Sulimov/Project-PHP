<?php

class add_test extends Meta_Admin // Класс,отвечающий за добавление тестов, часть первая (имя,описание,инструкция,результат,категория)
{

    protected function form_processor()
    {

        $name = $_POST['test_name'];
        $description = $_POST['test_description'];
        $instruction = $_POST['test_instruction'];
        $test_results = $_POST['test_results'];
        $category = $_POST['category'];

        if (empty($name) || empty($instruction) || empty($description) || empty($test_results)) {
            exit("Не заполнены обязательные поля");
        }
        $query = " INSERT INTO test
						(test_name,test_description,test_instruction,test_results,idcategory_test)
					VALUES ('$name','$description','$instruction','$test_results','$category')";
        if (!mysqli_query($this->db, $query)) {
            exit(mysqli_error());
        } else {
            $_SESSION['res'] = "Изменения сохранены";
            header("Location:?option=add_test_part2");
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
        $test_category = $this->get_test_categories();

        print <<<HEREDOC
<form action='' method='POST'>
<p>Название теста:<br />
<input type='text' name='test_name' >
</p>
<p>Краткое описание:<br />
<textarea name='test_description' cols='50' rows='7'></textarea>
</p>
<p>Инструкция:<br />
<textarea name='test_instruction' cols='50' rows='7'></textarea>
</p>
<p>Результат:<br />
<textarea name='test_results' cols='50' rows='7'></textarea>
</p>
<select name='category'>
HEREDOC;
        foreach ($test_category as $item) {
            echo "<option value='" . $item['idcategory_test'] . "'>" . $item['category_test_name'] . "</option>";
        }
        echo "</select><p><input type='submit' name='button' value='Сохранить и перейти к добавлению вопросов и ответов'></p></form>
        </div>
</div>";
    }
}