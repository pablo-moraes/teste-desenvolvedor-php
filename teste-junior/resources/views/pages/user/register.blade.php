@extends('layouts.app', ['containerClass' => 'mw-600 mx-auto'])
@section('title', 'Sign Up')
@section('content')
    <article class="mx-auto">
        <form id="registerForm">
            @csrf
            <div class="col mb-3">
                <label for="inputEmail">Email</label>
                <input type="email" name="email" id="inputEmail" class="form-control" autocomplete="email">
            </div>

            <div class="col mb-3">
                <label for="inputName">Name</label>
                <input type="text" name="name" id="inputName" class="form-control" autocomplete="off">
            </div>

            <div class="mb-3 position-relative">
                <label for="inputPasswd">Password</label>
                <input type="password" name="password" id="inputPasswd" class="form-control pe-5" autocomplete="off">
                <i class="bi bi-eye-fill position-absolute eye-icon" style="font-size: 1.3rem" role="button" onclick="showOrHidePassword()"></i>
                <i class="bi bi-eye-slash-fill position-absolute eye-icon d-none" style="font-size: 1.3rem" role="button" onclick="showOrHidePassword()"></i>
            </div>
            <button type="submit" class="btn btn-primary d-none d-md-block d-lg-block btn-create">Create Account</button>
            <button type="submit" class="btn btn-primary form-control d-block d-md-none d-lg-none btn-create" >Create Account
            </button>
        </form>
    </article>
@endsection
