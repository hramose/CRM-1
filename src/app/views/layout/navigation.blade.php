<nav class="navbar navbar-inverse" role="navigation">

    <div class="navbar-collapse">
        <ul class="nav navbar-nav">
            <li{{isActive('home')}}>
                <a href="{{ URL::route('home') }}">Главная</a>
            </li>
            @if(Auth::check())

            <li{{isActive('account-sign-out')}}>
                <a href="{{ URL::route('account-sign-out') }}">Выход</a>
            </li>
            <li{{isActive('account-change-password')}}>
                <a href="{{ URL::route('account-change-password') }}">Сменить пароль</a>
            </li>

                @if(Auth::user()->group_admin==1)
                <li{{isActive('admin_page')}}>
                    <a href="{{ URL::route('admin_page') }}">Управление группами</a>
                </li>
                @endif

            @else

            <li{{isActive('account-create')}}>
                <a href="{{ URL::route('account-create') }}">Создать аккаунт</a>
            </li>
            <li{{isActive('account-sign-in')}}>
                <a href="{{ URL::route('account-sign-in') }}">Авторизоваться</a>
            </li>
            <li{{isActive('account-forgot-password')}}>
                <a href="{{ URL::route('account-forgot-password') }}">Забыли пароль?</a>
            </li>

            @endif
        </ul>

        @if(Auth::check())
        <a href="{{ URL::route('profile-user', Auth::user()->username) }}" class="navbar-right navbar-brand">
        {{{ Auth::user()->username }}}
        </a>
        @endif
    </div>

</nav>