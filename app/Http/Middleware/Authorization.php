<?php

namespace App\Http\Middleware;

use App\Models\Mahasiswa;
use Closure;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('token') ?? $request->query('token');
        if (!$token) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Token not provided',
            ], 400);
        }

        $collegeStudent = Mahasiswa::where('token', $token)->first();
        if (!$collegeStudent) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid Token',
            ], 400);
        }

        $request->user = $collegeStudent;
        return $next($request);
    }
}
