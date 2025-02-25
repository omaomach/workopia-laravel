<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\View\View;

class HomeController extends Controller
{
    // Show home index view
    // @route GET /
    public function index(): View
    {
        // session()->put('test', '123');
        // session()->forget('test');

        $jobs = Job::latest()->limit(6)->get();

        return view('pages.index')->with('jobs', $jobs);
    }
}
