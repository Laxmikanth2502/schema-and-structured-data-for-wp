<?php
/**
 * Admin Settings
 * Function saswp_add_menu_links
 *
 */
add_action( 'plugin_action_links_' . plugin_basename( SASWP_DIR_NAME_FILE ), 'saswp_plugin_action_links' );
function saswp_plugin_action_links( $links ) {
        $nonce = wp_create_nonce( 'saswp_install_wizard_nonce' );  
	$links[] = '<a href="' . esc_url( admin_url( 'edit.php?post_type=saswp&page=structured_data_options' ) ) . '">' . esc_html__( 'Settings', 'schema-and-structured-data-for-wp' ) . '</a>';
	$links[] = '<a href="'.  esc_url(admin_url( 'plugins.php?page=saswp-setup-wizard' ).'&_saswp_nonce='.$nonce).'">' . esc_html__( 'Start setup wizard &raquo;', 'schema-and-structured-data-for-wp' ) . '</a>';
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
        $is_amp =false;
        if ( is_plugin_active('accelerated-mobile-pages/accelerated-moblie-pages.php') || is_plugin_active('amp/amp.php') ) {
	$is_amp = true;			
        }   
       
        $tab = saswp_get_tab('general', array('general','knowledge','schema', 'tools', 'amp','review','compatibility','support'));            
	
	?>
<div class="saswp-settings-container">
	<div class="wrap saswp-settings-form saswp-settings-first-div">	
		<h1 class="wp-heading-inline"> <?php echo esc_html__( 'Schema & Structured Data For WP', 'schema-and-structured-data-for-wp' ); ?> <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=saswp' ) ); ?>" class="page-title-action"><?php echo esc_html__( 'Schema Types', 'schema-and-structured-data-for-wp' ); ?></a></h1><br>		
                <div>
		<h2 class="nav-tab-wrapper saswp-tabs">
			<?php			

			echo '<a href="' . esc_url(saswp_admin_link('general')) . '" class="nav-tab ' . esc_attr( $tab == 'general' ? 'nav-tab-active' : '') . '"><span class=""></span> ' . esc_html__('General','schema-and-structured-data-for-wp') . '</a>';

			echo '<a href="' . esc_url(saswp_admin_link('knowledge')) . '" class="nav-tab ' . esc_attr( $tab == 'knowledge' ? 'nav-tab-active' : '') . '"><span class=""></span> ' . esc_html__('Knowledge Graph','schema-and-structured-data-for-wp') . '</a>';
                                                
                        echo '<a href="' . esc_url(saswp_admin_link('amp')) . '" class="nav-tab ' . esc_attr( $tab == 'amp' ? 'nav-tab-active' : '') . '"><span class=""></span> ' . esc_html__('AMP','schema-and-structured-data-for-wp') . '</a>';    
                        
                        echo '<a href="' . esc_url(saswp_admin_link('tools')) . '" class="nav-tab ' . esc_attr( $tab == 'tools' ? 'nav-tab-active' : '') . '"><span class=""></span> ' . esc_html__('Tools','schema-and-structured-data-for-wp') . '</a>';
                         
			echo '<a href="' . esc_url(saswp_admin_link('schema')) . '" class="nav-tab ' . esc_attr( $tab == 'schema' ? 'nav-tab-active' : '') . '"><span class=""></span> ' . esc_html__('Misc','schema-and-structured-data-for-wp') . '</a>';
                                                                                                                                                                                              
                        echo '<a href="' . esc_url(saswp_admin_link('review')) . '" class="nav-tab ' . esc_attr( $tab == 'review' ? 'nav-tab-active' : '') . '"><span class=""></span> ' . esc_html__('Review','schema-and-structured-data-for-wp') . '</a>';
                        
                        echo '<a href="' . esc_url(saswp_admin_link('compatibility')) . '" class="nav-tab ' . esc_attr( $tab == 'compatibility' ? 'nav-tab-active' : '') . '"><span class=""></span> ' . esc_html__('Compatibility','schema-and-structured-data-for-wp') . '</a>';
                        
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
				// general Application Settings
				do_settings_sections( 'saswp_general_section' );	// Page slug
			echo "</div>";

			echo "<div class='saswp-knowledge' ".( $tab != 'knowledge' ? 'style="display:none;"' : '').">";
				// knowledge Application Settings
				do_settings_sections( 'saswp_knowledge_section' );	// Page slug
			echo "</div>";
			echo "<div class='saswp-schema' ".( $tab != 'schema' ? 'style="display:none;"' : '').">";				
				do_settings_sections( 'saswp_schema_section' );	// Page slug
			echo "</div>";
                                                
                        echo "<div class='saswp-amp' ".( $tab != 'amp' ? 'style="display:none;"' : '').">";				
				do_settings_sections( 'saswp_amp_section' );	// Page slug
			echo "</div>";
                        
                        echo "<div class='saswp-tools' ".( $tab != 'tools' ? 'style="display:none;"' : '').">";
			     // Status
			        do_settings_sections( 'saswp_tools_section' );	// Page slug
			echo "</div>";
                        
                        echo "<div class='saswp-review' ".( $tab != 'review' ? 'style="display:none;"' : '').">";
			     // Status
			        do_settings_sections( 'saswp_review_section' );	// Page slug
			echo "</div>";
                        
                        echo "<div class='saswp-compatibility' ".( $tab != 'compatibility' ? 'style="display:none;"' : '').">";
			     // Status
			        do_settings_sections( 'saswp_compatibility_section' );	// Page slug
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
            <li><a target="_blanl" href="https://wordpress.org/support/plugin/schema-and-structured-data-for-wp/reviews/#new-post"><?php echo esc_html__( 'I would like to review this plugin', 'schema-and-structured-data-for-wp' ); ?></a></li>    
            <li><a target="_blanl" href="http://structured-data-for-wp.com/contact-us/"><?php echo esc_html__( 'I have ideas to improve this plugin', 'schema-and-structured-data-for-wp' ); ?></a></li>
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
                
                add_settings_section('saswp_knowledge_section', __return_false(), '__return_false', 'saswp_knowledge_section');
	
		add_settings_field(
			'knowledge_settings',								// ID
			'',		// Title
			'saswp_knowledge_page_callback',								// CB
			'saswp_knowledge_section',						// Page slug
			'saswp_knowledge_section'						// Settings Section ID
		);
                add_settings_section('saswp_schema_section', __return_false(), '__return_false', 'saswp_schema_section');
	
		add_settings_field(
			'saswp_schema_settings',								// ID
			'',		// Title
			'saswp_schema_page_callback',								// CB
			'saswp_schema_section',						// Page slug
			'saswp_schema_section'						// Settings Section ID
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
                                                     
                 
}

function saswp_custom_upload_mimes($mimes = array()) {
	
	$mimes['json'] = "application/json";

	return $mimes;
}

add_action('upload_mimes', 'saswp_custom_upload_mimes');

function saswp_handle_file_upload($option)
{
  if(!empty($_FILES["saswp_import_backup"]["tmp_name"]))
  {
    $urls = wp_handle_upload($_FILES["saswp_import_backup"], array('test_form' => FALSE));    
    $url = $urls["url"];
    update_option('saswp-file-upload_url',esc_url($url));
  }
  
  return $option;
}


function saswp_schema_page_callback(){
	// Get Settings
	$settings = saswp_defaultSettings(); 
        $field_objs = new saswp_fields_generator();                 
         $meta_fields_default = array(	                                		                             
                array(
			'label' => 'Default Image',
			'id' => 'sd_default_image',
                        'name' => 'sd_data[sd_default_image][url]',
                        'class' => 'saswp-sd_default_image',
			'type' => 'media',
		),
                array(
			'label' => 'Default Post Image Width',
			'id' => 'sd_default_image_width',
                        'name' => 'sd_data[sd_default_image_width]',
                        'class' => 'regular-text',                        
			'type' => 'text',
		),
                array(
			'label' => 'Default Post Image Height',
			'id' => 'sd_default_image_height',
                        'name' => 'sd_data[sd_default_image_height]',
                        'class' => 'regular-text',                        
			'type' => 'text',
		),
                array(
			'label' => 'Default Thumbnail for VideoObject',
			'id' => 'sd_default_video_thumbnail',
                        'name' => 'sd_data[sd_default_video_thumbnail][url]',
                        'class' => 'saswp-sd_default_video_thumbnail',
			'type' => 'media',
		),                                                   
	);
          echo '<h2>'.esc_html__('Default Values','schema-and-structured-data-for-wp').'</h2>';
         echo '<div class="saswp-schema-type-fields">';
         $field_objs->saswp_field_generator($meta_fields_default, $settings);
         echo '</div>';
        ?>     
        
	<?php
}

function saswp_amp_page_callback(){
        $settings = saswp_defaultSettings();         
        $field_objs = new saswp_fields_generator();
        
        $non_amp_enable_field = array(
			'label' => 'Structured Data for AMP',
			'id' => 'saswp-for-amp-checkbox',                        
                        'name' => 'saswp-for-amp-checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox',
                        'hidden' => array(
                             'id' => 'saswp-for-amp',
                             'name' => 'sd_data[saswp-for-amp]',                             
                        )
		) ;                                        
        
        if ( !is_plugin_active('accelerated-mobile-pages/accelerated-moblie-pages.php') || is_plugin_active('amp/amp.php') ) {
            
             $non_amp_enable_field['attributes'] = array(
                 'disabled' => 'disabled'
             );
             $non_amp_enable_field['note'] = esc_html__('AMP Plugin is not activated','schema-and-structured-data-for-wp');
             $settings['saswp-for-amp'] = 0;	
        }
                
        $meta_fields = array(
            $non_amp_enable_field,
		 array(
			'label' => 'Structured Data for Non AMP',
			'id' => 'saswp-for-wordpress-checkbox',
                        'name' => 'saswp-for-wordpress-checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox',
                        'note'  => '',
                        'hidden' => array(
                             'id' => 'saswp-for-wordpress',
                             'name' => 'sd_data[saswp-for-wordpress]',                             
                        )
		)                                         
	);
        echo '<h2>'.esc_html__('Set Up','schema-and-structured-data-for-wp').'</h2>';
        $field_objs->saswp_field_generator($meta_fields, $settings);    
}

function saswp_general_page_callback(){	
	$settings = saswp_defaultSettings(); 
        
        $meta_fields_default = array(	
		array(
			'label' => 'Archive',
			'id' => 'saswp_archive_schema_checkbox', 
                        'name' => 'saswp_archive_schema_checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox',                        
                        'hidden' => array(
                             'id' => 'saswp_archive_schema',
                             'name' => 'sd_data[saswp_archive_schema]',                             
                        )
		),
                array(
			'label' => 'BreadCrumbs',
			'id' => 'saswp_breadcrumb_schema_checkbox', 
                        'name' => 'saswp_breadcrumb_schema_checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox',                        
                        'hidden' => array(
                             'id' => 'saswp_breadcrumb_schema',
                             'name' => 'sd_data[saswp_breadcrumb_schema]',                             
                        )
		),
                array(
			'label' => 'Comments',
			'id' => 'saswp_comments_schema_checkbox', 
                        'name' => 'saswp_comments_schema_checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox',                        
                        'hidden' => array(
                             'id' => 'saswp_comments_schema',
                             'name' => 'sd_data[saswp_comments_schema]',                             
                        )
		)
            )
        
        ?>
<div class="saswp-settings-list">
<h2><?php echo esc_html__('Page Schema','schema-and-structured-data-for-wp') ?></h2>
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
			'name' => 'sd_data[sd_about_page]', 
                        'id' => 'sd_about_page',
			'echo' => 0, 
			'show_option_none' => esc_attr( 'Select an item' ), 
			'option_none_value' => '', 
			'selected' =>  isset($settings['sd_about_page']) ? $settings['sd_about_page'] : '',
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
			'name' => 'sd_data[sd_contact_page]', 
                        'id' => 'sd_contact_page-select',
			'echo' => 0, 
			'show_option_none' => esc_attr( 'Select an item' ), 
			'option_none_value' => '', 
			'selected' =>  isset($settings['sd_contact_page']) ? $settings['sd_contact_page'] : '',
		)); ?>
	     		 </label>       
       	 		</div>
        	 </div>
   			 </li>
			</ul>
		</div>                                                                                                                                
	<?php
        $field_objs = new saswp_fields_generator(); 
        echo '<div class="saswp-archive-div">';
        $field_objs->saswp_field_generator($meta_fields_default, $settings);
        echo '</div>';
}
function saswp_knowledge_page_callback(){	
	$settings = saswp_defaultSettings();            
        $field_objs = new saswp_fields_generator();
        $meta_fields = array(	                
                array(
			'label' => 'Data Type',
			'id' => 'saswp_kb_type',
                        'name' => 'sd_data[saswp_kb_type]',
			'type' => 'select',
			'options' => array(
                                ''=>'Select an item',
				'Organization'=>'Organization',
				'Person'=>'Person',
			)
                    ),
		
                array(
			'label' => 'Name',
			'id' => 'sd_name',
                        'name' => 'sd_data[sd_name]',
                        'class' => 'regular-text',                        
			'type' => 'text',
		),
                               
                array(
			'label' => 'Url',
			'id' => 'sd_url',
                        'name' => 'sd_data[sd_url]',
                        'class' => 'regular-text',                        
			'type' => 'text',
		),
                array(
			'label' => 'Logo',
			'id' => 'sd_logo',
                        'name' => 'sd_data[sd_logo][url]',
                        'class' => 'saswp-icon upload large-text',
			'type' => 'media',                        
		),
                array(
			'label' => 'Contact details',
			'id' => 'saswp_kb_contact_1_checkbox', 
                        'name' => 'saswp_kb_contact_1_checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox',                        
                        'hidden' => array(
                            'id' => 'saswp_kb_contact_1',                            
                            'name' => 'sd_data[saswp_kb_contact_1]'
                        )
		),
                array(
			'label' => 'Telephone Number',
			'id' => 'saswp_kb_telephone',
                        'name' => 'sd_data[saswp_kb_telephone]',
                        'class' => 'regular-text',                        
			'type' => 'text',
		),
                array(
			'label' => 'Contact Type',
			'id' => 'saswp_contact_type',
                        'name' => 'sd_data[saswp_contact_type]',
                        'class' => '',
			'type' => 'select',
			'options' => array(
                                ''=>'Select an item',
				'customer support'=>'Customer Support',
				'technical support'=>'Technical Support',
                                'billing support'=>'Billing Support',
                                'bill payment'=>'Bill payment',
                                'sales'=>'Sales',
                                'reservations'=>'Reservations',
                                'credit card support'=>'Credit Card Support',
                                'emergency'=>'Emergency',
                                'baggage tracking'=>'Baggage Tracking',
                                'roadside assistance'=>'Roadside Assistance',
                                'package tracking'=>'Package Tracking',
			)
                   ),  
                   array(
			'label' => 'Name',
			'id' => 'sd-person-name',
                        'name' => 'sd_data[sd-person-name]',
                        'class' => 'regular-text',                        
			'type' => 'text',
		    ),
                    array(
			'label' => 'Job Title',
			'id' => 'sd-person-job-title',
                        'name' => 'sd_data[sd-person-job-title]',
                        'class' => 'regular-text',                        
			'type' => 'text',
		    ),  
                    array(
			'label' => 'Image',
			'id' => 'sd-person-image',
                        'name' => 'sd_data[sd-person-image][url]',
                        'class' => 'upload large-text',
			'type' => 'media',
		   ),
                    array(
			'label' => 'Phone Number',
			'id' => 'sd-person-phone-number',
                        'name' => 'sd_data[sd-person-phone-number]',
                        'class' => 'regular-text',                        
			'type' => 'text',
		    ),
                     array(
			'label' => 'URL',
			'id' => 'sd-person-url',
                        'name' => 'sd_data[sd-person-url]',
                        'class' => 'regular-text',                        
			'type' => 'text',
		    ),
                
	);
        echo '<h2>'.esc_html__('Knowledge Base','schema-and-structured-data-for-wp').'</h2>';
        echo '<div class="saswp-knowledge-base">';
        $field_objs->saswp_field_generator($meta_fields, $settings);
        echo '</div>';
        
        //social
        echo '<h2>'.esc_html__( 'Social Fields', 'schema-and-structured-data-for-wp' ).'</h2>';
        $social_meta_fields = array(	
                array(
			'label' => 'Facebook',
			'id' => 'saswp-facebook-enable-checkbox', 
                        'name' => 'saswp-facebook-enable-checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox', 
                        'hidden' => array(
                             'id' => 'saswp-facebook-enable',
                             'name' => 'sd_data[saswp-facebook-enable]',                             
                        )
		),            
		array(
			'label' => '',
			'id' => 'sd_facebook',
                        'name' => 'sd_data[sd_facebook]',
                        'class' => 'regular-text',                        
			'type' => 'text',
                        'attributes' => array(
                            'placeholder' => 'https://'
                        )
		    ),
                array(
			'label' => 'Twitter',
			'id' => 'saswp-twitter-enable-checkbox', 
                        'name' => 'saswp-twitter-enable-checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox', 
                        'hidden' => array(
                             'id' => 'saswp-twitter-enable',
                             'name' => 'sd_data[saswp-twitter-enable]',                             
                        )
		),    
                array(
			'label' => '',
			'id' => 'sd_twitter',
                        'name' => 'sd_data[sd_twitter]',
                        'class' => 'regular-text',                        
			'type' => 'text',
                        'attributes' => array(
                            'placeholder' => 'https://'
                        )
		    ),
              array(
			'label' => 'Google+',
			'id' => 'saswp-google-plus-enable-checkbox', 
                        'name' => 'saswp-google-plus-enable-checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox', 
                        'hidden' => array(
                             'id' => 'saswp-google-plus-enable',
                             'name' => 'sd_data[saswp-google-plus-enable]',                             
                        )
		),
                array(
			'label' => '',
			'id' => 'sd_google_plus',
                        'name' => 'sd_data[sd_google_plus]',
                        'class' => 'regular-text',                        
			'type' => 'text',
                        'attributes' => array(
                            'placeholder' => 'https://'
                        )
		    ),
                array(
			'label' => 'Instagram',
			'id' => 'saswp-instagram-enable-checkbox', 
                        'name' => 'saswp-instagram-enable-checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox', 
                        'hidden' => array(
                             'id' => 'saswp-instagram-enable',
                             'name' => 'sd_data[saswp-instagram-enable]',                             
                        )
		),
                array(
			'label' => '',
			'id' => 'sd_instagram',
                        'name' => 'sd_data[sd_instagram]',
                        'class' => 'regular-text',                        
			'type' => 'text',
                        'attributes' => array(
                            'placeholder' => 'https://'
                        )
		    ), 
                array(
			'label' => 'Youtube',
			'id' => 'saswp-youtube-enable-checkbox', 
                        'name' => 'saswp-youtube-enable-checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox', 
                        'hidden' => array(
                             'id' => 'saswp-youtube-enable',
                             'name' => 'sd_data[saswp-youtube-enable]',                             
                        )
		),    
                array(
			'label' => '',
			'id' => 'sd_youtube',
                        'name' => 'sd_data[sd_youtube]',
                        'class' => 'regular-text',                        
			'type' => 'text',
                        'attributes' => array(
                            'placeholder' => 'https://'
                        )
		    ),
               array(
			'label' => 'LinkedIn',
			'id' => 'saswp-linkedin-enable-checkbox', 
                        'name' => 'saswp-linkedin-enable-checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox', 
                        'hidden' => array(
                             'id' => 'saswp-linkedin-enable',
                             'name' => 'sd_data[saswp-linkedin-enable]',                             
                        )
		),      
               array(
			'label' => '',
			'id' => 'sd_linkedin',
                        'name' => 'sd_data[sd_linkedin]',
                        'class' => 'regular-text',                        
			'type' => 'text',
                        'attributes' => array(
                            'placeholder' => 'https://'
                        )
		    ),
                array(
			'label' => 'Pinterest',
			'id' => 'saswp-pinterest-enable-checkbox', 
                        'name' => 'saswp-pinterest-enable-checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox', 
                        'hidden' => array(
                             'id' => 'saswp-pinterest-enable',
                             'name' => 'sd_data[saswp-pinterest-enable]',                             
                        )
		), 
                array(
			'label' => '',
			'id' => 'sd_pinterest',
                        'name' => 'sd_data[sd_pinterest]',
                        'class' => 'regular-text',                        
			'type' => 'text',
                        'attributes' => array(
                            'placeholder' => 'https://'
                        )
		    ),
                array(
			'label' => 'SoundCloud',
			'id' => 'saswp-soundcloud-enable-checkbox', 
                        'name' => 'saswp-soundcloud-enable-checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox', 
                        'hidden' => array(
                             'id' => 'saswp-soundcloud-enable',
                             'name' => 'sd_data[saswp-soundcloud-enable]',                             
                        )
		),     
                array(
			'label' => '',
			'id' => 'sd_soundcloud',
                        'name' => 'sd_data[sd_soundcloud]',
                        'class' => 'regular-text',                        
			'type' => 'text',
                        'attributes' => array(
                            'placeholder' => 'https://'
                        )
		    ),
             array(
			'label' => 'Tumblr',
			'id' => 'saswp-tumblr-enable-checkbox', 
                        'name' => 'saswp-tumblr-enable-checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox', 
                        'hidden' => array(
                             'id' => 'saswp-tumblr-enable',
                             'name' => 'sd_data[saswp-tumblr-enable]',                             
                        )
		),
                array(
			'label' => '',
			'id' => 'sd_tumblr',
                        'name' => 'sd_data[sd_tumblr]',
                        'class' => 'regular-text',                        
			'type' => 'text',
                        'attributes' => array(
                            'placeholder' => 'https://'
                        )
		    ),
                			
	);
         echo '<div class="saswp-social-fileds">';
        $field_objs->saswp_field_generator($social_meta_fields, $settings);
         echo '</div>';      
        ?>            	     
	<?php
}

function saswp_check_data_imported_from($plugin_post_type_name){
       $cc_args = array(
                        'posts_per_page'   => -1,
                        'post_type'        => 'saswp',
                        'meta_key'         => 'imported_from',
                        'meta_value'         => $plugin_post_type_name,
                    );					
	$imported_from = new WP_Query( $cc_args ); 
        return $imported_from;
}
function saswp_import_callback(){
        $message = '<p>'.esc_html__('This plugin\'s data already has been imported. Do you want to import again?. click on button above button.','schema-and-structured-data-for-wp').'</p>';
        $schema_message = '';
        $schema_pro_message = '';
        $wp_seo_schema_message = '';
        $seo_pressor_message = '';
        $schema_plugin = saswp_check_data_imported_from('schema'); 
        $schema_pro_plugin = saswp_check_data_imported_from('schema_pro');
        $wp_seo_schema_plugin = saswp_check_data_imported_from('wp_seo_schema');
        $seo_pressor = saswp_check_data_imported_from('seo_pressor');
        
        if($seo_pressor->post_count !=0){
         $seo_pressor_message =$message;
        }        
	if($schema_plugin->post_count !=0){
         $schema_message =$message;
        }
        if($schema_pro_plugin->post_count !=0){
         $schema_pro_message =$message;   
        }
        if($wp_seo_schema_plugin->post_count !=0){
         $wp_seo_schema_message =$message;   
        }
        
	 echo '<h2>'.esc_html__('Migration','schema-and-structured-data-for-wp').'</h2>';       	                  
        ?>	
            <ul>
                <li><div class="saswp-tools-field-title"><div class="saswp-tooltip"><span class="saswp-tooltiptext"><?php echo esc_html__('All the settings and data you can import from this plugin when you click start importing','schema-and-structured-data-for-wp') ?></span><strong><?php echo esc_html__('Schema Plugin','schema-and-structured-data-for-wp'); ?></strong></div><button data-id="schema" class="button saswp-import-plugins"><?php echo esc_html__('Start Importing','schema-and-structured-data-for-wp'); ?></button>
                        <p class="saswp-imported-message"></p>
                        <?php echo $schema_message; ?>    
                    </div>
                </li>
                <li><div class="saswp-tools-field-title"><div class="saswp-tooltip"><span class="saswp-tooltiptext"><?php echo esc_html__('All the settings and data you can import from this plugin when you click start importing','schema-and-structured-data-for-wp') ?></span><strong><?php echo esc_html__('Schema Pro','schema-and-structured-data-for-wp'); ?></strong></div><button data-id="schema_pro" class="button saswp-import-plugins"><?php echo esc_html__('Start Importing','schema-and-structured-data-for-wp'); ?></button>
                        <p class="saswp-imported-message"></p>
                        <?php echo $schema_pro_message; ?>    
                    </div>
                </li>
                <li><div class="saswp-tools-field-title"><div class="saswp-tooltip"><span class="saswp-tooltiptext"><?php echo esc_html__('All the settings and data you can import from this plugin when you click start importing','schema-and-structured-data-for-wp') ?></span><strong><?php echo esc_html__('WP SEO Schema','schema-and-structured-data-for-wp'); ?></strong></div><button data-id="wp_seo_schema" class="button saswp-import-plugins"><?php echo esc_html__('Start Importing','schema-and-structured-data-for-wp'); ?></button>
                        <p class="saswp-imported-message"></p>
                        <?php echo $wp_seo_schema_message; ?>    
                    </div>
                </li>
                <li><div class="saswp-tools-field-title"><div class="saswp-tooltip"><span class="saswp-tooltiptext"><?php echo esc_html__('All the settings and data you can import from this plugin when you click start importing','schema-and-structured-data-for-wp') ?></span><strong><?php echo esc_html__('SEO Pressor','schema-and-structured-data-for-wp'); ?></strong></div><button data-id="seo_pressor" class="button saswp-import-plugins"><?php echo esc_html__('Start Importing','schema-and-structured-data-for-wp'); ?></button>
                        <p class="saswp-imported-message"></p>
                        <?php echo $seo_pressor_message; ?>    
                    </div>
                </li>
                
            </ul>                   
	<?php   
        echo '<h2>'.esc_html__('Import / Export','schema-and-structured-data-for-wp').'</h2>'; 
        $url =  admin_url('admin-ajax.php?action=saswp_export_all_settings_and_schema');
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
                        <div class="saswp-tooltip"><strong><?php echo esc_html__('Reset Plugin','schema-and-structured-data-for-wp'); ?></strong></div><a href="#"class="button saswp-reset-data"><?php echo esc_html__('Reset','schema-and-structured-data-for-wp'); ?></a>                         
                        <p>This will reset your settings and schema types</p>
                    </div>
                </li> 
                
            </ul>
<?php
         
}

function saswp_imported_callback(){	        
	$settings = saswp_defaultSettings();          
        ?>		
	<?php        
}

function saswp_review_page_callback(){
        
        $settings = saswp_defaultSettings();         
        $field_objs = new saswp_fields_generator();
        $meta_fields = array(				
                array(
			'label' => 'Review Module',
			'id' => 'saswp-review-module-checkbox',                        
                        'name' => 'saswp-review-module-checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox',
                        'hidden' => array(
                             'id' => 'saswp-review-module',
                             'name' => 'sd_data[saswp-review-module]',                             
                        )
		),  
                
	);        
        $field_objs->saswp_field_generator($meta_fields, $settings);    
       
}
function saswp_compatibility_page_callback(){
        
        $settings = saswp_defaultSettings();  
        $kk_star = array(
			'label' => 'kk Star Ratings',
			'id' => 'saswp-kk-star-raring-checkbox',                        
                        'name' => 'saswp-kk-star-raring-checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox',
                        'hidden' => array(
                             'id' => 'saswp-kk-star-raring',
                             'name' => 'sd_data[saswp-kk-star-raring]',                             
                        )
		);
        $woocommerce = array(
			'label' => 'Woocommerce',
			'id' => 'saswp-woocommerce-checkbox',                        
                        'name' => 'saswp-woocommerce-checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox',
                        'hidden' => array(
                             'id' => 'saswp-woocommerce',
                             'name' => 'sd_data[saswp-woocommerce]',                             
                        )
		);
        $extratheme = array(
			'label' => 'Extra Theme By Elegant',
			'id' => 'saswp-extra-checkbox',                        
                        'name' => 'saswp-extra-checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox',
                        'hidden' => array(
                             'id' => 'saswp-extra',
                             'name' => 'sd_data[saswp-extra]',                             
                        )
		);
        $dwquestiton = array(
			'label' => 'DW Question Answer',
			'id' => 'saswp-dw-question-answer-checkbox',                        
                        'name' => 'saswp-dw-question-answer-checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox',
                        'hidden' => array(
                             'id' => 'saswp-dw-question-answer',
                             'name' => 'sd_data[saswp-dw-question-answer]',                             
                        )
		);
        
        
        if(!is_plugin_active('kk-star-ratings/index.php')){
             $kk_star['attributes'] = array(
                 'disabled' => 'disabled'
             );
             $kk_star['note'] = esc_html__('Plugin is not activated','schema-and-structured-data-for-wp');
             $settings['saswp-kk-star-raring'] = 0;
        }
       
             
        if(!is_plugin_active('woocommerce/woocommerce.php')){
         
             $woocommerce['attributes'] = array(
                 'disabled' => 'disabled'
             );
             $woocommerce['note'] = esc_html__('Plugin is not activated','schema-and-structured-data-for-wp');
             $settings['saswp-woocommerce'] = 0;
            
        }
                         
        if(get_template() != 'Extra'){

             $extratheme['attributes'] = array(
                 'disabled' => 'disabled'
             );
             $extratheme['note'] = esc_html__('Theme is not activated','schema-and-structured-data-for-wp');
             $settings['saswp-extra'] = 0;  
        }
                 
        
         if(!is_plugin_active('dw-question-answer/dw-question-answer.php')){
             
             $dwquestiton['attributes'] = array(
                 'disabled' => 'disabled'
             );
             $dwquestiton['note'] = esc_html__('Plugin is not activated','schema-and-structured-data-for-wp');
             $settings['saswp-dw-question-answer'] = 0; 
         }
                        
        $field_objs = new saswp_fields_generator();
        $meta_fields = array(				
                $kk_star,  
                $woocommerce, 
                $extratheme,
                $dwquestiton, 
                
	);       
        
        $field_objs->saswp_field_generator($meta_fields, $settings);
        
        
        if ( is_plugin_active('flexmls-idx/flexmls_connect.php')) {
         $meta_fields_default = array(	
		array(
			'label' => 'FlexMLS IDX Plugin',
			'id' => 'saswp_compativility_checkbox', 
                        'name' => 'saswp_compativility_checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox',                       
                        'hidden' => array(
                             'id' => 'saswp_compativility',
                             'name' => 'sd_data[saswp_compativility]',                             
                        )
		),
		);   
        }else{
        $settings['saswp_compativility'] =0; 
        $meta_fields_default = array(	
		array(
			'label' => 'FlexMLS IDX',
			'id' => 'saswp_compativility_checkbox', 
                        'name' => 'saswp_compativility_checkbox',
			'type' => 'checkbox',
                        'class' => 'checkbox saswp-checkbox', 
                        'attributes' => array(
                            'disabled' => 'disabled'
                        ),
                        'hidden' => array(
                             'id' => 'saswp_compativility',
                             'name' => 'sd_data[saswp_compativility]',                             
                        )
		),
		);          
        }
         $meta_fields_text = array();
         $meta_fields_text[] = array(
                        'label' => 'Name',
			'id' => 'sd-seller-name',
                        'name' => 'sd_data[sd-seller-name]',
                        'class' => 'regular-text',                        
			'type' => 'text',
        );
         $meta_fields_text[] = array(
                        'label' => 'Addres',
			'id' => 'sd-seller-address',
                        'name' => 'sd_data[sd-seller-address]',
                        'class' => 'regular-text',                        
			'type' => 'text',
        );
         $meta_fields_text[] = array(
                        'label' => 'Telephone',
			'id' => 'sd-seller-telephone',
                        'name' => 'sd_data[sd-seller-telephone]',
                        'class' => 'regular-text',                        
			'type' => 'text',
        );
         $meta_fields_text[] = array(
                        'label' => 'Price Range',
			'id' => 'sd-seller-price-range',
                        'name' => 'sd_data[sd-seller-price-range]',
                        'class' => 'regular-text',                        
			'type' => 'text',
        );
        $meta_fields_text[] = array(
			'label' => 'URL',
			'id' => 'sd-seller-url',
                        'name' => 'sd_data[sd-seller-url]',
                        'class' => 'regular-text',
			'type' => 'text',
		);                                
        $meta_fields_text[] = array(
			'label' => 'Image',
			'id' => 'sd_seller_image',
                        'name' => 'sd_data[sd_seller_image][url]',
                        'class' => 'saswp-sd_seller_image',
			'type' => 'media',
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
            <strong><?php echo esc_html__('If you have any query, please write the query in below box or email us at', 'schema-and-structured-data-for-wp') ?> <a href="mailto:team@magazine3.com">team@magazine3.com</a>. <?php echo esc_html__('We will reply to your email address shortly', 'schema-and-structured-data-for-wp') ?></strong>
       
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
    
   echo '<h1>'.esc_html__( 'Frequently Asked Questions.', 'schema-and-structured-data-for-wp' ).'</h1> 
         <br><br>
	 <h3>1Q) '.esc_html__( 'How can I setup the Schema and Structured data for individual pages and posts?', 'schema-and-structured-data-for-wp' ).'</h3>
	  <p class="saswp_qanda_p">A) '.esc_html__( 'Just with one click on the Structured data option, you will find an add new options window in the structured data option panel. Secondly, you need to write the name of the title where, if you would like to set the individual Page/Post then you can set the Page/Post type equal to the Page/Post(Name).', 'schema-and-structured-data-for-wp' ).'</p>

	  <h3>2Q) '.esc_html__( 'How can I check the code whether the structured data is working or not?', 'schema-and-structured-data-for-wp' ).'</h3>
	   <p class="saswp_qanda_p">A) To check the code, the first step we need to take is to copy the code of a page or post then visit the <a href="https://search.google.com/structured-data/testing-tool" target="_blank">Structured data testing tool</a> by clicking on code snippet. Once we paste the snippet we can run the test.</p>

	<h3> 3Q) '.esc_html__( 'How can I check whether the pages or posts are valid or not?', 'schema-and-structured-data-for-wp' ).'</h3>
	<p class="saswp_qanda_p"> A) '.esc_html__( 'To check the page and post validation, please visit the', 'schema-and-structured-data-for-wp' ).' <a href="https://search.google.com/structured-data/testing-tool" target="_blank">'.esc_html__( 'Structured data testing tool', 'schema-and-structured-data-for-wp' ).'</a> '.esc_html__( 'and paste the link of your website.', 'schema-and-structured-data-for-wp' ).' '.esc_html__( 'Once we click on run test we can see the result whether the page or post is a valid one or not.', 'schema-and-structured-data-for-wp' ).'</p>

	 <h3>4Q) '.esc_html__( 'Where should users contact if they faced any issues?', 'schema-and-structured-data-for-wp' ).'</h3>
	  <p class="saswp_qanda_p">A) '.esc_html__( 'We always welcome all our users to share their issues and get them fixed just with one click to the link', 'schema-and-structured-data-for-wp' ).' team@magazine3.com or <a href="https://ampforwp.com/support/" target="_blank">'.esc_html__( 'Support link', 'schema-and-structured-data-for-wp' ).'</a></p><br>';
}

/**
 * Enqueue CSS and JS
 */
function saswp_enqueue_style_js( $hook ) {    

	// Color picker CSS
	// @refer https://make.wordpress.org/core/2012/11/30/new-color-picker-in-wp-3-5/
        wp_enqueue_style( 'wp-color-picker' );	
	// Everything needed for media upload
        wp_enqueue_media();	
	// Main JS
        
        wp_register_script( 'saswp-main-js', SASWP_PLUGIN_URL . 'admin_section/js/main-script.js', array('jquery'), SASWP_VERSION , true );
        
        $data = array(
            'post_id'                        => get_the_ID(),
            'ajax_url'                  => admin_url( 'admin-ajax.php' ),            
            'saswp_security_nonce'      => wp_create_nonce('saswp_ajax_check_nonce')            
        );
        
        wp_localize_script( 'saswp-main-js', 'saswp_localize_data', $data );
        
        wp_enqueue_script( 'saswp-main-js' );
        //Main Css 
        wp_enqueue_style( 'saswp-main-css', SASWP_PLUGIN_URL . 'admin_section/css/main-style.css', false , SASWP_VERSION );
}
add_action( 'admin_enqueue_scripts', 'saswp_enqueue_style_js' );