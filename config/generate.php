<?php

return [
    /*
     * Laravel-admin install directory.
     */
    'directory' => config_path(),
    'enable_repo' => true,
    'enable_facade' => true,
    'generate_dir' => 'app/Generate', //生成器类文件路径
    'models_dir' => 'app/Models', //模型类文件路径
    'repos_dir' => 'app/Repositories', //服务类文件路径
    'facades_dir' => 'app/Facades',//Facade类文件路径
    'controller_dir' => 'app/Admin/Controllers',//Controller类文件路径
    'db_config' =>[
        [
            'table_name' => 'testing_advice', //表名
            'model_name' => 'Advices', //model名
            'table_columns' => 'id,tid,range_value,operate_type,note',  //表对应的列
            'info_cache_key' => 'testing.advice.info', //详情缓存信息key
            'cache_time_key' => 'testing.common_cache_time', //详情缓存信息key
            'cache_tag' => 'testing.advice', //redis缓存对应的 tag
        ],
        [
            'table_name' => 'testing_advice', //表名
            'model_name' => 'AdvicesTTT', //model名
            'table_columns' => 'id,tid,range_value,operate_type,note',  //表对应的列
            'info_cache_key' => 'testing.advice.info', //详情缓存信息key
            'cache_time_key' => 'testing.common_cache_time', //详情缓存信息key
            'cache_tag' => 'testing.advice', //redis缓存对应的 tag
        ],
        [
            'table_name' => 'testing_advice', //表名
            'model_name' => 'AdvicesRRR', //model名
            'table_columns' => 'id,tid,range_value,operate_type,note',  //表对应的列
            'info_cache_key' => 'testing.advice.info', //详情缓存信息key
            'cache_time_key' => 'testing.common_cache_time', //详情缓存信息key
            'cache_tag' => 'testing.advice', //redis缓存对应的 tag
        ]
    ]
];
