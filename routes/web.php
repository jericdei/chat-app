<?php

use App\Events\MessageSent;
use App\Http\Controllers\ProfileController;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('chats')->as('chats.')->group(function () {
    Route::get('/', function () {
        /** @var User $user */
        $user = Auth::user();

        return inertia('Chats/Index', [
            'chats' => $user->getChats()
        ]);
    })->name('index');

    Route::get('create', fn () => inertia("Chats/Create", [
        'users' => User::exceptAuth()->get()
    ]))->name('create');

    Route::get('{user}', function (User $user) {
        $auth = Auth::user();
        $chatRelations = ['messages.sender'];

        $chat = Chat::with($chatRelations)->fromUsers($auth, $user)->first();

        if (!$chat) {
            $chat = Chat::create([
                'user_1' => $auth->id,
                'user_2' => $user->id
            ])->load($chatRelations);
        }

        return inertia('Chats/Show', [
            'chat' => $chat,
        ]);
    })->name('show');

    Route::post('{chat}', function (Chat $chat, Request $request) {
        $request->validate([
            'message' => ['required', 'string']
        ]);

        /** @var User $from */
        $from = Auth::user();

        $to = $chat->receiver;

        if (!Chat::existsForUsers($from, $to)) {
            $chat = Chat::create([
                'user_1' => $from->id,
                'user_2' => $to->id
            ]);
        } else {
            $chat = Chat::fromUsers($from, $to)->first();
        }

        $chat->messages()->create([
            'value' => $request->input('message'),
            'from' => $from->id
        ]);

        MessageSent::dispatch($chat);

        return back();
    })->name('store');

    Route::delete('{chat}', function (Chat $chat) {
        $chat->messages()->delete();

        $chat->delete();

        return back();
    })->name('destroy');
});

require __DIR__.'/auth.php';
