<?php

namespace App\Http\Controllers\Step;

use Buzz\Control\Campaign\Address;
use Buzz\Helpers\Exceptions\Errors;
use Buzz\Helpers\Utilities\NonPostcodeCountries;

use App\Http\Traits;
use RegCore\Http\Controllers\Step;

class Step2Controller extends Step\Step2Controller
{
    use Traits\Flow;
    use Traits\Step;

    protected $step = 2;

    public function render()
    {
        $address = customer()->addresses->first();

        return view(
            'step',
            ['step' => $this->step] + compact('address')
        );
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws Errors
     */
    public function save()
    {
        $this->handleFlow();

        $validator = createValidator(request(), [
            'address.work'         => 'required|array',
            'address.work.country' => 'required|string|size:2',
            'address.work.county'  => 'string|max:80',
            'address.work.city'    => 'required|string|max:60',
            'address.work.line_1'  => 'required|string|max:120',
            'address.work.line_2'  => 'string|max:120',
            'address.work.line_3'  => 'string|max:120',
            'address.work.lookup'  => 'sometimes|required',
        ]);

        $validator->sometimes('address.work.postcode', 'required|string|min:1|max:60', function ($input) {
            return !in_array($input->address['work']['country'], NonPostcodeCountries::get());
        });

        try {
            $validator->validate();
        } catch (Errors $e) {
            if (request()->has('address.work.lookup')) {
                throw new Errors([transUi('Please specify your work address')]);
            } else {
                throw $e;
            }
        }

        $address = customer()->addresses->where('type', 'work')->first() ?: new Address();

        $address->type     = 'work';
        $address->country  = request()->input("address.work.country");
        $address->city     = request()->input("address.work.city");
        $address->county   = request()->input("address.work.county");
        $address->postcode = request()->input("address.work.postcode");
        $address->line_1   = request()->input("address.work.line_1");
        $address->line_2   = request()->input("address.work.line_2");
        $address->line_3   = request()->input("address.work.line_3");

        $address->associate(customer());

        $address->save();

        return $this->next();
    }
}
