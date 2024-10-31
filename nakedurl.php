<?php
/*
Plugin Name: Naked URLs to live links
Plugin URI: http://www.prometod.eu/en/turn-naked-urls-live-links-wordpress-filter/
Description: Make all the naked URLs addresses turn into live clickable links
Version: 1.2.0
Author: peeping4dsun
Author URI: http://www.prometod.eu/en/
*/


/*  Copyright 2014  

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
function new_naked_filter_the_content( $content ) {
	global $post;
        $check_1 = "iframe";
        $check_2 = "text/javascript";
        $flag_new_naked = strpos($content, $check_1);
        $flag_new_naked_2 = strpos($content, $check_2);
        if($flag_new_naked == false && $flag_new_naked_2 == false ){
	$pattern='/(?<=[^\n]|\s)(?:(?<!\"|\=|">))http:\/\/[a-z.\/0-9A-Z?_^%\$*#!~+-]+|(?<=[^\n]|\s)(?:(?<!\"|\=|">))https:\/\/[a-z.\/0-9A-Z?_^%\$*#!~+-]+/';

	$sub='<a href="$0" target="_blank">$0</a>';
	$content= preg_replace($pattern, $sub, $content);
	//-------------------------
    return $content;}else{return $content;}
}
add_filter( 'the_content', 'new_naked_filter_the_content' );

//------------------------- Atention
//------------------------- Below is a legacy code, when the plugin was working as a shortcode. The purpose is to serve those few, which are using the old version of the plugin, when it was a shortcode plugin.
//-------------------------
//Declaring the main function
function nakedurls_shortcode_function($atts , $content = null) {
//Setting the pattern that will filter the naked URLs from everything else
//Note that if this pattern is used as a filter, rather than as a shortcode, it will lead to issues with embedded codes from sites such as www.list.ly
//In these parts "[a-z.\/0-9A-Z_*-]" of the pattern are declared the accepted characters after http:// and https://
//You can add additional character such as ? #
//The pattern is tested against inserted images between then opening and closing tags of the shortcode
//This mean that you can add images between then opening and closing tags of the shortcode, without worring that the plugin can cause issues with them  
$naked_urls_pattern='/(?<=[^\n]|\s)(?:(?<!\"|\=|">))http:\/\/[a-z.\/0-9A-Z_*-]+|(?<=[^\n]|\s)(?:(?<!\"|\=|">))https:\/\/[a-z.\/0-9A-Z_*-]+/';
//Here you can edit the code to open the links in the same tab(default is opening them in a new tab) or add additional code for the purposes of styling 
$replace_naked_urls='<a href="$0" target="_blank">$0</a>';
//Executing the change from naked to live links 
$content_with_live_links= preg_replace($naked_urls_pattern, $replace_naked_urls, $content);
//Returning the data 
return $content_with_live_links;
 
}
//connect the shortcode function via add_filter  
add_shortcode( 'naked_urls', 'nakedurls_shortcode_function' );