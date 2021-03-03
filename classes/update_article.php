<?php

class update_article extends Meta_Admin // Класс, отвечающий за редактирование статей
{

    protected function form_processor()
    {
        if (!empty($_FILES['img_src']['tmp_name'])) {
            if (!move_uploaded_file($_FILES['img_src']['tmp_name'], 'images/' . $_FILES['img_src']['name'])) {
                exit("Не удалось загрузить изображение");
            }
            $img_src = 'images/' . $_FILES['img_src']['name'];
        }
        $id = $_POST['id'];
        $title = $_POST['article_title'];
        $date = date("Y-m-d", time());
        $description = $_POST['article_description'];
        $text = $_POST['article_text'];
        $category = $_POST['category'];

        if (empty($title) || empty($text) || empty($description)) {
            exit("Не заполнены обязательные поля");
        }
        $query = "UPDATE article SET article_title='$title',article_image='$img_src',article_date='$date',article_text='$text',article_description='$description',idcategory_article='$category' WHERE idarticle='$id'";
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
            $id_text = (int)$_GET['id_text'];
        } else {
            exit('Не правильные данные для этой страницы');
        }
        $text = $this->get_text_article($id_text);
        echo "<div id ='main'>";
        if ($_SESSION['res']) {
            echo $_SESSION['res'];
            unset($_SESSION['res']);
        }
        $article_category = $this->get_article_categories();

        print <<<HEREDOC
<form enctype='multipart/form-data' action='' method='POST'>
<p>Заголовок статьи:<br />
<input type='text' name='article_title' style='width:420px;' value='$text[article_title]'>
<input type='hidden' name='id' style='width:420px;' value='$text[idarticle]'>
</p>
<p>Изображение:<br />
<input type='file' name='img_src'>
</p>
<p>Краткое описание:<br />
<textarea name='article_description' cols='50' rows='7'>$text[article_description]</textarea>
</p>
<p>Текст:<br />
<textarea name='article_text' cols='50' rows='7'>$text[article_text]</textarea>
</p>
<select name='category'>
HEREDOC;
        foreach ($article_category as $item) {
            if ($text['idcategory_article'] == $item['idcategory_article']) {
                echo "<option selected value='" . $item['idcategory_article'] . "'>" . $item['category_article_name'] . "</option>";
            } else {
                echo "<option value='" . $item['idcategory_article'] . "'>" . $item['category_article_name'] . "</option>";
            }
        }
        echo "</select><p><input type='submit' name='button' value='Сохранить'></p></form>
        </div>
</div>";
    }
}