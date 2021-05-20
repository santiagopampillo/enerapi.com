<table class="table">
    <tbody>
            <tr style="background-color: #f8f9fa;font-size:14px;color: #495057;">
                    <th style="text-align: center;width: 130px">Acciones</th>
                    <th>Email</th>
                    <th>Fecha Desde</th>
                    <th>Fecha Hasta</th>
                    <th>Api Secret</th>
            </tr>
            @foreach($registros as $registro)
            <tr>
                <td nowrap style="text-align: center;width: 130px">
                        {!! Form::open(['route' => ['usuarios_api.destroy', $registro->id], 'method' => 'delete']) !!}
                        <a href="{!! route('usuarios_api.edit', [$registro->id]) !!}" class="btn btn-sm btn-edit" style="padding: 1px 5px 0px 5px;height: 25px;">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button type="submit" class="btn btn-sm btn-delete" style="    padding: 0px 5px 0px 5px;height: 25px;" onclick="return confirm('¿Estás seguro?')">
                                <i class="fa fa-trash"></i>
                        </button>                                    
                        {!! Form::close() !!}                                                 
                </td>
                <td>{!! $registro->email !!}</td>
                <td>{!! $registro->fecha_desde !!}</td>
                <td>{!! $registro->fecha_hasta !!}</td>
                <td>{!! $registro->api_secret !!}</td>
            </tr>
            @endforeach
    </tbody>
</table>
