<nav>
    <ul>
        <li><a href="{{ URL::route('home') }}">Главная</a></li>
        @if(Auth::check())

        <li><a href="{{ URL::route('account-sign-out') }}">Выход</a></li>
        <li><a href="{{ URL::route('account-change-password') }}">Сменить пароль</a></li>

        @else

        <li><a href="{{ URL::route('account-create') }}">Создать аккаунт</a></li>
        <li><a href="{{ URL::route('account-sign-in') }}">Авторизоваться</a></li>
        <li><a href="{{ URL::route('account-forgot-password') }}">Забыли пароль?</a></li>

        @endif
    </ul>
</nav>