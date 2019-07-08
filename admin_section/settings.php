<?php
/**
 * Settings Page
 *
 * @author   Magazine3
 * @category Admin
 * @path     admin_section/settings
 * @version 1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Admin Settings
 * Function saswp_add_menu_links
 *
 */
add_action( 'plugin_action_links_' . plugin_basename( SASWP_DIR_NAME_FILE ), 'saswp_plugin_action_links' );

function saswp_plugin_action_links( $links ) {
    
        $nonce = wp_create_nonce( 'saswp_install_wizard_nonce' );  
	$links[] = '<a href="' . esc_url( admin_url( 'edit.php?post_type=saswp&page=structured_data_options' ) ) . '">' . esc_html__( 'Settings', 'schema-and-structured-data-for-wp' ) . '</a>';
	$links[] = '<a href="'.  esc_url( admin_url( 'plugins.php?page=saswp-setup-wizard' ).'&_saswp_nonce='.$nonce).'">' . esc_html__( 'Setup Wizard', 'schema-and-structured-data-for-wp' ) . '</a>';
        $links[] = '<a target="_blank" href="http://structured-data-for-wp.com/docs/">' . esc_html__( 'Documentation', 'schema-and-structured-data-for-wp' ) . '</a>';
  	return $links;
        
}

function saswp_add_menu_links() {				
	// Settings page - Same as main menu page
	add_submenu_page( 'edit.php?post_type=saswp', esc_html__( 'Schema & Structured Data For Wp', 'schema-and-structured-data-for-wp' ), esc_html__( 'Settings', 'schema-and-structured-data-for-wp' ), 'manage_options', 'structured_data_options', 'saswp_admin_interface_render' );	
        
}
add_action( 'admin_menu', 'saswp_add_menu_links' );

function saswp_admin_interface_render(){
	// Authentication
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	// Handing save settings
	if ( isset( $_GET['settings-updated'] ) ) {							                                                 
		settings_errors();               
	}
            $is_amp = false;
        if ( is_plugin_active('accelerated-mobile-pages/accelerated-moblie-pages.php') || is_plugin_active('amp/amp.php') ) {
            $is_amp = true;			
        }   
       
        $tab = saswp_get_tab('general', array('general', 'amp','review','compatibility','email_schema', 'tools', 'tools','premium_features', 'services', 'support'));            
	
	?>
<div class="saswp-settings-container">
	<div class="wrap saswp-settings-form saswp-settings-first-div">	
		<h1 class="wp-heading-inline"> <?php echo esc_html__( 'Schema & Structured Data For WP', 'schema-and-structured-data-for-wp' ); ?> <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=saswp' ) ); ?>" class="page-title-action"><?php echo esc_html__( 'Schema Types', 'schema-and-structured-data-for-wp' ); ?></a></h1><br>		
                <div>
		<h2 class="nav-tab-wrapper saswp-tabs">
                    
			<?php			

			echo '<a href="' . esc_url(saswp_admin_link('general')) . '" class="nav-tab ' . esc_attr( $tab == 'general' ? 'nav-tab-active' : '') . '"><span class=""></span> ' . esc_html__('Global','schema-and-structured-data-for-wp') . '</a>';
			                                               
                        echo '<a href="' . esc_url(saswp_admin_link('amp')) . '" class="nav-tab ' . esc_attr( $tab == 'amp' ? 'nav-tab-active' : '') . '"><span class=""></span> ' . esc_html__('AMP','schema-and-structured-data-for-wp') . '</a>';    
                                                                                                                                                                                                                                              
                        echo '<a href="' . esc_url(saswp_admin_link('review')) . '" class="nav-tab ' . esc_attr( $tab == 'review' ? 'nav-tab-active' : '') . '"><span class=""></span> ' . esc_html__('Review','schema-and-structured-data-for-wp') . '</a>';
                        
                        echo '<a href="' . esc_url(saswp_admin_link('compatibility')) . '" class="nav-tab ' . esc_attr( $tab == 'compatibility' ? 'nav-tab-active' : '') . '"><span class=""></span> ' . esc_html__('Compatibility','schema-and-structured-data-for-wp') . '</a>';
                        
                        echo '<a href="' . esc_url(saswp_admin_link('email_schema')) . '" class="nav-tab ' . esc_attr( $tab == 'email_schema' ? 'nav-tab-active' : '') . '"><span class=""></span> ' . esc_html__('Email Schema','schema-and-structured-data-for-wp') . '</a>';
                        
                        echo '<a href="' . esc_url(saswp_admin_link('tools')) . '" class="nav-tab ' . esc_attr( $tab == 'tools' ? 'nav-tab-active' : '') . '"><span class=""></span> ' . esc_html__('Advanced','schema-and-structured-data-for-wp') . '</a>';                         			
                        
                        echo '<a href="' . esc_url(saswp_admin_link('premium_features')) . '" class="nav-tab ' . esc_attr( $tab == 'premium_features' ? 'nav-tab-active' : '') . '"><span class=""></span> ' . esc_html__('Premium Features','schema-and-structured-data-for-wp') . '</a>';                         			
                        
                        echo '<a href="' . esc_url(saswp_admin_link('services')) . '" class="nav-tab ' . esc_attr( $tab == 'services' ? 'nav-tab-active' : '') . '"><span class=""></span> ' . esc_html__('Services','schema-and-structured-data-for-wp') . '</a>';                         			
                        
                        echo '<a href="' . esc_url(saswp_admin_link('support')) . '" class="nav-tab ' . esc_attr( $tab == 'support' ? 'nav-tab-active' : '') . '"><span class=""></span> ' . esc_html__('Support','schema-and-structured-data-for-wp') . '</a>';
			?>
                    
		</h2>
                 
                                           
                </div>
                
                <form action="<?php echo admin_url("options.php") ?>" method="post" enctype="multipart/form-data" class="saswp-settings-form">		
			<div class="form-wrap saswp-settings-form-wrap">
			<?php
			// Output nonce, action, and option_page fields for a settings page.
			settings_fields( 'sd_data_group' );												
			echo "<div class='saswp-general' ".( $tab != 'general' ? 'style="display:none;"' : '').">";
                        
                        echo '<div id="saswp-global-tabs" style="margin-top: 10px;">';
                        
                        echo '<a data-id="saswp-general-container">'.esc_html__('General Settings','schema-and-structured-data-for-wp').'</a> | <a data-id="saswp-knowledge-container">'.esc_html__('Knowledge Graph','schema-and-structured-data-for-wp').'</a> | <a data-id="saswp-default-container" >'.esc_html__('Default Data','schema-and-structured-data-for-wp').'</a>';
                        
                        echo'</div> ';
                        
				// general Application Settings                        
				do_settings_sections( 'saswp_general_section' );	// Page slug
			echo "</div>";
						                                                
                        echo "<div class='saswp-amp' ".( $tab != 'amp' ? 'style="display:none;"' : '').">";
                        
				do_settings_sections( 'saswp_amp_section' );	// Page slug
			echo "</div>";
                                                                        
                        echo "<div class='saswp-review' ".( $tab != 'review' ? 'style="display:none;"' : '').">";
			     // Status                        
			        do_settings_sections( 'saswp_review_section' );	// Page slug
			echo "</div>";
                        
                        echo "<div class='saswp-compatibility' ".( $tab != 'compatibility' ? 'style="display:none;"' : '').">";
			     // Status
                        
			        do_settings_sections( 'saswp_compatibility_section' );	// Page slug
			echo "</div>";
                        
                        echo "<div class='saswp-email_schema' ".( $tab != 'email_schema' ? 'style="display:none;"' : '').">";
			     // Status                        
			        do_settings_sections( 'saswp_email_schema_section' );	// Page slug
			echo "</div>";
                        
                        echo "<div class='saswp-tools' ".( $tab != 'tools' ? 'style="display:none;"' : '').">";
			     // Status
                        
			        do_settings_sections( 'saswp_tools_section' );	// Page slug
			echo "</div>";
                        
                        echo "<div class='saswp-premium_features' ".( $tab != 'premium_features' ? 'style="display:none;"' : '').">";
			     // Status                        
			        do_settings_sections( 'saswp_premium_features_section' );	// Page slug
			echo "</div>";
                        
                        echo "<div class='saswp-services' ".( $tab != 'services' ? 'style="display:none;"' : '').">";
			     // Status                        
			        do_settings_sections( 'saswp_services_section' );	// Page slug
			echo "</div>";
                        
                        echo "<div class='saswp-support' ".( $tab != 'support' ? 'style="display:none;"' : '').">";
			     // Status                        
			        do_settings_sections( 'saswp_support_section' );	// Page slug
			echo "</div>";

			?>
		</div>
			<div class="button-wrapper">
				<?php
				// Output save settings button
                                submit_button( esc_html__('Save Settings', 'schema-and-structured-data-for-wp') );
				?>
			</div>  
                    <input type="hidden" name="sd_data[sd_initial_wizard_status]" value="1">
		</form>
	</div>
    <div class="saswp-settings-second-div">
        <p style="float:left;"><?php 
        $nonce = wp_create_nonce( 'saswp_install_wizard_nonce' );          
        echo esc_html('Need Quick Setup?', 'schema-and-structured-data-for-wp'); ?></p><a href="<?php echo esc_url(admin_url( 'plugins.php?page=saswp-setup-wizard' ).'&_saswp_nonce='.$nonce); ?>" class="page-title-action saswp-start-quck-setup button button-primary"><?php echo esc_html('Try Installation Wizard', 'schema-and-structured-data-for-wp'); ?></a>
    <div class="saswp-feedback-panel">
        
        <h2><?php echo esc_html__( 'Leave A Feedback', 'schema-and-structured-data-for-wp' ); ?></h2>
        
        <ul>
            <li><a target="_blank" href="https://wordpress.org/support/plugin/schema-and-structured-data-for-wp/reviews/#new-post"><?php echo esc_html__( 'I would like to review this plugin', 'schema-and-structured-data-for-wp' ); ?></a></li>    
            <li><a target="_blank" href="http://structured-data-for-wp.com/contact-us/"><?php echo esc_html__( 'I have ideas to improve this plugin', 'schema-and-structured-data-for-wp' ); ?></a></li>
            <li><a href="<?php echo esc_url( admin_url( 'admin.php?page=structured_data_options&tab=support' ) ); ?>"><?php echo esc_html__( 'I need help this plugin', 'schema-and-structured-data-for-wp' ); ?></a></li>              
        </ul>  
        <div class="saswp-social-sharing-buttons">
            <a class="saswp-facebook-share" href="https://www.facebook.com/sharer/sharer.php?u=http://structured-data-for-wp.com/" target="_blank">           
        <span class="dashicons dashicons-facebook"></span>
        <?php echo esc_html__( 'Share', 'schema-and-structured-data-for-wp' ); ?>
       </a>
        <a target="_blank" class="twitter-share-button"
        href="https://twitter.com/home?status=I'm%20using%20this%20Structured%20data%20WordPress%20plugin%20for%20implementing%20Schema%20on%20my%20site!%20http%3A//structured-data-for-wp.com/%20via%20%40WPF_community">
            <span class="dashicons dashicons-twitter"></span>
                <?php echo esc_html__( 'Tweet', 'schema-and-structured-data-for-wp' ); ?>
        </a>
        </div>
        
    </div>
        <div class="saswp-view-docs">
            
            <p style="float: left;"><?php echo esc_html__('Need Help?','schema-and-structured-data-for-wp') ?></p>  <a style="float: right;" class="button button-default" target="_blank" href="http://structured-data-for-wp.com/docs/"><?php echo esc_html__('View Documentation','schema-and-structured-data-for-wp') ?></a>
            
        </div>
        <div class="saswp-upgrade-pro">
        	<h2><?php echo esc_html__('Upgrade to Pro!','schema-and-structured-data-for-wp') ?></h2>
        	<ul>
        		<li><?php echo esc_html__('Premium features','schema-and-structured-data-for-wp') ?></li>
        		<li><?php echo esc_html__('Dedicated Schema Support','schema-and-structured-data-for-wp') ?></li>
        		<li><?php echo esc_html__('Active Development','schema-and-structured-data-for-wp') ?></li>
        	</ul>
        	<a target="_blank" href="http://structured-data-for-wp.com/pricing/"><?php echo esc_html__('UPGRADE','schema-and-structured-data-for-wp') ?></a>
        </div> 
    </div>
</div>

	<?php
}
/*
	WP Settings API
*/
add_action('admin_init', 'saswp_settings_init');

function saswp_settings_init(){
    
          	register_setting( 'sd_data_group', 'sd_data', 'saswp_handle_file_upload' );
                add_settings_section('saswp_general_section', __return_false(), '__return_false', 'saswp_general_section');

                add_settings_field(
			'general_settings',								// ID
			'',		// Title
			'saswp_general_page_callback',								// CB
			'saswp_general_section',						// Page slug
			'saswp_general_section'						// Settings Section ID
		);
                                                                 
                add_settings_section('saswp_amp_section', __return_false(), '__return_false', 'saswp_amp_section');
	
		add_settings_field(
			'saswp_amp_settings',								// ID
			'',		// Title
			'saswp_amp_page_callback',								// CB
			'saswp_amp_section',						// Page slug
			'saswp_amp_section'						// Settings Section ID
		); 
                
                
                add_settings_section('saswp_review_section', __return_false(), '__return_false', 'saswp_review_section');

                add_settings_field(
			'saswp_review_settings',								// ID
			'',		// Title
			'saswp_review_page_callback',								// CB
			'saswp_review_section',						// Page slug
			'saswp_review_section'						// Settings Section ID
		);
                
                add_settings_section('saswp_compatibility_section', __return_false(), '__return_false', 'saswp_compatibility_section');

                add_settings_field(
			'saswp_compatibility_settings',								// ID
			'',		// Title
			'saswp_compatibility_page_callback',								// CB
			'saswp_compatibility_section',						// Page slug
			'saswp_compatibility_section'						// Settings Section ID
		);
                
                add_settings_section('saswp_email_schema_section', __return_false(), '__return_false', 'saswp_email_schema_section');

                add_settings_field(
			'saswp_email_schema_settings',								// ID
			'',		// Title
			'saswp_email_schema_callback',								// CB
			'saswp_email_schema_section',						// Page slug
			'saswp_email_schema_section'						// Settings Section ID
		);
                
                
                add_settings_section('saswp_support_section', __return_false(), '__return_false', 'saswp_support_section');

                add_settings_field(
			'saswp_support_settings',								// ID
			'',		// Title
			'saswp_support_page_callback',								// CB
			'saswp_support_section',						// Page slug
			'saswp_support_section'						// Settings Section ID
		);
                
                
                add_settings_section('saswp_tools_section', __return_false(), '__return_false', 'saswp_tools_section');
                
                // the meta_key 'diplay_on_homepage' with the meta_value 'true'                    
                    add_settings_field(
                            'saswp_import_status',								// ID
                            '',			// Title
                            'saswp_import_callback',					// Callback
                            'saswp_tools_section',							// Page slug
                            'saswp_tools_section'							// Settings Section ID
                    );
                    
                    add_settings_section('saswp_premium_features_section', __return_false(), '__return_false', 'saswp_premium_features_section');
                
                // the meta_key 'diplay_on_homepage' with the meta_value 'true'                    
                    add_settings_field(
                            'saswp_premium_features_settings',								// ID
                            '',			// Title
                            'saswp_premium_features_callback',					// Callback
                            'saswp_premium_features_section',							// Page slug
                            'saswp_premium_features_section'							// Settings Section ID
                    );
                    
                    add_settings_section('saswp_services_section', __return_false(), '__return_false', 'saswp_services_section');
                
                // the meta_key 'diplay_on_homepage' with the meta_value 'true'                    
                    add_settings_field(
                            'saswp_services_settings',								// ID
                            '',			// Title
                            'saswp_services_callback',					// Callback
                            'saswp_services_section',							// Page slug
                            'saswp_services_section'							// Settings Section ID
                    );
                                                     
                 
}

function saswp_custom_upload_mimes($mimes = array()) {
	
	$mimes['json'] = "application/json";

	return $mimes;
}

add_action('upload_mimes', 'saswp_custom_upload_mimes');

function saswp_handle_file_upload($option){
    
    if ( ! current_user_can( 'upload_files' ) ) {
		return $option;
    }

  $fileInfo = wp_check_filetype(basename($_FILES['saswp_import_backup']['name']));
    
  if (!empty($fileInfo['ext']) && $fileInfo['ext'] == 'json') {
      
      if(!empty($_FILES["saswp_import_backup"]["tmp_name"])){
  
        $urls = wp_handle_upload($_FILES["saswp_import_backup"], array('test_form' => FALSE));    
        $url = $urls["url"];
        update_option('saswp-file-upload_url',esc_url($url));
    
     }
  }           
  return $option;
  
}


function saswp_premium_features_callback(){ ?>
	<div class="saswp-pre-ftrs-wrap">
		<ul class="saswp-features-blocks">
			<li><a target="_blank" href="http://structured-data-for-wp.com/extensions/woocommerce-compatibility-for-schema/">
				<div class="saswp-features-ele">
					<div class="saswp-ele-ic saswp-ele-1">
                                            <img src="<?php echo SASWP_PLUGIN_URL; ?>/admin_section/images/woocommerce-icon.png">
					</div>
					<div class="saswp-ele-tlt">
						<h3><?php echo esc_html__('WooCommerce Compatibility for Schema','schema-and-structured-data-for-wp') ?></h3>
						<p><?php echo esc_html__('WooCommerce Compatibility extension is the number one solution to enhance your store with the right structured data.','schema-and-structured-data-for-wp') ?></p>
					</div>
				</div>
				<div class="saswp-sts-btn">
                                    
                                        <?php
                                        
                                        if(is_plugin_active('woocommerce-compatibility-for-schema/woocommerce-compatibility-for-schema.php')){                                           
                                          echo '<label class="saswp-sts-txt">Status :<span>Active</span></label>';                                          
                                        }else{                                            
                                           echo '<label class="saswp-sts-txt">Status :<span>Inactive</span></label>'; 
                                           echo '<span class="saswp-d-btn">Download</span>';
                                        }
                                        
                                        ?>                                    										
				</div>
			</a></li>
			<li><a target="_blank" href="http://structured-data-for-wp.com/extensions/cooked-compatibility-for-schema/">
				<div class="saswp-features-ele">
					<div class="saswp-ele-ic saswp-ele-2">
                                            <img src="<?php echo SASWP_PLUGIN_URL; ?>/admin_section/images/cooked-schema-wp.png">
					</div>
					<div class="saswp-ele-tlt">
						<h3><?php echo esc_html__('Cooked Compatibility for Schema','schema-and-structured-data-for-wp') ?></h3>
						<p><?php echo esc_html__('This extension will be able to take all the proper recipe data and integrate it with the schema & structured data in AMP & non-AMP.','schema-and-structured-data-for-wp') ?></p>
					</div>
				</div>
				<div class="saswp-sts-btn">
                                    
                                        <?php
                                        
                                        if(is_plugin_active('cooked-compatibility-for-schema/cooked-compatibility-for-schema.php')){                                        
                                            echo '<label class="saswp-sts-txt">Status :<span>Active</span></label>';                                            
                                        }else{
                                            echo '<label class="saswp-sts-txt">Status :<span>Inactive</span></label>';
                                            echo '<span class="saswp-d-btn">Download</span>';
                                        }
                                        
                                        ?>                                    										
				</div>
			</a></li>
		</ul>
	</div>

 <?php
}

function saswp_services_callback(){ ?>
   <div class="saswp-pre-ftrs-wrap">
		<ul class="saswp-features-blocks">
			<li><a target="_blank" href="http://structured-data-for-wp.com/services/google-news-schema-setup/">
				<div class="saswp-features-ele">
					<div class="saswp-ele-ic saswp-ele-3">
                                            <img src="<?php echo SASWP_PLUGIN_URL; ?>/admin_section/images/news.png">
					</div>
					<div class="saswp-ele-tlt">
						<h3><?php echo esc_html__('Google News Schema Setup','schema-and-structured-data-for-wp') ?></h3>
						<p><?php echo esc_html__('Get quick approval to Google News with our service. Our structured data experts will set up the Google News schema properly on your website.','schema-and-structured-data-for-wp') ?></p>
					</div>
				</div>
				<div class="saswp-sts-btn">
					<label class="saswp-sts-txt"><?php echo esc_html__('Staus:','schema-and-structured-data-for-wp') ?><span><?php echo esc_html__('Inactive','schema-and-structured-data-for-wp') ?></span></label>
					<span class="saswp-d-btn"><?php echo esc_html__('Download','schema-and-structured-data-for-wp') ?></span>
				</div>
			</a></li>
			<li><a target="_blank" href="http://structured-data-for-wp.com/services/structured-data-setup-error-clean-up/">
				<div class="saswp-features-ele">
					<div class="saswp-ele-ic saswp-ele-4">
                                            <img src="<?php echo SASWP_PLUGIN_URL; ?>/admin_section/images/schema-setup-icon.png">
					</div>
					<div class="saswp-ele-tlt">
						<h3><?php echo esc_html__('Structured Data Setup & Error Clean Up','schema-and-structured-data-for-wp') ?></h3>
						<p><?php echo esc_html__('We will help you setup Schema and Structured data on your website as per your requirements and as per recommendation by our expert developers.','schema-and-structured-data-for-wp') ?></p>
					</div>
				</div>
				<div class="saswp-sts-btn">
					<label class="saswp-sts-txt"><?php echo esc_html__('Staus:','schema-and-structured-data-for-wp') ?><span><?php echo esc_html__('Inactive','schema-and-structured-data-for-wp') ?></span></label>
					<span class="saswp-d-btn"><?php echo esc_html__('Download','schema-and-structured-data-for-wp') ?></span>
				</div>
			</a></li>
		</ul>
	</div>

<?php }
function saswp_amp_page_callback(){
    
        $settings = saswp_defaultSettings();         
        $field_objs = new saswp_fields_generator();
        
        $non_amp_enable_field = array(
			'label'  => 'Structured Data for AMP',
			'id'     => 'saswp-for-amp-checkbox',                        
                        'name'   => 'saswp-for-amp-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'hidden' => array(
                             'id'   => 'saswp-for-amp',
                             'name' => 'sd_data[saswp-for-amp]',                             
                        )
		) ;                                        
                
        
        if ( is_plugin_active('accelerated-mobile-pages/accelerated-moblie-pages.php') || is_plugin_active('amp/amp.php') ) {                         
        }else{
            
            $non_amp_enable_field['attributes'] = array(
                 'disabled' => 'disabled'
             );
             $non_amp_enable_field['note'] = esc_html__('Requires','schema-and-structured-data-for-wp'). ' <a target="_blank" href="https://wordpress.org/plugins/accelerated-mobile-pages/">AMP for WP</a> or <a target="_blank" href="https://wordpress.org/plugins/amp/">AMP</a>';
             $settings['saswp-for-amp'] = 0;	
            
        }
                
        $meta_fields = array(
            $non_amp_enable_field,
		 array(
			'label'  => 'Structured Data for Non AMP',
			'id'     => 'saswp-for-wordpress-checkbox',
                        'name'   => 'saswp-for-wordpress-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'note'   => '',
                        'hidden' => array(
                             'id'   => 'saswp-for-wordpress',
                             'name' => 'sd_data[saswp-for-wordpress]',                             
                        )
		)                                         
	);        
         echo '<div class="saswp-heading">';
         echo '<h2>'.esc_html__('Enable On','schema-and-structured-data-for-wp').'</h2>';        
         echo '</div>';
         echo '<p>'.esc_html__('Using this option, one can hide and show schema markup on AMP and Non AMP','schema-and-structured-data-for-wp').'</p>';
        
        $field_objs->saswp_field_generator($meta_fields, $settings);    
}

function saswp_general_page_callback(){	
    
	$settings = saswp_defaultSettings(); 
        $field_objs = new saswp_fields_generator(); 
        $locations = get_nav_menu_locations();
        
        $meta_fields_default = array(	
                array(
			'label'  => 'Website Schema (Global)',
			'id'     => 'saswp_website_schema_checkbox', 
                        'name'   => 'saswp_website_schema_checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',                        
                        'hidden' => array(
                             'id'   => 'saswp_website_schema',
                             'name' => 'sd_data[saswp_website_schema]',                             
                        )
		),
                array(
			'label'  => 'Sitelinks Search Box',
			'id'     => 'saswp_search_box_schema_checkbox', 
                        'name'   => 'saswp_search_box_schema_checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',                         
                        'hidden' => array(
                             'id'   => 'saswp_search_box_schema',
                             'name' => 'sd_data[saswp_search_box_schema]',                             
                        )
		),
		array(
			'label'  => 'Archive',
			'id'     => 'saswp_archive_schema_checkbox', 
                        'name'   => 'saswp_archive_schema_checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',                        
                        'hidden' => array(
                             'id'   => 'saswp_archive_schema',
                             'name' => 'sd_data[saswp_archive_schema]',                             
                        )
		),
                array(
			'label'   => 'Schema Type',
			'id'      => 'saswp_archive_schema_type',
                        'name'    => 'sd_data[saswp_archive_schema_type]',
                        'class'   => 'saswp_archive_schema_type_class',
			'type'    => 'select',
			'options' => array(                                
				     'Article'          => 'Article',                                     
                                     'Blogposting'      => 'Blogposting',                                     
                                     'NewsArticle'      => 'NewsArticle',                                                                                                                                                                                                                                                                   
                                     'WebPage'          => 'WebPage' 
			)
                   ),
                array(
			'label'  => 'BreadCrumbs',
			'id'     => 'saswp_breadcrumb_schema_checkbox', 
                        'name'   => 'saswp_breadcrumb_schema_checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',                        
                        'hidden' => array(
                             'id'   => 'saswp_breadcrumb_schema',
                             'name' => 'sd_data[saswp_breadcrumb_schema]',                             
                        )
		),
                array(
			'label'  => 'Comments',
			'id'     => 'saswp_comments_schema_checkbox', 
                        'name'   => 'saswp_comments_schema_checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',                        
                        'hidden' => array(
                             'id'   => 'saswp_comments_schema',
                             'name' => 'sd_data[saswp_comments_schema]',                             
                        )
		)
                                
            );
            if($locations){
             $meta_fields_default[] =   array(
			'label'  => 'Site Navigation Menu',
			'id'     => 'saswp_site_navigation_menu_checkbox', 
                        'name'   => 'saswp_site_navigation_menu_checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',                        
                        'hidden' => array(
                             'id'   => 'saswp_site_navigation_menu',
                             'name' => 'sd_data[saswp_site_navigation_menu]',                             
                        )
		); 
            }                    
        ?>

    <div class="saswp-global-container" id="saswp-general-container">
                        
        <div class="saswp-settings-list">      
            
            <div class="saswp-heading">
              <h2><?php echo esc_html__('General Settings','schema-and-structured-data-for-wp'); ?></h2>              
            </div>
            <p><?php echo esc_html__('This is a global schema settings, to display about, contact, website, archive, breadcrumbs, comments and site navigation schema type.','schema-and-structured-data-for-wp') ?> <a target="_blank" href="http://structured-data-for-wp.com/docs/article/what-is-general-settings-in-schema/"><?php echo esc_html__('Learn More','schema-and-structured-data-for-wp') ?></a></p>   
        <ul><li><div style="float:left;clear: both;"><label class="saswp-tooltip">
        <?php echo esc_html__('About','schema-and-structured-data-for-wp') ?>
                <span class="saswp-tooltiptext"><?php echo esc_html__('Set the about page of of your website','schema-and-structured-data-for-wp') ?></span>
                </label>
        </div>
        <div style="">
        <div style="width:75%; float:right;">
              
                    <label for="sd_about_page-select">
	<?php        
        echo wp_dropdown_pages( array( 
			'name'              => 'sd_data[sd_about_page]', 
                        'id'                => 'sd_about_page',
			'echo'              => 0, 
			'show_option_none'  => esc_html__( 'Select an item', 'schema-and-structured-data-for-wp' ), 
			'option_none_value' => '', 
			'selected'          =>  isset($settings['sd_about_page']) ? esc_attr($settings['sd_about_page']) : '',
		)); ?>
	      </label>  
        </div>
       </div>
    </li>
    <li><div style="float:left;clear: both;">
            <label class="saswp-tooltip">
    <?php echo esc_html__('Contact','schema-and-structured-data-for-wp') ?>
                <span class="saswp-tooltiptext"><?php echo esc_html__('Set the contact us page of your website','schema-and-structured-data-for-wp') ?></span>
            </label>
        </div>
        <div style="">
        <div style="width:75%; float:right;">          
           <label for="sd_contact_page-select">
	  <?php echo wp_dropdown_pages( array( 
			'name'              => 'sd_data[sd_contact_page]', 
                        'id'                => 'sd_contact_page-select',
			'echo'              => 0, 
			'show_option_none'  => esc_html( 'Select an item', 'schema-and-structured-data-for-wp' ), 
			'option_none_value' => '', 
			'selected'          =>  isset($settings['sd_contact_page']) ? esc_attr($settings['sd_contact_page']) : '',
		)); ?>
	     		 </label>       
       	 		</div>
        	 </div>
   			 </li>
			</ul>
		</div> 
        
        <?php
        
        echo '<div class="saswp-archive-div">';
        $field_objs->saswp_field_generator($meta_fields_default, $settings, 'general');
        echo '</div>';
        
        ?>
        
    </div>
    <div class="saswp-global-container" id="saswp-knowledge-container">
        
        <?php 
        
        
        $meta_fields = array(	                
                array(
			'label'   => 'Data Type',
			'id'      => 'saswp_kb_type',
                        'name'    => 'sd_data[saswp_kb_type]',
			'type'    => 'select',
			'options' => array(
                                ''             => 'Select an item',
				'Organization' => 'Organization',
				'Person'       => 'Person',
			)
                    ),
                array(
			'label' => 'Organization Name',
			'id'    => 'sd_name',
                        'name'  => 'sd_data[sd_name]',
                        'class' => 'regular-text saswp_org_fields',                        
			'type'  => 'text',
                        'attributes' => array(
                                'placeholder' => 'Organization Name'
                            )
		),
                               
                array(
			'label' => 'Organization URL',
			'id'    => 'sd_url',
                        'name'  => 'sd_data[sd_url]',
                        'class' => 'regular-text saswp_org_fields',                        
			'type'  => 'text',
                        'attributes' => array(
                                'placeholder' => 'https://www.example.com'
                            )
		), 
                array(
			'label' => 'Contact Type',
			'id'    => 'saswp_contact_type',
                        'name'  => 'sd_data[saswp_contact_type]',
                        'class' => 'saswp_org_fields',
			'type'  => 'select',
			'options' => array(
                                ''                    => 'Select an item',
				'customer support'    => 'Customer Support',
				'technical support'   => 'Technical Support',
                                'billing support'     => 'Billing Support',
                                'bill payment'        => 'Bill payment',
                                'sales'               => 'Sales',
                                'reservations'        => 'Reservations',
                                'credit card support' => 'Credit Card Support',
                                'emergency'           => 'Emergency',
                                'baggage tracking'    => 'Baggage Tracking',
                                'roadside assistance' => 'Roadside Assistance',
                                'package tracking'    => 'Package Tracking',
			)                        
                   ),
                    array(
                            'label' => 'Contact Number',
                            'id'    => 'saswp_kb_telephone',
                            'name'  => 'sd_data[saswp_kb_telephone]',
                            'class' => 'regular-text saswp_org_fields',                        
                            'type'  => 'text',
                            'attributes' => array(
                                    'placeholder' => '+1-012-012-0124'
                            )
                    ),
                    array(
                            'label' => 'Contact URL',
                            'id'    => 'saswp_kb_contact_url',
                            'name'  => 'sd_data[saswp_kb_contact_url]',
                            'class' => 'regular-text saswp_org_fields',                        
                            'type'  => 'text',
                            'attributes' => array(
                                    'placeholder' => 'https://www.example.com/contact'
                            )
                    ),
                                   
                   array(
			'label' => 'Name',
			'id'    => 'sd-person-name',
                        'name'  => 'sd_data[sd-person-name]',
                        'class' => 'regular-text saswp_person_fields',                        
			'type'  => 'text',
                        'attributes' => array(
                                    'placeholder' => 'Name'
                            )
		    ),
                    array(
			'label' => 'Job Title',
			'id'    => 'sd-person-job-title',
                        'name'  => 'sd_data[sd-person-job-title]',
                        'class' => 'regular-text saswp_person_fields',                        
			'type'  => 'text',
                        'attributes' => array(
                                    'placeholder' => 'Job Title'
                            )
		    ),  
                    array(
			'label'      => 'Image',
			'id'         => 'sd-person-image',
                        'name'       => 'sd_data[sd-person-image][url]',
                        'class'      => 'upload large-text saswp_person_fields',
			'type'       => 'media',
                        'attributes' => array(
                                'readonly' => 'readonly'
                            ) 
		   ),
                    array(
			'label'  => 'Phone Number',
			'id'     => 'sd-person-phone-number',
                        'name'   => 'sd_data[sd-person-phone-number]',
                        'class'  => 'regular-text saswp_person_fields',                        
			'type'   => 'text',
                        'attributes' => array(
                                    'placeholder' => '+1-012-012-0124'
                            )
		    ),
                     array(
			'label' => 'URL',
			'id'    => 'sd-person-url',
                        'name'  => 'sd_data[sd-person-url]',
                        'class' => 'regular-text saswp_person_fields',                        
			'type'  => 'text',
                        'attributes' => array(
                                            'placeholder' => 'https://www.example.com/person'
                        )                             
		    ),
                    array(
			'label' => 'Logo',
			'id'    => 'sd_logo',
                        'name'  => 'sd_data[sd_logo][url]',
                        'class' => 'saswp-icon upload large-text saswp_kg_logo',
			'type'  => 'media',
                        'note'  => 'According to google validation tool, Logo size must be 160*50 or 600*60',
                        'attributes' => array(
                                'readonly' => 'readonly'                                
                            )    
		   ),
                
	);
        
        echo '<div class="saswp-heading">';
        echo '<h2>'.esc_html__('Knowledge Graph','schema-and-structured-data-for-wp').'</h2>';                 
        echo '</div>';                
        echo '<p>'.esc_html__('The Knowledge Graph is a knowledge base used by Google and its services to enhance its search engine\'s results.','schema-and-structured-data-for-wp').' <a target="_blank" href="http://structured-data-for-wp.com/docs/article/how-to-setup-knowledge-graph-in-schema-in-wordpress/">'.esc_html__('Learn More','schema-and-structured-data-for-wp').'</a> </p>';
        echo '<div class="saswp-knowledge-base">';
        $field_objs->saswp_field_generator($meta_fields, $settings);
        echo '</div>';
        
        //social
        echo '<h2>'.esc_html__( 'Social Fields', 'schema-and-structured-data-for-wp' ).'</h2>';
        $social_meta_fields = array(	
                array(
			'label'  => 'Facebook',
			'id'     => 'saswp-facebook-enable-checkbox', 
                        'name'   => 'saswp-facebook-enable-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox', 
                        'hidden' => array(
                             'id'   => 'saswp-facebook-enable',
                             'name' => 'sd_data[saswp-facebook-enable]',                             
                        )
		),            
		array(
			'label' => '',
			'id'    => 'sd_facebook',
                        'name'  => 'sd_data[sd_facebook]',
                        'class' => 'regular-text',                        
			'type'  => 'text',
                        'attributes' => array(
                            'placeholder' => 'https://facebook.com'
                        )
		    ),
                array(
			'label'  => 'Twitter',
			'id'     => 'saswp-twitter-enable-checkbox', 
                        'name'   => 'saswp-twitter-enable-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox', 
                        'hidden' => array(
                             'id'   => 'saswp-twitter-enable',
                             'name' => 'sd_data[saswp-twitter-enable]',                             
                        )
		),    
                array(
			'label'      => '',
			'id'         => 'sd_twitter',
                        'name'       => 'sd_data[sd_twitter]',
                        'class'      => 'regular-text',                        
			'type'       => 'text',
                        'attributes' => array(
                            'placeholder' => 'https://twitter.com'
                        )
		    ),              
                array(
			'label'  => 'Instagram',
			'id'     => 'saswp-instagram-enable-checkbox', 
                        'name'   => 'saswp-instagram-enable-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox', 
                        'hidden' => array(
                             'id'   => 'saswp-instagram-enable',
                             'name' => 'sd_data[saswp-instagram-enable]',                             
                        )
		),
                array(
			'label'      => '',
			'id'         => 'sd_instagram',
                        'name'       => 'sd_data[sd_instagram]',
                        'class'      => 'regular-text',                        
			'type'       => 'text',
                        'attributes' => array(
                            'placeholder' => 'https://instagram.com'
                        )
		    ), 
                array(
			'label'  => 'Youtube',
			'id'     => 'saswp-youtube-enable-checkbox', 
                        'name'   => 'saswp-youtube-enable-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox', 
                        'hidden' => array(
                             'id'   => 'saswp-youtube-enable',
                             'name' => 'sd_data[saswp-youtube-enable]',                             
                        )
		),    
                array(
			'label'      => '',
			'id'         => 'sd_youtube',
                        'name'       => 'sd_data[sd_youtube]',
                        'class'      => 'regular-text',                        
			'type'       => 'text',
                        'attributes' => array(
                            'placeholder' => 'https://youtube.com'
                        )
		    ),
               array(
			'label'  => 'LinkedIn',
			'id'     => 'saswp-linkedin-enable-checkbox', 
                        'name'   => 'saswp-linkedin-enable-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox', 
                        'hidden' => array(
                             'id'   => 'saswp-linkedin-enable',
                             'name' => 'sd_data[saswp-linkedin-enable]',                             
                        )
		),      
               array(
			'label'      => '',
			'id'         => 'sd_linkedin',
                        'name'       => 'sd_data[sd_linkedin]',
                        'class'      => 'regular-text',                        
			'type'       => 'text',
                        'attributes' => array(
                            'placeholder' => 'https://linkedin.com'
                        )
		    ),
                array(
			'label'  => 'Pinterest',
			'id'     => 'saswp-pinterest-enable-checkbox', 
                        'name'   => 'saswp-pinterest-enable-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox', 
                        'hidden' => array(
                             'id'   => 'saswp-pinterest-enable',
                             'name' => 'sd_data[saswp-pinterest-enable]',                             
                        )
		), 
                array(
			'label'      => '',
			'id'         => 'sd_pinterest',
                        'name'       => 'sd_data[sd_pinterest]',
                        'class'      => 'regular-text',                        
			'type'       => 'text',
                        'attributes' => array(
                            'placeholder' => 'https://pinterest.com'
                        )
		    ),
                array(
			'label'  => 'SoundCloud',
			'id'     => 'saswp-soundcloud-enable-checkbox', 
                        'name'   => 'saswp-soundcloud-enable-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox', 
                        'hidden' => array(
                             'id'   => 'saswp-soundcloud-enable',
                             'name' => 'sd_data[saswp-soundcloud-enable]',                             
                        )
		),     
                array(
			'label'      => '',
			'id'         => 'sd_soundcloud',
                        'name'       => 'sd_data[sd_soundcloud]',
                        'class'      => 'regular-text',                        
			'type'       => 'text',
                        'attributes' => array(
                            'placeholder' => 'https://soundcloud.com'
                        )
		    ),
             array(
			'label'  => 'Tumblr',
			'id'     => 'saswp-tumblr-enable-checkbox', 
                        'name'   => 'saswp-tumblr-enable-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox', 
                        'hidden' => array(
                             'id' => 'saswp-tumblr-enable',
                             'name' => 'sd_data[saswp-tumblr-enable]',                             
                        )
		),
                array(
			'label'      => '',
			'id'         => 'sd_tumblr',
                        'name'       => 'sd_data[sd_tumblr]',
                        'class'      => 'regular-text',                        
			'type'       => 'text',
                        'attributes' => array(
                            'placeholder' => 'https://tumblr.com'
                        )
		    ),
                			
	);
         echo '<div class="saswp-social-fileds">';
         $field_objs->saswp_field_generator($social_meta_fields, $settings);
         echo '</div>';
                
        ?>
                        
    </div>
    <div class="saswp-global-container" id="saswp-default-container">
    
        <?php
                
        $meta_fields_default = array(	                                		                             
                array(
			'label' => 'Default Image',
			'id'    => 'sd_default_image',
                        'name'  => 'sd_data[sd_default_image][url]',
                        'class' => 'saswp-sd_default_image',
			'type'  => 'media',
		),
                array(
			'label' => 'Default Post Image Width',
			'id'    => 'sd_default_image_width',
                        'name'  => 'sd_data[sd_default_image_width]',
                        'class' => 'regular-text',                        
			'type'  => 'text',
		),
                array(
			'label' => 'Default Post Image Height',
			'id'    => 'sd_default_image_height',
                        'name'  => 'sd_data[sd_default_image_height]',
                        'class' => 'regular-text',                        
			'type'  => 'text',
                        'note'  => esc_html__('According to google validation tool, Image size must be greater than or equal to 1200*728','schema-and-structured-data-for-wp')
		)                                                                   
	);
         echo '<div class="saswp-heading">';
         echo '<h2>'.esc_html__('Default Data','schema-and-structured-data-for-wp').'</h2>';                  
         echo '</div>';
         echo '<p>'.esc_html__('If schema markup doest not have image, it adds this image to validate schema markup.','schema-and-structured-data-for-wp').' <a target="_blank" href="http://structured-data-for-wp.com/docs/article/how-to-set-up-the-default-structured-data-values/">'.esc_html__('Learn More','schema-and-structured-data-for-wp').'</a></p>';
         echo '<div class="saswp-schema-type-fields">';
         $field_objs->saswp_field_generator($meta_fields_default, $settings);
         echo '</div>';  
        
        
        ?>
    </div>        
                                                                                                                             
	<?php
                
        
}

function saswp_check_data_imported_from($plugin_post_type_name){
    
       $cc_args = array(
                        'posts_per_page'   => -1,
                        'post_type'        => 'saswp',
                        'meta_key'         => 'imported_from',
                        'meta_value'       => $plugin_post_type_name,
                    );	
       
	$imported_from = new WP_Query( $cc_args ); 
        
        return $imported_from;
}
function saswp_import_callback(){
    
        global $sd_data;
        
        
        echo '<h2>'.esc_html__('Advanced Settings','schema-and-structured-data-for-wp').'</h2>'; 
        
        $settings = saswp_defaultSettings();         
        $field_objs = new saswp_fields_generator();
        $meta_fields = array(				
                array(
			'label'  => 'Defragment Schema Markup',
			'id'     => 'saswp-defragment-checkbox',                        
                        'name'   => 'saswp-defragment-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'note'   => 'It relates all schema markups on page to a main entity and merge all markup to a single markup. <a target="_blank" href="https://structured-data-for-wp.com/docs/article/what-is-defragment-schema-markup-and-how-to-add-it/">Learn More</a>',
                        'hidden' => array(
                             'id'   => 'saswp-defragment',
                             'name' => 'sd_data[saswp-defragment]',                             
                        )
		),
                array(
			'label'  => 'Add Schema Markup in footer',
			'id'     => 'saswp-markup-footer-checkbox',                        
                        'name'   => 'saswp-markup-footer-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'note'  => 'By default schema markup will be added in header section',
                        'hidden' => array(
                             'id'   => 'saswp-markup-footer',
                             'name' => 'sd_data[saswp-markup-footer]',                             
                        )
		),
                array(
			'label'  => 'Pretty Print Schema Markup',
			'id'     => 'saswp-pretty-print-checkbox',                        
                        'name'   => 'saswp-pretty-print-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'note'  => 'By default schema markup will be minified format',
                        'hidden' => array(
                             'id'   => 'saswp-pretty-print',
                             'name' => 'sd_data[saswp-pretty-print]',                             
                        )
		),
                array(
			'label'  => 'MicroData CleanUp',
			'id'     => 'saswp-microdata-cleanup-checkbox',                        
                        'name'   => 'saswp-microdata-cleanup-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',   
                        'note'   => 'It removes all the microdata generated by third party plugins which cause validation error on google testing tool',   
                        'hidden' => array(
                             'id'   => 'saswp-microdata-cleanup',
                             'name' => 'sd_data[saswp-microdata-cleanup]',                             
                        )
		),
                
	);        
        $field_objs->saswp_field_generator($meta_fields, $settings);  
        
        ?>
       
        <?php
                                
        $message               = 'This plugin\'s data already has been imported. Do you want to import again?. click on button above button.';
        $schema_message        = '';
        $schema_pro_message    = '';
        $wp_seo_schema_message = '';
        $seo_pressor_message   = '';
        $schema_plugin         = saswp_check_data_imported_from('schema'); 
        $schema_pro_plugin     = saswp_check_data_imported_from('schema_pro');
        $wp_seo_schema_plugin  = saswp_check_data_imported_from('wp_seo_schema');
        $seo_pressor           = saswp_check_data_imported_from('seo_pressor');
        
        if($seo_pressor->post_count !=0){
            
          $seo_pressor_message = $message;
         
        }        
	if($schema_plugin->post_count !=0){
            
          $schema_message    = $message;
         
        }
        if($schema_pro_plugin->post_count !=0){
            
          $schema_pro_message = $message;   
         
        }
        if($wp_seo_schema_plugin->post_count !=0){
            
          $wp_seo_schema_message = $message;   
         
        }
        
	 echo '<h2>'.esc_html__('Migration','schema-and-structured-data-for-wp').'</h2>';       	                  
        ?>	
            <ul>
                <li><div class="saswp-tools-field-title"><div class="saswp-tooltip"><span class="saswp-tooltiptext"><?php echo esc_html__('All the settings and data you can import from this plugin when you click start importing','schema-and-structured-data-for-wp') ?></span><strong><?php echo esc_html__('Schema Plugin','schema-and-structured-data-for-wp'); ?></strong></div><button data-id="schema" class="button saswp-import-plugins"><?php echo esc_html__('Import','schema-and-structured-data-for-wp'); ?></button>
                        <p class="saswp-imported-message"></p>
                        <?php echo '<p>'.esc_html__($schema_message, 'schema-and-structured-data-for-wp').'</p>'; ?>    
                    </div>
                </li>
                <li><div class="saswp-tools-field-title"><div class="saswp-tooltip"><span class="saswp-tooltiptext"><?php echo esc_html__('All the settings and data you can import from this plugin when you click start importing','schema-and-structured-data-for-wp') ?></span><strong><?php echo esc_html__('Schema Pro','schema-and-structured-data-for-wp'); ?></strong></div><button data-id="schema_pro" class="button saswp-import-plugins"><?php echo esc_html__('Import','schema-and-structured-data-for-wp'); ?></button>
                        <p class="saswp-imported-message"></p>
                        <?php echo '<p>'.esc_html__($schema_pro_message, 'schema-and-structured-data-for-wp').'</p>'; ?>                       
                    </div>
                </li>
                <li><div class="saswp-tools-field-title"><div class="saswp-tooltip"><span class="saswp-tooltiptext"><?php echo esc_html__('All the settings and data you can import from this plugin when you click start importing','schema-and-structured-data-for-wp') ?></span><strong><?php echo esc_html__('WP SEO Schema','schema-and-structured-data-for-wp'); ?></strong></div><button data-id="wp_seo_schema" class="button saswp-import-plugins"><?php echo esc_html__('Import','schema-and-structured-data-for-wp'); ?></button>
                        <p class="saswp-imported-message"></p>
                        <?php echo '<p>'.esc_html__($wp_seo_schema_message, 'schema-and-structured-data-for-wp').'</p>'; ?>                       
                    </div>
                </li>
                <li><div class="saswp-tools-field-title"><div class="saswp-tooltip"><span class="saswp-tooltiptext"><?php echo esc_html__('All the settings and data you can import from this plugin when you click start importing','schema-and-structured-data-for-wp') ?></span><strong><?php echo esc_html__('SEO Pressor','schema-and-structured-data-for-wp'); ?></strong></div><button data-id="seo_pressor" class="button saswp-import-plugins"><?php echo esc_html__('Import','schema-and-structured-data-for-wp'); ?></button>
                        <p class="saswp-imported-message"></p>
                        <?php echo '<p>'.esc_html__($seo_pressor_message, 'schema-and-structured-data-for-wp').'</p>'; ?>                          
                    </div>
                </li>
                
            </ul>                   
	<?php   
        echo '<h2>'.esc_html__('Import / Export','schema-and-structured-data-for-wp').'</h2>'; 
        $url = wp_nonce_url(admin_url('admin-ajax.php?action=saswp_export_all_settings_and_schema'), '_wpnonce');         
        ?>
        <ul>
                <li>
                    <div class="saswp-tools-field-title"><div class="saswp-tooltip"><strong><?php echo esc_html__('Export All Settings & Schema','schema-and-structured-data-for-wp'); ?></strong></div><a href="<?php echo esc_url($url); ?>"class="button saswp-export-data"><?php echo esc_html__('Export','schema-and-structured-data-for-wp'); ?></a>                         
                    </div>
                </li> 
                <li>
                    <div class="saswp-tools-field-title"><div class="saswp-tooltip"><strong><?php echo esc_html__('Import All Settings & Schema','schema-and-structured-data-for-wp'); ?></strong></div><input type="file" name="saswp_import_backup" id="saswp_import_backup">                         
                    </div>
                </li> 
        </ul>
        <?php                
         echo '<h2>'.esc_html__('Reset','schema-and-structured-data-for-wp').'</h2>'; 
         ?>
            <ul>
                <li>
                    <div class="saswp-tools-field-title">
                        <div class="saswp-tooltip"><strong><?php echo esc_html__('Reset Settings','schema-and-structured-data-for-wp'); ?></strong></div><a href="#"class="button saswp-reset-data"><?php echo esc_html__('Reset','schema-and-structured-data-for-wp'); ?></a>                         
                        <p><?php echo esc_html__('This will reset your settings and schema types','schema-and-structured-data-for-wp'); ?></p>
                    </div>
                </li> 
                
            </ul>


        <?php    
        
                        
        $add_on = array();
                
        if(is_plugin_active('cooked-compatibility-for-schema/cooked-compatibility-for-schema.php')){
                      
           $add_on[] = 'Cooked';           
                                      
        }
        
        if(is_plugin_active('woocommerce-compatibility-for-schema/woocommerce-compatibility-for-schema.php')){
                      
           $add_on[] = 'Woocommerce';           
                                      
        }
                
        if(!empty($add_on)){
            
            echo '<h2>'.esc_html__('License','schema-and-structured-data-for-wp').'</h2>';
            
            echo '<ul>';
            
            foreach($add_on as $on){
                
                $license_key        = '';
                $license_status     = 'inactive';
                $license_status_msg = '';
                
                if(isset($sd_data[strtolower($on).'_addon_license_key'])){
                  $license_key =   $sd_data[strtolower($on).'_addon_license_key'];
                }
                
                if(isset($sd_data[strtolower($on).'_addon_license_key_status'])){
                  $license_status =   $sd_data[strtolower($on).'_addon_license_key_status'];
                }
                
                if(isset($sd_data[strtolower($on).'_addon_license_key_message'])){
                  $license_status_msg =   $sd_data[strtolower($on).'_addon_license_key_message'];
                }
                
                echo '<li>';
                echo '<div class="saswp-tools-field-title">';
                
                echo '<div class="" style="display:inline-block">';
                echo '<strong>'.esc_html__(''.$on.' Compatibility For Schema','schema-and-structured-data-for-wp').'</strong>';
                echo '</div>';
                
                if($license_status == 'active'){
                
                    echo '<span class="dashicons dashicons-yes saswp-'.strtolower($on).'-dashicons" style="color: #46b450;"></span>';    
                    
                }else{
                
                    echo '<span class="dashicons dashicons-no-alt saswp-'.strtolower($on).'-dashicons" style="color: #dc3232;"></span>';
                    
                }
                                                
                echo '<input type="text" placeholder="Enter License Key" id="'.strtolower($on).'_addon_license_key" name="sd_data['.strtolower($on).'_addon_license_key]" value="'.esc_attr($license_key).'">';
                
                echo '<input type="hidden" id="'.strtolower($on).'_addon_license_key_status" name="sd_data['.strtolower($on).'_addon_license_key_status]" value="'.esc_attr($license_status).'">';                
                
                if($license_status == 'active'){
                
                    echo '<a license-status="inactive" add-on="'.strtolower($on).'" class="button button-default saswp_license_activation">'.esc_html__('Deactivate', 'schema-and-structured-data-for-wp').'</a>';
                    
                }else{
                
                    echo '<a license-status="active" add-on="'.strtolower($on).'" class="button button-default saswp_license_activation">'.esc_html__('Activate', 'schema-and-structured-data-for-wp').'</a>';
                    
                }
                
                if($license_status_msg !='active'){
                    echo '<p style="color:red;" add-on="'.strtolower($on).'" class="saswp_license_status_msg">'.$license_status_msg.'</p>';
                }                
                                                
                echo '<p>'.esc_html__('Enter your '.$on.' addon license key to activate updates & support.','schema-and-structured-data-for-wp').'</p>';
                
                echo '</div>';
                echo '</li>';
                
            }
            
            echo '</ul>';
            
        }
                          
         ?>

<?php
         
}

function saswp_review_page_callback(){
        
        $settings = saswp_defaultSettings();         
        $field_objs = new saswp_fields_generator();
        $meta_fields = array(				
                array(
			'label'  => 'Review Module',
			'id'     => 'saswp-review-module-checkbox',                        
                        'name'   => 'saswp-review-module-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'note'   => 'This option enables the review metabox on every post/page. <a target="_blank" href="http://structured-data-for-wp.com/docs/article/how-to-use-review-in-schema-and-structure-data/">Learn More</a>',
                        'hidden' => array(
                             'id'   => 'saswp-review-module',
                             'name' => 'sd_data[saswp-review-module]',                             
                        )
		),
                array(
			'label'  => 'Google Review',
			'id'     => 'saswp-google-review-checkbox',                        
                        'name'   => 'saswp-google-review-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'note'   => 'This option enables the google review section. <a target="_blank" href="https://structured-data-for-wp.com/docs/article/how-to-display-google-review/">Learn More</a>',
                        'hidden' => array(
                             'id'   => 'saswp-google-review',
                             'name' => 'sd_data[saswp-google-review]',                             
                        )
		),                        
                array(
                            'label' => 'Google place API Key',
                            'id'    => 'saswp_google_place_api_key',
                            'name'  => 'sd_data[saswp_google_place_api_key]',
                            'note'   => 'How to get place API Key ? <a target="_blank" href="https://structured-data-for-wp.com/docs/article/how-to-display-google-review/">Click Here</a>',
                            'class' => '',
                            'type'  => 'text',
                  )
                
	);        
        $field_objs->saswp_field_generator($meta_fields, $settings);             
}

function saswp_email_schema_callback(){
        
        $settings = saswp_defaultSettings();  
                                        
        $woocommerce = array(
			'label'  => 'Woocommerce Booking',
			'id'     => 'saswp-woocommerce-booking-main-checkbox',                        
                        'name'   => 'saswp-woocommerce-booking-main-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'hidden' => array(
                                'id'   => 'saswp-woocommerce-booking-main',
                                'name' => 'sd_data[saswp-woocommerce-booking-main]',                             
                        )
		);
        
        if(!is_plugin_active('woocommerce/woocommerce.php') || !is_plugin_active('woocommerce-bookings/woocommerce-bookings.php')){
                      
             $woocommerce['note'] = esc_html__('Requires','schema-and-structured-data-for-wp').' <a target="_blank" href="https://wordpress.org/plugins/woocommerce/">Woocommerce</a>';
                                      
        }
        
        if(!is_plugin_active('woocommerce-compatibility-for-schema/woocommerce-compatibility-for-schema.php')){
                      
             $woocommerce['note'] = esc_html__('This feature requires','schema-and-structured-data-for-wp').' <a target="_blank" href="http://structured-data-for-wp.com/woocommerce-compatibility-for-schema/">WooCommerce Addon</a>';
                                      
        }
                                   
        $field_objs = new saswp_fields_generator();
        $meta_fields = array(				               
                $woocommerce,                                              
	);       
        
        $field_objs->saswp_field_generator($meta_fields, $settings);
                        
}

function saswp_compatibility_page_callback(){
        
        $settings = saswp_defaultSettings();  
        
        $tagyeem = array(
			'label'  => 'Tagyeem With Jannah Theme',
			'id'     => 'saswp-tagyeem-checkbox',                        
                        'name'   => 'saswp-tagyeem-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'hidden' => array(
                                'id'   => 'saswp-tagyeem',
                                'name' => 'sd_data[saswp-tagyeem]',                             
                        )
		);
        
        $the_events_calendar = array(
			'label'  => 'The Events Calendar',
			'id'     => 'saswp-the-events-calendar-checkbox',                        
                        'name'   => 'saswp-the-events-calendar-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'hidden' => array(
                                'id'   => 'saswp-the-events-calendar',
                                'name' => 'sd_data[saswp-the-events-calendar]',                             
                        )
		);
        
        
        $kk_star = array(
			'label'  => 'kk Star Ratings',
			'id'     => 'saswp-kk-star-raring-checkbox',                        
                        'name'   => 'saswp-kk-star-raring-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'hidden' => array(
                                'id'   => 'saswp-kk-star-raring',
                                'name' => 'sd_data[saswp-kk-star-raring]',                             
                        )
		);
        $wppostratings = array(
			'label'  => 'WP-PostRatings',
			'id'     => 'saswp-wppostratings-raring-checkbox',                        
                        'name'   => 'saswp-wppostratings-raring-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'hidden' => array(
                                'id'   => 'saswp-wppostratings-raring',
                                'name' => 'sd_data[saswp-wppostratings-raring]',                             
                        )
		);
        $woocommerce = array(
			'label'  => 'Woocommerce',
			'id'     => 'saswp-woocommerce-checkbox',                        
                        'name'   => 'saswp-woocommerce-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'hidden' => array(
                                'id'   => 'saswp-woocommerce',
                                'name' => 'sd_data[saswp-woocommerce]',                             
                        )
		);
        $woocommerce_bok = array(
			'label'  => 'Woocommerce Booking',
			'id'     => 'saswp-woocommerce-booking-checkbox',                        
                        'name'   => 'saswp-woocommerce-booking-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'hidden' => array(
                                'id'   => 'saswp-woocommerce-booking',
                                'name' => 'sd_data[saswp-woocommerce-booking]',                             
                        )
		);
        
        $cooked = array(
			'label'  => 'Cooked',
			'id'     => 'saswp-cooked-checkbox',                        
                        'name'   => 'saswp-cooked-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'hidden' => array(
                                'id'   => 'saswp-cooked',
                                'name' => 'sd_data[saswp-cooked]',                             
                        )
		);
        
        $woocommerce_mem = array(
			'label'  => 'Woocommerce Membership',
			'id'     => 'saswp-woocommerce-membership-checkbox',                        
                        'name'   => 'saswp-woocommerce-membership-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'hidden' => array(
                                'id'   => 'saswp-woocommerce-membership',
                                'name' => 'sd_data[saswp-woocommerce-membership]',                             
                        )
		);
        
        $extratheme = array(
			'label'  => 'Extra Theme By Elegant',
			'id'     => 'saswp-extra-checkbox',                        
                        'name'   => 'saswp-extra-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'hidden' => array(
                                'id'   => 'saswp-extra',
                                'name' => 'sd_data[saswp-extra]',                             
                        )
		);
        $dwquestiton = array(
			'label'  => 'DW Question Answer',
			'id'     => 'saswp-dw-question-answer-checkbox',                        
                        'name'   => 'saswp-dw-question-answer-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'hidden' => array(
                                    'id'   => 'saswp-dw-question-answer',
                                    'name' => 'sd_data[saswp-dw-question-answer]',                             
                        )
		);
        
        $bbpress = array(
			'label'  => 'bbPress',
			'id'     => 'saswp-bbpress-checkbox',                        
                        'name'   => 'saswp-bbpress-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',
                        'hidden' => array(
                                    'id'   => 'saswp-bbpress',
                                    'name' => 'sd_data[saswp-bbpress]',                             
                        )
		);
                
        $yoast      = array(
			'label'   => 'Yoast SEO Plugin',
			'id'      => 'saswp-yoast-checkbox',                        
                        'name'    => 'saswp-yoast-checkbox',
			'type'    => 'checkbox',
                        'class'   => 'checkbox saswp-checkbox',
                        'hidden'  => array(
                                'id'   => 'saswp-yoast',
                                'name' => 'sd_data[saswp-yoast]',                             
                        )
		);
        $rankmath      = array(
			'label'   => 'Rank Math',
			'id'      => 'saswp-rankmath-checkbox',                        
                        'name'    => 'saswp-rankmath-checkbox',
			'type'    => 'checkbox',
                        'class'   => 'checkbox saswp-checkbox',
                        'hidden'  => array(
                                'id'   => 'saswp-rankmath',
                                'name' => 'sd_data[saswp-rankmath]',                             
                        )
		);        
                
        if(!is_plugin_active('taqyeem/taqyeem.php')  || get_template() != 'jannah'  ){
            
             $tagyeem['note'] = esc_html__('Requires','schema-and-structured-data-for-wp').' <a target="_blank" href="https://codecanyon.net/item/taqyeem-wordpress-review-plugin/4558799">Taqyeem</a>';
                          
        }
        
        if(!is_plugin_active('bbpress/bbpress.php')){
            
             $bbpress['note'] = esc_html__('Requires','schema-and-structured-data-for-wp').' <a target="_blank" href="https://wordpress.org/plugins/bbpress/">bbPress</a>';
                          
        }
        
        
        if(!is_plugin_active('wordpress-seo/wp-seo.php') && !is_plugin_active('wordpress-seo-premium/wp-seo-premium.php')){
            
             $yoast['note'] = esc_html__('Requires','schema-and-structured-data-for-wp').' <a target="_blank" href="https://wordpress.org/plugins/wordpress-seo/">Yoast SEO</a>';
             
             
        }
        if(!is_plugin_active('seo-by-rank-math/rank-math.php') && !is_plugin_active('seo-by-rank-math-premium/rank-math-premium.php')){
            
             $rankmath['note'] = esc_html__('Requires','schema-and-structured-data-for-wp').' <a target="_blank" href="https://wordpress.org/plugins/seo-by-rank-math/">WordPress SEO Plugin – Rank Math</a>';
             
             
        }
        
        if(!is_plugin_active('kk-star-ratings/index.php')){
            
             $kk_star['note'] = esc_html__('Requires','schema-and-structured-data-for-wp').' <a target="_blank" href="https://wordpress.org/plugins/kk-star-ratings/">kk Star Rating</a>';             
             
        }
                    
        if(!is_plugin_active('woocommerce/woocommerce.php')){
         
             $woocommerce['note'] = esc_html__('Requires','schema-and-structured-data-for-wp').' <a target="_blank" href="https://wordpress.org/plugins/woocommerce/">Woocommerce</a>';
                         
        }
        if(!is_plugin_active('woocommerce/woocommerce.php') || !is_plugin_active('woocommerce-bookings/woocommerce-bookings.php')){
                      
            $woocommerce_bok['note'] = esc_html__('Requires','schema-and-structured-data-for-wp').' <a target="_blank" href="https://wordpress.org/plugins/woocommerce/">Woocommerce</a>';
                                      
        }
                                
        if(!is_plugin_active('woocommerce/woocommerce.php') || !is_plugin_active('woocommerce-memberships/woocommerce-memberships.php')){
                      
           $woocommerce_mem['note'] = esc_html__('Requires','schema-and-structured-data-for-wp').' <a target="_blank" href="https://wordpress.org/plugins/woocommerce/">Woocommerce</a>';
                                      
        }
        
        
        if(!is_plugin_active('woocommerce-compatibility-for-schema/woocommerce-compatibility-for-schema.php')){
                      
             $woocommerce_bok['note'] = esc_html__('This feature requires','schema-and-structured-data-for-wp').' <a target="_blank" href="http://structured-data-for-wp.com/woocommerce-compatibility-for-schema/">Woocommerce Addon</a>';
                                      
        }
                                
        if(!is_plugin_active('woocommerce-compatibility-for-schema/woocommerce-compatibility-for-schema.php')){
                      
            $woocommerce_mem['note'] = esc_html__('This feature requires','schema-and-structured-data-for-wp').' <a target="_blank" href="http://structured-data-for-wp.com/woocommerce-compatibility-for-schema/">Woocommerce Addon</a>';
                                      
        }
        
        
        if(!is_plugin_active('cooked-compatibility-for-schema/cooked-compatibility-for-schema.php')){
                          
             $cooked['note'] = esc_html__('This feature requires','schema-and-structured-data-for-wp').' <a target="_blank" href="http://structured-data-for-wp.com/cooked-compatibility-for-schema/">Cooked Addon</a>';
             
         }
         
        if(is_plugin_active('cooked/cooked.php') || is_plugin_active('cooked-pro/cooked-pro.php')){                                                    
         }else{
         $cooked['note'] = esc_html__('Requires','schema-and-structured-data-for-wp').' <a target="_blank" href="https://wordpress.org/plugins/cooked/">Cooked</a>';    
         } 
                                                                         
        if(get_template() != 'Extra'){
             
             $extratheme['note']      = esc_html__('Requires','schema-and-structured-data-for-wp').' <a target="_blank" href="https://www.elegantthemes.com/gallery/extra/">Extra Theme</a>';
             
             
        }
                         
         if(!is_plugin_active('dw-question-answer/dw-question-answer.php') && !is_plugin_active('dw-question-answer-pro/dw-question-answer.php')){
             
             $dwquestiton['note'] = esc_html__('Requires','schema-and-structured-data-for-wp').' <a target="_blank" href="https://wordpress.org/plugins/dw-question-answer/">DW Question Answer</a>';
             
         }
         
         if(!is_plugin_active('wp-postratings/wp-postratings.php')){
             
             $wppostratings['note'] = esc_html__('Requires','schema-and-structured-data-for-wp').' <a target="_blank" href="https://wordpress.org/plugins/wp-postratings/">WP-PostRatings</a>';
             
         }
         
//         if(!is_plugin_active('wp-job-manager/wp-job-manager.php')){
//                          
//             $wpjobmanager['note'] = esc_html__('Requires selected plugin','schema-and-structured-data-for-wp');
//             
//         }
         
         if(!is_plugin_active('the-events-calendar/the-events-calendar.php')){
                          
             $the_events_calendar['note'] = esc_html__('Requires','schema-and-structured-data-for-wp').' <a target="_blank" href="https://wordpress.org/plugins/the-events-calendar/">The Events Calendar</a>';
             
         }
                  
                        
        $field_objs = new saswp_fields_generator();
        
        $meta_fields = array(				
                $kk_star,  
                $wppostratings,
                $bbpress,
                $woocommerce,
                $woocommerce_bok,
                $woocommerce_mem,
                $cooked,
                $the_events_calendar,
                $tagyeem,
                $extratheme,
                $dwquestiton,
                //$wpjobmanager,
                $yoast,
                $rankmath
                
	);     
        
        echo '<div class="saswp-heading">';
        echo '<h2>'.esc_html__('Compatibility','schema-and-structured-data-for-wp').'</h2>';                
        echo '</div>';
        echo '<p>'.esc_html__('These are the list of plugin\'s name which are compatible with Schema & Structured Data For WP.','schema-and-structured-data-for-wp').' <a target="_blank" href="https://structured-data-for-wp.com/docs/article-categories/compatibility/">Learn More</a></p>';
        
        $field_objs->saswp_field_generator($meta_fields, $settings);
        
        
        if ( is_plugin_active('flexmls-idx/flexmls_connect.php')) {
         $meta_fields_default = array(	
		array(
			'label'  => 'FlexMLS IDX Plugin',
			'id'     => 'saswp-flexmlx-compativility-checkbox', 
                        'name'   => 'saswp-flexmlx-compativility-checkbox',
			'type'   => 'checkbox',
                        'class'  => 'checkbox saswp-checkbox',                       
                        'hidden' => array(
                             'id'   => 'saswp-flexmlx-compativility',
                             'name' => 'sd_data[saswp-flexmlx-compativility]',                             
                        )
		),
		);   
        }else{
        
        $meta_fields_default = array(	
		array(
			'label'      => 'FlexMLS IDX',
			'id'         => 'saswp-flexmlx-compativility-checkbox', 
                        'name'       => 'saswp-flexmlx-compativility-checkbox',
			'type'       => 'checkbox',
                        'class'      => 'checkbox saswp-checkbox',
                        'note'       => 'Requires <a target="_blank" href="https://wordpress.org/plugins/flexmls-idx/">FlexMLS IDX</a>',                        
                        'hidden' => array(
                             'id'   => 'saswp-flexmlx-compativility',
                             'name' => 'sd_data[saswp-flexmlx-compativility]',                             
                        )
		),
		);          
        }
         $meta_fields_text = array();
         $meta_fields_text[] = array(
                        'label' => 'Name',
			'id'    => 'sd-seller-name',
                        'name'  => 'sd_data[sd-seller-name]',
                        'class' => 'regular-text',                        
			'type'  => 'text',
        );
         $meta_fields_text[] = array(
                        'label' => 'Addres',
			'id'    => 'sd-seller-address',
                        'name'  => 'sd_data[sd-seller-address]',
                        'class' => 'regular-text',                        
			'type'  => 'text',
        );
         $meta_fields_text[] = array(
                        'label' => 'Telephone',
			'id'    => 'sd-seller-telephone',
                        'name'  => 'sd_data[sd-seller-telephone]',
                        'class' => 'regular-text',                        
			'type'  => 'text',
        );
         $meta_fields_text[] = array(
                        'label' => 'Price Range',
			'id'    => 'sd-seller-price-range',
                        'name'  => 'sd_data[sd-seller-price-range]',
                        'class' => 'regular-text',                        
			'type'  => 'text',
        );
        $meta_fields_text[] = array(
			'label' => 'URL',
			'id'    => 'sd-seller-url',
                        'name'  => 'sd_data[sd-seller-url]',
                        'class' => 'regular-text',
			'type'  => 'text',
		);                                
        $meta_fields_text[] = array(
			'label' => 'Image',
			'id'    => 'sd_seller_image',
                        'name'  => 'sd_data[sd_seller_image][url]',
                        'class' => 'saswp-sd_seller_image',
			'type'  => 'media',
	);                
              
        $field_objs = new saswp_fields_generator();         
        $field_objs->saswp_field_generator($meta_fields_default, $settings);  
        
        if ( is_plugin_active('flexmls-idx/flexmls_connect.php')) {
            
            echo '<div class="saswp-seller-div">';
            echo '<strong>'.esc_html__('Real estate agent info :','schema-and-structured-data-for-wp').'</strong>';

            $field_objs->saswp_field_generator($meta_fields_text, $settings);

            echo '</div>';    
        }                        
                        
}


function saswp_support_page_callback(){
    
    ?>
     <div class="saswp_support_div">
            <strong><?php echo esc_html__('If you have any query, please write the query in below box or email us at', 'schema-and-structured-data-for-wp') ?> <a href="mailto:team@ampforwp.com">team@ampforwp.com</a>. <?php echo esc_html__('We will reply to your email address shortly', 'schema-and-structured-data-for-wp') ?></strong>
       
            <ul>
                <li>
                    <textarea rows="5" cols="60" id="saswp_query_message" name="saswp_query_message"> </textarea>
                    <br>
                    <span class="saswp-query-success saswp_hide"><?php echo esc_html__('Message sent successfully, Please wait we will get back to you shortly', 'schema-and-structured-data-for-wp'); ?></span>
                    <span class="saswp-query-error saswp_hide"><?php echo esc_html__('Message not sent. please check your network connection', 'schema-and-structured-data-for-wp'); ?></span>
                </li> 
                <li><button class="button saswp-send-query"><?php echo esc_html__('Send Message', 'schema-and-structured-data-for-wp'); ?></button></li>
            </ul>            
                   
        </div>
    <?php
    
   echo  '<h1>'.esc_html__( 'Frequently Asked Questions.', 'schema-and-structured-data-for-wp' ).'</h1> 
          <br>          
          <h3>1Q) '.esc_html__( 'Is there a Documentation Available?', 'schema-and-structured-data-for-wp' ).'</h3>
	  <p class="saswp_qanda_p">A) '.esc_html__( 'The Documentation is always updated and available at ', 'schema-and-structured-data-for-wp' ).'<a href="http://structured-data-for-wp.com/docs/" target="_blank"><strong>http://structured-data-for-wp.com/docs/</strong></a></p>
          
	  <h3>2Q) '.esc_html__( 'How can I setup the Schema and Structured data for individual pages and posts?', 'schema-and-structured-data-for-wp' ).'</h3>
	  <p class="saswp_qanda_p">A) '.esc_html__( 'Just with one click on the Structured data option, you will find an add new options window in the structured data option panel. Secondly, you need to write the name of the title where, if you would like to set the individual Page/Post then you can set the Page/Post type equal to the Page/Post(Name).', 'schema-and-structured-data-for-wp' ).'</p>

	  <h3>3Q) '.esc_html__( 'How can I check the code whether the structured data is working or not?', 'schema-and-structured-data-for-wp' ).'</h3>
	  <p class="saswp_qanda_p">A) To check the code, the first step we need to take is to copy the code of a page or post then visit the <a href="https://search.google.com/structured-data/testing-tool" target="_blank">Structured data testing tool</a> by clicking on code snippet. Once we paste the snippet we can run the test.</p>

	  <h3> 4Q) '.esc_html__( 'How can I check whether the pages or posts are valid or not?', 'schema-and-structured-data-for-wp' ).'</h3>
	  <p class="saswp_qanda_p"> A) '.esc_html__( 'To check the page and post validation, please visit the', 'schema-and-structured-data-for-wp' ).' <a href="https://search.google.com/structured-data/testing-tool" target="_blank">'.esc_html__( 'Structured data testing tool', 'schema-and-structured-data-for-wp' ).'</a> '.esc_html__( 'and paste the link of your website.', 'schema-and-structured-data-for-wp' ).' '.esc_html__( 'Once we click on run test we can see the result whether the page or post is a valid one or not.', 'schema-and-structured-data-for-wp' ).'</p>

	  <h3>5Q) '.esc_html__( 'Where should users contact if they faced any issues?', 'schema-and-structured-data-for-wp' ).'</h3>
	  <p class="saswp_qanda_p">A) '.esc_html__( 'We always welcome all our users to share their issues and get them fixed just with one click to the link', 'schema-and-structured-data-for-wp' ).' team@ampforwp.com or <a href="https://ampforwp.com/support/" target="_blank">'.esc_html__( 'Support link', 'schema-and-structured-data-for-wp' ).'</a></p><br>';
}

/**
 * Enqueue CSS and JS
 */
function saswp_enqueue_style_js( $hook ) { 
    
        $post_type = '';
        
        $current_screen = get_current_screen(); 
       
        if(isset($current_screen->post_type)){                  
            $post_type = $current_screen->post_type;                
        }    
                
        $data = array(                                    
            'post_id'                      => get_the_ID(),
            'ajax_url'                     => admin_url( 'admin-ajax.php' ),            
            'saswp_security_nonce'         => wp_create_nonce('saswp_ajax_check_nonce'),  
            'new_url_selector'             => esc_url(admin_url()).'post-new.php?post_type=saswp',
            'new_url_href'                 => htmlspecialchars_decode(wp_nonce_url(admin_url('index.php?page=saswp_add_new_data_type&'), '_wpnonce')),            
            'collection_post_add_url'      => esc_url(admin_url()).'post-new.php?post_type=saswp-google-review',
            'collection_post_add_new_url'  => htmlspecialchars_decode(wp_nonce_url(admin_url('admin.php?page=collection'), '_wpnonce')),
            'post_type'                    => $post_type,   
            'page_now'                     => $hook,
            'saswp_settings_url'           => esc_url(admin_url('edit.php?post_type=saswp&page=structured_data_options'))                       
        );
        
        $data = apply_filters('saswp_localize_filter',$data,'saswp_localize_data');
	// Color picker CSS
	// @refer https://make.wordpress.org/core/2012/11/30/new-color-picker-in-wp-3-5/
        wp_enqueue_style( 'wp-color-picker' );	
	// Everything needed for media upload
        wp_enqueue_media();
        
        	
        wp_enqueue_script( 'saswp-timepicker-js', SASWP_PLUGIN_URL . 'admin_section/js/jquery.timepicker.js', false, SASWP_VERSION);        
        wp_enqueue_style( 'saswp-timepicker-css', SASWP_PLUGIN_URL . 'admin_section/css/jquery.timepicker.css', false , SASWP_VERSION );

        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_register_style( 'jquery-ui', SASWP_PLUGIN_URL. 'admin_section/css/jquery-ui.css' );
        wp_enqueue_style( 'jquery-ui' ); 
        
        wp_register_script( 'saswp-main-js', SASWP_PLUGIN_URL . 'admin_section/js/main-script.min.js', array('jquery'), SASWP_VERSION , true );
                        
        wp_localize_script( 'saswp-main-js', 'saswp_localize_data', $data );
        
        wp_enqueue_script( 'saswp-main-js' );
        
        wp_enqueue_style( 'saswp-main-css', SASWP_PLUGIN_URL . 'admin_section/css/main-style.min.css', false , SASWP_VERSION );
}
add_action( 'admin_enqueue_scripts', 'saswp_enqueue_style_js' );