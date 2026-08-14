<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        abort_if(!in_array($locale, ['ro', 'en']), 404);

        auth()->user()->profile()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['language_preference' => $locale]
        );

        session(['locale' => $locale]);

        return redirect()->back();
    }
}
