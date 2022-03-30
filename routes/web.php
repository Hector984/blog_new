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
    return view('home');
});


$posts = [
    1 => [
        'title' => 'Intro to laravel',
        'content' => 'This is a short intro to laravel',
        'is_new' => true,
        'has_comments' => true
    ],
    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is a short intro to PHP',
        'is_new' => false
    ]
];

// Route::get('/posts', function() use($posts){
//     return view('posts.index', ['posts' => $posts]);
// });

// Route::get('/posts/{id}', function($id) use($posts){
    
    
//     abort_if(!isset($posts[$id]), 404); 

//     return view('posts.show', ['post' => $posts[$id]]);
// })->name('posts.show');

Route::resource('posts', App\Http\Controllers\PostController::class);

Route::prefix('/fun')->name('fun.')->group(function() use($posts){

    Route::get('/fun/responses', function() use($posts){
        return response($posts, 201)
        ->header('Content-Type', 'application/json')
        ->cookie('MY_COOKIE', 'Piotr Jura', 3600);
    });
    
    Route::get('/fun/redirect', function(){
        return redirect('/posts');
    });
    
    Route::get('/fun/back', function(){
        return back();
    });
    
    Route::get('/fun/named-route', function(){
        return redirect()->route('posts.show', ['id' => 1]);
    });
    
    Route::get('/fun/away', function(){
        return redirect()->away('https://google.com'); 
    });
    
    Route::get('/fun/download',function() use($posts){
        return response()->download(public_path('/descarga.jpg'), 'pikachu.jpg');
    });

});

Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home.index');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('home.contact');

//Single controllers:invoke
Route::get('/single', App\Http\Controllers\AboutController::class);
Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
