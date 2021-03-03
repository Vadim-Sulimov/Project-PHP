<?php
class update_test_category extends Meta_Admin //Класс для редактирования категорий тестов
{

    protected function form_processor()
    {

        $id = $_POST['id'];
        $text = $_POST['category_test_name'];
        if (empty($text)) {
            exit("Не заполнены обязательные поля");
        }
        $query = "UPDATE category_test SET category_test_name='$text' WHERE idcategory_test='$id'";
        if (!mysqli_query($this->db, $query)) {
            exit(mysqli_error());
        } else {
            $_SESSION['res'] = "Изменения сохранены";
            header("Location:?option=admin_tests");
            exit;
        }
    }

    public function get_content()
    {
        if ($_GET['id_text']) {
            $id_category = (int)$_GET['id_text'];
        } else {
            exit('Не правильные данные для этой страницы');
        }
        $category = $this->get_test_category($id_category);
        echo "<div id ='main'>";
        if ($_SESSION['res']) {
            echo $_SESSION['res'];
            unset($_SESSION['res']);
        }
        print <<<HEREDOC
<form action='' method='POST'>
<p>Название категории:<br />
<input type='text' name='category_test_name' style='width:420px;' value='$category[category_test_name]'>
<input type='hidden' name='id' style='width:420px;' value='$category[idcategory_test]'>
</p>
<p><input type='submit' name='button' value='Сохранить'></p></form>
</div>
HEREDOC;
    }
}