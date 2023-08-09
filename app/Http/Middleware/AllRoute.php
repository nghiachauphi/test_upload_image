<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class AllRoute
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    //add an array of routes to skip santize check
    protected $openRoutes = [
        'setup/*',
    ];

    public function handle($request, Closure $next)
    {
        $date_now = (Carbon::today())->toDateString();

        $check_ip = Visitor::where("ip",$request->ip())
                            ->where("user_agent", $request->userAgent())
                            ->where("path", $request->path())
                            ->where("date", $date_now)
                            ->get();

        if(!in_array($request->path(), $this->openRoutes) && $check_ip->isEmpty() == true){
            //middleware code or call of function

            Visitor::create([
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip(),
                'path' => $request->path(),
                'date' => $date_now,
            ]);
        }

        return $next($request);
    }
}
