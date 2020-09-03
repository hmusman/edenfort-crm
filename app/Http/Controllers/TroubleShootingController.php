<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\permission;
use App\Models\TroubleShoot;
use Session;

class TroubleShootingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $troublshooting = TroubleShoot::all();
        return view('troublshooting',compact('troublshooting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validation = Validator::make($request->all(), [
            't_heading' => 'required|string',
            't_description' => 'required|string',

        ]);
        if($validation->passes()){
            $heading = $request->t_heading;
            $description = $request->t_description;

            if($request->hasfile('t_video')){
                $file = $request->file('t_video');
                $ext=$file->getClientOriginalExtension();
                $troubleVideo = 'Video-'.rand(111111111,999999999).'.'.$ext;
                $file->move(public_path().'/troubleVideo/' , $troubleVideo);  
             }else{
                $troubleVideo = null;
             }

             TroubleShoot::create(['heading'=>$heading,'description'=>$description,'video'=>$troubleVideo]);

             return response()->json([
               'message'   => 'Entry Added Successfully!'
              ]);
        }else{

             return response()->json([
               'error'   => $validation->errors()->all()
              ]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // dd($id, $request->all());
        // $id = $request->trouble_id;

        $trouble = TroubleShoot::where('id',$id)->first();
        // dd($trouble);
        return view('troubleshootEdit',compact('trouble'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($id, $request->all());
        $validation = Validator::make($request->all(), [
            't_heading' => 'required|string',
            't_description' => 'required|string',

        ]);
        if($validation->passes()){
            $trouble = TroubleShoot::where('id',$id)->first();
            $heading = $request->t_heading;
            $description = $request->t_description;

            if($request->hasfile('t_video')){
                $file = $request->file('t_video');
                $ext=$file->getClientOriginalExtension();
                $troubleVideo = 'Video-'.rand(111111111,999999999).'.'.$ext;
                $file->move(public_path().'/troubleVideo/' , $troubleVideo);  
             }else{
                $troubleVideo = $trouble->video;
             }

             TroubleShoot::where('id',$id)->update(['heading'=>$heading,'description'=>$description,'video'=>$troubleVideo]);

            Session::flash('msg','Entry Updated Successfully.');
            return redirect()->route('troubleshooting.index');
        }else{

            Session::flash('msg','Something went wrong.');
            return redirect()->back();

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trouble = TroubleShoot::where('id',$id)->first();

        $video = $trouble->video;

        if(!empty($video)){
            $file_path = base_path().'/public/troubleVideo/'.$video;
            unlink($file_path);
        }

        $trouble->delete();
        Session::flash('msg','Entry Deleted Successfully.');
        return redirect()->back();
    }


    public function AgentTroubleShoot(){
        $permissions = permission::where('user_id', session('user_id'))->first();
        $troubleshooting = \App\Models\TroubleShoot::all();
        return view('agent-troubleshoot',compact('permissions','troubleshooting'));
    }
}
