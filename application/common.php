<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function permission_jstree_data($tree, $selected_ids=[])
{
    $result = [];
    foreach($tree as $val)
    {
        $selected = in_array($val['id'], $selected_ids);
        $temp = [
            'id' => strval($val['id']),
            'text' => $val['name'],
            'state' => ['opend' => $selected, 'selected' => $selected],
        ];
        if (!empty($val['child']))
        {
            $temp['children'] = permission_jstree_data($val['child'], $selected_ids);
        } else {
            $temp['children'] = [];
        }
        $result[] = $temp;
    }
    return $result;
}
