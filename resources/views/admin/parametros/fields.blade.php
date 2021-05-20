<!-- Nombre Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
</div>

<!-- Valores Field -->
<div class="form-group col-sm-6">
    {!! Form::label('valores', 'Valores:') !!}
    {!! Form::text('valores', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
	{!! Form::submit('Guardar', ['class' => 'btn btn-sm btn-success']) !!}
    <a href="{!! route('parametros.index') !!}" class="btn btn-sm btn-info">Cancelar</a>
</div>