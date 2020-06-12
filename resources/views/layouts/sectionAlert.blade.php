<!----------------------------------------->
<div style="padding-top: 10px">
    <!-- Mostrar el mensaje cuando creo un nuevo video. Compruebo si existe mensaje-->@if(session('message'))
        <div class="alert alert-warning">
            {{session('message')}}
        </div>
    @endif
</div>
<!----------------------------------------->