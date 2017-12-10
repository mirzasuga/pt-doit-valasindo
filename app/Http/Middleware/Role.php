<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Factory as Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $auth;
    //protected $gate;
    public function __construct(Auth $auth,Gate $gate)
    {
        $this->auth = $auth;
        $this->gate = $gate;
    }

    public function handle($request, Closure $next, $ability, ...$models)
    {
        $this->auth->authenticate();
        if($this->auth->user()->hasAccess([$ability])) {
            return $next($request);
        }
        if($request->ajax()) {
            return response('Maaf anda tidak memiliki akses.',401);
        }
        return redirect(route('401'));
        //return response('Unauthorized Access',401);
    }
    protected function getGateArguments($request, $models)
    {
        if (is_null($models)) {
            return [];
        }

        return collect($models)->map(function ($model) use ($request) {
            return $model instanceof Model ? $model : $this->getModel($request, $model);
        })->all();
    }
    protected function getModel($request, $model)
    {
        return $this->isClassName($model) ? $model : $request->route($model);
    }
    protected function isClassName($value)
    {
        return strpos($value, '\\') !== false;
    }
}
