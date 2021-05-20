<div class="card-body">
    <div class="row">
        <div class="form-group col-sm-6">
            {!! Form::label('codigo', 'Código:') !!}
            {!! Form::text('codigo', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-12">
            {!! Form::label('nombre', 'Nombre:') !!}
            {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="card-footer text-right">
    {!! Form::submit('Guardar', ['class' => 'btn btn-sm btn-success']) !!}
    <a href="{!! route('empresas.index') !!}" class="btn btn-sm btn-info">Cancelar</a>
</div>