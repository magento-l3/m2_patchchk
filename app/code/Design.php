<?php

require_once 'app/code/Cache/File.php';

class Design
{
    const STATIC_HASH_CACHE_ID = 'static_hash';


    public function generateStaticHash()
    {
        $staticFileList = [
            'design/js/jquery/plugins/mfupload.js',
            'design/js/jquery/jquery.min.js',
            'design/js/uploader.js',
            'design/js/script.js',
            'design/style/style.css',
            'design/style/uploader.css'
        ];

        $hash = [];
        foreach ($staticFileList as $file) {
            if (!file_exists($file) || is_dir($file) || !is_readable($file)) {
                continue;
            }

            $hash[] = md5_file($file);
        }

        return md5(join('_', $hash));
    }

    public function getStaticHash()
    {
        $cache = new Cache_File();
        $content = $cache->loadCache(self::STATIC_HASH_CACHE_ID);
        if (!$content) {
            $content = $this->generateStaticHash();
            $cache->saveCache(self::STATIC_HASH_CACHE_ID, $content);
        }

        return $content;
    }
}
