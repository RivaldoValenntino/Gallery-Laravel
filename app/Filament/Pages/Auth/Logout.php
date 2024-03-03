<?php

namespace App\Http\Controllers\Filament\Auth;
use Filament\Http\Controllers\Auth\LogoutController as BaseLogoutController;
use Illuminate\Http\Request;

class LogoutController extends BaseLogoutController{
    public function logout(Request $request){
        
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}