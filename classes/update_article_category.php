<?php

class update_article_category extends Meta_Admin //Класс,отвечающий за редактирование категорий статей
{

    protected function form_processor()
    {

        $id = $_POST['id'];
        $text = $_POST['category_article_name'];
        if (empty($text)) {
            exit("Не заполнены обязательные поля");
        }
        $query = "UPDATE category_article SET category_article_name='$text' WHERE idcategory_article='$id'";
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
        if ($_GET['id_text']) {
            $id_category = (int)$_GET['id_text'];
        } else {
            exit('Не правильные данные для этой страницы');
        }
        $category = $this->get_category_article($id_category);
        echo "<div id ='main'>";
        if ($_SESSION['res']) {
            echo $_SESSION['res'];
            unset($_SESSION['res']);
        }
        print <<<HEREDOC
<form action='' method='POST'>
<p>Название категории:<br />
<input type='text' name='category_article_name' style='width:420px;' value='$category[category_article_name]'>
<input type='hidden' name='id' style='width:420px;' value='$category[idcategory_article]'>
</p>
<p><input type='submit' name='button' value='Сохранить'></p></form>
</div>
HEREDOC;
    }
}