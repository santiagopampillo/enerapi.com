<!-- Cuil Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cuil', 'Cuil:') !!}
    {!! Form::text('cuil', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Codarea Field -->
<div class="form-group col-sm-6">
    {!! Form::label('codarea', 'Codarea:') !!}
    {!! Form::text('codarea', null, ['class' => 'form-control']) !!}
</div>

<!-- Celular Field -->
<div class="form-group col-sm-6">
    {!! Form::label('celular', 'Celular:') !!}
    {!! Form::text('celular', null, ['class' => 'form-control']) !!}
</div>

<!-- Provincia Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('provincia_id', 'Provincia Id:') !!}
    {!! Form::text('provincia_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Monto Field -->
<div class="form-group col-sm-6">
    {!! Form::label('monto', 'Monto:') !!}
    {!! Form::text('monto', null, ['class' => 'form-control']) !!}
</div>

<!-- Codigo Sms Field -->
<div class="form-group col-sm-6">
    {!! Form::label('codigo_sms', 'Codigo Sms:') !!}
    {!! Form::text('codigo_sms', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
	{!! Form::submit('Guardar', ['class' => 'btn btn-sm btn-success']) !!}
    <a href="{!! route('solicituds.index') !!}" class="btn btn-sm btn-info">Cancelar</a>
</div>
