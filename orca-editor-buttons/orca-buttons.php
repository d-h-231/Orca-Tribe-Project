<?php
/*
Plugin Name: Orca Editor Buttons
Plugin URI:
Version: 0.6
Description: Adds pullquote to editor
Author: Michael Hall
*/
function enqueue_plugin_scripts($plugin_array)
{
    //enqueue TinyMCE plugin script with its ID.
    $plugin_array["orca_button_plugin"] =  plugin_dir_url(__FILE__) . "index.js";
    return $plugin_array;
}

add_filter("mce_external_plugins", "enqueue_plugin_scripts");

function register_buttons_editor($buttons)
{
    //register buttons with their id.
    array_push($buttons, "pullquote");
    return $buttons;
}

add_filter("mce_buttons", "register_buttons_editor");
?>