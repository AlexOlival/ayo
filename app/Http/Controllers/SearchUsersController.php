<?php

namespace App\Http\Controllers;

use App\User;

class SearchUsersController extends Controller
{
    public function __invoke()
    {
        if (request()->get('q') === null) {
            return response()->json('No results found.', 404);
        }

        $results = User::search(request()->get('q'));

        if ($results->isEmpty()) {
            return response()->json('No results found.', 404);
        }

        return $results;
    }
}
