<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\siswa;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        // Fetch all classes from the Kelas model
        $kelas = Kelas::all();

        // Return the view and pass the classes to it
        return view('auth.register', compact('kelas'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nis' => ['required', 'string', 'max:20'],
            'no_hp' => ['required', 'string', 'max:15'],
            'id_kelas' => ['required', 'exists:kelas,id'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        siswa::create([
            'nis' => $data['nis'],
            'no_hp' => $data['no_hp'],
            'id_kelas' => $data['id_kelas'],
            'id_user' => $user->id,
        ]);

        return $user;
    }


}
