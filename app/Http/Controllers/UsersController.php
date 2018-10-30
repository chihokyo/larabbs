<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;//引入模型
use App\Http\Requests\UserRequest;//引入 UserRequest
use App\Handlers\ImageUploadHandler; //引入工具类utility class


class UsersController extends Controller
{

   /* Laravel 会自动解析定义在控制器方法（变量名匹配路由片段）中的 Eloquent 模型类型声明
    1). 路由声明时必须使用 Eloquent 模型的单数小写格式来作为 路由片段参数，User 对应 {user}：
    2). 控制器方法传参中必须包含对应的 Eloquent 模型类型 提示，并且是有序的：*/
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    public function edit(User $user)
    {

        return view('users.edit',compact('user'));
    }

    public function update(UserRequest $request,ImageUploadHandler $uploader,User $user)
    {
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
