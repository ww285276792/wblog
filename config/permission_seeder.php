<?php

return [
//    后端
    'backend' => [
        'permissions' => [
//            控制台
            [
                'name' => 'admin.dash',
                'display_name' => '控制台',
                'description' => '控制台',
            ],
            [
                'name' => 'admin_article.index',
                'display_name' => '文章列表',
                'description' => '文章列表',
            ],
            [
                'name' => 'admin_article.create',
                'display_name' => '添加文章页面',
                'description' => '添加文章页面',
            ],
            [
                'name' => 'admin_article.store',
                'display_name' => '保存文章',
                'description' => '保存文章',
            ],
            [
                'name' => 'admin_article.edit',
                'display_name' => '修改文章页面',
                'description' => '修改文章页面',
            ],
            [
                'name' => 'admin_article.update',
                'display_name' => '编辑文章',
                'description' => '编辑文章',
            ],
            [
                'name' => 'admin_article.destroy',
                'display_name' => '删除文章',
                'description' => '删除文章',
            ],
            [
                'name' => 'admin_article_comment.index',
                'display_name' => '评论列表',
                'description' => '评论列表',
            ],
            [
                'name' => 'admin_article_comment.destroy',
                'display_name' => '删除评论',
                'description' => '删除评论',
            ],
            [
                'name' => 'admin_tag.index',
                'display_name' => '标签列表',
                'description' => '标签列表',
            ],
            [
                'name' => 'admin_tag.create',
                'display_name' => '添加标签页面',
                'description' => '添加标签页面',
            ],
            [
                'name' => 'admin_tag.store',
                'display_name' => '保存标签',
                'description' => '保存标签',
            ],
            [
                'name' => 'admin_tag.edit',
                'display_name' => '修改标签页面',
                'description' => '修改标签页面',
            ],
            [
                'name' => 'admin_tag.update',
                'display_name' => '编辑标签',
                'description' => '编辑标签',
            ],
            [
                'name' => 'admin_tag.destroy',
                'display_name' => '删除标签',
                'description' => '删除标签',
            ],
            [
                'name' => 'admin_message.index',
                'display_name' => '留言列表',
                'description' => '留言列表',
            ],
            [
                'name' => 'admin_message.destroy',
                'display_name' => '删除留言',
                'description' => '删除留言',
            ],
            [
                'name' => 'admin_changelog.index',
                'display_name' => '更新日志列表',
                'description' => '更新日志列表',
            ],
            [
                'name' => 'admin_changelog.create',
                'display_name' => '添加更新日志页面',
                'description' => '添加更新日志页面',
            ],
            [
                'name' => 'admin_changelog.store',
                'display_name' => '保存更新日志',
                'description' => '保存更新日志',
            ],
            [
                'name' => 'admin_changelog.edit',
                'display_name' => '修改更新日志页面',
                'description' => '修改更新日志页面',
            ],
            [
                'name' => 'admin_changelog.update',
                'display_name' => '编辑更新日志',
                'description' => '编辑更新日志',
            ],
            [
                'name' => 'admin_user.index',
                'display_name' => '管理员列表',
                'description' => '管理员列表',
            ],
            [
                'name' => 'admin_user.create',
                'display_name' => '添加管理员页面',
                'description' => '添加管理员页面',
            ],
            [
                'name' => 'admin_user.store',
                'display_name' => '保存管理员',
                'description' => '保存管理员',
            ],
            [
                'name' => 'admin_user.edit',
                'display_name' => '修改管理员页面',
                'description' => '修改管理员页面',
            ],
            [
                'name' => 'admin_user.update',
                'display_name' => '编辑管理员',
                'description' => '编辑管理员',
            ],
            [
                'name' => 'admin_user.destroy',
                'display_name' => '删除管理员',
                'description' => '删除管理员',
            ],
            [
                'name' => 'admin_user_role.index',
                'display_name' => '角色列表',
                'description' => '角色列表',
            ],
            [
                'name' => 'admin_user_role.create',
                'display_name' => '添加角色页面',
                'description' => '添加角色页面',
            ],
            [
                'name' => 'admin_user_role.store',
                'display_name' => '保存角色',
                'description' => '保存角色',
            ],
            [
                'name' => 'admin_user_role.edit',
                'display_name' => '修改角色页面',
                'description' => '修改角色页面',
            ],
            [
                'name' => 'admin_user_role.update',
                'display_name' => '编辑角色',
                'description' => '编辑角色',
            ],
            [
                'name' => 'admin_user_role.destroy',
                'display_name' => '删除角色',
                'description' => '删除角色',
            ],
            [
                'name' => 'admin_setting_banner.index',
                'display_name' => 'banner列表',
                'description' => 'banner列表',
            ],
            [
                'name' => 'admin_setting_banner.create',
                'display_name' => '添加banner页面',
                'description' => '添加banner页面',
            ],
            [
                'name' => 'admin_setting_banner.store',
                'display_name' => '保存banner',
                'description' => '保存banner',
            ],
            [
                'name' => 'admin_setting_banner.edit',
                'display_name' => '修改banner页面',
                'description' => '修改banner页面',
            ],
            [
                'name' => 'admin_setting_banner.update',
                'display_name' => '编辑banner',
                'description' => '编辑banner',
            ],
            [
                'name' => 'admin_setting_banner.destroy',
                'display_name' => '删除banner',
                'description' => '删除banner',
            ],
            [
                'name' => 'admin_setting_site.edit',
                'display_name' => '修改站点设置页面',
                'description' => '修改站点设置页面',
            ],
            [
                'name' => 'admin_setting_site.update',
                'display_name' => '编辑站点设置',
                'description' => '编辑站点设置',
            ],
        ]
    ],
//    前端
    'web' => [
        'permissions' => [
            [
                'name' => 'home',
                'display_name' => '首页',
                'description' => '首页',
            ],
        ]
    ]
];
