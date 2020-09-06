<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\BasicController;
use Illuminate\Http\Request;

class ToollerController extends BasicController
{
    public function mind()
    {
        return view('tooller.mind');
    }

    public function save(Request $request)
    {
        $processId = $request->get('processId');
        $name      = $request->get('name');
        $content   = $request->get('content');
    }
}
