@extends('layout/auth')

@section('content')
    <div class="grey-section border-top-0 mb-3">
        <h3>{{ transUi('Summary') }}</h3>
        <p class="mb-0">{{ transUi('Review your registration details') }}</p>
    </div>
    <div class="row justify-content-between">
        <div class="col-xl-6">
            <h3 class="mb-3">
                {{ transUi('Your Badge') }}
            </h3>
            <p class="mb-2">
                {{ transUi('Congratulations, you\'re registered to attend') }} {{ trans('buzz.event.name') }} {{ trans('buzz.event.year') }}!
            </p>
            <p>
                {{ transUi('Please print your badge and bring it with you for fast track entry.') }}
            </p>

            <div class="my-3">
                <div class="row">
                    <div class="col-md-6">
                        <a
                            class="btn btn-primary btn-sm btn-block"
                            target="_blank"
                            href="{{ customer()->signed_e_badge_link }}"
                        >
                            <i class="fa fa-ticket"></i>
                            {{ transUi('Download e-badge') }}
                        </a>
                    </div>
                    @if(config('buzz.web_module_meetings'))
                        <div class="col-md-6">
                            <a
                                class="btn btn-primary btn-sm btn-block"
                                href="{{ route('meetings') }}"
                            >
                                <i class="fa fa-ticket"></i>
                                {{ transUi('Schedule meetings') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <h3 class="mt-5 mb-3">{{ transUi('Registration Details') }}</h3>

            <p class="mb-1">{{ customer()->title }} {{ customer()->name }}</p>
            <p class="mb-1">{{ customer()->email }}</p>
            <p class="mb-1">{{ customer()->job_title }}</p>
            <p class="mb-1">{{ customer()->company }}</p>

            <div class="mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <a
                            href="{{ route('step1') }}"
                            class="btn btn-block btn-sm btn-secondary"
                        >
                            <i
                                class="fa fa-pencil"
                                aria-hidden="true"
                            ></i>
                            {{ transUi('Amend my registration') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <h3 class="mb-3">
                {{ transUi('Venue Details') }}
            </h3>
            <h5 class="mb-2">
                {{ trans('buzz.event.date') }}
                {{ trans('buzz.event.venue') }}
            </h5>

            <address class="mb-2 my-1">
                National Exhibition Center, Halls, Marston Green, Birmingham B40 1NT
            </address>

            <p class="mb-4">
                <a
                    href="http://www.thenec.co.uk/"
                    target="_blank"
                >
                    <i
                        class="fa fa-globe"
                        aria-hidden="true"
                    ></i>
                    Visit Website
                </a>
            </p>

            <leaflet-map
                :lat="52.4548971"
                :lng="-1.7184944"
                :zoom="14"
            ></leaflet-map>

            <p class="mt-2">
                <a
                    href="https://www.google.co.uk/maps/dir/My+location/NEC,+National+Exhibition+Center,+Halls,+Marston+Green,+Birmingham+B40+1NT"
                    target="_blank"
                >
                    <i
                        class="fa fa-map-marker"
                        aria-hidden="true"
                    ></i>
                    Get directions
                </a>
            </p>
        </div>
    </div>

    @if(config('buzz.organization') === 'reedexpo')
        <rx-recommendations
            recommendations-url="{{ route('rx-recommendations::fetch') }}"
        ></rx-recommendations>
    @endif

    @if (config('buzz.seminars_enabled'))
        @if($seminars->count())
            <h3 class="mb-3">{{ transUi('Seminar Agenda') }}</h3>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">{{ transUi('Session') }}</th>
                    <th scope="col">{{ transUi('Date & Time') }}</th>
                    <th scope="col">{{ transUi('Theatre') }}</th>
                    <th scope="col">
                        <div class="row justify-content-between">
                            <div class="col-md-8">{{ transUi('Attendee(s)') }}</div>
                            <div class="col-md-4">{{ transUi('Status') }}</div>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($seminars as $seminar)
                    <tr>
                        <td>{{ $seminar->title }}</td>
                        <td>
                            {{ $seminar->starts_at->copy()->tz(cache('settings')['locale']['timezone'])->format('l jS M') }}
                            <br/>
                            {{ $seminar->starts_at->copy()->tz(cache('settings')['locale']['timezone'])->format('H:i') }} - {{ $seminar->ends_at->copy()->tz(cache('settings')['locale']['timezone'])->format('H:i') }}
                        </td>
                        <td>{{ $seminar->theater->name }}</td>
                        <td>
                            @foreach($seminar->attendees_filtered as $attendee)
                                <div class="row justify-content-between">
                                    <div class="col-md-8">
                                        @if($attendee->customer)
                                            @if($attendee->customer->id === customer()->id)
                                                <i
                                                    title="{{ transUi('I am attending') }}"
                                                    class="fa fa-user"
                                                ></i>
                                            @else
                                                {{ $attendee->customer->name }}
                                            @endif
                                        @else
                                            {{ transUi('non allocated') }}
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        @if($attendee->status === 'in_basket')
                                            {{ transUi('In Basket') }}
                                        @elseif($attendee->status === 'awaiting_payment')
                                            {{ transUi(' Awaiting Payment') }}
                                        @else
                                            {{ transUi('Confirmed') }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    @endif

    @if($webModulesOauthToken)
        <web-module-loader
            organization="{{ config('buzz.organization') }}"
            campaign="{{ config('buzz.campaign') }}"
            web-module-o-auth-token="{{ $webModulesOauthToken }}"
            version="v1-latest-{{ app()->environment() === 'production' ? 'prod' : 'staging' }}"
            env="production"
        ></web-module-loader>
    @endif

    @if(config('buzz.social_reg_enabled') || config('buzz.social_share_enabled') || config('buzz.social_invite_enabled'))
        <div class="grey-section fit-to-bottom mt-3">
            @if(config('buzz.social_share_enabled'))
                <div class="row justify-content-center mb-3">
                    <div class="col-md-6">
                        <h5 class="mt-4 text-center">{{ transUi('Tell people you\'re coming') }}</h5>
                        <div class="row social-icons pb-2">
                            <div class="col-4 facebook-icon">
                                <a
                                    href="http://www.facebook.com/share.php?u={{ urlencode($shareUrls['facebook']) }}"
                                    target="_blank"
                                >
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </div>
                            <div class="col-4 twitter-icon">
                                <a
                                    href="http://twitter.com/intent/tweet?status={{ urlencode(trans('buzz.twitter_share_message')) }}+{{ urlencode($shareUrls['twitter']) }}"
                                    target="_blank"
                                >
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </div>
                            <div class="col-4 linkedin-icon">
                                <a
                                    href="http://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($shareUrls['linkedin']) }}&summary={{ urlencode(trans('buzz.linkedin_share_message')) }}"
                                    target="_blank"
                                >
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(config('buzz.social_invite_enabled'))
                <social
                    :buzz-config="{{ json_encode(config('buzz')) }}"
                    suggest-url="{{ route('social::suggest') }}"
                    invite-connection-url="{{ route('social::invite-connection') }}"
                    invite-email-url="{{ route('social::invite-email') }}"
                ></social>
            @endif

            @if(config('buzz.social_reg_enabled'))
                <div class="login-buttons login-buttons--main">
                    <h5 class="mt-4 text-center">{{ transUi('Connect your social accounts') }}</h5>
                    @foreach([
                        'linkedin' => 'linkedin',
                        'facebook' => 'facebook',
                        'twitter' => 'twitter',
                     ] as $icon => $provider)
                        @if($customerSocials->contains($provider))
                            <span class="btn btn--buzz btn--{{ $provider }} connected">
                            <i class="fa fa-{{ $icon }}"></i> {{ transUi('already connected') }}
                        </span>
                        @else
                            <a
                                class="btn btn--buzz btn--{{ $provider }}"
                                href="{{ $stream->social_connect_urls[$provider] .'/' . customer()->id  }}"
                            >
                                <i class="fa fa-{{ $icon }}"></i> {{ transUi('Connect') }}
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    @endif
@endsection
