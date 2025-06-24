<x-guest-layout>
    <div class="text-center mb-4" data-aos="fade-up">
        <h1 class="h2 mb-2">Welcome Back</h1>
        <p class="text-muted">Sign in to access your helpdesk account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="alert alert-info mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="auth-form" data-aos="fade-up" data-aos-delay="100">
        @csrf

        <!-- Email Address -->
        <div class="form-group mb-3">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter your email">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Password -->
        <div class="form-group mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Remember Me -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">Remember me</label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none">
                    Forgot password?
                </a>
            @endif
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                Sign In
            </button>

            @if (Route::has('register'))
                <p class="text-center mt-3 mb-0">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-decoration-none">Sign up</a>
                </p>
            @endif
        </div>
    </form>

    <!-- Petit texte motivant -->
    <div class="mt-8 text-center animate__animated animate__fadeInUp animate__delay-2s">
        <p class="text-gray-500 text-sm">Besoin d'aide ? <span class="text-indigo-600 font-medium">Contactez notre support technique à tout moment.</span></p>
    </div>
</x-guest-layout>
