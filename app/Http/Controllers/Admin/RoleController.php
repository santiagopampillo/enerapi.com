<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Repositories\RoleRepository;
use App\Repositories\ModuloRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class RoleController extends AppBaseController
{
    /** @var  RoleRepository */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepo, ModuloRepository $moduloRepo)
    {
        $this->roleRepository = $roleRepo;
        $this->moduloRepo = $moduloRepo;
    }

    /**
     * Display a listing of the Role.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $pagination = 10;
        $filtros = [];
        $filtros["name"] = \Request::input('name');

        $roles = $this->roleRepository->getByFilter($pagination,$filtros);

        return view('admin.roles.index')->with('roles', $roles)->with('filtros', $filtros);

    }

    /**
     * Show the form for creating a new Role.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.roles.create')->with('modulos',$this->moduloRepo->getOrderBy('id'));
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param CreateRoleRequest $request
     *
     * @return Response
     */
    public function store(CreateRoleRequest $request)
    {
        $input = $request->all();

        $input['guard_name'] = str_slug($input["name"], '-');; 
        $role = $this->roleRepository->create($input);

        Flash::success('Role saved successfully.');

        return redirect(route('roles.index'));
    }

    /**
     * Display the specified Role.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $role = $this->roleRepository->findWithoutFail($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }

        return view('admin.roles.show')->with('role', $role);
    }

    /**
     * Show the form for editing the specified Role.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $role = $this->roleRepository->findWithoutFail($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }

        return view('admin.roles.edit')->with('role', $role)->with('modulos',$this->moduloRepo->getOrderBy('id'));
    }

    /**
     * Update the specified Role in storage.
     *
     * @param  int              $id
     * @param UpdateRoleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRoleRequest $request)
    {
        $role = $this->roleRepository->findWithoutFail($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }

        $role = $this->roleRepository->update($request->all(), $id);

        Flash::success('Role updated successfully.');

        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified Role from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $role = $this->roleRepository->findWithoutFail($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }

        $role->permisos()->detach();

        $this->roleRepository->delete($id);

        Flash::success('Role deleted successfully.');

        return redirect(route('roles.index'));
    }

    public function export()
    {
/*        $filtros = [];
        $filtros["name"] = \Request::input('name');
        $filtros["lastname"] = \Request::input('lastname');

        $users = $this->userRepository->getByFilter(null,$filtros);

        foreach ($users as $u) {
            $usersArray[] = array($l->id,$l->nombre,$l->empresa->nombre,$l->direccion,$l->zona->nombre);
        }

        Excel::create('locales', function($excel) use($localesArray) {
            $excel->sheet('Hoja 1', function($sheet) use($localesArray) {
                $sheet->fromArray($localesArray,null,'A1',false,false);
            });
        })->export('xls');*/
    }
}
