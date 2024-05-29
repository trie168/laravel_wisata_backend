@extends('layouts.auth')

@section('title', 'Login')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
@endpush

@section('main')

    <div class="card card-primary">
        <div class="card-header">
            <h4>Login</h4>
        </div>

        <div class="card-body">
            <form method="POST"
                action="{{ route('login') }}"
                class="needs-validation"
                novalidate=""> @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email"
                        type="email"
                        class="form-control"
                        name="email"
                        tabindex="1"
                        required
                        autofocus value="{{ old('name') }}">
                    <div class="invalid-feedback">
                        Please fill in your email
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-block">
                        <label for="password"
                            class="control-label">Password</label>
                        <div class="float-right">
                            <a href="auth-forgot-password.html"
                                class="text-small">
                                Forgot Password?
                            </a>
                        </div>
                    </div>
                    <input id="password"
                        type="password"
                        class="form-control"
                        name="password"
                        tabindex="2"
                        required>
                    <div class="invalid-feedback">
                        please fill in your password
                    </div>
                </div>



                <div class="form-group">
                    <label for="captcha">Captcha</label>
                    <div class="captcha">
                        <span>{!! captcha_img('math') !!}</span>
                        <button type="button" class="btn btn-primary" class="refresh" id="refresh">
                            &#x21bb;
                        </button>
                    </div> <br>
                    <input id="captcha"
                        type="text"
                        class="form-control"
                        name="captcha"
                        tabindex="3"
                        required>
                    <div class="invalid-feedback">
                        Please fill in your captcha
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit"
                        class="btn btn-primary btn-lg btn-block"
                        tabindex="4">
                        Login
                    </button>
                </div>

            </form>

        </div>
    </div>
    <div class="text-muted mt-5 text-center">
        Don't have an account? <a href="auth-register.html">Create One</a>
    </div>

@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
    <script type="text/javascript">
        $('#refresh').click(function () {
            $.ajax({
                type: 'GET',
                url: 'refresh-captcha',
                success: function (data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>
@endpush
