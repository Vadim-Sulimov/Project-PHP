<?php

class view_test extends Meta // Класс, отвечающий за отображение выбранного теста и логику тестирования.
{

    public function get_content()
    {
        if (isset($_GET['idtest'])) {
            $idtest = (int)$_GET['idtest'];
            if (!$idtest) return;
            $query = "SELECT test.test_instruction, q.idquestion, q.question,q.idtest,a.id,a.answer,a.parent_question
    FROM questions q
    INNER JOIN test
    ON test.idtest = q.idtest
    INNER JOIN answers a 
    ON a.parent_question = q.idquestion
    WHERE test.idtest = $idtest";
            $result = mysqli_query($this->db, $query);
            $test_data = null;
            while ($row = mysqli_fetch_assoc($result)) {
                if (!$row['parent_question']) return false;
                $instruction = $row['test_instruction'];
                $test_data[$row['parent_question']][0] = $row['question'];
                $test_data[$row['parent_question']][$row['id']] = $row['answer'];
            }
        }
        if (is_array($test_data)) {
            $count_questions = count($test_data);
            $pagination = $this->pagination($count_questions, $test_data);
        }
        echo '<div class="test_content">';
        if (isset($test_data)) {
            echo $instruction;
                printf("<p>Всего вопросов: $count_questions</p>"
                );
                echo $pagination;
                echo '<span class="none" id = "test-id">' . $idtest . '</span>';
                echo '<div class="test-data">';
                foreach ($test_data as $id_question => $item) {
                    echo '<div class="question" data-id = "' . $id_question . '" id="question-' . $id_question . '">';
                    foreach ($item as $id_answer => $answer) {
                        if ($id_answer == 0) {
                            echo '<p class="q">' . $answer . ' </p>';
                        } else {
                            echo '<p class="a">
<input type="radio" id = "answer-' . $id_answer . '" name="question-' . $id_question . '"  value="' . $id_answer . '">
<label for="answer-' . $id_answer . '">' . $answer . '</label>
</p>';
                        }
                    }
                    echo '</div>';// class question
                }
                echo '</div>';// class test-data
                echo '<div class="buttons">';
                echo '<button class="btn" id="btn">Закончить тест</button>';
                echo '</div>';// class buttons
            } else {
                echo 'Выберите тест';
            }

        echo '</div>';
    }
}