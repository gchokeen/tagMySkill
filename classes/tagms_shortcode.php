<?php

class Tagms_Shortcode {
	


	function __construct(){

		## Register shortcodes
		add_shortcode( 'tagmyskill', array(&$this, 'tagmyskill_handler' ) );
		

	}


	public function  tagmyskill_handler($atts){
		
		extract( shortcode_atts( array(
				'user_id' => get_the_author_meta('ID'),				
		), $atts ) );
		
		
	
		$keyskills = explode(',',get_the_author_meta( 'tagkeyskill', $user_id ));
		$otherskills = explode(',',get_the_author_meta( 'tagotherskill', $user_id ));
		
			$html = '';
	
			$html .='<div class="tagms-wrapper">';
			
		if(count($keyskills)!=0){
			$html .='<div class="tagms-keyskill">';
			$html .='<h3>'.__("Key Skills", 'tagMySkill').'</h3>';
			$html .='<ul class="tagms-tags">';
						foreach($keyskills as $skill):
			$html .='<li><a href="#">'. $skill.'</a></li>';
						endforeach;
			$html .='</ul>';
			$html .='</div>';
		}
		if(count($otherskills)!=0){
			$html .='<div class="tagms-otherskill">';
			$html .='<h3>'.__("Other Skills", 'tagMySkill').'</h3>';
			$html .='<ul class="tagms-tags">';
						 foreach($otherskills as $skill):
			$html .='<li><a href="#">'.$skill.'</a></li>';
						endforeach;
			$html .='</ul>';
			$html .='</div>';
		}			
			$html .='</div>';		
		
		return $html;
	}
	

	
}

$tagms__shortcode =new Tagms_Shortcode();


