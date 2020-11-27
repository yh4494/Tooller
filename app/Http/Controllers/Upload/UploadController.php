<?php


namespace App\Http\Controllers\Upload;


use App\Http\Controllers\BasicController;
use App\Model\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadController extends BasicController
{
    /**
     * @param Request $request
     */
    public function upload(Request $request)
    {
        $fileCharater = $request->file('file');
        if ($fileCharater->isValid()) { // 括号里面的是必须加的哦
            //如果括号里面的不加上的话，下面的方法也无法调用的
            //获取文件的扩展名
            $ext = $fileCharater->getClientOriginalExtension();
            //获取文件的绝对路径
            $path = $fileCharater->getRealPath();
            $filennameOrigin = $fileCharater->getClientOriginalName();

            Log::info($filennameOrigin);
            Log::info(explode('.', $filennameOrigin)[0]);
            $filename = md5(date('Y-m-d-h-i-s')) . '.' .$ext;

            $book = new Book();
            $book->book_name = str_replace('.' . $ext, '', $filennameOrigin);
            $book->pdf_url   = '/storage/app/public/' . $filename;
            $book->mark      = $request->get('markInput');
            $book->save();

            //存储文件。disk里面的public。总的来说，就是调用disk模块里的public配置
            Storage::disk('public')->put($filename, file_get_contents($path));
        }

    }
}
