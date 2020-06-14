<?php


namespace App\Http\Controllers;



use App\Model\User;
use Illuminate\Support\Facades\Request;

class BasicController extends Controller
{
    protected $user;

    public function __construct()
    {
        $userId = Request::session()->get('user_id');
        if ($userId) {
            $this->user = User::find($userId);
            view()->share('userId', $userId);
            view()->share('user', $this->user);
            view()->share('isLogin', true);
            view()->share('userName', $this->user->nickname);
        }
    }
}
