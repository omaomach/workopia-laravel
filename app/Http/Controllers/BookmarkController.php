<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookmarkController extends Controller
{
    // @desc Get All users bookmarks
    // @route GET /bookmarks

    public function index(): View
    {
        $user = Auth::user();

        $bookmarks = $user->bookmarkedJobs()->paginate(9);
        return view('jobs.bookmarked')->with('bookmarks', $bookmarks);
    }
}
