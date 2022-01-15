<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/games', function () {
    return view('games');
})->middleware(['auth', 'verified'])->name('games');

Route::get('/users', function () {
    return view('users');
})->middleware(['auth', 'verified'])->name('users');

Route::get('/download', function () {
    return view('download');
})->middleware(['auth', 'verified'])->name('download');

Route::get('/downloadfile', function () {
    return Storage::download('Rainway Setup.exe');
})->middleware(['auth', 'verified'])->name('downloadfile');

Route::get('/join', function () {
    return view('join');
})->middleware(['auth', 'verified'])->name('join');

Route::any ( '/search', function () {
    session(['searched' => 'true']);
    $q = Request::get('q');
    
    if($q != ""){
        $users = DB::table('users')->where('name', $q)->where('status', 1)->whereNotNull('email_verified_at')->simplePaginate(5);
        if( $users->isEmpty() )
            session(['data' => '']);
        else
            session(['data' => $users]);
    }
    return view ('users');
})->middleware(['auth', 'verified'])->name('search');

Route::any ( '/adminsearch', function () {
    session(['adminsearched' => 'true']);
    $q = Request::get('q');
    
    if($q != ""){
        $users = DB::table('users')->where('name', $q)->simplePaginate(5);
        if( $users->isEmpty() )
            session(['admindata' => '']);
        else
            session(['admindata' => $users]);
    }
    return view ('adminpanel');
})->middleware(['auth', 'verified'])->name('adminsearch');

Route::post('/banuser', function () {
    $username = $_POST["username_ban"];
    $page = DB::table('users')->where('name', $username)->value('id');
    $page = strval(ceil($page / 5));
    $url = "/adminpanel?page=$page";
    
    DB::table('users')
        ->where('name', $username)
        ->update(['status' => 0, 'admin' => 0]);
        
    header("Location: $url");
    exit;
    
})->middleware(['auth', 'verified'])->name('banuser');

Route::post('/unbanuser', function () {
    $username = $_POST["username_unban"];
    $page = DB::table('users')->where('name', $username)->value('id');
    $page = strval(ceil($page / 5));
    $url = "/adminpanel?page=$page";
    
    DB::table('users')
        ->where('name', $username)
        ->update(['status' => 1]);
        
    header("Location: $url");
    exit;
    
})->middleware(['auth', 'verified'])->name('unbanuser');

Route::post('/adminpromote', function () {
    $username = $_POST["username_promote"];
    $page = DB::table('users')->where('name', $username)->value('id');
    $page = strval(ceil($page / 5));
    $url = "/adminpanel?page=$page";
    
    DB::table('users')
        ->where('name', $username)
        ->update(['admin' => 1]);
        
    header("Location: $url");
    exit;
    
})->middleware(['auth', 'verified'])->name('adminpromote');

Route::post('/admindemote', function () {
    $username = $_POST["username_demote"];
    $page = DB::table('users')->where('name', $username)->value('id');
    $page = strval(ceil($page / 5));
    $url = "/adminpanel?page=$page";
    
    DB::table('users')
        ->where('name', $username)
        ->update(['admin' => 0]);
        
    header("Location: $url");
    exit;
    
})->middleware(['auth', 'verified'])->name('admindemote');

Route::get('/adminpanel', function () {
    return view('adminpanel');
})->middleware(['auth', 'verified'])->name('adminpanel');

require __DIR__.'/auth.php';