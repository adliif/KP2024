<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <body
        style="background-image: url(assets/img/background.png); background-color: #060606f1; background-repeat: no-repeat; background-size: cover; background-position: center;">
        <div id="layoutAuthentication" class="d-flex align-items-center justify-content-center min-vh-100">
            <div id="layoutAuthentication_content" class="w-100">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Sign in</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <!-- Email Address -->
                                            <div class="form-floating mb-3">
                                                <x-text-input class="form-control" id="email" type="email" 
                                                    name="email" :value="old('email')" placeholder="name@example.com" required autofocus autocomplete="username" />
                                                <label for="email">Email address</label>
                                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                            </div>

                                            <!-- Password -->
                                            <div class="form-floating mb-3">
                                                <x-text-input id="password" class="form-control" type="password"
                                                    name="password" placeholder="Password" required autocomplete="current-password" />
                                                <label for="password">Password</label>
                                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                            </div>

                                            <div class="flex items-center justify-end mt-4">
                                                @if (Route::has('password.request'))
                                                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                        href="{{ route('password.request') }}">
                                                        {{ __('Forgot your password?') }}
                                                    </a>
                                                @endif

                                                <x-primary-button class="ms-3 btn btn-primary">
                                                    {{ __('Log in') }}
                                                </x-primary-button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>

</x-layout>