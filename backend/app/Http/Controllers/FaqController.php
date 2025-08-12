<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faqs;
use Inertia\Inertia;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faqs::first();
        return Inertia::render('Welcome', [
            'faqs' => $faqs,
        ]);
    }



    public function getFaq()
    {
        $faqs = Faqs::all();
        return response()->json($faqs);
    }

/* 
    public function showSettingsPage()
    {
        $settings = SiteSettings::first(); // ou SiteSettings::latest()->first();

        $images = [
            'logo' => $settings->logo ? asset('storage/' . $settings->logo) : null,
            'image_accueil' => $settings->image_accueil ? asset('storage/' . $settings->image_accueil) : null,
            'img1_propos' => $settings->img1_propos ? asset('storage/' . $settings->img1_propos) : null,
            'img2_propos' => $settings->img2_propos ? asset('storage/' . $settings->img2_propos) : null,
            'img3_propos' => $settings->img3_propos ? asset('storage/' . $settings->img3_propos) : null,
            'img4_propos' => $settings->img4_propos ? asset('storage/' . $settings->img4_propos) : null,
        ];

        return Inertia::render('Welcome', [
            'settings' => array_merge($images, [
                'title_propos' => $settings->title_propos,
                'text_propos' => $settings->text_propos,
            ])
        ]);
    }
 */

}