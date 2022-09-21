<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\UserContract;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Ui\Presets\React;

class UserController extends BaseController
{
    protected $userRepository;

    public function __construct(UserContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        // $users = $this->userRepository->listUsers();
        // $this->setPageTitle('Users', 'Users List');
        // return view('admin.users.index', compact('users'));

        try {
            $users = User::all(); // fetch all user from database
            $this->setPageTitle('Users', 'Users List');
            return view('admin.users.index', ['users' => $users]);
            // ['table' => $users]
        } catch (ModelNotFoundException $ex) {
            return $ex->getMessage();
        }
    }

    public function search(Request $request)
    {
        $email = $request->input('email');
        $users = User::where('email', 'LIKE', "%$email%")->get();
        // $users = User::search("$email")->get();
        // $users = User::like('email', "%$email%")->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            '*' => 'required',
            'email' => 'required|unique:users,email',
        ]);

        // Solution 1 (not hash password)
        // User::create($request->all());

        // Solution 2
        User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
        ]);

        return redirect('/admin/users');
    }

    // public function edit($id)
    // {
    //     $row = DB::table('users')->where('id', $id)->first();
    //     $data = [
    //         'user' => $row,
    //     ];
    //     return view('admin.users.edit', $data);
    // }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = User::where('id', $request->input('id'))->first();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->address =  $request->input('address');
        $user->city = $request->input('city');
        $user->country = $request->input('country');
        $user->save();

        return redirect('/admin/users');
    }

    public function delete($id)
    {
        $user = User::find($id);

        $user->delete();

        return redirect('/admin/users');
    }
}
