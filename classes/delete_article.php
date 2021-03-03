<?php
class delete_article extends Meta_Admin { // Класс,отвечающий за удаление статей
    public function form_processor() {
        if($_GET['del']) {
            $id_text = (int)$_GET['del'];

            $query = "DELETE FROM article WHERE idarticle='$id_text'";

            if(mysqli_query($this->db,$query)) {
                $_SESSION['res'] = "Удалено";
                header("Location:?option=admin_articles");
                exit();
            }
            else {
                exit("Ошибка удаления");
            }
        }
        else {
            exit("Не верные данные для этой страницы");
        }
    }

    public function get_content() {

    }
}
?>