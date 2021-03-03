<?php

class login extends Meta // Класс, отвечающий за авторизацию
{


    protected function processor()
    {
        $login = clean($_POST['login']);
        $password = clean($_POST['password']);
        if (!empty($login) and !empty($password)) {
            $password = md5($password);

            $query = "SELECT id_user FROM users WHERE login='$login' AND password = '$password'";

            $result = mysqli_query($this->db, $query);

            if (!$result) {
                exit(mysqli_error());
            }

            if (mysqli_num_rows($result) == 1) {
                $_SESSION['user'] = TRUE;
                header("Location:?option=admin_main");
                exit();
            } else {
                exit("такого пользователя нет");
            }

        } else {
            exit("Заполните обязательные поля");
        }
    }


    public function get_content()
    {

        echo '<div id="main">';

        print <<<HEREDOC
<form enctype='multipart/form-data' action='' method='POST'>
<p>Логин:<br />
<input type='text' name='login'>
</p>
<p>Пароль:<br />
<input type='password' name='password'>
</p>
<p><input type='submit' name='button' value='Войти'></p></form>
HEREDOC;
        echo '</div>
			</div>';
    }
}