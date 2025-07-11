<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompteBancaireController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\CarteBancaireController;
use App\Models\CompteBancaire;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

Route::post('/appliquer-interets', [CompteBancaireController::class, 'appliquerInterets'])->name('appliquer.interets');
Route::get('/transactions/pdf', [\App\Http\Controllers\BankController::class, 'exportPDF'])->name('transactions.pdf');
Route::get('/carte/pdf', [CarteBancaireController::class, 'genererCarte'])->name('carte.pdf');



// ✅ Page d’accueil = formulaire de login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

// ✅ Authentification
Auth::routes(['verify' => true]); // permet email vérifié

// ✅ Inscription
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// ✅ Connexion
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// ✅ Déconnexion
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ✅ Email : page de vérification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
// ✅ Email : traitement de la vérification
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard'); // ou la route que tu veux
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Lien de vérification envoyé.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ✅ Email : renvoi de lien de vérification
Route::post('/email/resend', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect('/dashboard');
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Un nouveau lien de vérification a été envoyé.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

// ✅ Dashboard du client
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// web.php
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/demandes-ouverture', [AdminController::class, 'demandesOuverture'])->name('admin.ouverture');
    Route::post('/admin/valider-ouverture/{id}', [AdminController::class, 'validerOuverture'])->name('admin.validerOuverture');
    Route::post('/admin/rejeter-ouverture/{id}', [AdminController::class, 'rejeterOuverture'])->name('admin.rejeterOuverture');

    Route::get('/admin/demandes-fermeture', [AdminController::class, 'demandesFermeture'])->name('admin.fermeture');
    Route::post('/admin/valider-fermeture/{id}', [AdminController::class, 'validerFermeture'])->name('admin.validerFermeture');
    Route::post('/admin/rejeter-fermeture/{id}', [AdminController::class, 'rejeterFermeture'])->name('admin.rejeterFermeture');

    Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
});



Route::middleware(['auth'])->group(function () {
    Route::post('/demande-fermeture/{id}', [CompteBancaireController::class, 'demanderFermeture'])->name('demanderFermeture');
});


// routes/web.php

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $compte = CompteBancaire::where('user_id', $user->id)->first();
        $transactions = [];

        if ($compte) {
            $transactions = Transaction::where('compte_bancaire_id', $compte->id)->latest()->get();
        }

        return view('dashboard', compact('user', 'compte', 'transactions'));
    })->middleware(['auth'])->name('dashboard');

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->middleware(['auth', 'admin'])->name('admin.dashboard');

});



// ✅ Routes protégées (clients uniquement)
Route::middleware(['auth', 'verified'])->group(function () {
    // Profil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Comptes bancaires
    Route::get('/compte/create', [CompteBancaireController::class, 'create'])->name('compte.create');
    Route::post('/compte', [CompteBancaireController::class, 'store'])->name('compte.store');

    // Dépôt
    Route::get('/depot', [BankController::class, 'showDepotForm'])->name('depot');
    Route::post('/deposer', [BankController::class, 'deposer'])->name('bank.deposer');
    Route::get('/deposer/confirmation', [BankController::class, 'confirmation'])->name('bank.deposer.confirmation');

    // Retrait
    Route::get('/retrait', [BankController::class, 'showRetraitForm'])->name('retrait.form');
    Route::post('/retrait', [BankController::class, 'retrait'])->name('retrait');

    // Virement
    Route::get('/virement', [BankController::class, 'showVirementForm'])->name('virement.form');
    Route::post('/virement', [BankController::class, 'submitVirement'])->name('virement');

    // Modifier compte
    Route::get('/compte/edit', [BankController::class, 'edit'])->name('compte.edit');
    Route::post('/compte/edit', [BankController::class, 'update'])->name('compte.update');

    // Notifications
    Route::get('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});
