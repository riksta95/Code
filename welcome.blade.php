@extends('layout/center-column')

@section('content')
    <div class="text-center">
        <div class="grey-section mb-4">
            <h3>
                Visitor Registration
            </h3>
            @if (config('buzz.paid_show'))
                <p class="mb-0">You can register for your ticket below</p>
            @else
                <p class="mb-0">You can register for your free ticket below</p>
            @endif
        </div>

        @if(config('buzz.social_reg_enabled'))
            <h5>{{ transUi('Register Socially') }}</h5>

            @include('partials.social-reg')

            <div class="row separator">
                <div><span>or</span></div>
            </div>
        @endif

        <h5>{{ transUi('Register Manually') }}</h5>

        <div class="login-buttons">
            <a
                href="{{route('step1')}}"
                class="btn btn-primary"
            >
                {{ transUi('Continue') }}
            </a>
        </div>

        @if (passwordIsEnabled())
            <div class="grey-section fit-to-bottom mt-4">
                <p class="mb-1">{{ transUi('Already registered for this year\'s show') }}?</p>
                <a href="{{ route('auth::login') }}">{{ transUi('Login to your registration') }}</a>
            </div>
        @endif
    </div>
@endsection
