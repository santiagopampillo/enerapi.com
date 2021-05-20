<?php 
	if ($valores!=""){
		$meses_validar = $valores->meses_validar;
		$situacion_minima = $valores->situacion_minima;
	}else{
		$meses_validar = "";
		$situacion_minima = "";
	}
?>
<div class="card-body">
	<div class="row">
		<div class="form-group col-sm-6">
		    {!! Form::label('meses_validar', 'Meses a validar:') !!}
		    {!! Form::number('meses_validar', $meses_validar, ['class' => 'form-control']) !!}
		</div>

		<!-- Valores Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('situacion_minima', 'Código de situación mínima:') !!}
            {!! Form::select('situacion_minima', [null,1,2,3,4,5,6], $situacion_minima, ['id' => 'situacion_minima','class' => 'form-control']) !!}
        </div>

	</div>
</div>
<div class="card-footer text-right">
    {!! Form::submit('Guardar', ['class' => 'btn btn-sm btn-success']) !!}
</div>
@section('scripts')
	<script>
		var _errores = '';
		$(function(){
			$('#frm').on('submit', function() {
				_errores = '';
		        if($('#meses_validar').val() == '') {
		            _errores += '<li>El campo meses a validar es requerido</li>';
		        }
		        if($('#situacion_minima').val() == 0) {
		            _errores += '<li>El campo código de situación mínima es requerido</li>';
		        }

				if(_errores!='') {
					$('.content').find('.alert-danger').first().remove();
					$('.content').prepend('<ul class="alert alert-danger" style="list-style-type: none">' + _errores + '</ul>');
					return false;
				}
			
		    
			});

		});
	</script>
@endsection