<h5><i class="fa fa-user-circle mr-2"></i>{{ transUi('Personal Information') }}</h5>
<p class="help-block">{{ transUi('Enter your personal details') }}</p>

<titles
    title="{{ customer()->title ?? '' }}"
    :required="true"
></titles>

<buzz-input
    name="first_name"
    placeholder="{{ transUi('First name') }}"
    value="{{ customer()->first_name ?? '' }}"
    :required="true"
></buzz-input>

<buzz-input
    name="last_name"
    placeholder="{{ transUi('Last name') }}"
    value="{{ customer()->last_name ?? '' }}"
    :required="true"
></buzz-input>

<buzz-input
    name="job_title"
    placeholder="{{ transUi('Job title') }}"
    value="{{ customer()->job_title ?? '' }}"
    :required="true"
></buzz-input>

<buzz-input
    name="company"
    placeholder="{{ transUi('Company') }}"
    value="{{ customer()->company ?? '' }}"
    :required="true"
></buzz-input>

<buzz-phone
    name="telephone"
    placeholder="{{ transUi('Telephone') }}"
    value="{{ $phones['telephone'] ?? '' }}"
    :required="true"
></buzz-phone>

<buzz-phone
    name="mobile"
    placeholder="{{ transUi('Mobile') }}"
    value="{{ $phones['mobile'] ?? '' }}"
></buzz-phone>

@if (passwordIsEnabled())
    <h5 class="mt-4"><i class="fa fa-sign-in mr-2"></i>{{ transUi('Login Information') }}</h5>
    <p class="help-block">{{ transUi('Enter your desired login details') }}</p>
@endif

<buzz-input
    name="email"
    type="email"
    placeholder="{{ transUi('Email') }}"
    value="{{ customer()->email ?? '' }}"
    :required="true"
></buzz-input>

<buzz-input
    name="email_confirmation"
    type="email"
    placeholder="{{ transUi('Confirm email') }}"
    value="{{ customer()->email ?? '' }}"
    :required="true"
></buzz-input>

@if (passwordIsEnabled())
    <buzz-password
        :optional="{{ passwordIsOptional() ? 'true' : 'false' }}"
        :required="true"
    ></buzz-password>
@endif

<answer
    :answer="{{ customer() ? customer()->getAnswerByIdentifier('dob') ?? 'null' : 'null' }}"
    :question="{{ $questions['dob'] }}"
    :required="{{ in_array('dob', $required) ? 'true' : 'false' }}"
></answer>
