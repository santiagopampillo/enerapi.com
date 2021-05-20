<div class="card-body">
    <div class="row">
        <div class="form-group col-sm-12">
            {!! Form::label('email', 'Email:') !!}
            {!! Form::text('email', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-12">
            {!! Form::label('fecha_desde', 'Fecha Desde:') !!}
            {!! Form::text('fecha_desde', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-sm-12">
            {!! Form::label('fecha_hasta', 'Fecha Hasta:') !!}
            {!! Form::text('fecha_hasta', null, ['class' => 'form-control']) !!}
        </div>        
    </div>
</div>
<div class="card-footer text-right">
    {!! Form::submit('Guardar', ['class' => 'btn btn-sm btn-success']) !!}
    <a href="{!! route('usuarios_api.index') !!}" class="btn btn-sm btn-info">Cancelar</a>
</div>