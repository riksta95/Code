<?php

use Buzz\Control\Campaign\Customer;
use Buzz\Control\Campaign\Property;
use Buzz\Control\Campaign\Redemption;
use Buzz\Control\Filter;
use Carbon\Carbon;

function earlyBirdCheck($product)
{
    $now = date_format(Carbon::now(), "Y-m-d H:i:s");

    if ($product == 'visitor') {
        $earlyBirdEnd = date_format(date_create("2020-03-09 23:59:59"), "Y-m-d H:i:s");
    } elseif ($product == 'ww') {
        $earlyBirdEnd = date_format(date_create("2020-01-12 23:59:59"), "Y-m-d H:i:s");
    } elseif ($product == 'writers-summit') {
        $earlyBirdEnd = date_format(date_create("2020-01-12 23:59:59"), "Y-m-d H:i:s");
    } elseif ($product == 'forum') {
        $earlyBirdEnd = date_format(date_create("2020-01-13 23:59:59"), "Y-m-d H:i:s");
    }

    if ((in_array($product, ['p-access', 'rights'])) || (isset($earlyBirdEnd) && $earlyBirdEnd < $now)) {
        return false;
    }

    return true;
}

function getProductClashes($basketInfo)
{
    $allClashes     = [];
    $productClashes = [];

    $allClashes['ww'][] = 'writers-summit';

    $allClashes['writers-summit'][] = 'ww';

    foreach ($basketInfo as $basketProduct => $info) {
        if (isset($allClashes[$basketProduct])) {
            foreach ($allClashes[$basketProduct] as $clash) {
                $productClashes[$clash] = true;
            }
        }
    }

    return $productClashes;
}

function focVisitor($customer = null)
{
    if (!$customer) {
        $customer = customer();
    }

    $jobFunction = $customer->getAnswerByIdentifier('profile-question-4335');

    if ($jobFunction) {
        $jobFunction = $jobFunction->options[0]->question_option->identifier;
    }

    $position = $customer->getAnswerByIdentifier('profile-question-4336');

    if ($position) {
        $position = $position->options[0]->question_option->identifier;
    }

    if ($position == 'profile-answer-272179' || $jobFunction == 'profile-answer-272150') {
        return 'student';
    }

    return false;
}

function reducedRate($product = null, $customer = null)
{
    if (!$customer) {
        $customer = customer();
    }

    $jobFunction = $customer->getAnswerByIdentifier('profile-question-4335');

    if ($jobFunction) {
        $jobFunction = $jobFunction->options[0]->question_option->identifier;
    }

    $companyActivity = $customer->getAnswerByIdentifier('profile-question-4334');

    if ($companyActivity) {
        $companyActivity = $companyActivity->options[0]->question_option->identifier;
    }

    $position = $customer->getAnswerByIdentifier('profile-question-4336');

    if ($position) {
        $position = $position->options[0]->question_option->identifier;
    }

    /*
     * Students pay £10 for everything
     */

    if ($position == 'profile-answer-272179' || $jobFunction == 'profile-answer-272150') {
        return 833;
    }

    /*
     * Visitor rates based on demographic selections
     */

    if ($product == 'visitor') {

        $now = date_format(Carbon::now(), "Y-m-d H:i:s");
        $earlyBirdEnd = date_format(date_create("2020-03-09 23:59:59"), "Y-m-d H:i:s");

        /*
         * Check if early bird has passed, if so, only certain people should continue to pay £50, rest £60.
         */

        if ($earlyBirdEnd < $now){
            // TV/Film Producer
            if ($jobFunction == 'profile-answer-272153' || $companyActivity == 'profile-answer-272084') {
                return 4167;
            }

            // Author
            if ($jobFunction == 'profile-answer-272134') {
                return 4167;
            }

            // Buy/Option Rights
            if (hasAnswerOptionSaved('profile-question-4337', ['profile-answer-272186'])
                && in_array($companyActivity, ['profile-answer-272094', 'profile-answer-272089', 'profile-answer-272090'])) {
                return 4167;
            }

            return 5000;
        }
    }

    return false;
}

function wwDiscounts($customer = null)
{
    if (!$customer) {
        $customer = customer();
    }

    $jobFunction = $customer->getAnswerByIdentifier('profile-question-4335');

    if ($jobFunction) {
        $jobFunction = $jobFunction->options[0]->question_option->identifier;
    }

    $companyActivity = $customer->getAnswerByIdentifier('profile-question-4334');

    if ($companyActivity) {
        $companyActivity = $companyActivity->options[0]->question_option->identifier;
    }

    $teacherLevel = $customer->getAnswerByIdentifier('profile-question-4335-272122');

    if ($jobFunction == 'profile-answer-272130' || $teacherLevel || $companyActivity == 'profile-answer-272093') {
        $basket                = getBasket();
        $basket->discount_code = 'LBF20WWC';
        $basket->save();
    }

    return;
}
