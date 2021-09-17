<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;

class Cekroleuser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,...$roles)
    {
        $user = Auth::user();
        $cek_detail = $user->where('email', $request->user()->email)->first();

        if (in_array($request->user()->role,$roles) && in_array($cek_detail->status == "P",$roles)) {
            abort(403, 'Sorry, your account status is currently inactive.');
        }elseif (in_array($request->user()->role,$roles) && in_array($cek_detail->status == "NA",$roles)) {
            abort(403, 'Sorry, your account status is currently inactive.');
            
        }elseif (in_array($request->user()->role,$roles) && in_array($cek_detail->status == "A",$roles)) {
            return $next($request);
        }

        return redirect('/');
    }
}
