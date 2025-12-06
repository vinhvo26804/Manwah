<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index() {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create() {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('users.index')->with('error', 'Bạn không có quyền thêm user mới.');
        }
        return view('users.create');
    }

    public function store(Request $request) {
        $request->validate([
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'status' => 'required|in:active,inactive',
            'phone' => 'nullable|regex:/^0[0-9]{9}$/',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:admin,user,customer',
        ]);
        User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => $request->status,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
        ]);
        return redirect()->route('users.index')->with('success', 'Thêm user thành công!');
    }

    public function edit(User $user) {
        if(!auth()-> user()-> isAdmin()){
            abort(403,'Bạn không có quyền sửa thông tin User');
        }
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user) {
        $request->validate([
            'full_name' => 'required'   ,
            'email' => 'required|email|unique:users,email,'.$user->id,
            'status' => 'required|in:active,inactive',
            'phone' => 'nullable|regex:/^0[0-9]{9}$/',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:admin,user,customer',
        ]);
        $user->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'status' => $request->status,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
        ]);
        return redirect()->route('users.index')->with('success', 'Cập nhật user thành công!');
    }

    public function destroy(User $user) {
        if(auth()->user()!= 'admin'){
            return redirect()->route('users.index')->with('error','Bạn không có quyền xóa User');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Xóa user thành công!');
    }
    public function profile(){
        $user = auth()->user();

    return  view('users.profile', compact('user'));
    }
}