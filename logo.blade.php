@if(config('buzz.onsite'))
    <div class="text-center mb-3">
        <h4 class="mt-2">
            <a 
                data-buzz-confirm="Are you sure you want to restart the registration process?" 
                href="{{ route('new-reg') }}"
            >
                Cancel and start a new registration »
            </a>
        </h4>
    </div>
@else
    <div class="logo">
        <a href="/">
            <img
                src="{{ getShowLogoUrl() }}"
                alt=""
            />
        </a>
    </div>
@endif
