<div class="login-buttons login-buttons--main">
    <a href="{{ $stream->social_connect_urls['linkedin'] }}" class="btn btn--buzz btn--linkedin">
        <i class="fa fa-linkedin"></i> {{ transUi('LinkedIn') }}
    </a>
    <a href="{{ $stream->social_connect_urls['facebook'] }}" class="btn btn--buzz btn--facebook">
        <i class="fa fa-facebook"></i> {{ transUi('Facebook') }}
    </a>
    <a href="{{ $stream->social_connect_urls['twitter'] }}" class="btn btn--buzz btn--twitter">
        <i class="fa fa-twitter"></i> {{ transUi('Twitter') }}
    </a>
</div>
