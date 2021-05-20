<table class="table table-responsive" id="parametros-table">
    <thead>
        <tr>
            <th>Nombre</th>
        <th>Valores</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($parametros as $parametro)
        <tr>
            <td>{!! $parametro->nombre !!}</td>
            <td>{!! $parametro->valores !!}</td>
            <td>
                {!! Form::open(['route' => ['parametros.destroy', $parametro->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('parametros.show', [$parametro->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('parametros.edit', [$parametro->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>