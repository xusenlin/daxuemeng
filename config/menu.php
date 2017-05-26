<?php
return [
    'group0'=>array(
        'home' => array('name'=>'首页',
            'icon'=>'fa-home',
            'link'=>'admin',
        )
    ),
    //分组一
    'group1'    =>array(
        'info'  =>array(
            'name'=>'个人中心',
            'icon'=>'fa-user',
            'submenu'=>array(
                array(
                    'name'=>'我的信息',
                    'icon'=>'fa-circle-o',
                    'link'=>'admin.personal_center',
                ),
            )
        ),
        'users'  =>array(
            'name'=>'用户管理',
            'icon'=>'fa-users',
            'submenu'=>array(
                array(
                    'name'=>'注册用户',
                    'icon'=>'fa-circle-o',
                    'link'=>'admin.users',
                ),
            )
        ),
        'photo'  =>array(
            'name'=>'照片管理',
            'icon'=>'fa-picture-o',
            'submenu'=>array(
                'project_list'  =>array(
                    'name'=>'照片列表',
                    'icon'=>'fa-circle-o',
                    'link'=>'admin',
                ),
            ),
        ),
        'live'  =>array(
            'name'=>'生活管理',
            'icon'=>'fa-desktop',
            'submenu'=>array(
                array(
                    'name'=>'兼职',
                    'icon'=>'fa-circle-o',
                    'link'=>'admin.part_time_job',
                ),
                array(
                    'name'=>'租赁',
                    'icon'=>'fa-circle-o',
                    'link'=>'admin.leases_list',
                ),
                array(
                    'name'=>'驾校',
                    'icon'=>'fa-circle-o',
                    'link'=>'admin.driving_list',
                ),
                array(
                    'name'=>'课程表',
                    'icon'=>'fa-circle-o',
                    'link'=>'admin.course_list',
                ),
                array(
                    'name'=>'二手市场',
                    'icon'=>'fa-circle-o',
                    'link'=>'admin.secondary_list',
                ),
            )
        ),
        'basic_data'  =>array(
            'name'=>'基础数据',
            'icon'=>'fa-database',
            'submenu'=>array(
                array(
                    'name'=>'学校管理',
                    'icon'=>'fa-circle-o',
                    'link'=>'admin.school_list',
                ),
                array(
                    'name'=>'院系管理',
                    'icon'=>'fa-circle-o',
                    'link'=>'admin.department_list',
                ),
                array(
                    'name'=>'专业管理',
                    'icon'=>'fa-circle-o',
                    'link'=>'admin.major_list',
                )
            )
        ),
        'role'  =>array(
            'name'=>'权限管理',
            'icon'=>'fa-qrcode',
            'submenu'=>array(
                'role_list'  =>array(
                    'name'=>'角色权限',
                    'icon'=>'fa-circle-o',
                    'link'=>'admin.roles_list',
                ),
                'user_permission_list'  =>array(
                    'name'=>'用户角色',
                    'icon'=>'fa-circle-o',
                    'link'=>'admin.roles_users',
                )
            )
        ),
    ),
    //分组二
    'group2'    =>array(
        'contact'  =>array(
            'name'=>'回收站',
            'icon'=>'fa-trash text-red',
            'link'=>'admin.recycle_bin',
        ),
    ),

];