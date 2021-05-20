<?php 
	$categorias_monotributo = ($valores!="") ? implode(',',$valores) : '';
?>
<div class="card-body">
	<div class="row">
		<div class="form-group col-sm-6">
		    {!! Form::label('categorias_monotributo', 'Seleccionar las categorías de Monotributo que están habilitadas para solicitar crédito:') !!}
			<select class="form-control" id="categorias_monotributo" name="categorias_monotributo[]" multiple="multiple">
			  <option value="A">A</option>
			  <option value="B">B</option>
			  <option value="C">C</option>
			  <option value="D">D</option>
			  <option value="E">E</option>
			  <option value="F">F</option>
			  <option value="G">G</option>
			  <option value="H">H</option>
			  <option value="I">I</option>
			  <option value="J">J</option>
			  <option value="K">K</option>
			</select>
		</div>


	</div>
</div>
<div class="card-footer text-right">
    {!! Form::submit('Guardar', ['class' => 'btn btn-sm btn-success']) !!}
</div>
@section('scripts')
	<script>
		categorias_monotributo = '{{$categorias_monotributo}}';
		var _errores = '';
		$(function(){

    		
    		if (categorias_monotributo!=""){
    			array_categorias = categorias_monotributo.split(',');
    			$('#categorias_monotributo').val(array_categorias);
    		}
    		$('#categorias_monotributo').select2();


			$('#frm').on('submit', function() {
				_errores = '';
		        if($('#categorias_monotributo').val() == '') {
		            _errores += '<li>Por favor, seleccionar al menos una categoría</li>';
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