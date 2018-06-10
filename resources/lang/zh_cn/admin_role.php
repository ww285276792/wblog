<?php

return [
    'name' => '角色',
    'permissions' => '权限',
    'manage' => '角色管理',
    'add_user' => '添加角色',
    'edit_user' => '编辑角色',
    'delete_role' => '删除角色',
    'confirm_delete_role' => '你确定删除角色吗?',
    'placeholder' => [
        'input_user' => '请输入用户名',
        'input_display_name' => '请输入名称',
        'input_description' => '请输入描述',
    ],
    'table' => [
        'name' => '标识',
        'display_name' => '名称',
        'description' => '描述',
    ],
    'validator' => [
        'name_required' => '标识不能为空',
        'name_string' => '标识必须是一个字符串',
        'display_name_required' => '名称不能为空',
        'display_name_string' => '名称必须是一个字符串',
        'name_unique' => '标识已经存在',
    ]
];
