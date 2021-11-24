<?php

namespace App\Services;


use DfaFilter\SensitiveHelper;

class Mgc
{
    protected static $handle = null;


    public static function getInstance($word_path = [])
    {
        if (!self::$handle) {
            //默认的一些敏感词库
            $default_path = [
                storage_path('disk/ck.txt'),
            ];
            $paths = array_merge($default_path, $word_path);
            self::$handle = SensitiveHelper::init();
            if (!empty($paths)) {
                foreach ($paths as $path) {
                    self::$handle->setTreeByFile($path);
                }
            }
        }
        return self::$handle;
    }
    /**
     * 检测是否含有敏感词
     */
    public static function isLegal($content)
    {
        return self::getInstance()->islegal($content);
    }
    /**
     * 敏感词过滤
     */
    public static function replace($content, $replace_char = '', $repeat = false, $match_type = 1)
    {
        return self::getInstance()->replace($content, $replace_char, $repeat, $match_type);
    }
    /**
     * 标记敏感词
     */
    public static function mark($content, $start_tag, $end_tag, $match_type = 1)
    {
        return self::getInstance()->mark($content, $start_tag, $end_tag, $match_type);
    }
    /**
     * 获取文本中的敏感词
     */
    public static function getBadWord($content, $match_type = 1, $word_num = 0)
    {
        return self::getInstance()->getBadWord($content, $match_type, $word_num);
    }

}
