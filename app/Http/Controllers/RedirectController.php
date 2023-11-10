<?php

namespace App\Http\Controllers;

use App\Models\Short;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirect(string $hash)
    {
        $url = Short::where('hash', $hash)->firstOrFail();

        if ($url) {
            $url->increment('visits_count');
            return redirect($url->original_url);
        };
        abort(404);
    }
}
