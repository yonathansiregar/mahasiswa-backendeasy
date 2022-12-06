<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 
    }

    protected function jsonWebToken(Mahasiswa $collegeStudent)
    {
        $payload = [
            'iss' => 'lumen-jwt',
            'sub' => $collegeStudent->nim,
            'iat' => time(),
            'exp' => time() + 60 * 60
        ];

        return JWT::encode(
            $payload,
            env('JWT_SECRET'),
            'HS256'
        );
    }

    // Register Function
    public function register(Request $request)
    {
        $nim = $request->nim;
        $name = $request->nama;
        $batch = $request->angkatan;
        $password = Hash::make($request->password);

        $collegeStudent = Mahasiswa::create([
            'nim' => $nim,
            'nama' => $name,
            'angkatan' => $batch,
            'password' => $password,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Successfully registered',
            // 'data' => [
            //     'mahasiswa' => $collegeStudent
            // ]
        ], 200);
    }

    // Login Function
    public function login(Request $request)
    {
        $nim = $request->nim;
        $password = $request->password;

        $collegeStudent = Mahasiswa::where(
            'nim',
            $nim
        )->first();

        if (!$collegeStudent) {
            return response()->json([
                'status' => 'Error',
                'message' => 'user not exist',
            ], 404);
        }

        if (!Hash::check($password, $collegeStudent->password)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Wrong Password'
            ], 400);
        }

        // $collegeStudent->token = Str::random(36);
        $collegeStudent->token = $this->jsonWebToken($collegeStudent);
        $collegeStudent->saveOrFail();

        return response()->json([
            'status' => true,
            'message' => 'Successfully logged in',
            'token' => $collegeStudent->token,
            // 'data' => [
            //     'mahasiswa' => $collegeStudent
            // ]
        ], 200);
    }
}
