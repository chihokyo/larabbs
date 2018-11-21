<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Requests\Api\CaptchaRequest;

class CaptchasController extends Controller
{
    public function store(CaptchaRequest $request, CaptchaBuilder $captchaBuilder)
    {
        //增加了CaptchaRequest接口 注入了CaptchaBuilder
        $key = 'captcha-'.str_random(15);//生成随机数
        $phone = $request->phone;//取出手机号码

        $captcha = $captchaBuilder->build();//调用生成方法
        $expiredAt = now()->addMinutes(2);//设置过期时间
        \Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], $expiredAt);//设置缓存 getPhrase 方法获取验证码文本，跟手机号一同存入缓存。

        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()//inline 方法获取的 base64 图片验证码
        ];

        return $this->response->array($result)->setStatusCode(201);
    }
}