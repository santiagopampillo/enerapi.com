{!! Form::hidden('id') !!}
<div class="card-body">
    <div class="row">
        <div class="form-group col-sm-6">
            {!! Form::label('name', 'Nombre:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>