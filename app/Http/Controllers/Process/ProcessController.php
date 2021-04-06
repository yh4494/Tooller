<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\BasicController;
use App\Lib\CommonUtils;
use App\Lib\JsonTooller;
use App\Model\Article;
use App\Model\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProcessController extends BasicController
{
    /**
     * 今日任务
     * @param Request $request
     * @return false|string
     */
    public function todayTask(Request $request)
    {
        $process = Process::select('*')->with('article')->where([
            ['pid', '!=', 0],
            ['create_at', '>', strtotime(date('ymd', time())) - 24 * 60 * 60],
            ['create_at', '<', strtotime(date('ymd', time())) + 24 * 60 * 60]
        ])->get();
        return JsonTooller::data(0, '返回成功', $process->toArray());
    }

    public function index(Request $request)
    {
        $process = null;
        $sprint  = $request->get('sprint');
        if ($sprint && $sprint == 'true') {
            $process = Process::where([['user_id', '=', $this->userId], ['pid', '!=', 0]])->get()->groupBy('status');
            isset($process[2]) ? '' : $process[2] = [];
            isset($process[1]) ? '' : $process[1] = [];
            isset($process[0]) ? '' : $process[0] = [];
        }
        return view('home.process.process_index', [
            'route'   => 'process',
            'sprint'  => $sprint  ?? false,
            'process' => isset($process) ? $process->toArray() : []
        ]);
    }

    public function wall(Request $request)
    {
        $process = Process::where([['user_id', '=', $this->userId], ['pid', '!=', 0]])->get()->groupBy('status');
        isset($process[2]) ? '' : $process[2] = [];
        isset($process[1]) ? '' : $process[1] = [];
        isset($process[0]) ? '' : $process[0] = [];
        return view('home.process.process_wall', [
            'route'   => 'wall',
            'sprint'  => $sprint  ?? false,
            'process' => isset($process) ? $process->toArray() : []
        ]);
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
        $process = Process::where($where)->with(['childProcess' => function ($query) use ($request) {
            $query->with(['article' => function($articleQuery) { return $articleQuery->select('id', 'process_id'); }]);
            if (!CommonUtils::Judge($request->get('history'))) {
                $query->where('status', 0);
            }
        }])->get();
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

    /**
     * 改变状态
     *
     * @param Request $request
     * @return false|string
     */
    public function changeStatus(Request $request)
    {
        $process = Process::find($request->get('id'));
        $process->status = $request->get('status');
        $process->save();
        return JsonTooller::success();
    }
}
