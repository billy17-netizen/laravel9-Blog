<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class AdminSettingsController extends Controller
{
    public function edit()
    {
        return view('admin_dashboard.about.edit',[
            'setting' => Setting::find(1)
        ]);
    }

    public function update()
    {
        $validated = request()->validate([
            'about_first_text' => 'required|min:3|max:255',
            'about_second_text' => 'required|min:3|max:255',
            'about_our_mission' => 'required',
            'about_our_vision' => 'required',
            'about_services' => 'required',
            'about_first_image' => 'nullable|image',
            'about_second_image' => 'nullable|image'
        ]);

        if (request()->hasFile('about_first_image'))
        {
            $about_first_image = request()->file('about_first_image');
            $path = $about_first_image->store('setting', 'public');

            $validated['about_first_image'] = $path;
        }

        if (request()->hasFile('about_second_image'))
        {
            $about_second_image = request()->file('about_second_image');
            $path = $about_second_image->store('setting', 'public');

            $validated['about_second_image'] = $path;
        }

        Setting::find(1)->update($validated);
        return redirect()->route('admin.settings.edit')->with('success','Settings updated successfully');
    }
}
