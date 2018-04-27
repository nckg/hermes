<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function show($id, Request $request)
    {
        return call_user_func(
            [response(), $request->has('download') ? 'download' : 'file'],
            Document::find($id)->getFirstMediaPath()
        );
    }
}
