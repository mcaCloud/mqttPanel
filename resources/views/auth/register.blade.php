@extends('auth.layout')

@section('content')
 <h2>Register</h2>


    <form method="POST" action="/register">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="first_name" name="first_name">
        </div>
 
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
 
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="password">Confirmar contraseña:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
        </div>
        <!------ Esto es un numero aleatorio que permite crea un numero de cuenta a cada customer-->
        <!--Lo creamos aqui y lo enviamos por la request al controlador de 'Registration' para poder guardarlo en la BD-->
        <div class="form-group">
            <input type="hidden" class="form-control" id="account_ID" name="account_id" value="<?php $d=rand(1999,20000);
                                        echo $d ; ?>">
        </div>
 
        <div class="form-group">
            <button style="cursor:pointer" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
