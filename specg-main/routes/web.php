<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SearchController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/
//->middleware('alreadyLoggedIn')
Route::get('/', [UserController::class, 'landing'])->name('landing')->middleware('alreadyLoggedIn');
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('alreadyLoggedIn');
Route::post('/authenticate', [UserController::class, 'authenticate'])->name('authenticate');

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/signup', [UserController::class, 'signup'])->name('signup');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/home', [ProjectController::class, 'home'])->name('home')->middleware('isLoggedIn');;
Route::get('/project-list', [ProjectController::class, 'showProjectList'])->name('project-list')->middleware('isLoggedIn');
Route::get('/client-list', [ClientController::class, 'showClientList'])->name('client-list')->middleware('isLoggedIn');
Route::post('/add-client', [ClientController::class, 'addClient'])->name('add-client')->middleware('isLoggedIn');
Route::post('/edit-client', [ClientController::class, 'editClient'])->name('edit-client')->middleware('isLoggedIn');
Route::get('/add-project', [ProjectController::class, 'addProject'])->name('add-project')->middleware('isLoggedIn');
Route::post('/save-project', [ProjectController::class, 'saveProject'])->name('save-project')->middleware('isLoggedIn');
Route::get('/view-project/{id}', [ProjectController::class, 'viewProject'])->name('view-project')->middleware('isLoggedIn');
Route::post('/edit-project', [ProjectController::class, 'editProject'])->name('edit-project')->middleware('isLoggedIn');
Route::post('/add-task', [TaskController::class, 'addTask'])->name('add-task')->middleware('isLoggedIn');
Route::post('/close-task', [TaskController::class, 'closeTask'])->name('close-task')->middleware('isLoggedIn');
Route::post('/delete-task', [TaskController::class, 'deleteTask'])->name('delete-task')->middleware('isLoggedIn');
Route::get('/task-list', [TaskController::class, 'showTaskList'])->name('task-list')->middleware('isLoggedIn');

Route::get('/file-list', [FileController::class, 'index'])->name('file-list')->middleware('isLoggedIn');
Route::post('/add-file', [FileController::class, 'store'])->name('add-file')->middleware('isLoggedIn');
Route::get('/view-project/{id}/files', [FileController::class, 'showProjectFiles'])->name('project-files')->middleware('isLoggedIn');
Route::get('/delete-file/{id}', [FileController::class, 'deleteFile'])->name('delete-file')->middleware('isLoggedIn');
Route::post('/edit-file', [FileController::class, 'editFile'])->name('edit-file')->middleware('isLoggedIn');

Route::get('/admin', [UserController::class, 'showAccounts'])->name('admin')->middleware('isLoggedIn');
Route::get('/remove-user/{id}', [UserController::class, 'removeUser'])->name('remove-user')->middleware('isLoggedIn');
Route::get('/approve-user/{id}', [UserController::class, 'approveUser'])->name('approve-user')->middleware('isLoggedIn');

Route::post('/search', [SearchController::class, 'search'])->name('search')->middleware('isLoggedIn');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink(
        $request->only('email')
    );
    if ($status === Password::RESET_LINK_SENT) {
        return back()->with('success','Forgot Password request successful. Please check your email.');
    }
    else {
        return back()->with('fail','Error encountered. Try again later.');
    }
})->middleware('alreadyLoggedIn')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('reset-password', ['token' => $token]);
})->middleware('alreadyLoggedIn')->name('password.reset');

Route::post('/reset-password', function (Request $request) {      
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]+$/|confirmed'
    ]);
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ]);
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    if ($status === Password::PASSWORD_RESET) {
        return redirect('/login')->with('success','Password successfully reset. Please login below.');
    }
    else {
        return redirect('/login')->with('fail','Error encountered. Try again later.');
    }    
})->middleware('alreadyLoggedIn')->name('password.update');

