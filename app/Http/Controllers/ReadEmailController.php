<?php

namespace App\Http\Controllers;

// use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\coldcallingModel;


class ReadEmailController extends Controller
{

    public function reademail(Request $request)
    {
        // dd($request->all());
        $search = $request->keyword;

        $result = coldcallingModel::distinct('email')->where('email', 'like', $search.'%')->get();

        
        // dd($result);

        foreach($result as $key => $value){
        	echo '<li id="pick_me'.$key.'" onClick="select(this.id)">'.$value->email.'</li><hr>';
        }
    }

    public function readdata(Request $request){
    	// return $request->all();

    	$result = coldcallingModel::where('email',$request->email)->select('LandLord','contact_no')->first();

    	return $result;
    }
}
