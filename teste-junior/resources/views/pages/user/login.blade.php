@extends('layouts.app', ['containerClass' => 'mw-600 mx-auto'])
@section('title', 'Login')
@section('content')
    <article class="mx-auto">
        <form id="loginForm">
            @csrf
            <div class="mb-3">
                <label for="inputEmail">Email</label>
                <input type="email" name="email" id="inputEmail" class="form-control" autocomplete="email">
            </div>

            <div class="mb-3">
                <label for="inputPasswd">Password</label>
                <input type="password" name="password" id="inputPasswd" class="form-control" autocomplete="current-password">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" id="inputCheckbox" class="form-check-input">
                <label for="inputCheckbox" class="form-check-label">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary d-none d-md-block d-lg-block btn-login">Login</button>
            <button type="submit" class="btn btn-primary form-control d-block d-md-none d-lg-none btn-login">Login</button>
        </form>
    </article>
@endsection
