<div class="card-body">
    <div class="row">
        <div class="form-group col-sm-6">
            {!! Form::label('email', 'E-mail:') !!}
            <p>{!! $user->email !!}</p>
        </div>
        <div class="form-group col-sm-6">
            {!! Form::label('perfil', 'Perfil:') !!}
            <p>{!! $user->rol->name !!}</p>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-6">
            {!! Form::label('sucursal', 'Sucursal:') !!}
            <p>{!! $user->sucursal->nombre !!}</p>
        </div>
    </div>
</div>
