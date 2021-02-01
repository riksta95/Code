<?php

namespace App\Http\Controllers\Step;

use Buzz\Helpers\AnswerHelper;
use Buzz\Helpers\QuestionHelper;

use App\Http\Traits;
use RegCore\Http\Controllers\Step;

class Step3Controller extends Step\Step3Controller
{
    use Traits\Flow;
    use Traits\Step;

    protected $step = 3;

    // required to be answered, open question can be submitted empty
    protected function getRequired()
    {
        return [
            'work-status',
            'dietary-preference',
            'favourite-character',
            'favourite-comic-book-universe',
            'terms',
        ];
    }

    protected function getQuestions()
    {
        return [
            'work-status',
            'dietary-preference',
            'favourite-character',
            'favourite-comic-book-universe',
            'favourite-villain',
            'terms',
        ];
    }

    /**
     * @param QuestionHelper $questionHelper
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Buzz\Helpers\Exceptions\Error
     */
    public function render(QuestionHelper $questionHelper)
    {
        $questions = $questionHelper->getByIdentifiers($this->getQuestions());

        $required = $this->getRequired();

        return view(
            'step',
            ['step' => $this->step] + compact('questions', 'required')
        );
    }

    public function save(AnswerHelper $answerHelper)
    {
        $this->handleFlow();

        $required = $this->getRequired();

        // if 'favourite comic book universe' is answered 'dc'
        if (isAnswered('favourite-comic-book-universe', 'dc')) {
            $required[] = 'favourite-villain';
        }

        $answerHelper->answerMany($this->getQuestions(), request('questions'), $required);

        if (!customer()->badge_type_id) {
            customer()->badge_type_id = 'visitor';
            customer()->save();
        }

        return $this->complete();
    }
}
