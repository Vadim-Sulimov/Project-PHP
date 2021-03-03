<?php

class admin_tests extends Meta_Admin // Класс, овечающий за вывод панели, отображающей все операции (добавление,удаление,редактирование) с тестами и категориями тестов.
{
    public function get_content()
    {
        $query = "SELECT idtest, test_name FROM test"; // Вывод добавления теста
        $result = mysqli_query($this->db, $query);
        if (!$result) {
            exit(mysqli_error());
        }
        echo "<div class='block-left'>";
        echo "<a class='add' href='?option=add_test'>Добавить новый тест </a><hr>";
        echo "</div>";
        $query = "SELECT idcategory_test, category_test_name FROM category_test"; // Вывод операций с категориями тестов
        $result = mysqli_query($this->db, $query);
        if (!$result) {
            exit(mysqli_error());
        }
        echo "<div class='block-right'>";
        echo "<a class='add' href='?option=add_category_test'>Добавить новую категорию</a><hr>";
        $row = array();
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            printf("<p style='font-size:14px;'>
						<a href='?option=update_test_category&id_text=%s'>%s</a>
					</p>", $row['idcategory_test'], $row['category_test_name'], $row['idcategory_test']);

        }
        echo "</div>";
    }
}