<?php

namespace App\Http\Controllers;

use App\User;
use Symfony\Component\HttpFoundation\Response;

class SearchUsersController extends Controller
{
    public function __invoke()
    {
        $query = request()->get('q');
        
        if ($query === null) {
            return response()->json('No results found.', Response::HTTP_NOT_FOUND);
        }

        $results = User::search($query)->get();

        if ($results->isEmpty()) {
            return response()->json('No results found.', Response::HTTP_NOT_FOUND);
        }

        return $results;
    }
}
