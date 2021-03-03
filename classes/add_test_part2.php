<?php
class add_test_part2 extends Meta_Admin {

    protected function form_processor(){
        $idtest = $this->get_test_id();
        $question = $_POST['question'];

        if(empty($question)) {
            exit("Не заполнены обязательные поля");
        }
        $query = " INSERT INTO questions 
						(idtest,question)
					VALUES ('$idtest','$question')";
        if(!mysqli_query($this->db,$query)) {
            exit(mysqli_error());
        }
       else {
            $_SESSION['res'] = "Изменения сохранены";
            header("Location:?option=add_test_part3");
            exit;
        }
    }


    public function get_content()
    {
        echo "<div id ='main'>";
        if($_SESSION['res']) {
            echo $_SESSION['res'];
            unset($_SESSION['res']);
        }

        print <<<HEREDOC
<form action='' method='POST'>
<p>Введите вопрос:<br />
<input type='text' name='question' style='width:420px;'>
</p>
<p><input type='submit' name='button' value='Далее'></p></form>
</div>
HEREDOC;
    }
}