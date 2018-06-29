<?php

namespace App\Http\Controllers;

use App\Repositories\HeadshotRepository;
use Illuminate\Http\Request;

class HeadshotController extends BaseController
{
    protected $headshotRepository;

    public function __construct(HeadshotRepository $headshotRepository)
    {
         $this->headshotRepository=  $headshotRepository;
    }

    public  function list(){
         $data=$this->headshotRepository->list();
         return view('headshot.list',['data'=>$data]);
    }

    public function audit(Request $request){
        $id=$request->id;
        $status=$request->status;
         if($this->headshotRepository->audit($id,$status)){
             parent::saveLog('审核头像id--'.$id);
             return redirect('/headshot/list');
         }else{
             return redirect('/headshot/list');
         }
    }
}
