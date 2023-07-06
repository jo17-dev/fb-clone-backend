<?php session_start() ?>
@extends('acceuil.layout')

@section('title')

@endsection

@section('content')


@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>User edit form</h1><br>
    <div class="">
        <a href="/dashboard">dashboard</a>
        <form action="/home/edit" method="post">
            @csrf
            @method('PUT')
            <div class="">
                <label for="username">Enter your username</label>
                <input type="text" name="username" id="username" value="{{ $_SESSION['user']['username'] }}" required>
            </div>
            <div class="">
                <label for="email">Enter your email</label>
                <input type="email" name="email" id="email" value="{{ $_SESSION['user']['email'] }}">
            </div>
            <div class="">
                <label for="born_day">Enter your born day:</label>
                <input type="date" name="born_day" id="born_day" value="{{ $_SESSION['user']['born_day'] }}" required>
            </div>
            <div class="">
                <label for="password">Enter a new password</label>
                <input type="password" name="password" id="password" >
            </div>
            <div class="">
                <label for="confirm_pass">confirm your password</label>
                <input type="password" name="confirm_password" id="confirm_password">
            </div>
            <div class="">
                <input type="submit" value="Save" name="save">
            </div>
        </form>
    </div>
    <p> <?php var_dump($_SESSION); ?> </p>
</body>
</html>