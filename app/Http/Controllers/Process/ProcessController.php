<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\BasicController;
use App\Lib\CommonUtils;
use App\Lib\JsonTooller;
use App\Model\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProcessController extends BasicController
{
    public function index()
    {
        return view('home.process.process_index', ['route' => 'process']);
    }

    /**
     * 获取所有
     *
     * @return false|string
     */
    public function all(Request $request)
    {
        $array = [];
        $where = [];
        array_push($where, ['pid', '=', 0]);
        array_push($where, ['user_id', '=', $this->user->id]);
        if ($request->get('pid') && $request->get('pid') != 'null') {
            array_push($where, ['id', '=', $request->get('pid')]);
        }
        $process = Process::where($where)->get();
        foreach ($process as $k => $p) {
            $tempArr = [];
            $child = Process::where('pid', $p->id)->with('article')->get();
            foreach ($child as $s) {
                if (($s && $s->status != 1) || CommonUtils::Judge($request->get('history'))) {
                    $tempArr[] = $s;
                }
            }
            $p->child = $tempArr;
            array_push($array, $p);
        }
        return JsonTooller::data(0, '返回数据成功', $process->toArray());
    }

    /**
     * 获取所有父任务
     *
     * @param Request $request
     * @return false|string
     */
    public function mainProcess(Request $request)
    {
        $process = Process::where([['pid', '=', 0], ['user_id', '=', $this->user->id]])->get();
        return JsonTooller::data(0, '返回数据成功', $process->toArray());
    }

    /**
     * 删除成功
     *
     * @param $id
     * @return false|string
     */
    public function delete($id)
    {
        $process = Process::find($id);
        if ($process && $process->delete()) {
            return JsonTooller::success();
        }
        return JsonTooller::commonError();
    }

    /**
     * 完成 process
     *
     * @param $id
     * @return false|string
     */
    public function complete($id)
    {
        $process = Process::find($id);
        if ($process) {
            $process->status = 1;
            $process->save();
            return JsonTooller::success();
        }
        return JsonTooller::commonError();
    }

    /**
     * 完成 process
     *
     * @param $id
     * @return false|string
     */
    public function cancel($id)
    {
        $process = Process::find($id);
        if ($process) {
            $process->status = 0;
            $process->save();
            return JsonTooller::success();
        }
        return JsonTooller::commonError();
    }

    /**
     * 添加Process
     *
     * @param Request $request
     * @return false|string
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|max:255',
            'content' => 'required|max:255',
            'pid'     => 'required'
        ]);

        if ($validator->fails()) {
            return JsonTooller::paramsFail();
        }

        $process = new Process();
        $process->name    = $request->get('name');
        $process->content = $request->get('content');
        $process->status  = 0;
        $process->pid     = $request->get('pid');

        if ($process->save()) {
            return JsonTooller::success();
        }

        return JsonTooller::systemError();
    }
}
