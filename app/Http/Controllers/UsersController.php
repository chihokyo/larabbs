<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;//引入模型
use App\Http\Requests\UserRequest;//引入 UserRequest
use App\Handlers\ImageUploadHandler; //引入工具类utility class


class UsersController extends Controller
{
    // 该方法接收两个参数，第一个为中间件的名称，第二个为要进行过滤的动作。
    //Auth 中间件在过滤指定动作时，如该用户未通过身份验证（未登录用户），将会被重定向到登录页面
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

   /* Laravel 会自动解析定义在控制器方法（变量名匹配路由片段）中的 Eloquent 模型类型声明
    1). 路由声明时必须使用 Eloquent 模型的单数小写格式来作为 路由片段参数，User 对应 {user}：
    2). 控制器方法传参中必须包含对应的 Eloquent 模型类型 提示，并且是有序的：*/
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    public function edit(User $user)
    {
        //authorize 方法接收两个参数，第一个为授权策略的名称，第二个为进行授权验证的数据。
        $this->authorize('update', $user);

        return view('users.edit',compact('user'));
    }

    public function update(UserRequest $request,ImageUploadHandler $uploader,User $user)
    {
        //authorize 方法接收两个参数，第一个为授权策略的名称，第二个为进行授权验证的数据。
        $this->authorize('update', $user);
        
        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id,362);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
