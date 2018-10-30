<?php
//自定义辅助方法
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}
