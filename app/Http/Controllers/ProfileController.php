<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Models\HrComponent;
use App\SmartSystem\General;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $data = array();
        $data['judul'] = 'Profil';
        $data['aktif'] = 'Profil Siswa';
        $data['profil'] = General::getProfil();
        return view('profile.edit',$data);
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        if (auth()->user()->id == 1) {
            return back()->withErrors(['not_allow_profile' => __('Tidak diizinkan edit profil Admin')]);
        }

        $berhasil = auth()->user()->update($request->all());
        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        if (auth()->user()->id == 1) {
            return back()->withErrors( __('Tidak diizinkan edit profil Admin'));
        }

        $inputpassword = $request->get('old_password');
        $currentpassword = auth()->user()->password;

        if(!Hash::check($inputpassword, $currentpassword))
        {
            return back()->withErrors('Password yang saat ini aktif, salah!');
        }

        $berhasil = auth()->user()->update(['password' => Hash::make($request->get('password'))]);
        return back()->withPasswordStatus(__('Password berhasil diganti!'));
    }
}
