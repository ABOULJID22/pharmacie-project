<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSettings;
use Inertia\Inertia; 

class SiteSettingController extends Controller
{
    public function index()
    {
        $settinginfos = SiteSettings::all();
        return Inertia::render('settinginfos', [
            'settinginfos' => $settinginfos,
        ]);
    }


    public function getInfo()
{
    $settinginfos = SiteSettings::first(); 

   
/*     $settinginfos->logo = $settinginfos->logo ? asset('storage/' . $settinginfos->logo) : null;
 */
    return response()->json($settinginfos);
}


}
