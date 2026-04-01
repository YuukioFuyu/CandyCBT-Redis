<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

function clear_all_cache()
{
    $CI =& get_instance();
    $path = $CI->config->item();

    $cache_path = ($path == '') ? APPPATH.'cache/' : $path;

    $handle = opendir($cache_path);
    while (($file = readdir($handle))!== FALSE) 
    {
        //Leave the directory protection alone
        if ($file != '.htaccess' && $file != 'index.html')
        {
           @unlink($cache_path.'/'.$file);
        }
    }
    closedir($handle);       
}