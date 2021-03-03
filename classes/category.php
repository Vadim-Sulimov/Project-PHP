<?php

class category extends Meta // Класс,отвечающий за отображение статей и тестов, принадлежащих к выбранной категории.
{
    public function get_content()
    {
        if ($_GET['idcategory_article']) {
            $idcategory_article = (int)$_GET['idcategory_article'];
            if (!$idcategory_article) {
                echo 'Невозможно отобразить статью. Неправильные исходные данные';
            } else {
                $query = "SELECT idarticle, article_title, article_description, article_date, article_image FROM article
WHERE idcategory_article = '$idcategory_article'";
                $result = mysqli_query($this->db, $query);
                if (!$result) {
                    exit(mysqli_error());
                }

                echo '<div id = "main">';

                $row = array();
                for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    printf("<div class='block'>
<p>%s</p>
<p>%s</p>
<p><img src = '%s'>%s</p>
<button class='btn' id='btn'><a class='link' href = '?option=view_article&idarticle=%s'>Читать далее...</a></button>
</div>", $row['article_title'], $row['article_date'], $row['article_image'], $row['article_description'], $row['idarticle']);

                }
                echo '</div>
     </div>';
            }
        } elseif ($_GET['idcategory_test']) {
            $idcategory_test = (int)$_GET['idcategory_test'];
            if (!$idcategory_test) {
                echo 'Невозможно отобразить тест. Неправильные исходные данные';
            } else {
                $query = "SELECT idtest, test_name, test_description FROM test
WHERE idcategory_test = '$idcategory_test'";
                $result = mysqli_query($this->db, $query);
                if (!$result) {
                    exit(mysqli_error());
                }

                echo '<div id = "main">';

                $row = array();
                for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    printf("<div class='block'>
<h3>%s</h3>
<p>%s</p>
<button class='btn' id='btn'><a class='link' href = '?option=view_test&idtest=%s'>Пройти тест...</a></button>
</div>", $row['test_name'], $row['test_description'], $row['idtest']);

                }
                echo '</div>
     </div>';
            }
        } else {
            echo 'Невозможно отобразить. Неправильные исходные данные';
        }
    }
}

