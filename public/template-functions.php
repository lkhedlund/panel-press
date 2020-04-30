<?php 

/**
 * The template functions of the plugin
 *
 * Defines wrapped functions to be called in themes and templates.
 *
 * @package    Panel_Press
 * @subpackage Panel_Press/public
 * @author     Lars <lkhedlund@gmail.com>
 */

 /**
* Template tag for displaying the filters form
* @return html object
*/
function pp_display_collections($args = array()){
    return Panel_Press_Public::display_collections($args);
}