<div class="grey-section py-2 px-3">
    <ul class="nav nav-pills flex-column flex-md-row">
        <li class="nav-item">
            <a
                class="nav-link{{ request()->routeIs('profile') || request()->routeIs('thanks') ? ' active': '' }}"
                href="{{ route('profile') }}"
            >
                {{ transUi('Summary') }}
            </a>
        </li>

        @if (config('buzz.seminars_enabled'))
            <li class="nav-item">
                <a
                    class="nav-link{{ request()->is('seminar*') ? ' active': '' }}"
                    href="{{ route('seminars') }}"
                >
                    {{ transUi('Seminars') }}
                </a>
            </li>
        @endif

        @if (config('buzz.register_customer_enabled'))
            <li class="nav-item">
                <a
                    class="nav-link{{ request()->is('colleagues*') ? ' active': '' }}"
                    href="{{ route('colleagues') }}"
                >
                    {{ transUi('Colleagues') }}
                </a>
            </li>
        @endif

        @if (config('buzz.paid_show'))
            <li class="nav-item">
                <a
                    class="nav-link{{ request()->is('product*') ? ' active': '' }}"
                    href="{{ route('products') }}"
                >
                    {{ transUi('Products') }}
                </a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link{{ request()->is('orders*') ? ' active': '' }}"
                    href="{{ route('orders') }}"
                >
                    {{ transUi('Orders') }}
                </a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link{{ request()->is('basket*') ? ' active': '' }}"
                    href="{{ route('basket') }}"
                >
                    {{ transUi('Basket') }}
                    @if (basket_product_count())
                        ({{ basket_product_count() }})
                    @endif
                </a>
            </li>
        @endif

        @if(config('buzz.web_module_meetings'))
            <li class="nav-item">
                <a
                    class="nav-link{{ request()->is('meetings*') ? ' active': '' }}"
                    href="{{ route('meetings') }}"
                >
                    {{ transUi('Meetings') }}
                </a>
            </li>
        @endif

        <li class="nav-item ml-md-auto">
            <a
                class="btn btn-secondary btn-sm btn-block"
                href="{{ route('auth::logout') }}"
            >
                {{ transUi('Logout') }}
            </a>
        </li>
    </ul>
</div>
