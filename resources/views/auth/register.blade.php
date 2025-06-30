<x-guest-layout>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/registrations/registration-3/assets/css/registration-3.css">
    <section class="p-3 p-md-4 p-xl-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 bg-primary">
                    <div class="d-flex flex-column justify-content-between h-100 p-3 p-md-4 p-xl-5">
                        <h3 class="m-0"></h3>
                        <img class="img-fluid rounded mx-auto my-4" loading="lazy" src="assets/img/illustration/illustration-16.png" width="245" height="80" alt="BootstrapBrain Logo">
                        <p class="mb-0 text-light"> </p>
                    </div>
                </div>
                <div class="col-12 col-md-6 bsb-tpl-bg-lotion">
                    <div class="p-3 p-md-4 p-xl-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-5">
                                    <h2 class="h3">Inscription</h2>
<h3 class="fs-6 fw-normal text-secondary m-0">Entrez vos informations pour créer un compte</h3>
                                </div>
                            </div>
                        </div>
                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-info mb-4">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row gy-3 gy-md-4 overflow-hidden">
                                <div class="col-12">
                                    <label for="name" class="form-label">Nom complet <span class="text-danger">*</span></label>
<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Nom complet" value="{{ old('name') }}" required autofocus autocomplete="name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label">Adresse e-mail <span class="text-danger">*</span></label>
<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="nom@exemple.com" value="{{ old('email') }}" required autocomplete="username">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" required autocomplete="new-password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required autocomplete="new-password">
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="iAgree" id="iAgree" required>
                                        <label class="form-check-label text-secondary" for="iAgree">
    J'accepte les <a href="#" class="link-primary text-decoration-none">conditions générales d'utilisation</a>
</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn bsb-btn-xl btn-primary" type="submit">S'inscrire</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-12">
                                <hr class="mt-5 mb-4 border-secondary-subtle">
                                <p class="m-0 text-secondary text-end">Déjà un compte ? <a href="{{ route('login') }}" class="link-primary text-decoration-none">Se connecter</a></p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
