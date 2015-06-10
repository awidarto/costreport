@extends('layout.makelogin')

@section('content')
    {{ Former::open('login')->class('form-signin')->id('form-signin')->role('form') }}

        <h3><strong>Sign in</strong> to your account</h3>
        <div class="append-icon">
            <input type="text" name="email" id="name" class="form-control form-white username" placeholder="Username" required>
            <i class="icon-user"></i>
        </div>
        <div class="append-icon m-b-20">
            <input type="password" name="password" class="form-control form-white password" placeholder="Password" required>
            <i class="icon-lock"></i>
        </div>
        <button type="submit" id="submit-form" class="btn btn-lg btn-dark btn-rounded ladda-button" data-style="expand-left">Sign In</button>
        <span class="forgot-password"><a id="password" href="account-forgot-password.html">Forgot password?</a></span>
        <div class="form-footer">
            <div class="clearfix">
                <p class="new-here"><a href="user-signup-v2.html">New here? Sign up</a></p>
            </div>
        </div>
    {{ Form::close() }}

    {{ Former::open('resetpass')->class('form-password')->id('form-password')->role('form') }}
        <h3><strong>Reset</strong> your password</h3>
        <div class="append-icon m-b-20">
            <input type="password" name="password" class="form-control form-white password" placeholder="Password" required>
            <i class="icon-lock"></i>
        </div>
        <button type="submit" id="submit-password" class="btn btn-lg btn-danger btn-block ladda-button" data-style="expand-left">Send Password Reset Link</button>
        <div class="clearfix m-t-60">
            <p class="pull-left m-t-20 m-b-0"><a id="login" href="#">Have an account? Sign In</a></p>
            <p class="pull-right m-t-20 m-b-0"><a href="user-signup2.html">New here? Sign up</a></p>
        </div>

    {{ Form::close() }}


@stop