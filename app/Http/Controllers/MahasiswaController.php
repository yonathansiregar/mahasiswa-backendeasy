<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
  public function __construct()
  {
    // 
  }

  // Create New Mahasiswa
  public function createMahasiswa(Request $request)
  {
    $collegeStudent = Mahasiswa::create([
      'nim' => $request->nim,
      'nama' => $request->nama,
      'angkatan' => $request->angkatan,
      'password' => $request->password,
    ]);

    return response()->json([
      'success' => true,
      'message' => 'New Mahasiswa created',
      'mahasiswa' => $collegeStudent

    ]);
  }

  // Get Mahasiswa by NIM
  public function getMahasiswaById($nim)
  {
    $collegeStudent = Mahasiswa::find($nim);
    return response()->json(
      [
        'success' => true,
        'message' => 'grabbed one mahasiswa',

        'mahasiswa' => $collegeStudent

      ]
    );
  }

  // Get All Mahasiswa
  public function getMahasiswas()
  {
    $collegeStudents = Mahasiswa::get();
    return response()->json([
      'status' => true,
      'message' => 'grabbed all mahasiswa',
      'mahasiswa' => $collegeStudents
    ], 200);
  }

  // Get Mahasiswa by Token
  public function getMahasiswaByToken(Request $request)
  {
    $collegeStudent = $request->mahasiswa;
    return response()->json([
      'success' => true,
      'message' => 'grabbed mahasiswa by token',
      'mahasiswa' => $collegeStudent
    ]);
  }

  public function deleteMahasiswa($nim)
  {
    $collegeStudent = Mahasiswa::find($nim);

    if (!$collegeStudent) {
      $data = [
        'message' => "NIM Mahasiswa not found",
      ];
    } else {
      $collegeStudent->delete();
      $data = [
        "message" => "mahasiswa deleted",
      ];
    }
  }
}
