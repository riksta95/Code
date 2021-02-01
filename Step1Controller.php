<?php

namespace App\Http\Controllers\Step;

use Buzz\Control\Campaign\Customer;
use Buzz\Control\Campaign\Lookup;
use Buzz\Control\Campaign\Phone;
use Buzz\Control\Filter;
use Buzz\Helpers\AnswerHelper;
use Buzz\Helpers\Exceptions\Error;
use Buzz\Helpers\QuestionHelper;

use App\Http\Traits;
use RegCore\Http\Controllers\Step;

// For having demographics on first page use `extends Step\Step1withDemoController`
class Step1Controller extends Step\Step1withDemoController
{
    use Traits\Flow;
    use Traits\Step;

    protected $step = 1;

    // required to be answered, open question can be submitted empty
    protected function getRequired()
    {
        return [
            'dob',
        ];
    }

    protected function getQuestions()
    {
        return [
            'dob',
        ];
    }

    /**
     * @param QuestionHelper $questionHelper
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Buzz\Helpers\Exceptions\Error
     * @throws \Buzz\EssentialsSdk\Exceptions\ErrorException
     */
    public function render(QuestionHelper $questionHelper)
    {
        $questions = $questionHelper->getByIdentifiers($this->getQuestions());
        $required  = $this->getRequired();
        $ipLookup  = config('buzz.onsite') ? false : (new Lookup())->ip(request()->getClientIp());

        if (customer()) {
            $phones['telephone'] = customer()->phones->where('type', 'telephone')->first();
            $phones['mobile']    = customer()->phones->where('type', 'mobile')->first();

            foreach ($phones as $key => $value) {
                if ($value) {
                    $phones[$key] = $value->number;
                }
            }
        }

        return view(
            'step',
            ['step' => $this->step] + compact('phones', 'ipLookup', 'questions', 'required')
        );
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws Error
     * @throws \Buzz\EssentialsSdk\Exceptions\ErrorException
     */
    public function save()
    {
        $questions = $this->getQuestions();
        $required  = $this->getRequired();

        $validationRules = [
            'title'       => 'required|max:40',
            'first_name'  => 'required|max:60',
            'last_name'   => 'required|min:2|max:60',
            'job_title'   => 'required|min:2|max:120',
            'company'     => 'required|min:2|max:120',
            'email'       => 'required|email|max:255|confirmed',
            'telephone'   => 'required|min:7|max:255|phone',
            'mobile'      => 'min:7|max:255|phone',
        ];

        $registeredAlready = customer() ? true : false;

        if (passwordIsEnabled()) {
            if (!passwordIsOptional() || request()->has('change_password')) {
                $validationRules['password'] = 'required|confirmed';
            }
        }

        if ($registeredAlready) {
            // if logged in sort out the flow
            $this->handleFlow();
        }

        validate(request(), $validationRules);

        $customer = customer() ?? new Customer();

        $customer->title       = request('title');
        $customer->first_name  = request('first_name');
        $customer->last_name   = request('last_name');
        $customer->job_title   = request('job_title');
        $customer->company     = request('company');
        $customer->email       = request('email');

        if (passwordIsEnabled()) {
            if (!passwordIsOptional() || request()->has('change_password')) {
                $customer->password = request('password');
            }
        }

        // Set locale and status
        if (!$registeredAlready) {
            if (cache('settings')['locale']['multilingual']) {
                $customer->langugage = session('locale');
            }

            $customer->status = 'incomplete';
        }

        app(AnswerHelper::class)->validateMany($questions, request('questions'), $required);

        // If onsite do not dupe on incomplete records
        if (config('buzz.onsite')) {
            $dupe_check = (new Customer())->get(
                (new Filter())
                    ->add('email', 'is', request('email'))
                    ->add('status', 'not in', ['cancelled', 'incomplete'])
                    ->add('exhibitor_role', 'is not', 'leader')
            );

            if (!$dupe_check->isEmpty()) {
                throw new Error(trans('auth.error_dupe_customer_onsite'));
            }
        }

        $customer->expand(config('auth.relations'))->options(['disable_dupecheck' => config('buzz.onsite')])->save();

        $telephone = $customer->phones->where('type', 'telephone')->first() ?? new Phone();

        $telephone->type   = 'telephone';
        $telephone->number = request('telephone');

        $telephone->associate($customer);
        $telephone->save();

        if (request('mobile')) {
            $mobile = $customer->phones->where('type', 'mobile')->first() ?? new Phone();

            $mobile->type   = 'mobile';
            $mobile->number = request('mobile');

            $mobile->associate($customer);
            $mobile->save();
        }

        if (!$registeredAlready) {
            // logs in customer if on registration page
            // Customer created! Login
            auth()->loginUsingId(
                $customer->id,
                true
            );

            $this->startFlow();
        }

        app(AnswerHelper::class)->answerMany($questions, request('questions'), $required);

        return $this->next();
    }
}
