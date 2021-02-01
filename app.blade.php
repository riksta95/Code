<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="description" content="{{ trans('buzz.meta_description') }}">
    <meta property="og:description" content="{{ trans('buzz.meta_description') }}">
    <title>{{ trans('buzz.event.name') }} {{ trans('buzz.event.year') }} - {{ transUi('Registration') }}</title>

    <link rel="shortcut icon" href="/images/favicon.ico">
    <link href="{{ mix("css/app.css") }}" rel="stylesheet">
    @stack('js-head')

    @include('theme')

    @yield('head')
</head>
<body>
<div id="holder" v-cloak v-if="loaded">
    <global-loading></global-loading>
    @include('partials.header')
    <main>
        <div class="container">
            @yield('layout')
        </div>
    </main>
    @if(!config('buzz.onsite'))
        @include('partials.footer')
    @endif
</div>

<!-- Scripts -->
<script>
    window.csrfToken = '{{csrf_token()}}';
    @if(!empty($ip_country))
        window.ip_country = '{{ $ip_country }}';
    @endif
</script>

@if(!config('buzz.onsite'))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/6.26.0/polyfill.min.js"></script>
@endif

<script src="{{ mix("js/manifest.js") }}"></script>
<script src="{{ mix("js/vendor.js") }}"></script>
<script src="{{ mix("js/app.js") }}"></script>
<script src="{{ mix("js/buzz.js") }}"></script>
<script>
    window.app = new Vue({
        el: '#holder',
        store: store,
        created: function() {
            Translations.setLocale('{{ session('locale') ?? cache('settings')['locale']['language'] }}');
        },
        mounted: function() {
            Buzz.init();
        },
        data: function () {
            return {
                Route: window.Route,
                props: {},
                loaded: true,
            }
        },
        computed: {
            formErrors: function() {
                return store.getters.formErrors;
            },
            unclaimedErrors: function() {
                return store.getters.unclaimedErrors;
            },
        },
    });
</script>
@include('partials/live_control_events')
@stack('js')
@include('partials/flash')
@include('partials.google-analytics')
</body>
</html>
