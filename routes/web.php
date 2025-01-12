<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

// Route::match(['get', 'post'], '/submit', function () {
//     return 'Submitted';
// });

// Route::any('/submit', function () {
//     return 'Submitted';
// });

// Route::get('/test', function () {
//     $url = route('jobs'); // We have assigned the route named 'jobs' to the $url variable
//     return "<a href='$url'>Click Here</a>";
// });

// Route::get('/api/users', function () {
//     return [
//         'name' => 'Joshua Bongoye',
//         'email' => 'joshua@gmail.com'
//     ];
// });

// Route::get('/posts/{id}', function (string $id) {
//     return 'Post ' . $id;
// })->whereNumber('id'); // This implies that the id can only be numbers

// Route::get('/posts/{id}', function (string $id) {
//     return 'Post ' . $id;
// })->whereAlpha('id'); // This implies that the id can only be letters

// Route::get('/posts/{id}/comments/{commentId}', function (string $id, string $commentId) {
//     return 'Post ' . $id . ' Comment ' . $commentId;
// });

// Route::get('/test', function (Request $request) {
//     return [
//         'method' => $request->method(),
//         'url' => $request->url(),
//         'path' => $request->path(),
//         'fullUrl' => $request->fullUrl(),
//         'ip' => $request->ip(),
//         'userAgent' => $request->userAgent(),
//         'header' => $request->header(),
//     ];
// });

// Route::get('/users', function (Request $request) {
//     // return $request->has('name'); // check to see if a query param exists
//     // return $request->query('name');
//     // return $request->only(['name', 'age']);
//     // return $request->all();
//     return $request->except(['name']);
// });

// Route::get('/test', function () {
//     return response('<h1>Hello World</h1>', 200)->header('Content-Type', 'text/plain');
// });

// Route::get('/test', function () {
//     return response('<h1>Hello World</h1>', 200)->header('Content-Type', 'text/html');
// });

// Route::get('/test', function () {
//     return response()->json(['name' => 'Joshua Bongoye'])->cookie('name', 'Joshua');
// });

// Route::get('/notfound', function () {
//     return response('Page Not Found', 404);
// });

// Route::get('/download', function () {
//     return response()->download(public_path('favicon.ico'));
// });

// Route::get('/read-cookie', function (Request $request) {
//     $cookieValue = $request->cookie('name');
//     return response()->json(['cookie' => $cookieValue]);
// });

Route::get('/jobs', function () {
    $title = 'Available Jobs';
    $jobs = [
        'Web Developer',
        'Database Admin',
        'Software Engineer',
        'Systems Analyst'
    ];

    return view('jobs.index', compact('title', 'jobs'));
})->name('jobs'); // We have given a name to this route

Route::get('/jobs/create', function () {
    return view('jobs.create');
})->name('jobs.create');
