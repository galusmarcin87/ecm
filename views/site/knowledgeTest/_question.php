<?php
$isSubquestion = isset($isSubquestion) ? $isSubquestion : false;
$subQuestionIndex = isset($subQuestionIndex) ? $subQuestionIndex : false;
$isCheckbox = isset($question['isCheckbox']) ? $question['isCheckbox'] : false;
?>

<div class="survey-question">
    <p>
        <?= $questionIndex + 1 ?>.<?= $subQuestionIndex ? $subQuestionIndex . '.' : '' ?> <?= $question['question'] ?>
    </p>
    <div class="survey-question-options">
        <? foreach ($question['answers'] as $answerIndex => $answer): ?>
            <div class="form-check">

                <input class="form-check-input"
                       type="<?= $isCheckbox ? 'checkbox' : 'radio' ?>" <?= $answerIndex == 0 && !$isSubquestion && !$isCheckbox ? 'required' : '' ?>
                       name="Answer<?= $isSubquestion ? 'Subquestion' : '' ?>[<?= $sectionIndex ?>][<?= $questionIndex ?>]<?= $isSubquestion ? '[' . $subQuestionIndex . ']' : '' ?><?= $isCheckbox ? '[]' : '' ?>"
                       id="answer_<?= $sectionIndex ?>_<?= $questionIndex ?>_<?= $answerIndex ?>_<?= $subQuestionIndex ?>"
                       value="<?= $answerIndex ?>"/>
                <label class="form-check-label"
                       for="answer_<?= $sectionIndex ?>_<?= $questionIndex ?>_<?= $answerIndex ?>_<?= $subQuestionIndex ?>">
                    <?= $answer ?>
                </label>
            </div>
        <? endforeach; ?>
    </div>
</div>
