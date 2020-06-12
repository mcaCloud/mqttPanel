<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/*Con esto importo los metodos (authorize,rules,message)*/
/*Es unicamente para la creacion y actualizacion de usuarios*/
use App\Http\Requests\PermissionRequest;

/********IMPORTANTE***********************/
/*Aqui importo los MODELOS de Role y Permissions*/
/*Dentro de estos modelos ya se encuentran importados los TRAIT de HasRoles y HasPermissions*/
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
/********IMPORTANTE***********************/

use Auth;
/*Importo el MODELO de User para poder utilizarlo en los eventos*/
use App\User;
//use App\Role;

/************* EVENTS ***************/
use \App\Events\permissionUpdate;


class PermissionController extends Controller
{

    public function index(Request $request)
    {
        $permissions = Permission::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $permissions->where(function ($q) use ($search) {
                $q->orWhere('name', 'like', "%$search%");
            });
        }

        return view('dashboard.permissions.index', [
            'items' => $permissions->paginate(config('ui.dashboard.page_size')),
            'page' => $request->query('page')
        ]);
    }

    public function create(Request $request) {

      $page = $request->query('page');
      $roles = Role::orderBy('name', 'asc')->pluck('name', 'id');
      return view('dashboard.permissions.create', [
          'roles'         => $roles,
          'role_id'       => $request->old('role_id'),
          'page'          => $request->query('page'),
          'cancel_link'   => route('dashboard::permissions.index', ['page' => $page])
      ]);

    }
/*******************STORE*********************************/

    public function store(PermissionRequest $request) {

      \DB::beginTransaction();

        $permission = Permission::create([
          'display_name' => $request->get('display_name'),
          'name' => $request->get('name'),
          'description' => $request->get('description'),
        ]);
          /****************************/
          /******* Evento *******/
          /****************************/
          //Tenemos que mencionar el evento en la cabecera del controlador, sino no lo puede llamar.
          //STATE es una variable que cree dentro del evento, junto con USER. STATE me va a guardar un vor que retrive en el front-end.Por ahora es un string despues intentare con un array

          $user = 'CREADO';
          $authUser = Auth::user();
          $state = 'creado';

          //Esto es lo que sacamos en la vista. Todas las propiedades de los objetos que creamos. AUnque a estate solo le sacamos un string, lo podemos convertir en un array
          //Aun cuando no mencionamos 'role' ams arriba tiene que ir declarada dentro del EVENTO y incluirlo como parametro para poder sacarlo en la vista. Role curiosamente en este controlador ya es una variable.
          event(new permissionUpdate($permission,$state,$user,$authUser));

          
          /****************************/
          /******* /Evento *******/
          /****************************/
      \DB::commit();

      return redirect()->route('dashboard::permissions.index')->with([
          'message' => "Se creado el permiso ". $permission->display_name,
          'level' => 'success'
      ]);

    }
/******************* /STORE*********************************/

    public function edit(Request $request, $id)
    {
        $page = $request->query('page');

        $permission = Permission::findOrFail($id);
        return view('dashboard.permissions.edit', [
            'model'         => $permission,
            'page'          => $request->query('page'),
            'cancel_link'   => route('dashboard::permissions.index', ['page' => $page])
        ]);
    }

    public function update(PermissionRequest $request, $id) {


        \DB::beginTransaction();

          $permission = Permission::findOrFail($id);

          $permission->update([
            'display_name' => $request->get('display_name'),
            'name' => $request->get('name'),
            'description' => $request->get('description'),
          ]);

        \DB::commit();

        return redirect()->route('dashboard::permissions.index')->with([
            'message' => "Se ha Actualizado el permiso ". $permission->name,
            'level' => 'success'
        ]);

    }

    /*******************DESTROY*********************************/
      public function destroy(Permission $permission)
      {
          $permission->delete();

          /****************************/
          /******* Evento *******/
          /****************************/
          //Tenemos que mencionar el evento en la cabecera del controlador, sino no lo puede llamar.
          //STATE es una variable que cree dentro del evento, junto con USER. STATE me va a guardar un vor que retrive en el front-end.Por ahora es un string despues intentare con un array
         // $user = 'BORRADO';
         // $authUser = Auth::user();
          //$state = 'borrado';

          //Esto es lo que sacamos en la vista. Todas las propiedades de los objetos que creamos. AUnque a estate solo le sacamos un string, lo podemos convertir en un array
         // event(new permissionUpdate($permission,$state,$user,$authUser));

          /****************************/
          /******* /Evento *******/
          /****************************/

         return redirect()->route('dashboard::permissions.index')->with([
            'message' => "Permiso :". $permission->name. "eliminado",
            'level' => 'success'
        ]);
      }
/****************************************************/
}
