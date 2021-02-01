<header class="row" id="standard_header">
    @if (!config('buzz.onsite'))
        <div class="assistance-link">
            <a
                class="btn has-shadow btn--blank"
                data-toggle="tooltip"
                data-placement="right"
                title="For technical help please click here"
                href="mailto:{{ config('buzz.campaign') }}@livebuzz.co.uk?Subject={{ trans('buzz.event.name') }}%20Registration"
                target="_top"
            >?</a>
        </div>
    @endif
    @if(cache('settings')['locale']['multilingual'])
        <div class="language-selector dropdown">
            <button
                class="btn has-shadow btn--blank btn-sm dropdown-toggle"
                type="button"
                id="dropdownMenuButton"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >
                {{ cache('settings')['locale']['supported_languages'][session('locale')]['native_name'] }}
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                @foreach(cache('settings')['locale']['supported_languages'] as $language)
                    <a
                        class="dropdown-item"
                        href="{{ route('change-language', $language['iso']) }}"
                    >{{ $language['native_name'] }}</a>
                @endforeach
            </div>
        </div>
    @endif
</header>
