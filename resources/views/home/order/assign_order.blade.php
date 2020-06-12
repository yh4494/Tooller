@extends('home.template')

@section('template')
    <form style="margin-top: 15px;">
        <h5>添加收单量</h5>
        <div class="form-group">
            <label for="exampleInputEmail1">人员选择</label>
            <select class="form-control">

            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">收单数量</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
        </div>
        <button type="submit" class="btn btn-primary">提交</button>
    </form>
    <hr>
    <form style="margin-top: 15px;">
        <h5>添加收单人员</h5>
        <div class="form-group">
            <label for="exampleInputEmail1">姓名</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">组</label>
            <select class="form-control">
                <option value="1">南A</option>
                <option value="2">南B</option>
                <option value="3">南C</option>
                <option value="4">南D</option>
                <option value="5">柳A</option>
                <option value="6">柳B</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">团队</label>
            <select class="form-control">
                <option value="1">南宁团队</option>
                <option value="2">柳州团队</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">提交</button>
    </form>
    <hr>
@endsection