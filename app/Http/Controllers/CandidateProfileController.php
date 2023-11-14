<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CandidateProfile;

class CandidateProfileController extends Controller
{
    public function resume_list()
    {
        $resume_list = CandidateProfile::all();
        return response([
            'resumes' => $resume_list,
            'success' => true,
        ]);
    }

    public function profile_save(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required|min:3|max:255',
            'email'=>'required|email|min:8|max:255',
            'dob'=>'required',
            'state'=>'required|min:2|max:255',
            'gender'=>'required|min:3|max:255',
            'loacation'=>'required|min:3|max:255',
            'profile_image'=>'required',
            'resume'=>'required',
        ]);

        $profile_path = $request->file('profile_image')->store('profile_images', 'public');
        $resume_path = $request->file('resume')->store('resumes', 'public');

        $candidate_profile = new CandidateProfile();
        $candidate_profile->name = $request->name;
        $candidate_profile->email = $request->email;
        $candidate_profile->dob = $request->dob;
        $candidate_profile->state = $request->state;
        $candidate_profile->gender = $request->gender;
        $candidate_profile->loacation = $request->loacation;
        $candidate_profile->profile_image = $profile_path;
        $candidate_profile->resume = $resume_path;
        $candidate = $candidate_profile->save();

        if ($candidate) 
        {
            return response([
                'message' => 'Profile Saved Successfully!',
                'success' => true,
            ]);
        }
    }
}
