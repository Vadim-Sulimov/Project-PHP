<?php

class admin_main extends Meta_Admin // Класс, отвечающий за вывод главной страницы административной части
{
    public function get_content()
    {
        echo "<div id ='main'>";
        echo '<div class="admin_main">Здравствуйте, Вы находитесь в разделе Администратор. В подразделе "Статьи" Вы можете добавлять, удалять, а также редактировать уже существующие статьи и категории статей.
В разделе "Тесты"-добавлять тесты и категории тестов. Пункт меню "Выход" - выход в пользовательскую часть.';
        if ($_SESSION['res']) {
            echo $_SESSION['res'];
            unset($_SESSION['res']);
        }
        echo "</div>
</div>";
    }
}