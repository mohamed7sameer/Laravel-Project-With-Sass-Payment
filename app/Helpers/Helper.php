<?php

function size_as_kb($size) {
    if($size < 1024) {
        return "{$size} bytes";
    } elseif($size < 1048576) {
        $size_kb = round($size/1024);
        return "{$size_kb} KB";
    } else {
        $size_mb = round($size/1048576, 1);
        return "{$size_mb} MB";
    }
}
