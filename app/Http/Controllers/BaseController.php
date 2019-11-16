<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\permission;
class BaseControllerr extends Controller
{

    public function __construct($permissions)
    {
        $permissions = permission::where("user_id",session("user_id"))->first();
        View::share('permissions', $permissions);
    }
}
