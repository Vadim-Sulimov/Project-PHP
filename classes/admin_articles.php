<?php

class admin_articles extends Meta_Admin // Класс, овечающий за вывод панели, отображающей все операции (добавление,удаление,редактирование) со статьями и категориями статей.
{
    public function get_content()
    {
        $query = "SELECT idarticle, article_title FROM article"; // Вывод операций со статьями
        $result = mysqli_query($this->db, $query);
        if (!$result) {
            exit(mysqli_error());
        }
        echo "<div class='block-left'>";
        echo "<a class='add' href='?option=add_articles'>Добавить новую статью </a><hr>";
        $row = array();
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            printf("<p>
						<a href='?option=update_article&id_text=%s'>%s</a> |
						<a class='delete' href='?option=delete_article&del=%s'>Удалить</a>
					</p>", $row['idarticle'], $row['article_title'], $row['idarticle']);
        }
        echo "</div>";
        $query = "SELECT idcategory_article, category_article_name FROM category_article"; // Вывод операций с категориями статей
        $result = mysqli_query($this->db, $query);
        if (!$result) {
            exit(mysqli_error());
        }
        echo "<div class='block-right'>";
        echo "<a class='add' href='?option=add_category_article'>Добавить новую категорию</a><hr>";
        $row = array();
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            printf("<p style='font-size:14px;'>
						<a href='?option=update_article_category&id_text=%s'>%s</a> 
					</p>", $row['idcategory_article'], $row['category_article_name'], $row['idcategory_article']);

        }
        echo "</div>";
    }
}
