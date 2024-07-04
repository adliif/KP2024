<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

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
                                        <form action="login.php" method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="email" type="email"
                                                    placeholder="name@example.com" required />
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="pass" type="password"
                                                    placeholder="Password" required />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="d-grid">
                                            <input type="submit" value="Login" class="btn btn-primary btn-block">
                                        </div>
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