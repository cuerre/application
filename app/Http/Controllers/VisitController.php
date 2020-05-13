<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\InputController;
use App\Http\Controllers\ActionController;

/** 
 * VisitController control the flow for 
 * /redirect route requests
 * 
 * VisitController is who control the flow 
 * for /redirect route, collecting data first
 * and redirecting after that.
 * 
 * Example usage:
 * 
 * @package Cuerre
 * @author Alby Hernández
 * @version $Revision: 1.0 $
 * @access private
 * @see http://cuerre.com/documentation
 */
class VisitController extends Controller
{
    /**
     * Sequentially perform all tasks 
     * relevant to a visit
     * 
     * @return  void
     */
    public static function Pipeline (Request $request)
    {   
        # Save request information into DB
        InputController::CollectData ($request);
        
        # Redirect the request according to the target
        ActionController::Redirect ($request);
    }
}
