<answer
    :answer="{{ customer()->getAnswerByIdentifier('work-status') ?? 'null' }}"
    :question="{{ $questions['work-status'] }}"
    :required="{{ in_array('work-status', $required) ? 'true' : 'false' }}"
    :column-count="2"
></answer>

<answer
    :answer="{{ customer()->getAnswerByIdentifier('dietary-preference') ?? 'null' }}"
    :question="{{ $questions['dietary-preference'] }}"
    :required="{{ in_array('dietary-preference', $required) ? 'true' : 'false' }}"
    check-none-option="none"
></answer>

<answer
    :answer="{{ customer()->getAnswerByIdentifier('favourite-character') ?? 'null' }}"
    :question="{{ $questions['favourite-character'] }}"
    :required="{{ in_array('favourite-character', $required) ? 'true' : 'false' }}"
    :limit-answers="2"
></answer>

<answer
    :answer="{{ customer()->getAnswerByIdentifier('favourite-comic-book-universe') ?? 'null' }}"
    :question="{{ $questions['favourite-comic-book-universe'] }}"
    :required="{{ in_array('favourite-comic-book-universe', $required) ? 'true' : 'false' }}"
>
    <answer
        :answer="{{ customer()->getAnswerByIdentifier('favourite-villain') ?? 'null' }}"
        :question="{{ $questions['favourite-villain'] }}"
        :required="true"
        slot="dc::after"
    ></answer>
</answer>

<answer
    :answer="{{ customer()->getAnswerByIdentifier('terms') ?? 'null' }}"
    :question="{{ $questions['terms'] }}"
    :required="{{ in_array('terms', $required) ? 'true' : 'false' }}"
></answer>
