<?php
namespace App\Http\Controllers;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller
{
    public function index()
    {
        $user = User::all();

        confirmDelete('Delete', 'Apakah Kamu Yakin?');
        return view('backend.user.index', compact('user'));
    }

    public function create()
    {
        $user = User::all();

        return view('backend.user.create', compact('user'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:user,staf,admin',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->email_verified_at = now();


        $user->save();

        Alert::success('Success', 'Data Berhasil Disimpan')->autoClose(1000);
        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('backend.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'password' => 'nullable|min:8|confirmed',
                'role' => 'required|in:user,staf,admin',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();
        Alert::success('Success', 'Data Berhasil Diubah')->autoClose(2000);
        return redirect()->route('user.index');
    }



    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        Alert::success('Success', 'Data Berhasil Di Hapus')->autoClose(1000);

        return redirect()->route('user.index');
    }

}
