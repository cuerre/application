<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\InputController;

class VisitController extends Controller
{
    /**
     * Sequentially perform all tasks 
     * relevant to a visit
     * 
     * @return 
     */
    public static function Pipeline (Request $request)
    {   
        # Save request information into DB
        InputController::CollectData ($request);
        
        # Redirect the request according to the target
        ActionController::Redirect ($request);
    }
}
