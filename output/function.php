<?php
function structured_data_generator($input) {
	$output =  '';
	global $sd_data;	 
	if( (  1 == $sd_data['sd-for-wordpress'] && ampforwp_sd_non_amp() ) || ( 1 == $sd_data['sd-for-ampforwp'] && !ampforwp_sd_non_amp() ) ) {
		if ($input) {
			$output .= "\n\n";
			$output .= '<!-- This site is optimized with the Structured data  plugin v'.STRUCTURED_DATA_VERSION.' - -->';
			$output .= "\n";
			$output .= '<script type="application/ld+json">' . json_encode($input) . '</script>';
			$output .= "\n\n";
		}
	}
	return $output;
}
if(class_exists('MeprAppCtrl') ){
	//remove_filter('the_content', 'MeprAppCtrl::page_route', 100);
}

add_action('wp', function(){
	if( ampforwp_sd_non_amp() ){
		return;
	}
	remove_filter( 'the_content', 'prefix_insert_post_ads' );
});

add_filter('the_content', 'paywallDataForLogin');
function paywallDataForLogin($content){
	if( ampforwp_sd_non_amp() ){
		return $content;
	}
	remove_filter('the_content', 'MeprAppCtrl::page_route', 60);
	
	$schemaConditionals = ampforwp_get_all_schema_posts();
	if(!$schemaConditionals){
		return $content;
	}else{
		$schema_options = $schemaConditionals['schema_options'];
		$schema_type = $schemaConditionals['schema_type'];
		if($schema_options['paywall_class_name']!=''){
			$className = $schema_options['paywall_class_name'];
		}
		if(strpos($content, '<!--more-->')!==false && !is_user_logged_in()){
			global $wp;
			$redirect =  home_url( $wp->request );
			$breakedContent = explode("<!--more-->", $content);
			$content = $breakedContent[0].'<a href="'.wp_login_url( $redirect ) .'">Login</a>';
		}elseif(strpos($content, '<!--more-->')!==false && is_user_logged_in()){
			global $wp;
			$redirect =  home_url( $wp->request );
			$breakedContent = explode("<!--more-->", $content);
			$content = $breakedContent[0].'<div class="'.$className.'">'.$breakedContent[1].'</div>';
		}
	}
	return $content;
}

add_filter('memberpress_form_update', function($form){
	if( !ampforwp_sd_non_amp() ){
		add_action('amp_post_template_css',function(){
			echo '.amp-mem-login{background-color: #fef5c4;padding: 13px 30px 9px 30px;}';
		},11); 
		global $wp;
		$redirect =  home_url( $wp->request );
		$form = '<a class="amp-mem-login" href="'.wp_login_url( $redirect ) .'">Login</a>';
	}
	return $form;
});