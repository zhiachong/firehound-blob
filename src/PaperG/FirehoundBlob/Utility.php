<?php

namespace PaperG\FirehoundBlob;


trait Utility {
    public function safeGet($array, $key, $default = null) {
        return isset($array[$key]) ? $array[$key] : $default;
    }
} 
