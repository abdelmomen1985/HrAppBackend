<?php

namespace App\Http\Controllers;

use App\AppSetting;
use Illuminate\Http\Request;

class SettingCtrl extends Controller
{
    //
    public function index() {
        echo 'get AppSetting';
        return AppSetting::all();
    }
}
