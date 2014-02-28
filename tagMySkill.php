<?php
/*
Plugin Name: tagMySkill
Plugin URI: http://wordpress.org/extend/plugins/tagMySkill/
Description: tagMySkill is wordpress plugin will help wp user to expose their skills to reader!.
Version: 1.0
Author: Gowri Sankar Ramasamy
Author URI: http://code-cocktail.in/author/gowrisankar/
Donate link: http://code-cocktail.in/donate-me/
License: GPL2
Text Domain: tagMySkill
*/

/*  
    Copyright 2012  Gowri Sankar Ramasamy  (email : gchokeen@gmail.com)

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
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// loads language files


define('TAGMS_PLUGIN_NAME', plugin_basename(__FILE__));
define('TAGMS_PLUGIN_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);

if (!class_exists('tagMySkill')) {

	class tagMySkill{
		/**
		 * @var tagMySkill
		 */
		static private $_instance = null;
		/**
		 * Get tagMySkill object
		 *
		 * @return tagMySkill
		 */
		static public function getInstance(){
			if (self::$_instance == null) {
				self::$_instance = new tagMySkill();
			}
			
			return self::$_instance;
		}


		private function __construct(){
			register_activation_hook(TAGMS_PLUGIN_NAME, array(&$this, 'pluginActivate'));
			register_deactivation_hook(TAGMS_PLUGIN_NAME, array(&$this, 'pluginDeactivate'));
			register_uninstall_hook(TAGMS_PLUGIN_NAME, array('tagMySkill', 'pluginUninstall'));

			## Register plugin widgets
			add_action('init', array($this, 'load_tagms_transl'));
			add_action('plugins_loaded', array(&$this, 'pluginLoad'));
			
			add_action( 'show_user_profile', array(&$this, 'user_profile_skill_fields') );
			add_action( 'edit_user_profile', array(&$this, 'user_profile_skill_fields') );
			
			
			add_action( 'personal_options_update', array(&$this, 'save_user_profile_skill_fields') );
			add_action( 'edit_user_profile_update', array(&$this, 'save_user_profile_skill_fields') );
				
			
			
			if (is_admin()) {
			add_action('wp_print_scripts', array(&$this, 'adminLoadScripts'));
			add_action('wp_print_styles', array(&$this, 'adminLoadStyles'));
			}
			else{

			add_action('wp_print_scripts', array(&$this, 'siteLoadScripts'));
			add_action('wp_print_styles', array(&$this, 'siteLoadStyles'));


			}


		}

		public function load_tagms_transl(){
			load_plugin_textdomain('tagMySkill', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
		}

		##
		## Loading Scripts and Styles
		##
	
		public function adminLoadStyles(){
		}
	
		public function adminLoadScripts(){


			wp_enqueue_script(
					'tagsinput',
					plugins_url('js/jquery.tagsinput.min.js', __FILE__),
					array('jquery')
			);
									wp_enqueue_script(
					'tagmyskill',
					plugins_url('js/tagmyskill.js', __FILE__),
					array('jquery','tagsinput')
			);
			

			
			
			wp_register_style('tagsinput-style',plugins_url('css/jquery.tagsinput.css', __FILE__));
			wp_enqueue_style( 'tagsinput-style' );
	
		}

		public function siteLoadStyles(){
			

	
		}
	
	
		public function siteLoadScripts(){
		}
		##
		## Widgets initializations
		##

		public function widgetsRegistration(){
		}


		##
		## Plugin Activation and Deactivation
		##

		/**
		* Activate plugin
		* @return void
		*/
		public function pluginActivate(){
	

		}

			/**
			* Deactivate plugin
			* @return void
			*/
			public function pluginDeactivate(){
				
			}

			/**
			* Uninstall plugin
			* @return void
			*/
			static public function pluginUninstall(){

			}


			public function pluginLoad(){

			}
			
			
			public function user_profile_skill_fields( $user ){
				 ?>
			    <h3><?php echo __("Tag your skills"); ?></h3>
			
			    <table class="form-table">
			        <tr>
			            <th><label for="tagkeyskill"><?php echo __("Key Skill"); ?></label></th>
			            <td>			
			                        
			                <input id="tagkeyskill" name="tagkeyskill" type="text" value="<?php echo get_the_author_meta( 'tagkeyskill', $user->ID ); ?>" />			             
			            </td>
			        </tr>
			        <tr>
			            <th><label for="tagotherskill"><?php echo __("Other Skill"); ?></label></th>
			            <td>
			               	<input id="tagotherskill" name="tagotherskill"  type="text"  value="<?php echo get_the_author_meta( 'tagotherskill', $user->ID ); ?>"/>
			            </td>
			        </tr>			        
			    </table>
			<?php 
			
			}
			
	
			public  function save_user_profile_skill_fields( $user_id ){
				
				if ( !current_user_can( 'edit_user', $user_id ) ) {
					return false;
				}else{
					if(isset($_POST['tagkeyskill'])){
						update_usermeta( $user_id, 'tagkeyskill', $_POST['tagkeyskill'] );
					}else{
						delete_usermeta($user_id, 'tagkeyskill');
					}
					
					if(isset($_POST['tagotherskill'])){
						update_usermeta( $user_id, 'tagotherskill', $_POST['tagotherskill'] );
					}else{
						delete_usermeta($user_id, 'tagotherskill');
					}
										
				}
			}

		}
}

//instantiate the class
if (class_exists('tagMySkill')) {
	$tagMySkill =  tagMySkill::getInstance();
}



