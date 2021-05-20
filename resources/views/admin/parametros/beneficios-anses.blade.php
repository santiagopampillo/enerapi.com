<!-- Nombre Field -->
<?php $fila = 1;?>

<div class="card-body">
	<div class="row">
		<div class="col-sm-12">
		<div class="card">
              <div class="card-header">
              	<h3 class="card-title" style="font-size: 1.00rem">Códigos habilitados</h3>
              	<div class="card-tools">
                		<input type="button" class="btn btn-default btn-sm float-right" id="agregar" value="Agregar código">
                	</div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered" id="table-codigos">
                  <thead>                  
                    <tr>
                      <th>Código</th>
                      <th style="width: 40px">Borrar</th>
                    </tr>
                  </thead>
                  <tbody>
                  	@if ($valores!=null)
	                  	@foreach ($valores as $key=>$value)
	                  		<tr data-id="{{$fila}}">
		                      <td><input type="text" name="codigos[]" value="{{$value}}" class="form-control"></td>
		                      <td align="center" style="vertical-align: middle"><a href="javascript:void(0)" onclick="eliminar_fila({{$fila}})"><i class="fas fa-trash-alt"></i></a></td>                  			
	                  		</tr>
	                  		<?php $fila++?>
	                  	@endforeach
                  	@endif
                  </tbody>
                </table>
              </div>

            </div>
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
			$('body').on('click', '#agregar', function() {
				ultimo_id = ($('#table-codigos tr:last').data('id') === undefined) ? 1 : $('#table-codigos tr:last').data('id') + 1;

				$('#table-codigos tbody').append('<tr data-id=\"' + ultimo_id + '\"><td><input type=\"text\" name=\"codigos[]\" value=\"\" class=\"form-control\"></td><td align=\"center\" style=\"vertical-align: middle\"><a href="javascript:void(0)" onclick=\"eliminar_fila(' + ultimo_id + ')\"><i class=\"fas fa-trash-alt\"></i></a></td></tr>');    		
			});

			$('#frm').on('submit', function() {
				input_vacio = true;
				$('input[type=text]').each(function(){
			     var text_value=$(this).val();
			     if(text_value!='')
			       {
			        input_vacio = false;
			        }

			   })

				_errores = '';
		        if(input_vacio) {
		            _errores += '<li>Debe ingresar al menos un código</li>';
		        }

				if(_errores!='') {
					$('.content').find('.alert-danger').first().remove();
					$('.content').prepend('<ul class="alert alert-danger" style="list-style-type: none">' + _errores + '</ul>');
					return false;
				}
			
		    
			});

		});

		function eliminar_fila(fila){
			$('#table-codigos tr[data-id="'+fila+'"]').remove();
		}
	</script>
@endsection