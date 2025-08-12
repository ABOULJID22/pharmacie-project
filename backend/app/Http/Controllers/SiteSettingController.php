<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSettings;
use App\Models\Faqs;
use Inertia\Inertia; 
use App\Models\Teams;

class SiteSettingController extends Controller
{
    

public function welcome()
{
    $settings = SiteSettings::first();
    $faqs = Faqs::all();
    $teams = Teams::all();

    return Inertia::render('Welcome', [
        'settings' => $settings,
        'faqs' => $faqs,
        'teams' => $teams,
    ]);
}

}