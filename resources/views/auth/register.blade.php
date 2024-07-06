<x-layout>
    <!-- {{$title = 'Register';}}
    <x-slot:title>{{$title}}</x-slot:title> -->

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
                                        <h3 class="text-center font-weight-light my-4">Register</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('register') }}">
                                            @csrf

                                            <!-- Name -->
                                            <div class="form-floating mb-3">
                                                <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                                <label for="name">Name</label>
                                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                            </div>

                                            <!-- Email Address -->
                                            <div class="form-floating mb-3">
                                                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                                <label for="email">Email</label>
                                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                            </div>

                                            <!-- Password -->
                                            <div class="form-floating mb-3">
                                                <x-text-input id="password" class="form-control"
                                                                type="password"
                                                                name="password"
                                                                required autocomplete="new-password" />

                                                <label for="password">Password</label>
                                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                            </div>

                                            <!-- Confirm Password -->
                                            <div class="form-floating mb-3">
                                                <x-text-input id="password_confirmation" class="form-control"
                                                                type="password"
                                                                name="password_confirmation" required autocomplete="new-password" />

                                                <label for="password_confirmation">Confirm Password</label>
                                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                            </div>

                                            <div class="flex items-center justify-end mt-4">
                                                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                                                    {{ __('Already registered?') }}
                                                </a>

                                                <x-primary-button class="ms-4 btn btn-primary">
                                                    {{ __('Register') }}
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