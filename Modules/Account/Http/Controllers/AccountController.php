<?php

namespace Modules\Account\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use function PHPUnit\Framework\isEmpty;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $permission_from_route = [];

        $pattern = "/can:/i";
        $allRoutes = Route::getRoutes()->get();

        foreach ($allRoutes as $Routes) {
            $given_route = end($Routes->action["middleware"]);
            if (preg_match($pattern, $given_route) === 1) {
                $value = str_replace("can:", "", $given_route);
                $module_names = $Routes->action["prefix"];
                $module_names = strlen($module_names) == 0 ? "global" : $module_names;
                $module_name = str_replace("/", "", $module_names);
                // echo $module_name."<br>";
                array_push($permission_from_route, (object)[
                    "name" => $value,
                    "module_name" => $module_name
                ]);
                array_push($permission_from_route, [
                    $value, $module_name
                ]);
                $existence = Permission::where('name', $value)->where('guard_name', 'web')->where('module_name', $module_name)->count();
                if ($existence == 0) {

                    DB::table('permissions')->updateOrInsert([
                        'name' => $value,
                        'guard_name' => "web",
                        'module_name' => $module_name,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }
        $all_permission_from_database = Permission::all('id', 'name', 'module_name');
        foreach ($all_permission_from_database as $permission) {
            if (!in_array([$permission->name, $permission->module_name], $permission_from_route))
                $permission->delete();
        }
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('account::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('account::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('account::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
