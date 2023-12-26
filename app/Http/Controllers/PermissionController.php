<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePermission;
use App\Models\Permission;
use Exception;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(StoreUpdatePermission $request)
    {
        try {
            $data = $request->all();
        
            Permission::create($data);
            return redirect()->route('permissions.view')->with('success', 'Registro salvo com sucesso!');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erro ao tentar cadastrar!');
        }
      
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            return redirect()->route('permissions.view')->with('error', 'Registro não encontrado!');
        }
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdatePermission $request, string $id)
    {
        try {
            $permission = Permission::find($id);
            $data = $request->all();

            $permission->update($data);

            return redirect()->route('permissions.view')->with('success', 'Registro salvo com sucesso!');
            
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erro ao tentar salvar!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::find($id);
     
        if (!$permission) {
            return redirect()->back()->with('errorDel', 'Ocorreu um erro ao tentar excluir o registro.');
        }

        if ($permission->roles()->count() > 0) {
            return redirect()->back()->with('errorDel', 'Ocorreu um erro ao tentar excluir o registro.'); 
        }

        $permission->delete();
        return redirect()->route('permissions.view')->with('successDel', 'Registro excluído com sucesso!');
    }
}