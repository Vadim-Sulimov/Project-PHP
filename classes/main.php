<?php

class main extends Meta //Класс, отвечающий за вывод содержимого главной страницы пользовательской части. Ее содержимое - краткое описание статей с картинками.
{
    public function get_content()
    {
        $page = (empty($_GET['page']) ? 1 : intval($_GET['page'])); // Пагинация
        $notesOnPage = 5;
        $from = ($page - 1) * $notesOnPage;
        $query = "SELECT idarticle, article_title, article_description, article_date, article_image FROM article
WHERE idarticle > 0 LIMIT $from,$notesOnPage";
        $result = mysqli_query($this->db, $query);
        if (!$result) {
            exit(mysqli_error());
        }
        $query = "SELECT COUNT(*) as count FROM article";
        $result2 = mysqli_query($this->db, $query);
        if (!$result2) {
            exit(mysqli_error());
        }
        $count = mysqli_fetch_assoc($result2)['count'];
        $pagesCount = ceil($count / $notesOnPage);
        echo '<div class="pagination-article">';
        for ($i = 1; $i <= $pagesCount; $i++) {
            printf("<a href='?page=$i'>$i</a>");
        }
        echo '</div>';
        $data = null;
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) ;

        echo '<div id = "main">';
        foreach ($data as $row) {
            printf("<div class='block'>
<p>%s</p>
<p>%s</p>
<p><img src = '%s'>%s</p>
<button class='btn' id='btn'><a class='link' href  ='?option=view_article&idarticle=%s'>Читать далее...</a></button>
</div>", $row['article_title'], $row['article_date'], $row['article_image'], $row['article_description'], $row['idarticle']);

        }
        echo '</div>';
    }
}
