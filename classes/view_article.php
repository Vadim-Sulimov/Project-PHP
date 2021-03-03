<?php
class view_article extends Meta// Класс, отвечающий за отображение выбранной статьи в полном, развернутом виде.
{
    public function get_content()
    {
        echo '<div id = "main">';
        if (!$_GET['idarticle']) {
            echo 'Невозможно отобразить статью. Неправильные исходные данные';
        } else {
            $idarticle = (int)$_GET['idarticle'];
            if (!$idarticle) {
                echo 'Невозможно отобразить статью. Неправильные исходные данные';
            } else {
                $query = "SELECT idarticle,article_title,article_description,article_text,article_date,article_image FROM article
WHERE idarticle = '$idarticle'";
                $result = mysqli_query($this->db, $query);
                if (!$result) {
                    exit(mysqli_error());
                }
            }
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            printf("<p>%s</p>
                    <p>%s</p>
                    <p>%s</p>
                    <p><img src = '%s'>%s</p>",
                $row['article_title'],$row['article_date'],$row['article_description'],$row['article_image'],$row['article_text']);
            echo '</div>';
        }
    }
}