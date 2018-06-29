<?php
/**
 * Created by PhpStorm.
 * User: LegendX
 * Date: 2018/2/5
 * Time: 20:36
 */

namespace App\Http\Controllers;

use App\Repositories\SpringActivityRepository;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;

class SpringActivityController
{
    private $springActivityRepository;

    public function __construct(SpringActivityRepository $springActivityRepository)
    {
        $this->springActivityRepository=$springActivityRepository;
    }

    public function index()
    {
        $client=new Client();
        $response=$client->get('http://192.168.1.27:8888/get_activity_data?activity_type=1&logic_type=3');
        if ($response->getStatusCode()==200)
        {
            $body=$response->getBody();
            $result=json_decode($body);
            if ($result->result==1)
            {
                return view('springactivity.index',['list'=>$result->list]);
            }
        }
    }

    public function contact(Request $request)
    {
        $uid=$request->get('uid');
        $contact=$this->springActivityRepository->getContactByUser($uid);
        return response()->json(['status'=>200,'msg'=>'ok','data'=>$contact]);
    }
}