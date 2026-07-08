<x-guest-layout>

    <div class="medical-login">

        <div class="medical-header">
            <div class="medical-icon">
                <span>✚</span>
            </div>

            <h1>Sistema de Atenciones Médicas</h1>
            <p>Control diario, reportes y gestión clínica administrativa</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="medical-form">
            @csrf

            <div class="field-group">
                <label for="email">Correo Electrónico</label>
                <div class="field-box">
                    <span>👤</span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        autocomplete="username" placeholder="usuario@correo.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="field-group">
                <label for="password">Contraseña</label>
                <div class="field-box">
                    <span>🔒</span>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        placeholder="Ingrese su contraseña">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="medical-options">
                <label>
                    <input type="checkbox" name="remember">
                    Recordarme
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        ¿Olvidó su contraseña?
                    </a>
                @endif
            </div>

            <button type="submit" class="medical-btn">
                Ingresar al Sistema
            </button>
        </form>

        <div class="medical-footer">
            Sistema de Control de Atenciones Médicas v1.0<br>
            © {{ date('Y') }}<br>
            <strong>Desarrollado por José Hernández</strong>
        </div>

    </div>

</x-guest-layout>
