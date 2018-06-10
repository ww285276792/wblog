<?php

return [
    'name' => '管理员',
    'manage' => '管理员管理',
    'add_user' => '添加管理员',
    'edit_user' => '编辑管理员',
    'delete_user' => '删除管理员',
    'confirm_delete_user' => '你确定删除管理员吗?',
    'not_delete_superadmin' => '不能删除超级管理员',
    'not_delete_self' => '不能删除自己',
    'placeholder' => [
        'input_user' => '请输入用户名',
        'input_email' => '请输入邮箱地址',
        'input_password' => '请输入密码',
        'input_password_confirmation' => '请输入确认密码',
    ],
    'table' => [
        'name' => '用户名',
        'email' => '邮箱',
        'password' => '密码',
        'password_confirmation' => '确认密码',
    ],
    'validator' => [
        'name_required' => '用户名不能为空',
        'name_string' => '用户名必须是一个字符串',
    ]
];
