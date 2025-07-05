<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Routing\Controller;

class UserController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth', 'role:admin']);
  }

  // Tampilkan daftar user
  public function index()
  {
    $users = User::with('roles')->paginate(10);
    return view('admin.user.index', compact('users'));
  }

  // Form tambah user
  public function create()
  {
    $roles = Role::all();
    return view('admin.user.create', compact('roles'));
  }

  // Simpan user baru
  public function store(Request $request)
  {
    $request->validate([
      'nama_lengkap' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|min:6|confirmed',
      'role' => 'required|exists:roles,name',
      
    ]);
    $data = [
      'nama_lengkap' => $request->nama_lengkap,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ];
    $user = User::create($data);
    $user->assignRole($request->role);
    return Redirect::route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
  }

  // Form edit user
  public function edit($id)
  {
    $user = User::findOrFail($id);
    $roles = Role::all();
    return view('admin.user.edit', compact('user', 'roles'));
  }

  // Update user
  public function update(Request $request, $id)
  {
    $user = User::findOrFail($id);
    $request->validate([
      'nama_lengkap' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email,' . $user->id,
      'role' => 'required|exists:roles,name',
    ]);
    $user->nama_lengkap = $request->nama_lengkap;
    $user->email = $request->email;
    if ($request->filled('password')) {
      $request->validate(['password' => 'string|min:6|confirmed']);
      $user->password = Hash::make($request->password);
    }
    $user->save();
    $user->syncRoles([$request->role]);
    return Redirect::route('admin.user.index')->with('success', 'User berhasil diupdate.');
  }

  // Hapus user
  public function destroy($id)
  {
    $user = User::findOrFail($id);
    if (auth()->user()->id == $user->id) {
      return Redirect::route('admin.user.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
    }
    $user->delete();
    return Redirect::route('admin.user.index')->with('success', 'User berhasil dihapus.');
  }
}
