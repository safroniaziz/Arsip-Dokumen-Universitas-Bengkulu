<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OperatorDashboardController extends Controller
{
    public function dashboard(){
        return view('operator/dashboard');
    }
}
