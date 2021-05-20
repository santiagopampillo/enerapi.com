<table class="table">
        <tbody>
                <tr style="background-color: #f8f9fa;font-size:14px;color: #495057;">
                        <th>ACCIONES</th>
                        <th>Nombre</th>
                </tr>
                @foreach($roles as $role)
                <tr>
                        <td nowrap>
                            @if ($role->id>1)                            
                                {!! Form::open(['route' => ['roles.destroy', $role->id], 'method' => 'delete']) !!}
                                @if (hasAccess("perfiles-modificar"))
                                    <a href="{!! route('roles.edit', [$role->id]) !!}" class="btn btn-sm btn-edit" style="padding: 1px 5px 0px 5px;height: 25px;">
                                            <i class="fa fa-edit"></i>
                                    </a>
                                @endif
                                @if (hasAccess("perfiles-baja"))
                                    <button type="submit" class="btn btn-sm btn-delete" style="    padding: 0px 5px 0px 5px;height: 25px;" onclick="return confirm('¿Estás seguro?')">
                                                                        <i class="fa fa-trash"></i>
                                                                </button>                                    
                                @endif
                                {!! Form::close() !!}                                                 
                            @endif
                        </td>
                        <td>{!! $role->name !!}</td>
                </tr>
                @endforeach
        </tbody>
</table>
