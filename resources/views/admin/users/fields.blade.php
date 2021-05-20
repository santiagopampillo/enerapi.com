{!! Form::hidden('id') !!}
<div class="card-body">
    <div class="row">
        <div class="form-group col-sm-6">
            {!! Form::label('first_name', 'Nombre:') !!}
            {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-sm-6">
            {!! Form::label('last_name', 'Apellido:') !!}
            {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
        </div>
    </div>

    @if(!isset($user))    
    <div class="row">
        <!-- Contact Name Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('password', 'Contraseña:') !!}
            {!! Form::password('password', ['class' => 'form-control']) !!}
        </div>

        <!-- Contact Lastname Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('password_confirmation', 'Confirmar contraseña:') !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
        </div>
    </div>
    @endif
    <div class="row">
        <!-- Contact Name Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('email', 'E-mail:') !!}
            {!! Form::text('email', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <input type="hidden" name="rol_id" value="1">
</div>
<div class="card-footer text-right">
    {!! Form::submit('Guardar', ['class' => 'btn btn-sm btn-success']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-sm btn-info">Cancelar</a>
</div>
