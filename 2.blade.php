<h5><i class="fa fa-home mr-2"></i>{{ transUi('Your Address Information') }}</h5>
<p class="help-block">{{ transUi('Enter your address details') }}</p>

<address-form
    name="address[work]"
    :address="{{customer()->addresses ? customer()->addresses->where('type', 'work')->first() ?? 'null' : 'null' }}"
    :required="true"
    :required-fields="['line_1', 'city']"
></address-form>
