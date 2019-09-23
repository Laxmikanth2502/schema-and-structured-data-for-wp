<?php       
/**
 * Schema Type Page
 *
 * @author   Magazine3
 * @category Admin
 * @path     view/schema_type
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * List of hooks used in this file
 */
add_action( 'wp_ajax_saswp_get_item_reviewed_fields', 'saswp_get_item_reviewed_fields' ) ;
add_action( 'save_post', 'saswp_schema_type_add_meta_box_save' ) ;
add_action( 'add_meta_boxes', 'saswp_schema_type_add_meta_box' ) ;

/**
 * Function to get review schema type fields as an array
 * @param type $item
 * @param type $post_specific
 * @param type $schema_id
 * @return array
 * @since 1.0.8
 */
function saswp_item_reviewed_fields($item, $post_specific = null, $schema_id = null){

    $post_fix = '';

    if($post_specific == 1 && isset($schema_id)){

        $post_fix = '_'.esc_attr($schema_id);  

    }

    $reviewed_field = array(
                        array(
                                'label'      => 'Name',
                                'id'         => 'saswp_review_schema_name'.$post_fix,
                                'type'       => 'text',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'Name'
                                 )

                        ),
                        array(
                                'label'      => 'Review Body',
                                'id'         => 'saswp_review_schema_description'.$post_fix,
                                'type'       => 'textarea',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'Review Body'
                                 )
                        ),
                        array(
                                'label'      => 'Image',
                                'id'         => 'saswp_review_schema_image'.$post_fix,
                                'type'       => 'media',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'Image'
                                 )
                        ),
                        array(
                                'label'      => 'Author',
                                'id'         => 'saswp_review_schema_author'.$post_fix,
                                'type'       => 'text',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'Author'
                                 )
                        ),
                        array(
                                'label'      => 'Price Range',
                                'id'         => 'saswp_review_schema_price_range'.$post_fix,
                                'type'       => 'text',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => '$$$ or 55$-100$'
                                 )
                        ),
                        array(
                                'label'      => 'Street Address',
                                'id'         => 'saswp_review_schema_street_address'.$post_fix,
                                'type'       => 'text',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'Street Address'
                                 )
                        ),
                        array(
                                'label'      => 'Address Locality',
                                'id'         => 'saswp_review_schema_locality'.$post_fix,
                                'type'       => 'text',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'Address Locality'
                                 )
                        ),
                        array(
                                'label'      => 'Address Region',
                                'id'         => 'saswp_review_schema_region'.$post_fix,
                                'type'       => 'text',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'Address Region'
                                 )
                        ),
                        array(
                                'label'      => 'Postal Code',
                                'id'         => 'saswp_review_schema_postal_code'.$post_fix,
                                'type'       => 'text',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'Postal Code'
                                 )
                        ),
                        array(
                                'label'      => 'Address Country',
                                'id'         => 'saswp_review_schema_country'.$post_fix,
                                'type'       => 'text',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'Country'
                                 )
                        ),
                        array(
                                'label'      => 'Telephone',
                                'id'         => 'saswp_review_schema_telephone'.$post_fix,
                                'type'       => 'text',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => '123456789'
                                 )
                        ),

                    );

    switch ($item) {

                
                case 'Adultentertainment':

                     $reviewed_field; 

                    break;
                case 'Blog':

                   $reviewed_field = array(
                     array(
                                'label'   => 'Name',
                                'id'      => 'saswp_review_schema_name'.$post_fix,
                                'type'    => 'text',
                                'default' => $site_name = get_bloginfo()
                        ),
                     array(
                                'label'   => 'Url',
                                'id'      => 'saswp_review_schema_url'.$post_fix,
                                'type'    => 'text',
                                'default' => get_site_url()
                        )
                   );  

                    break;
                case 'Book':

                    $reviewed_field = array(
                     array(
                                'label'      => 'Name',
                                'id'         => 'saswp_review_schema_name'.$post_fix,
                                'type'       => 'text',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'Name'
                                 )
                        ),
                     array(
                                'label'      => 'Author',
                                'id'         => 'saswp_review_schema_author'.$post_fix,
                                'type'       => 'text',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'Author'
                                 )
                        ),
                    array(
                                'label'      => 'ISBN',
                                'id'         => 'saswp_review_schema_isbn'.$post_fix,
                                'type'       => 'text',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'ISBN'
                                 )
                        ),
                    array(
                                'label'      => 'URL',
                                'id'         => 'saswp_review_schema_author_sameas'.$post_fix,
                                'type'       => 'text',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'URL'
                                 )
                        ),
                    array(
                                'label'      => 'Review Body',
                                'id'         => 'saswp_review_schema_description'.$post_fix,
                                'type'       => 'textarea',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'Review Body'
                                 )
                        )     

                    );  

                    break;                
                case 'Movie':
                   $reviewed_field = array(
                     array(
                                'label'      => 'Name',
                                'id'         => 'saswp_review_schema_name'.$post_fix,
                                'type'       => 'text',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'Name'
                                 )
                        ),
                       array(
                                'label'      => 'Date Created',
                                'id'         => 'saswp_review_schema_date_created'.$post_fix,
                                'type'       => 'text',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => '2017-05-17'
                                 )
                        ),
                       array(
                                'label'       => 'Image',
                                'id'          => 'saswp_review_schema_image'.$post_fix,
                                'type'        => 'media',
                                'default'     => '',
                                'attributes'  => array(
                                        'placeholder' => 'Image'
                                 )
                        ),
                     array(
                                'label'      => 'Director',
                                'id'         => 'saswp_review_schema_director'.$post_fix,
                                'type'       => 'text',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'Director'
                                 )
                        ),                            
                    array(
                                'label'      => 'URL',
                                'id'         => 'saswp_review_schema_itemreviewed_sameas'.$post_fix,
                                'type'       => 'text',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'URL'
                                 )
                        ),
                    array(
                                'label'      => 'Review Body',
                                'id'         => 'saswp_review_schema_description'.$post_fix,
                                'type'       => 'textarea',
                                'default'    => '',
                                'attributes' => array(
                                        'placeholder' => 'Review Body'
                                 )
                        )     

                    );
                    break;                
                case 'Restaurant':
                   $reviewed_field[] = array(
                                        'label'      => 'Serves Cuisine',
                                        'id'         => 'saswp_review_schema_servescuisine'.$post_fix,
                                        'type'       => 'text',
                                        'default'    => '',
                                        'attributes' => array(
                                             'placeholder' => 'Serves Cuisine'
                                     )
                                );
                    $reviewed_field[] = array(
                                        'label'      => 'Menu',
                                        'id'         => 'saswp_review_schema_menu'.$post_fix,
                                        'type'       => 'text',
                                        'default'    => '',
                                        'attributes' => array(
                                             'placeholder' => 'https://example.com/menu'
                                     )
                                );
                    break;                
                case 'WebSite':
                 $reviewed_field = array(
                     array(
                                'label'   => 'Name',
                                'id'      => 'saswp_review_schema_name'.$post_fix,
                                'type'    => 'text',
                                'default' => $site_name = get_bloginfo()
                        ),
                     array(
                                'label'   => 'Url',
                                'id'      => 'saswp_review_schema_url'.$post_fix,
                                'type'    => 'text',
                                'default' => get_site_url()
                        )
                 );
                    break;                        

                default:
                    break;
            }

    return  $reviewed_field;       

}
/**
 * Function to get review schema type html markup
 * @since 1.0.8 
 * @return type html string
 */
function saswp_get_item_reviewed_fields(){

    if ( ! isset( $_GET['saswp_security_nonce'] ) ){
        return; 
    }
    if ( !wp_verify_nonce( $_GET['saswp_security_nonce'], 'saswp_ajax_check_nonce' ) ){
       return;  
    } 

    $post_specific = '';
    $output        = '';
    $item          = sanitize_text_field($_GET['item']);  
    $schema_id     = sanitize_text_field($_GET['schema_id']);
    $post_id       = intval($_GET['post_id']);    

    if(isset($_GET['post_specific'])){
        $post_specific = sanitize_text_field($_GET['post_specific']);  
    }

     $meta_fields = saswp_item_reviewed_fields($item, $post_specific, $schema_id);
     
     if($meta_fields){
            
         foreach ($meta_fields as $meta_field){

          $attributes ='';

          if(isset($meta_field['attributes'])){

                    foreach ($meta_field['attributes'] as $key => $attr ){

                                   $attributes .=''.esc_attr($key).'="'.esc_attr($attr).'"';

                    }
         }


         if($post_specific == 1){

             $meta_value = get_post_meta( $post_id, $meta_field['id'], true );

             if(!$meta_value){

                 $schema_data = get_post_meta( $schema_id, 'saswp_review_schema_details', true ); 

                 $meta_value  = $schema_data[chop($meta_field['id'], '_'.$schema_id)];                          
             }

         }else{

            $schema_data = get_post_meta( $schema_id, 'saswp_review_schema_details', true );                       
            $meta_value  = $schema_data[$meta_field['id']];  

         }




         if ( empty( $meta_value ) ) {

            $meta_value = $meta_field['default'];

        }

         switch ($meta_field['type']) {

             case 'media':

                 $media_value = array();
                 $media_key   = $meta_field['id'].'_detail';                                                                            

                 if($post_specific == 1){

                     $media_value_meta = get_post_meta( $post_id, $media_key, true ); 

                     if(empty($media_value_meta)){

                      $media_key =   chop($meta_field['id'], '_'.$schema_id).'_detail';
                      $media_value_meta = $schema_data[$media_key];   

                     }                            

                 }else{

                     $media_value_meta = $schema_data[$media_key];

                 }

                 if(!empty($media_value_meta)){

                    $media_value = $media_value_meta;  

                 }                         

                 $input = sprintf(
                                        ' <input style="width: 80%%" id="%s" name="%s" type="text" value="%s" readonly>'                                                
                                        . '<input type="hidden" data-id="'.esc_attr($meta_field['id']).'_height" class="upload-height" name="'.esc_attr($meta_field['id']).'_height" id="'.esc_attr($meta_field['id']).'_height" value="'.esc_attr($media_value['height']).'">'
                                        . '<input type="hidden" data-id="'.esc_attr($meta_field['id']).'_width" class="upload-width" name="'.esc_attr($meta_field['id']).'_width" id="'.esc_attr($meta_field['id']).'_width" value="'.esc_attr($media_value['width']).'">'
                                        . '<input type="hidden" data-id="'.esc_attr($meta_field['id']).'_thumbnail" class="upload-thumbnail" name="'.esc_attr($meta_field['id']).'_thumbnail" id="'.esc_attr($meta_field['id']).'_thumbnail" value="'.esc_url($media_value['thumbnail']).'">'
                                        . '<input data-id="media" style="width: 19%%" class="button" id="%s_button" name="%s_button" type="button" value="Upload" />',
                                        esc_attr($meta_field['id']),
                                        esc_attr($meta_field['id']),
                                        esc_url($meta_value),
                                        esc_attr($meta_field['id']),
                                        esc_attr($meta_field['id'])
                                );


                 break;

             case 'textarea':
                 $input = sprintf(
                                        '<textarea %s style="width: 100%%" id="%s" name="%s" rows="5">%s</textarea>',                                                
                                        $attributes,
                                        esc_attr($meta_field['id']),
                                        esc_attr($meta_field['id']),
                                        $meta_value
                                );                                                                
                 break;

             default:

                 $input = sprintf(
                                        '<input %s %s id="%s" name="%s" type="%s" value="%s">',  
                                        $attributes,
                                        $meta_field['type'] !== 'color' ? 'style="width: 100%"' : '',
                                        esc_attr(saswp_remove_warnings($meta_field, 'id', 'saswp_string')),
                                        esc_attr(saswp_remove_warnings($meta_field, 'id', 'saswp_string')),
                                        esc_attr(saswp_remove_warnings($meta_field, 'type', 'saswp_string')),
                                        $meta_value
                                );

                 break;

         } 

         $output .= '<tr class="saswp-review-tr">'
                 .  '<td>'.esc_html__($meta_field['label'], 'schema-and-structured-data-for-wp' ).'</td>'
                 .  '<td>'.$input.'</td>'
                 .  '</tr>';

    }
         
     }
     

    echo $output;

    wp_die();
}
/**
 * Register a schema type metabox
 * @return null
 * @since version 1.0
 * 
 */
function saswp_schema_type_add_meta_box() {

    add_meta_box(
            'schema_type',
            esc_html__( 'Schema Type', 'schema-and-structured-data-for-wp' ),
            'saswp_schema_type_meta_box_callback',
            'saswp',
            'advanced',
            'high'
    );

}
/**
 * Function to get schema type meta 
 * @global type $post
 * @param type $value
 * @return boolean
 * @since version 1.0
 */
function saswp_schema_type_get_meta( $value ) {

    global $post;

    $field = get_post_meta( $post->ID, $value, true );

    if ( ! empty( $field ) ) {
            return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
    } else {
            return false;
    }
}


function saswp_migrate_global_static_data($schema_type){
    
            $meta_list = array();
            $service           = new saswp_output_service();
            $meta_fields = $service->saswp_get_all_schema_type_fields($schema_type);

            foreach($meta_fields as $key => $field){
                $meta_list[$key] = 'manual_text';
            }
            
            return $meta_list;
}


/**
 * Function to generate html markup for schema type metabox
 * @param type $post
 * return null
 * @since version 1.0
 */
function saswp_schema_type_meta_box_callback( $post) {

                    wp_nonce_field( 'saswp_schema_type_nonce', 'saswp_schema_type_nonce' );  

                    $style_business_type = '';
                    $style_business_name = '';         
                    $style_review_name   = ''; 
                    $business_name       = '';
                    $schema_type         = '';
                    $business_type       = '';                
                    $custom_logo_id      = '';
                    $speakable           = '';

                    $business_details    = array();
                    $logo                = array();
                    $service_details     = array();
                    $review_details      = array();        
                    $event_details       = array();
                
                    if($post){
            
                        $schema_options    = get_post_meta($post->ID, 'schema_options', true);            
                        $meta_list         = get_post_meta($post->ID, 'saswp_meta_list_val', true);                         
                        $fixed_text        = get_post_meta($post->ID, 'saswp_fixed_text', true);                         
                        $cus_field         = get_post_meta($post->ID, 'saswp_custom_meta_field', true); 
                        $schema_type       = get_post_meta($post->ID, 'schema_type', true);     

                        switch ($schema_type) {

                            case 'AudioObject':

                                $audio_details    = get_post_meta($post->ID, 'saswp_audio_schema_details', true);  

                                if($audio_details){

                                    $meta_list = saswp_migrate_global_static_data($schema_type);                        
                                    $fixed_text  = $audio_details;
                                    $schema_options['enable_custom_field'] = 1;
                                                                        
                                    update_post_meta( $post->ID, 'schema_options', $schema_options);                 
                                    update_post_meta( $post->ID, 'saswp_meta_list_val', $meta_list);
                                    update_post_meta( $post->ID, 'saswp_fixed_text', $fixed_text);                                    
                                    
                                }

                                break;

                            case 'SoftwareApplication':

                                $software_details    = get_post_meta($post->ID, 'saswp_software_schema_details', true);    

                                if($software_details){

                                    $meta_list   = saswp_migrate_global_static_data($schema_type);                             
                                    $fixed_text  = $software_details;
                                    $schema_options = array();
                                    $schema_options['enable_custom_field'] = 1;     
                                    
                                    update_post_meta( $post->ID, 'schema_options', $schema_options);                 
                                    update_post_meta( $post->ID, 'saswp_meta_list_val', $meta_list);
                                    update_post_meta( $post->ID, 'saswp_fixed_text', $fixed_text);                                    
                                }

                                break;

                            case 'Service':

                                $service_details  = get_post_meta($post->ID, 'saswp_service_schema_details', true);

                                if($service_details){

                                    $meta_list   = saswp_migrate_global_static_data($schema_type);   

                                    foreach($service_details as $key => $details){

                                        if(is_array($details)){                                
                                            $service_details[$key] = array_key_exists('url', $details)? $details['url'] : '';
                                        }else{
                                            $service_details[$key] = $details;
                                        }                            
                                    }

                                    $fixed_text  = $service_details;
                                    $schema_options = array();
                                    $schema_options['enable_custom_field'] = 1; 
                                    
                                    update_post_meta( $post->ID, 'schema_options', $schema_options);                 
                                    update_post_meta( $post->ID, 'saswp_meta_list_val', $meta_list);
                                    update_post_meta( $post->ID, 'saswp_fixed_text', $fixed_text);                                    
                                }

                                break;    

                            case 'local_business':

                                $business_type    = get_post_meta($post->ID, 'saswp_business_type', true); 
                                $business_name    = get_post_meta($post->ID, 'saswp_business_name', true); 
                                $business_details = get_post_meta($post->ID, 'saswp_local_business_details', true);                                                 
                                $dayoftheweek     = get_post_meta($post->ID, 'saswp_dayofweek', true);

                                if($business_details){

                                    $meta_list   = saswp_migrate_global_static_data($schema_type);   

                                    foreach($business_details as $key => $details){

                                        if(is_array($details)){                                
                                            $business_details[$key] = array_key_exists('url', $details)? $details['url'] : '';
                                        }else{
                                            $business_details[$key] = $details;
                                        }                            
                                    }

                                    $fixed_text  = $business_details;
                                    $schema_options = array();
                                    $schema_options['enable_custom_field'] = 1; 
                                    
                                    update_post_meta( $post->ID, 'schema_options', $schema_options);                 
                                    update_post_meta( $post->ID, 'saswp_meta_list_val', $meta_list);
                                    update_post_meta( $post->ID, 'saswp_fixed_text', $fixed_text);                                    
                                }

                                break;

                            case 'Review':

                                $review_details   = get_post_meta($post->ID, 'saswp_review_schema_details', true);

                                if(count($review_details) > 1){

                                    $meta_list     = saswp_migrate_global_static_data($schema_type); 

                                    foreach($review_details as $key => $details){

                                        if(is_array($details)){                                
                                            $review_details[$key] = array_key_exists('url', $details)? $details['url'] : '';
                                        }else{
                                            $review_details[$key] = $details;
                                        }                            
                                    }

                                    $fixed_text     = $review_details;
                                    $schema_options = array();
                                    $schema_options['enable_custom_field'] = 1; 
                                    
                                    update_post_meta( $post->ID, 'schema_options', $schema_options);                 
                                    update_post_meta( $post->ID, 'saswp_meta_list_val', $meta_list);
                                    update_post_meta( $post->ID, 'saswp_fixed_text', $fixed_text);                                    
                                }

                                break;

                            case 'Event':

                                $event_details   = get_post_meta($post->ID, 'saswp_event_schema_details', true);

                                if($event_details){

                                    $meta_list   = saswp_migrate_global_static_data($schema_type);  

                                    foreach($event_details as $key => $details){

                                        if(is_array($details)){                                    
                                            $event_details[$key] = array_key_exists('url', $details)? $details['url'] : '';
                                        }else{
                                            $event_details[$key] = $details;
                                        }                            
                                    }

                                    $fixed_text  = $event_details;
                                    $schema_options = array();
                                    $schema_options['enable_custom_field'] = 1;
                                    
                                    update_post_meta( $post->ID, 'schema_options', $schema_options);                 
                                    update_post_meta( $post->ID, 'saswp_meta_list_val', $meta_list);
                                    update_post_meta( $post->ID, 'saswp_fixed_text', $fixed_text);                                    

                                }

                                break;

                            default:

                                $speakable       = get_post_meta($post->ID, 'saswp_enable_speakable_schema', true);

                                break;
                        }    

                        $custom_logo_id   = get_theme_mod( 'custom_logo' );

                        if($custom_logo_id){

                            $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );    

                        }

                        if($schema_type != 'local_business'){

                            $style_business_type = 'style="display:none"';
                            $style_business_name = 'style="display:none"';

                         }                            
                        }                                                  
                        $item_reviewed = array(                                                                                    
                             'Book'                  => 'Book',                             
                             'Course'                => 'Course',                             
                             'Event'                 => 'Event',                              
                             'LocalBusiness'         => 'LocalBusiness',    
                             'Movie'                 => 'Movie', 
                             'MusicPlaylist'         => 'Music Playlist',                                      
                             'MusicRecording'        => 'MusicRecording',
                             'MediaObject'           => 'MediaObject',  
                             'Photograph'            => 'Photograph',                                                                  
                             'Product'               => 'Product',
                             'Recipe'                => 'Recipe',                             
                             'SoftwareApplication'   => 'SoftwareApplication',
                             'VideoGame'             => 'VideoGame', 
                        );                                                             

                        $mappings_file = SASWP_DIR_NAME . '/core/array-list/schemas.php';
                
                        if ( file_exists( $mappings_file ) ) {
                            $all_schema_array = include $mappings_file;
                        }
                        
                        $mappings_sub_business = SASWP_DIR_NAME . '/core/array-list/local-sub-business.php';
                
                        if ( file_exists( $mappings_sub_business ) ) {
                            $sub_business_arr = include $mappings_sub_business;
                        }
                                                                                                
                         $all_business_type = array(
                            ''                              => 'Select Business Type (Optional)', 
                            'animalshelter'                 => 'Animal Shelter',
                            'automotivebusiness'            => 'Automotive Business',
                            'childcare'                     => 'ChildCare',
                            'dentist'                       => 'Dentist',
                            'drycleaningorlaundry'          => 'Dry Cleaning Or Laundry',
                            'emergencyservice'              => 'Emergency Service',
                            'employmentagency'              => 'Employment Agency',
                            'entertainmentbusiness'         => 'Entertainment Business',
                            'financialservice'              => 'Financial Service',
                            'foodestablishment'             => 'Food Establishment',
                            'governmentoffice'              => 'Government Office',
                            'healthandbeautybusiness'       => 'Health And Beauty Business',
                            'homeandconstructionbusiness'   => 'Home And Construction Business',
                            'internetcafe'                  => 'Internet Cafe',
                            'legalservice'                  => 'Legal Service',
                            'library'                       => 'Library',
                            'lodgingbusiness'               => 'Lodging Business',
                            'medicalbusiness'               => 'Medical Business',
                            'professionalservice'           => 'Professional Service',
                            'radiostation'                  => 'Radio Station',
                            'realestateagent'               => 'Real Estate Agent',
                            'recyclingcenter'               => 'Recycling Center',
                            'selfstorage'                   => 'Self Storage',
                            'shoppingcenter'                => 'Shopping Center',
                            'sportsactivitylocation'        => 'Sports Activity Location',
                            'store'                         => 'Store',
                            'televisionstation'             => 'Television Station',
                            'touristinformationcenter'      => 'Tourist Information Center',
                            'travelagency'                  => 'Travel Agency',
                         );

                          $all_medical_business_array      = $sub_business_arr['medicalbusiness'];                         
                          $all_automotive_array            = $sub_business_arr['automotivebusiness'];
                          $all_emergency_array             = $sub_business_arr['emergencyservice'];
                          $all_entertainment_array         = $sub_business_arr['entertainmentbusiness'];
                          $all_financial_array             = $sub_business_arr['financialservice'];
                          $all_food_establishment_array    = $sub_business_arr['foodestablishment']; 
                          $all_health_and_beauty_array     = $sub_business_arr['healthandbeautybusiness'];
                          $all_home_and_construction_array = $sub_business_arr['homeandconstructionbusiness'];
                          $all_legal_service_array         = $sub_business_arr['legalservice'];
                          $all_lodging_array               = $sub_business_arr['lodgingbusiness']; 
                          $all_sports_activity_location    = $sub_business_arr['sportsactivitylocation']; 
                          $all_store                       = $sub_business_arr['store'];
        ?>                   
        <!-- Below variable $style_business_type is static -->
        <div class="misc-pub-section">
            
            <div class="saswp-schema-type-section">
               
                <table class="option-table-class saswp-option-table-class">
                <tr>
                   <td><label for="schema_type"><?php echo esc_html__( 'Schema Type' ,'schema-and-structured-data-for-wp');?></label></td>
                   <td><select class="saswp-schame-type-select" id="schema_type" name="schema_type">
                        <?php

                          if(!empty($all_schema_array)){

                              foreach ($all_schema_array as $parent_type => $type) {

                               $option_html = '';   

                               foreach($type as $key => $value){
                                $sel = '';
                                if($schema_type == $key){
                                  $sel = 'selected';
                                }
                                    $option_html.= "<option value='".esc_attr($key)."' ".esc_attr($sel).">".esc_html__($value, 'schema-and-structured-data-for-wp' )."</option>";    

                               }   

                                        echo '<optgroup label="'.esc_attr($parent_type).'">';
                                        //Escaping is done while adding data in this variable
                                        echo $option_html;   
                                        echo '</optgroup>';                                                                                 
                            }

                          }                                                                    
                        ?>
                    </select>                      
                   </td>
                </tr>                                                                                                                                                                         
                <tr class="saswp-business-type-tr" <?php echo $style_business_type; ?>>
                    <td>
                    <?php echo esc_html__('Business Type', 'schema-and-structured-data-for-wp' ); ?>    
                    </td>
                    <td>
                      <select id="saswp_business_type" name="saswp_business_type">
                        <?php


                          foreach ($all_business_type as $key => $value) {
                            $sel = '';
                            if($business_type==$key){
                              $sel = 'selected';
                            }
                            echo "<option value='".esc_attr($key)."' ".esc_attr($sel).">".esc_html__($value, 'schema-and-structured-data-for-wp' )."</option>";
                          }
                        ?>
                    </select>  
                    </td>
                </tr>
                <tr class="saswp-automotivebusiness-tr" <?php if(!array_key_exists($business_name, $all_automotive_array)){ echo 'style="display:none;"';}else{ echo $style_business_name;} ?>>
                    <td><?php echo esc_html__('Sub Business Type', 'schema-and-structured-data-for-wp' ); ?></td>
                    <td>
                        <select id="saswp_automotive" name="saswp_business_name">
                            
                        <?php
                          foreach ($all_automotive_array as $key => $value) {
                            $sel = '';
                            if($business_name==$key){
                              $sel = 'selected';
                            }
                            echo "<option value='".esc_attr($key)."' ".esc_attr($sel).">".esc_html__($value, 'schema-and-structured-data-for-wp' )."</option>";
                          }
                        ?>
                            
                    </select>
                    </td>

                </tr>
                <tr class="saswp-emergencyservice-tr" <?php if(!array_key_exists($business_name, $all_emergency_array)){ echo 'style="display:none;"';}else{ echo $style_business_name;} ?>>
                <td><?php echo esc_html__('Sub Business Type', 'schema-and-structured-data-for-wp' ); ?></td>    
                <td>
                    <select id="saswp_emergency_service" name="saswp_business_name">
                        <?php

                          foreach ($all_emergency_array as $key => $value) {
                            $sel = '';
                            if($business_name==$key){
                              $sel = 'selected';
                            }
                            echo "<option value='".esc_attr($key)."' ".esc_attr($sel).">".esc_html__($value, 'schema-and-structured-data-for-wp' )."</option>";
                          }
                        ?>
                    </select>
                </td>    
                </tr>
                <tr class="saswp-entertainmentbusiness-tr" <?php if(!array_key_exists($business_name, $all_entertainment_array)){ echo 'style="display:none;"';}else{ echo $style_business_name;} ?>>
                <td><?php echo esc_html__('Sub Business Type', 'schema-and-structured-data-for-wp' ); ?></td>    
                <td>
                    <select id="saswp_entertainment" name="saswp_business_name">
                        <?php

                          foreach ($all_entertainment_array as $key => $value) {
                            $sel = '';
                            if($business_name == $key){
                              $sel = 'selected';
                            }
                            echo "<option value='".esc_attr($key)."' ".esc_attr($sel).">".esc_html__($value, 'schema-and-structured-data-for-wp' )."</option>";
                          }
                        ?>
                    </select>
                </td>    
                </tr>
                
                <tr class="saswp-medicalbusiness-tr" <?php if(!array_key_exists($business_name, $all_medical_business_array)){ echo 'style="display:none;"';}else{ echo $style_business_name;} ?>>
                <td><?php echo esc_html__('Sub Business Type', 'schema-and-structured-data-for-wp' ); ?></td>    
                <td>
                    <select id="saswp_medicalbusiness" name="saswp_business_name">
                        <?php

                          foreach ($all_medical_business_array as $key => $value) {
                            $sel = '';
                            if($business_name == $key){
                              $sel = 'selected';
                            }
                            echo "<option value='".esc_attr($key)."' ".esc_attr($sel).">".esc_html__($value, 'schema-and-structured-data-for-wp' )."</option>";
                          }
                        ?>
                    </select>
                </td>    
                </tr>
                
                <tr class="saswp-financialservice-tr" <?php if(!array_key_exists($business_name, $all_financial_array)){ echo 'style="display:none;"';}else{ echo $style_business_name;} ?>>
                <td><?php echo esc_html__('Sub Business Type', 'schema-and-structured-data-for-wp' ); ?></td>    
                <td>
                    <select id="saswp_financial_service" name="saswp_business_name">
                        <?php
                          foreach ($all_financial_array as $key => $value) {
                            $sel = '';
                            if($business_name == $key){
                              $sel = 'selected';
                            }
                            echo "<option value='".esc_attr($key)."' ".esc_attr($sel).">".esc_html__($value, 'schema-and-structured-data-for-wp' )."</option>";
                          }
                        ?>
                    </select>
                </td>    
                </tr>                        
                <tr class="saswp-foodestablishment-tr" <?php if(!array_key_exists($business_name, $all_food_establishment_array)){ echo 'style="display:none;"';}else{ echo $style_business_name;} ?>>
                <td><?php echo esc_html__('Sub Business Type', 'schema-and-structured-data-for-wp' ); ?></td>  
                <td>
                    <select id="saswp_food_establishment" name="saswp_business_name">                        
                        <?php
                          foreach ($all_food_establishment_array as $key => $value) {
                            $sel = '';
                            if($business_name==$key){
                              $sel = 'selected';
                            }
                            echo "<option value='".esc_attr($key)."' ".esc_attr($sel).">".esc_html__($value, 'schema-and-structured-data-for-wp' )."</option>";
                          }
                        ?>
                    </select>
                </td>    
                </tr>
                <tr class="saswp-healthandbeautybusiness-tr" <?php if(!array_key_exists($business_name, $all_health_and_beauty_array)){ echo 'style="display:none;"';}else{ echo $style_business_name;} ?>>
                <td><?php echo esc_html__('Sub Business Type', 'schema-and-structured-data-for-wp' ); ?></td>   
                <td>
                    <select id="saswp_health_and_beauty" name="saswp_business_name">
                        <?php


                          foreach ($all_health_and_beauty_array as $key => $value) {
                            $sel = '';
                            if($business_name==$key){
                              $sel = 'selected';
                            }
                            echo "<option value='".esc_attr($key)."' ".esc_attr($sel).">".esc_html__($value, 'schema-and-structured-data-for-wp' )."</option>";
                          }
                        ?>
                    </select>
                </td>    
                </tr>                        
                <tr class="saswp-homeandconstructionbusiness-tr" <?php if(!array_key_exists($business_name, $all_home_and_construction_array)){ echo 'style="display:none;"';}else{ echo $style_business_name;} ?>>
                <td><?php echo esc_html__('Sub Business Type', 'schema-and-structured-data-for-wp' ); ?></td>
                <td>
                    <select id="saswp_home_and_construction" name="saswp_business_name">
                        <?php

                          foreach ($all_home_and_construction_array as $key => $value) {
                            $sel = '';
                            if($business_name==$key){
                              $sel = 'selected';
                            }
                            echo "<option value='".esc_attr($key)."' ".esc_attr($sel).">".esc_html__($value, 'schema-and-structured-data-for-wp' )."</option>";
                          }
                        ?>
                    </select>
                </td>    
                </tr>
                <tr class="saswp-legalservice-tr" <?php if(!array_key_exists($business_name, $all_legal_service_array)){ echo 'style="display:none;"';}else{ echo $style_business_name;} ?>>
                <td><?php echo esc_html__('Sub Business Type', 'schema-and-structured-data-for-wp' ); ?></td>
                <td>
                    <select id="saswp_legal_service" name="saswp_business_name">
                        <?php

                          foreach ($all_legal_service_array as $key => $value) {
                            $sel = '';
                            if($business_name==$key){
                              $sel = 'selected';
                            }
                            echo "<option value='".esc_attr($key)."' ".esc_attr($sel).">".esc_html__($value, 'schema-and-structured-data-for-wp' )."</option>";
                          }
                        ?>
                    </select>
                </td>    
                </tr>
                <tr class="saswp-lodgingbusiness-tr" <?php if(!array_key_exists($business_name, $all_lodging_array)){ echo 'style="display:none;"';}else{ echo $style_business_name;} ?>>
                <td><?php echo esc_html__('Sub Business Type', 'schema-and-structured-data-for-wp' ); ?></td>
                <td>
                    <select id="saswp_lodging" name="saswp_business_name">
                        <?php

                          foreach ($all_lodging_array as $key => $value) {
                            $sel = '';
                            if($business_name==$key){
                              $sel = 'selected';
                            }
                            echo "<option value='".esc_attr($key)."' ".esc_attr($sel).">".esc_html__($value, 'schema-and-structured-data-for-wp' )."</option>";
                          }
                        ?>
                    </select>
                </td>    
                </tr>
                <tr class="saswp-sportsactivitylocation-tr" <?php if(!array_key_exists($business_name, $all_sports_activity_location)){ echo 'style="display:none;"';}else{ echo $style_business_name;} ?>>
                <td><?php echo esc_html__('Sub Business Type', 'schema-and-structured-data-for-wp' ); ?></td>
                <td>
                    <select id="saswp_sports_activity_location" name="saswp_business_name">
                        <?php

                          foreach ($all_sports_activity_location as $key => $value) {
                            $sel = '';
                            if($business_name==$key){
                              $sel = 'selected';
                            }
                            echo "<option value='".esc_attr($key)."' ".esc_attr($sel).">".esc_html__($value, 'schema-and-structured-data-for-wp' )."</option>";
                          }
                        ?>
                    </select>
                </td>    
                </tr>
                <tr class="saswp-store-tr" <?php if(!array_key_exists($business_name, $all_store)){ echo 'style="display:none;"';}else{ echo $style_business_name;} ?>>
                <td><?php echo esc_html__('Sub Business Type', 'schema-and-structured-data-for-wp' ); ?></td>    
                <td>
                    <select id="saswp_store" name="saswp_business_name">
                        <?php


                          foreach ($all_store as $key => $value) {
                            $sel = '';
                            if($business_name==$key){
                              $sel = 'selected';
                            }
                            echo "<option value='".esc_attr($key)."' ".esc_attr($sel).">".esc_html__($value, 'schema-and-structured-data-for-wp' )."</option>";
                          }
                        ?>
                    </select>
                </td>    
                </tr>                
                
                <!-- Review Schema type starts here -->
                <tr class="saswp-review-text-field-tr" <?php echo $style_review_name; ?>>
                    <td><?php echo esc_html__('Item Reviewed Type', 'schema-and-structured-data-for-wp' ); ?></td>
                    <td>

                        <select data-id="<?php if(is_object($post)){ echo esc_attr($post->ID); }  ?>" name="saswp_review_schema_item_type" class="saswp-item-reivewed-list">
                        <?php                                
                          foreach ($item_reviewed as $key => $value) {
                            $sel = '';
                            if(saswp_remove_warnings($review_details, 'saswp_review_schema_item_type', 'saswp_string')==$key){
                              $sel = 'selected';
                            }
                            echo "<option value='".esc_attr($key)."' ".esc_attr($sel).">".esc_html__($value, 'schema-and-structured-data-for-wp' )."</option>";
                          }
                        ?>
                    </select>                                                                
                    </td>
                </tr>                                                                        
                
                <!-- Review Schema type ends here -->

                <tr>
                   <td>
                       <label for="saswp-speakable"><?php echo esc_html__( 'Speakable ' ,'schema-and-structured-data-for-wp');?></label>
                   </td>
                   <td>
                      <input class="saswp-enable-speakable" type="checkbox" name="saswp_enable_speakable_schema" value="1" <?php if(isset($speakable) && $speakable == 1){echo 'checked'; }else{ echo ''; } ?>>                                                                                                           
                   </td>
                </tr>
            </table>  
                
            </div>
            
            <div class="saswp-schema-modify-section">
                
                <!-- custom fields for schema output starts here -->
                              
                <table class="option-table-class saswp_modify_schema_checkbox">
                        <tr><td><label><?php echo esc_html__( 'Modify Schema Output', 'schema-and-structured-data-for-wp' ) ?></label></td><td><input type="checkbox" id="saswp_enable_custom_field" name="saswp_enable_custom_field" value="1" <?php if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field']==1){echo 'checked'; }?>></td></tr>   
                </table>  
                   <div class="saswp-custom-fields-div" <?php if(!isset($schema_options['enable_custom_field']) || $schema_options['enable_custom_field'] ==0){echo 'style="display:none;"'; }?>>
                       <table class="saswp-custom-fields-table">
                           
                        <?php 
                        
                        if(!empty($meta_list)){                                                                                    
                            $schema_type    = get_post_meta($post->ID, 'schema_type', true);
                            
                            $service     = new saswp_output_service();
                            $meta_fields = $service->saswp_get_all_schema_type_fields($schema_type);
                            
                            foreach($meta_list as $fieldkey => $fieldval){
                                                                                        
                            $option = '';
                            echo '<tr>'; 
                            echo '<td><select class="saswp-custom-fields-name">';
                            
                            foreach ($meta_fields as $key =>$val){
                                
                                if( $fieldkey == $key){
                                    
                                    $option .='<option value="'.esc_attr($key).'" selected>'.esc_attr($val).'</option>';   
                                 
                                }else{
                                    
                                    $option .='<option value="'.esc_attr($key).'">'.esc_attr($val).'</option>';   
                                 
                                }
                                
                            }
                                                        
                            echo $option;                            
                            echo '</select>';
                            echo '</td>';
                                                        
                            $list_html = '';
                            $meta_list_fields = include(SASWP_DIR_NAME . '/core/array-list/meta_list.php');                            
                            
                            $meta_list_arr = $meta_list_fields['text'];
                            
                            if (strpos($fieldkey, 'image') !== false) {
                                  $meta_list_arr = $meta_list_fields['image'];
                            }
                                                                                    
                            foreach($meta_list_arr as $list){
                            
                                $list_html.= '<optgroup label="'.$list['label'].'">';
                                
                                foreach ($list['meta-list'] as $key => $val){
                                    
                                    if( $fieldval == $key){
                                        $list_html.= '<option value="'.esc_attr($key).'" selected>'.esc_html($val).'</option>';    
                                    }else{
                                        $list_html.= '<option value="'.esc_attr($key).'">'.esc_html($val).'</option>';    
                                    }
                                                                        
                                }
                                
                                $list_html.= '</optgroup>';
                                
                            } 
                            echo '<td>';
                            echo '<select class="saswp-custom-meta-list" name="saswp_meta_list_val['.$fieldkey.']">';
                            echo $list_html;
                            echo '</select>';
                            echo '</td>';
                                                        
                            if($fieldval == 'manual_text'){
                                 echo '<td><input type="text" name="saswp_fixed_text['.esc_attr($fieldkey).']" value="'.(isset($fixed_text[$fieldkey]) ? esc_html($fixed_text[$fieldkey]) :'').'"></td>';    
                            }else if($fieldval == 'custom_field'){
                                 echo '<td><select class="saswp-custom-fields-select2" name="saswp_custom_meta_field['.esc_attr($fieldkey).']">';
                                 echo '<option value="'.esc_attr($cus_field[$fieldkey]).'">'.preg_replace( '/^_/', '', esc_html( str_replace( '_', ' ', $cus_field[$fieldkey] ) ) ).'</option>';
                                 echo '</select></td>';
                            }else{
                                echo '<td></td>';
                            }
                                                        
                            echo '<td><a class="button button-default saswp-rmv-modify_row">X</a></td>';
                                                                                   
                            echo '</tr>';
                            
                            }
                            
                        }
                        
                        ?>
                           
                           
                        </table>                    
                   <table class="option-table-class">
                       <tr><td></td><td><a style="float:right;" class="button button-primary saswp-add-custom-fields"><?php echo esc_html__( 'Add Field', 'schema-and-structured-data-for-wp' ); ?></a></td></tr>   
                   </table>
                       
                   </div>                   
                  
                
               <!-- custom fields for schema output ends here -->
                
            </div>
                        
        </div>
            <?php
} 
/**
 * Function to save schema type metabox value
 * @param type $post_id
 * @return type null
 * @since version 1.0
 */
function saswp_schema_type_add_meta_box_save( $post_id ) {     
            
                if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
                
                if ( ! isset( $_POST['saswp_schema_type_nonce'] ) || ! wp_verify_nonce( $_POST['saswp_schema_type_nonce'], 'saswp_schema_type_nonce' ) ) return;
                if ( ! current_user_can( 'edit_post', $post_id ) ) return;
                                
                if ( isset( $_POST['schema_type'] ) ){
                        update_post_meta( $post_id, 'schema_type', esc_attr( $_POST['schema_type'] ) );
                }
                                
                if ( isset( $_POST['saswp_business_type'] ) ){
                        update_post_meta( $post_id, 'saswp_business_type', esc_attr( $_POST['saswp_business_type'] ) );
                }else{
                        update_post_meta( $post_id, 'saswp_business_type', '' );
                }
                
                if ( isset( $_POST['saswp_business_name'] ) ){
                        update_post_meta( $post_id, 'saswp_business_name', esc_attr( $_POST['saswp_business_name'] ) );
                }else{
                       update_post_meta( $post_id, 'saswp_business_name', '' );
                }
                                               
                $review_schema_details     = array();                                                                
                $schema_type               = sanitize_text_field($_POST['schema_type']);   
                                                
                update_post_meta( $post_id, 'saswp_audio_schema_details', array());
                update_post_meta( $post_id, 'saswp_software_schema_details', array());
                update_post_meta( $post_id, 'saswp_service_schema_details', array());
                update_post_meta( $post_id, 'saswp_local_business_details', array());
                update_post_meta( $post_id, 'saswp_dayofweek', array());
                update_post_meta( $post_id, 'saswp_event_schema_details', array());
               
                if($schema_type == 'Review'){
                                                                                                                        
                    $review_schema_details['saswp_review_schema_item_type'] = sanitize_text_field($_POST['saswp_review_schema_item_type']);                                                               
                    update_post_meta( $post_id, 'saswp_review_schema_details', $review_schema_details);
                                                           
                }
                                                                
                if ( isset( $_POST['saswp_enable_speakable_schema'] ) ){
                    
                    update_post_meta( $post_id, 'saswp_enable_speakable_schema', sanitize_text_field($_POST['saswp_enable_speakable_schema']) );                                                                       
                    
                }else{
                    
                   update_post_meta( $post_id, 'saswp_enable_speakable_schema', '0' );                                                                        
                   
                }
                                              
        }           


