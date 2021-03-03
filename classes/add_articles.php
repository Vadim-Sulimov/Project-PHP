<?php

class add_articles extends Meta_Admin // Класс, отвечающий за добавление статей
{

    protected function form_processor()
    {
        if (!empty($_FILES['img_src']['tmp_name'])) {
            if (!move_uploaded_file($_FILES['img_src']['tmp_name'], 'images/' . $_FILES['img_src']['name'])) {
                exit("Не удалось загрузить изображение");
            }
            $img_src = 'images/' . $_FILES['img_src']['name'];
        } else {
            exit("Необходимо загрузить изображение");
        }
        $title = $_POST['article_title'];
        $date = date("Y-m-d", time());
        $description = $_POST['article_description'];
        $text = $_POST['article_text'];
        $category = $_POST['category'];

        if (empty($title) || empty($text) || empty($description)) {
            exit("Не заполнены обязательные поля");
        }
        $query = " INSERT INTO article
						(article_title,article_image,article_date,article_text,article_description,idcategory_article)
					VALUES ('$title','$img_src','$date','$text','$description','$category')";
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
        $article_category = $this->get_article_categories();

        print <<<HEREDOC
<form enctype='multipart/form-data' action='' method='POST'>
<p>Заголовок статьи:<br />
<input type='text' name='article_title' style='width:420px;'>
</p>
<p>Изображение:<br />
<input type='file' name='img_src'>
</p>
<p>Краткое описание:<br />
<textarea name='article_description' cols='50' rows='7'></textarea>
</p>
<p>Текст:<br />
<textarea name='article_text' cols='50' rows='7'></textarea>
</p>
<select name='category'>
HEREDOC;
        foreach ($article_category as $item) {
            echo "<option value='" . $item['idcategory_article'] . "'>" . $item['category_article_name'] . "</option>";
        }
        echo "</select><p><input type='submit' name='button' value='Сохранить'></p></form>
        </div>
</div>";
    }
}