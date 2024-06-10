<?php
namespace App\Http\Controllers\Api;



use App\Models\ClientModel;
use Illuminate\Http\Request;

class ClientController
{
    function reg($name,Request $request){
        $tm=$request->input('timestamp');
        $ver=$request->input('version',"");
        $nonce=bin2hex(random_bytes(10));
        if(!$tm){
            return $this->fail('缺少必要参数');
        }
        $row=ClientModel::where('name',$name)->first();
        if($row){
            if(!$row->status){
                return $this->fail('当前状态不可用',401);
            }
            $row->last_time=date('Y-m-d H:i:s',$tm);
            $row->last_ip=$request->ip();
            $row->version=$ver;
            $row->save();
            return $this->ok([
                'sign'=>$this->sign($row,$tm,$nonce),
                'nonce'=>$nonce,
            ]);
        }
        $row=ClientModel::create([
            'name'=>$name,
            'status'=>1,
            'last_time'=>date('Y-m-d H:i:s',$tm),
            'last_ip'=>$request->ip(),
            'version'=>$ver
        ]);

        return $this->ok([
            'sign'=>$this->sign($row,$tm,$nonce),
            'nonce'=>$nonce,
        ]);
    }

    protected function response($code,$msg,$data){
        return [
            'code'=>$code,
            'msg'=>$msg,
            'data'=>$data
        ];
    }

    protected function ok($data,$msg='OK'){
        return $this->response(200,$msg,$data);
    }
    protected function fail($msg,$code=400,$data=null){
        return $this->response($code,$msg,$data);
    }

    protected function sign($clientMode,$timestamp,$nonce){
        return  md5("aLphaJonG{$clientMode->name}_{$timestamp}_{$nonce}aLphaJonG");
    }
}
