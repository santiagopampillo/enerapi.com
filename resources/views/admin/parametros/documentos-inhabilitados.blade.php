<?php 
	if ($valores!=""){
		$meses_validar = $valores->meses_validar;
		$porc_aceptacion = $valores->porc_aceptacion;
		$situaciones_bcra = implode(',',$valores->situaciones_bcra);
	}else{
		$meses_validar = "";
		$porc_aceptacion = "";
		$situaciones_bcra = "";
	}
?>
<div class="card-body">
	<div class="row">
		<div class="form-group col-sm-4">
		    {!! Form::label('meses_validar', 'Meses a validar:') !!}
		    {!! Form::number('meses_validar', $meses_validar, ['class' => 'form-control']) !!}
		</div>
		<div class="form-group col-sm-4">
		    {!! Form::label('situaciones_bcra', 'Situaciones BCRA a considerar:') !!}
			<select class="form-control" id="situaciones_bcra" name="situaciones_bcra[]" multiple="multiple">
			  <option value="1">1</option>
			  <option value="2">2</option>
			  <option value="3">3</option>
			  <option value="4">4</option>
			  <option value="5">5</option>
			  <option value="6">6</option>
			</select>
		</div>

		<div class="form-group col-sm-4">
		    {!! Form::label('porc_aceptacion', 'Porcentaje de aceptación:') !!}
		    {!! Form::number('porc_aceptacion', $porc_aceptacion, ['class' => 'form-control']) !!}
		</div>

	</div>
</div>
<div class="card-footer text-right">
    {!! Form::submit('Guardar', ['class' => 'btn btn-sm btn-success']) !!}
</div>
@section('scripts')
	<script>
		situaciones_bcra = '{{$situaciones_bcra}}';
		var _errores = '';
		$(function(){

    		if (situaciones_bcra!=""){
    			array_situaciones_bcra = situaciones_bcra.split(',');
    			$('#situaciones_bcra').val(array_situaciones_bcra);
    		}
			$('#situaciones_bcra').select2();

			$('#frm').on('submit', function() {
				_errores = '';
		        if($('#meses_validar').val() == '') {
		            _errores += '<li>El campo meses a validar es requerido</li>';
		        }
		        if($('#situaciones_bcra').val() == '') {
		            _errores += '<li>Por favor, seleccionar al menos una situación BCRA</li>';
		        }
		        if($('#porc_aceptacion').val() == 0) {
		            _errores += '<li>El campo porcentaje de aceptación es requerido</li>';
		        }
		        if($('#porc_aceptacion').val() > 100) {
		            _errores += '<li>El campo porcentaje de aceptación no puede ser mayor a 100</li>';
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