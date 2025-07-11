<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */


    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function register(Request $request)
    {
        // Valider les données
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'numero_telephone' => 'required|string|max:15',  // Validation pour le numéro de téléphone
            'password' => 'required|min:6|confirmed', // Assurez-vous d'avoir un champ de confirmation de mot de passe

        ]);

        // Créer un utilisateur
        $user = new User();
        $user->name = $request->name; // Enregistrer le nom
        $user->email = $request->email;
        $user->numero_telephone = $request->numero_telephone; // Enregistrer le numéro de téléphone
        $user->password = Hash::make($request->password);  // Hachage du mot de passe
        $user->save();

        // Authentifier l'utilisateur après l'inscription
        auth()->login($user);  // Se connecter automatiquement


        return redirect()->route('dashboard'); // Rediriger l'utilisateur après l'inscription
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'numero_telephone' => $data['numero_telephone'], // Ajout du téléphone
        ]);

    }
}
