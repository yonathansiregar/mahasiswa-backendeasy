<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function getUserByToken(Request $request)
  {
    return response()->json([
      'success' => true,
      'message' => 'grabbed user by token',
      'user' => $request->user,
    ], 200);
  }
}
