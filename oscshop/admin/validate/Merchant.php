<?php

namespace osc\admin\validate;
use think\Validate;
class Merchant extends Validate
{
    protected $rule = [
        'username'  =>  'require|min:2|max:32|unique:merchant',
    ];

    protected $message = [
        'username.require'  =>  '商户号必填',
        'username.min'  =>  '商户号不能小于两个字',
        'username.max'  =>  '商户号不能大于32个字',
        'username.unique'  =>  '商户号已经存在',
    ];
}
?>