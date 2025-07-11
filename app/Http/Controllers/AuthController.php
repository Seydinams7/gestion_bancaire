<?php

// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    // Affiche le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Gère la soumission du formulaire de connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Vérifier email uniquement pour les clients
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return redirect()->route('verification.notice')
                    ->with('error', 'Veuillez vérifier votre adresse e-mail avant de vous connecter.');
            }

            // Redirection selon le rôle


                return redirect()->route('dashboard');

        }

        return back()->withErrors([
            'email' => 'Les identifiants ne sont pas corrects.',
        ]);
    }




    // Affiche le formulaire d'inscription
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    protected function redirectTo()
    {
        return '/dashboard';
    }


    // Gère la soumission du formulaire d'inscription
    public function register(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Connexion de l'utilisateur après l'inscription

        Auth::login($user); // Pour connecter un nouvel utilisateur


        // Rediriger l'utilisateur après l'inscription
        return redirect('/login');  // Remplacez /dashboard par la route de votre tableau de bord
    }

    // Déconnexion de l'utilisateur
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }



    // Dans ton AuthController ou un autre contrôleur dédié

    public function authenticated(Request $request, $user)
    {
        if (!$user->hasVerifiedEmail()) {
            // Envoi de l'email de vérification si l'email n'est pas vérifié
            $user->sendEmailVerificationNotification();

            // Déconnexion de l'utilisateur
            Auth::logout();

            // Redirection vers la page de vérification avec un message
            return redirect()->route('verification.notice')
                ->with('message', 'Un e-mail de vérification a été envoyé. Veuillez vérifier votre adresse avant de vous connecter.');
        }

        // Si l'email est vérifié, rien ne change et l'utilisateur peut accéder à l'application
        return redirect()->route('dashboard');
    }




}

