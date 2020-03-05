<div id="container_form">
    <div id="content_form">
        <form method="POST" action="{{ route('login') }}" id="form_login">
            @csrf




            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
            @error('email')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror

            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"placeholder="Mot de passe">
            @error('password')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
            <button type="submit" class="btn_login">
                {{ __('Se connecter') }}
            </button>
            <span id="inscription">Pas encore de compte ? <a href="{{ url('/register') }}"> Inscrivez-vous</a></span>

        </form>
    </div>
</div>
