<?php
//自定义辅助方法
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}
// Eloquent 观察器
function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}