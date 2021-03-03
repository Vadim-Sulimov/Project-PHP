<?php

class add_test_part3 extends Meta_Admin
{

    protected function form_processor()
    {
        $idquestion = $this->get_question_id();
        $answer = $_POST['answer'];
        $value = $_POST['value'];

        if (empty($answer) || empty($value)) {
            exit("Не заполнены обязательные поля");
        }
        if (!is_numeric($value)){
            $_SESSION['res'] = "Введите число в поле 'Value'";
            header("Location:?option=add_test_part3");
            exit;
        }
        $query = "INSERT INTO answers
(answer,value,parent_question )
VALUES ('$answer','$value','$idquestion')";
        if (!mysqli_query($this->db, $query)) {
            exit(mysqli_error());
        } else {
            $_SESSION['res'] = "Изменения сохранены";
            header("Location:?option=add_test_part3");
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
        <p>Введите вариант ответа:<br />
        <textarea name='answer' cols='50' rows='7'></textarea>
        </p>
        <p>Введите значение(баллов за ответ,ввести можно только число):<br />
        <textarea name='value' cols='50' rows='7'></textarea>
        </p>
        <p><input type='submit' name='button' value='Сохранить и ввести следующий вариант ответа'></p>
        </form>
        <button><a class='link' href = '?option=add_test_part2'>Ввести следующий вопрос</a></button>
        <button><a class='link' href = '?option=admin_tests'>Закончить добавление теста</a></button>
</div>
HEREDOC;
    }
}