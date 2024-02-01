<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Auth;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        

        view()->composer('*', function ($view) 
        {   
            if(Auth::check()){
                $id_rol = auth()->user()->roles_id;
            }
            else{
                $id_rol = "";
            }

            View::share('key', 'value');
            Schema::defaultStringLength(191);

            $roles_permisos = DB::table('permisos')
            ->where('rol_id','=', $id_rol)
            ->where('permiso','=', 1)
            ->get();

            View::share('roles_permisos',$roles_permisos); 
        });  

        
    }
}
