<?php

if (request('questions')) {
    $vip = null;

    foreach (request('questions') as $question => $answer) {
        if ($question == 'vip-code') {
            if ($answer['text']) {
                $vip = $answer['text'];
            }
        }
    }

    if ($vip) {
        $vipCode = (new Lead())
            ->first((new Filter())
                ->add('first_name', 'is', $vip)
                ->add('group.identifier', 'is', 'vip-codes')
        );

        if (!$vipCode || $vipCode->name !== $vip) {
            throw new Error(trans('The VIP code you have entered is invalid. Please check and try again'));
        } else {
            $existingCustomer = (new Customer())
                ->first((new Filter())
                    ->add('status', 'is', 'active')
                    ->add('answers.question.identifier', 'is', 'vip-code')
                    ->add('answers.text', 'is', $vip)
                );

            if ($existingCustomer && $existingCustomer->id != $customer->id) {
                throw new Error(trans('This VIP code has already been used'));
            }
        }
    }

    if (isAnswered('registration-type', 'vip')) {
        $required[] = 'vip-code';
    }
}