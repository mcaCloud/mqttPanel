@component('mail::message')

<img src="data:image/png;base64,{{base64_encode(file_get_contents(resource_path('img/logo.png')))}}" alt="">
Hola {{$user->first_name}}!

De parte de  todo el equipo de **{{config('app.name')}}** te damos la bienvenida!

Mi nombre es (nombre de USER para responder) . Soy tu asesor. Trabajo para **{{config('app.name')}}** desde {{$user->created_at->diffForHumans() }}.

Tengo mucha experiencia en 
 {{$user->first_name}} te contacto para contarte tres cosas importantes:

##1. Estoy a tudispocición para lo que necesites.

	- Aquí me puedes contactar si tiene cualquier  pregunta o duda.
<div style="text-align: right">
@component('mail::button', ['url' => '/'])
Contáctame
@endcomponent
</div>

##2. Estas son tus credenciales:

	-  User name: {{$user->email}}

	-  password: 

	- Ingresa aquí para escribir tu contraseña:

<div style="text-align: right">
@component('mail::button', ['url' => '/'])
Cambiar contraseña
@endcomponent
</div>



##3. Estos son algunos links sobre (Base de datos enlaces de interes)


[nombre que quieres darle a tu enlace][nombre de tu referencia]

[nombre de tu referencia]: http:www.google.com


Gracias,<br>

<p>
	{{$user->first_name}}
</p>
{{ config('app.name') }}
@endcomponent