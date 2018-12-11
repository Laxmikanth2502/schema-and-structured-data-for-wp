<?php
//FrontEnd
function saswp_get_all_schema_posts(){
        $post_idArray = array();
        $query = new WP_Query(
          array(
              'post_type' => 'saswp',
              'post_status' => 'publish',
              'posts_per_page' => -1,
          ));
          while ($query->have_posts()) {
              $query->the_post();
              $post_idArray[] = get_the_ID();
          }
          wp_reset_query();
          wp_reset_postdata();
          
    if(count($post_idArray)>0){    
      $returnData = array();
      foreach ($post_idArray as $key => $post_id) 
        {
          $unique_checker ='';
          $resultset = saswp_generate_field_data( $post_id );
          
          if($resultset){
              
          $condition_array = array();    
              
          foreach ($resultset as $result){
              
          $data = array_filter($result);
          $number_of_fields = count($data);
          $checker = 0;
          // Check if we have more then 1 fields.
          if ( $number_of_fields > 0 ) {
            // Check if all the arrays have TRUE setup, then send the value 1, if all the 
            // values are same.
            $checker = count( array_unique($data) );
            // Check and make sure only all TRUE values only passed on, if all values are FALSE,
            // then making sure all FALSE are converting to 0, and returing false.
            // Code will not run.
            $array_is_false =  in_array(false, $result);
            if (  $array_is_false ) {
              $checker = 0;
            }
          }  
          $condition_array[] = $checker;
          }          
          $array_is_true = in_array(true,$condition_array);
          if($array_is_true){
          $unique_checker = 1;    
          }                    
          }else{
          $unique_checker ='notset';    
          }
                    
          if ( $unique_checker === 1 || $unique_checker === true || $unique_checker == 'notset') {
              $conditions = array();
              
              $data_group_array = get_post_meta( $post_id, 'data_group_array', true);                                         
              if(isset($data_group_array['group-0'])){
              $conditions = $data_group_array['group-0']['data_array'];                  
              }
              if(isset($conditions[0])){
              $conditions = $conditions[0];    
              }                          
              $returnData[] = array(
                    'schema_type' => get_post_meta( $post_id, 'schema_type', true),
                    'schema_options' => get_post_meta( $post_id, 'schema_options', true),
                    'conditions'  => $conditions,
                    'post_id'  => $post_id,
                  );
            }
            
      }//foreach closed post_idArray
      return $returnData;      
  }//iF Closed post_idArray
   return false;
}

function saswp_generate_field_data( $post_id ){
      $data_group_array = get_post_meta( $post_id, 'data_group_array', true);  
      $output = array();
      if($data_group_array){          
      foreach ($data_group_array as $gropu){
         $output[] = array_map('saswp_comparison_logic_checker', $gropu['data_array']);     
      }   
      
      }         
      return $output;
}

function saswp_comparison_logic_checker($input){
        global $post;
        $type       = $input['key_1'];
        $comparison = $input['key_2'];
        $data       = $input['key_3'];
        $result             = ''; 
       
        // Get all the users registered
        $user               = wp_get_current_user();

        switch ($type) {
          case 'show_globally':   
               $result = true;      
          break;            
        // Basic Controls ------------ 
          // Posts Type
          case 'post_type':   
                $current_post_type  = $post->post_type;            
                  if ( $comparison == 'equal' ) {
                  if ( $current_post_type == $data ) {
                    $result = true;
                  }
              }
              if ( $comparison == 'not_equal') {              
                  if ( $current_post_type != $data ) {
                    $result = true;
                  }
              }            
          break;

      // Logged in User Type
         case 'user_type':            
            if ( $comparison == 'equal') {
                if ( in_array( $data, (array) $user->roles ) ) {
                    $result = true;
                }
            }            
            if ( $comparison == 'not_equal') {
                require_once ABSPATH . 'wp-admin/includes/user.php';
                // Get all the registered user roles
                $roles = get_editable_roles();                
                $all_user_types = array();
                foreach ($roles as $key => $value) {
                  $all_user_types[] = $key;
                }
                // Flip the array so we can remove the user that is selected from the dropdown
                $all_user_types = array_flip( $all_user_types );

                // User Removed
                unset( $all_user_types[$data] );

                // Check and make the result true that user is not found 
                if ( in_array( $data, (array) $all_user_types ) ) {
                    $result = true;
                }
            }
            
           break; 

    // Post Controls  ------------ 
      // Posts
      case 'post': 
            $current_post = $post->ID;
            if ( $comparison == 'equal' ) {
                if ( $current_post == $data ) {
                  $result = true;
                }
            }
            if ( $comparison == 'not_equal') {              
                if ( $current_post != $data ) {
                  $result = true;
                }
            }

        break;

      // Post Category
      case 'post_category':
          $postcat = get_the_category( $post->ID );
          $current_category = $postcat[0]->cat_ID; 

          if ( $comparison == 'equal') {
              if ( $data == $current_category ) {
                  $result = true;
              }
          }
          if ( $comparison == 'not_equal') {
              if ( $data != $current_category ) {
                  $result = true;
              }
          }
        break;
      // Post Format
      case 'post_format':
          $current_post_format = get_post_format( $post->ID );
          if ( $current_post_format === false ) {
              $current_post_format = 'standard';
          }
          if ( $comparison == 'equal') {
              if ( $data == $current_post_format ) {
                  $result = true;
              }
          }
          if ( $comparison == 'not_equal') {
              if ( $data != $current_post_format ) {
                  $result = true;
              }
          }
        break;

    // Page Controls ---------------- 
      // Page
      case 'page': 
        global $redux_builder_amp;
        if(function_exists('ampforwp_is_front_page')){
          if(ampforwp_is_front_page()){
          $current_post = $redux_builder_amp['amp-frontpage-select-option-pages'];    
          } else{
          $current_post = $post->ID;    
          }           
        }else{
          $current_post = $post->ID;
        }
            if ( $comparison == 'equal' ) {
                if ( $current_post == $data ) {
                  $result = true;
                }
            }
            if ( $comparison == 'not_equal') {              
                if ( $current_post != $data ) {
                  $result = true;
                }
            }
        break;

      // Page Template 
      case 'page_template':
        $current_page_template = get_page_template_slug( $post->ID );
            if ( $current_page_template == false ) {
                $current_page_template = 'default';
            }
            if ( $comparison == 'equal' ) {
                if ( $current_page_template == $data ) {
                    $result = true;
                }
            }
            if ( $comparison == 'not_equal') {              
                if ( $current_page_template != $data ) {
                    $result = true;
                }
            }

        break; 

    // Other Controls ---------------
      // Taxonomy Term
      case 'ef_taxonomy':
        // Get all the post registered taxonomies        
        // Get the list of all the taxonomies associated with current post
        $taxonomy_names = get_post_taxonomies( $post->ID );

        $checker    = '';
        $post_terms = '';

          if ( $data != 'all') {
            $post_terms = wp_get_post_terms($post->ID, $data);           

            if ( $comparison == 'equal' ) {
                if ( $post_terms ) {
                    $result = true;
                }
            }

            if ( $comparison == 'not_equal') { 
                $checker =  in_array($data, $taxonomy_names);       
                if ( ! $checker ) {
                    $result = true;
                }
            }
            if($result==true && isset( $input['key_4'] ) && $input['key_4'] !='all'){
              $term_data       = $input['key_4'];
              $terms = wp_get_post_terms( $post->ID ,$data);
              if(count($terms)>0){
                $termChoices = array();
                foreach ($terms as $key => $termvalue) {
                   $termChoices[] = $termvalue->slug;
                 } 
              }
              $result = false;
              if(in_array($term_data, $termChoices)){
                $result = true;
              }
            }//if closed for key_4

          } else {

            if ( $comparison == 'equal' ) {
              if ( $taxonomy_names ) {                
                  $result = true;
              }
            }

            if ( $comparison == 'not_equal') { 
              if ( ! $taxonomy_names ) {                
                  $result = true;
              }
            }

          }
        break;
      
      default:
        $result = false;
        break;
    }

    return $result;
}


  require_once( untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/ajax-selectbox.php' );
//Back End
if(is_admin()){
  add_action( 'init', 'saswp_create_post_type' );
  function saswp_create_post_type() {
    $nonce = wp_create_nonce( 'saswp_install_wizard_nonce' );      
    $not_found_button = '<div><span class="dashicons dashicons-thumbs-up"></span>'.esc_html__("Thank you for using Schema & Structured Data For WP plugin!",'schema-and-structured-data-for-wp').' <a href="'.esc_url(admin_url( 'plugins.php?page=saswp-setup-wizard' ).'&_saswp_nonce='.$nonce).'">'.esc_html__("Start Quick Setup?",'schema-and-structured-data-for-wp').'</a></div>';       
    register_post_type( 'saswp',
      array(
            'labels' => array(
            'name'              => esc_html__( 'Structured Data', 'schema-and-structured-data-for-wp' ),
            'singular_name'     => esc_html__( 'Structured Data', 'schema-and-structured-data-for-wp' ),
            'add_new' 		 => esc_html__( 'Add Schema Type', 'schema-and-structured-data-for-wp' ),
	    'add_new_item'  	=> esc_html__( '', 'schema-and-structured-data-for-wp' ),
            'edit_item'         => esc_html__( 'Edit Schema Type','schema-and-structured-data-for-wp'),           
            'all_items'          => esc_html__( 'Schema Types', 'schema-and-structured-data-for-wp' ),  
            'not_found'             => $not_found_button    
        ),
          'public'                => true,
          'has_archive'           => false,
          'exclude_from_search'   => true,
          'publicly_queryable'    => false,
          'supports'              => array('title'),  
          'menu_position'         => 100
          
      )
    );
  }
  add_action( 'add_meta_boxes', 'saswp_create_meta_box_select' );
  function saswp_create_meta_box_select(){
    // Repeater Comparison Field
    add_meta_box( 'saswp_amp_select', esc_html__( 'Placement','schema-and-structured-data-for-wp' ), 'saswp_select_callback', 'saswp','normal', 'high' );
    
  }


add_action( 'admin_head','saswp_change_add_new_url'); 
function saswp_change_add_new_url() {

    ?>

    <script type="text/javascript">
    jQuery(function($) {
        $('a[href="<?php echo esc_url(admin_url());  ?>post-new.php?post_type=saswp"]').attr( 'href', '<?php echo htmlspecialchars_decode(wp_nonce_url(admin_url('index.php?page=saswp_add_new_data_type&'), '_wpnonce')); ?>');
    });
    </script>
    <?php
} 
 


  function saswp_select_callback($post) {
    
    $data_group_array =  esc_sql ( get_post_meta($post->ID, 'data_group_array', true)  );                 
    $data_group_array = is_array($data_group_array)? array_values($data_group_array): array();      
    if ( empty( $data_group_array ) ) {
               $data_group_array[0] =array(
                   'data_array' => array(
                            array(
                            'key_1' => 'post_type',
                            'key_2' => 'equal',
                            'key_3' => 'none',
                            )
               )               
      );
    }
    //security check
    wp_nonce_field( 'saswp_select_action_nonce', 'saswp_select_name_nonce' );?>

    <?php 
    // Type Select    
      $choices = array(
        esc_html__("Basic",'schema-and-structured-data-for-wp') => array(        
          'post_type'   =>  esc_html__("Post Type",'schema-and-structured-data-for-wp'),
          'show_globally'   =>  esc_html__("Show Globally",'ads-for-wp'),    
          'user_type'   =>  esc_html__("Logged in User Type",'schema-and-structured-data-for-wp'),
        ),
        esc_html__("Post",'schema-and-structured-data-for-wp') => array(
          'post'      =>  esc_html__("Post",'schema-and-structured-data-for-wp'),
          'post_category' =>  esc_html__("Post Category",'schema-and-structured-data-for-wp'),
          'post_format' =>  esc_html__("Post Format",'schema-and-structured-data-for-wp'), 
        ),
        esc_html__("Page",'schema-and-structured-data-for-wp') => array(
          'page'      =>  esc_html__("Page",'schema-and-structured-data-for-wp'), 
          'page_template' =>  esc_html__("Page Template",'schema-and-structured-data-for-wp'),
        ),
        esc_html__("Other",'schema-and-structured-data-for-wp') => array( 
          'ef_taxonomy' =>  esc_html__("Taxonomy Term",'schema-and-structured-data-for-wp'), 
        )
      ); 

      $comparison = array(
        'equal'   =>  esc_html__( 'Equal to', 'schema-and-structured-data-for-wp'), 
        'not_equal' =>  esc_html__( 'Not Equal to (Exclude)', 'schema-and-structured-data-for-wp'),     
      );

      $total_group_fields = count( $data_group_array ); ?>
<div class="saswp-placement-groups">
    
    <?php for ($j=0; $j < $total_group_fields; $j++) {
        $data_array = $data_group_array[$j]['data_array'];
        
        $total_fields = count( $data_array );
        ?>
    <div class="saswp-placement-group" name="data_group_array[<?php echo esc_attr( $j) ?>]" data-id="<?php echo esc_attr($j); ?>">           
     <?php 
     if($j>0){
     echo '<span style="margin-left:10px;font-weight:600">Or</span>';    
     }     
     ?>   
     <table class="widefat saswp-placement-table" style="border:0px;">
        <tbody id="sdwp-repeater-tbody" class="fields-wrapper-1">
        <?php  for ($i=0; $i < $total_fields; $i++) {  
          $selected_val_key_1 = $data_array[$i]['key_1']; 
          $selected_val_key_2 = $data_array[$i]['key_2']; 
          $selected_val_key_3 = $data_array[$i]['key_3'];
          $selected_val_key_4 = '';
          if(isset($data_array[$i]['key_4'])){
            $selected_val_key_4 = $data_array[$i]['key_4'];
          }
          ?>
          <tr class="toclone">
            <td style="width:31%" class="post_types"> 
              <select class="widefat select-post-type <?php echo esc_attr( $i );?>" name="data_group_array[group-<?php echo esc_attr( $j) ?>][data_array][<?php echo esc_attr( $i) ?>][key_1]">    
                <?php 
                foreach ($choices as $choice_key => $choice_value) { ?>         
                  <option disabled class="pt-heading" value="<?php echo esc_attr($choice_key);?>"> <?php echo esc_html__($choice_key,'schema-and-structured-data-for-wp');?> </option>
                  <?php
                  foreach ($choice_value as $sub_key => $sub_value) { ?> 
                    <option class="pt-child" value="<?php echo esc_attr( $sub_key );?>" <?php selected( $selected_val_key_1, $sub_key );?> > <?php echo esc_html__($sub_value,'schema-and-structured-data-for-wp');?> </option>
                    <?php
                  }
                } ?>
              </select>
            </td>
            <td style="width:31%; <?php if (  $selected_val_key_1 =='show_globally' ) { echo 'display:none;'; }  ?>">
              <select class="widefat comparison" name="data_group_array[group-<?php echo esc_attr( $j) ?>][data_array][<?php echo esc_attr( $i )?>][key_2]"> <?php
                foreach ($comparison as $key => $value) { 
                  $selcomp = '';
                  if($key == $selected_val_key_2){
                    $selcomp = 'selected';
                  }
                  ?>
                  <option class="pt-child" value="<?php echo esc_attr( $key );?>" <?php echo esc_attr($selcomp); ?> > <?php echo esc_html__($value,'schema-and-structured-data-for-wp');?> </option>
                  <?php
                } ?>
              </select>
            </td>
            <td style="width:31%; <?php if (  $selected_val_key_1 =='show_globally' ) { echo 'display:none;'; }  ?>">
              <div class="insert-ajax-select">              
                <?php saswp_ajax_select_creator($selected_val_key_1, $selected_val_key_3, $i, $j );
                if($selected_val_key_1 == 'ef_taxonomy'){
                  saswp_create_ajax_select_taxonomy($selected_val_key_3, $selected_val_key_4, $i, $j);
                }
                ?>
                  <div style="display:none;" class="spinner"></div>
              </div>
            </td>

            <td class="widefat structured-clone" style="width:3.5%; <?php if (  $selected_val_key_1 =='show_globally' ) { echo 'display:none;'; }  ?>">
                <span> <button class="saswp-placement-button" type="button"> <?php echo esc_html__('And' ,'schema-and-structured-data-for-wp');?> </button> </span> </td>
            
            <td class="widefat structured-delete" style="width:3.5%; <?php if (  $selected_val_key_1 =='show_globally' ) { echo 'display:none;'; }  ?>">
                <button class="saswp-placement-button" type="button"><span class="dashicons dashicons-trash"></span>  </button></td>         
          </tr>
          <?php 
        } ?>
        </tbody>
      </table>   
    </div>
    <?php } ?>
    
    
    <a style="margin-left: 8px; margin-bottom: 8px;" class="button saswp-placement-or-group saswp-placement-button" href="#">Or</a>
</div>        
    <?php
  }
  add_action( 'admin_enqueue_scripts', 'saswp_style_script_include' );
  function saswp_style_script_include() {
     global $pagenow, $typenow;
    if (is_admin()) {
       wp_register_script( 'structure_admin', plugin_dir_url(__FILE__) . '/js/structure_admin.js', array( 'jquery'), SASWP_VERSION, true );
       $post_type='';
       $current_screen = get_Current_screen(); 
       if(isset($current_screen->post_type)){
       $post_type = $current_screen->post_type;     
       }      
       $saswp_posts = get_posts(
                    array(
                            'post_type' 	 => 'saswp',                                                                                   
                            'posts_per_page' => -1,   
                            'post_status' => 'publish',                            
                    )
                 ); 
       $post_found_status ='';
       if(!$saswp_posts){
        $post_found_status ='not_found';   
       }       
      $data_array = array(
          'ajax_url'    =>  admin_url( 'admin-ajax.php' ), 
          'post_found_status' => $post_found_status,
          'post_type' =>$post_type,                              
      );
       wp_localize_script( 'structure_admin', 'saswp_app_object', $data_array );
       wp_enqueue_script('structure_admin');
      
       wp_enqueue_script( 'saswp-timepicker-js', SASWP_PLUGIN_URL . 'admin_section/js/jquery.timepicker.js', false, SASWP_VERSION);
        //Main Css 
       wp_enqueue_style( 'saswp-timepicker-css', SASWP_PLUGIN_URL . 'admin_section/css/jquery.timepicker.css', false , SASWP_VERSION );
       
       wp_enqueue_script( 'jquery-ui-datepicker' );
       wp_register_style( 'jquery-ui', 'https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css' );
       wp_enqueue_style( 'jquery-ui' );
      
      //Enque select 2 script starts here
       
       wp_enqueue_style('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css' );
       wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array('jquery') );
       
      //Enque select 2 script ends here
       
       
      
    }
  }
  
  // Save PHP Editor
  add_action ( 'save_post' , 'saswp_select_save_data' );
  function saswp_select_save_data ( $post_id ) {           
      if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
       
      // if our nonce isn't there, or we can't verify it, bail
      if( !isset( $_POST['saswp_select_name_nonce'] ) || !wp_verify_nonce( $_POST['saswp_select_name_nonce'], 'saswp_select_action_nonce' ) ) return;
      
      // if our current user can't edit this post, bail
      if( !current_user_can( 'edit_post' ) ) return;  
    $meta_value = get_post_meta( $post_id, null, true );       
    $post_data_group_array = array();  
    $temp_condition_array  = array();
    $show_globally =false;
    if(isset($_POST['data_group_array'])){        
    $post_data_group_array = $_POST['data_group_array'];    
    foreach($post_data_group_array as $groups){        
          foreach($groups['data_array'] as $group ){              
            if(array_search('show_globally', $group))
            {
              $temp_condition_array[0] =  $group;  
              $show_globally = true;              
            }
          }
      }    
      if($show_globally){
      unset($post_data_group_array);
      $post_data_group_array['group-0']['data_array'] = $temp_condition_array;       
      }      
    }                      
    if(isset($_POST['data_group_array'])){
      update_post_meta(
        $post_id, 
        'data_group_array', 
        $post_data_group_array 
      );     
    }
  }

}//CLosed is_admin

// Generate Proper post types for select and to add data.
add_action('wp_loaded', 'saswp_post_type_generator');
 
function saswp_post_type_generator(){

    $post_types = '';
    $post_types = get_post_types( array( 'public' => true ), 'names' );

    // Remove Unsupported Post types
    unset($post_types['attachment'], $post_types['amp_acf']);

    return $post_types;
}

add_action('wp','saswp_custom_breadcrumbs',99);

// Breadcrumbs
function saswp_custom_breadcrumbs() {
    global $sd_data;	
    $variables1_titles = array();   
    $variables2_links = array();   
    // Settings
    $separator          = '&gt;';        
    $home_title         = esc_html__('Homepage', 'schema-and-structured-data-for-wp' );
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
       
    // Get the query & post information
    global $post;       
    // Do not display on the homepage
    if ( !is_front_page() ) {      
        // Build the breadcrums
        // Home page
        $variables1_titles[] = $home_title;
        $variables2_links[] = get_home_url();

        
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() && !is_author() ) {
            $archive_title = post_type_archive_title($prefix, false);
             $variables1_titles[] = $archive_title;


        } else if  ( is_author() ) {
	    		global $author;
	    		
	            $userdata = get_userdata( $author ); 
	            $author_url= get_author_posts_url($userdata->ID);

	            // author name
	            $variables1_titles[]= $userdata->display_name;
	            $variables2_links[]= $author_url;
                    
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
                $variables1_titles[] = $post_type_object->labels->name;
                $variables2_links[] = $post_type_archive;
              
            }
              
            $custom_tax_name = get_queried_object()->name;
              $variables1_titles[] = $custom_tax_name;

        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);              
                $variables1_titles[]= $post_type_object->labels->name;
                $variables2_links[]= $post_type_archive;              
            }
             
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              $category_values = array_values( $category );
              foreach ($category_values as $category_value) {
                  $category_name = get_category($category_value);
                  $cat_name = $category_name->name;
                  $variables1_titles[]=$cat_name;
                  $variables2_links[]=get_category_link( $category_value );
              
              }
               
                // Get last category post is in
                $last_category = end(($category));
                  $category_name = get_category($last_category);
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.esc_html__( $parents, 'schema-and-structured-data-for-wp' ).'</li>';
                    $cat_display .= '<li class="separator"> ' . esc_html__( $separator, 'schema-and-structured-data-for-wp' ) . ' </li>';
                }
                
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );                
                $cat_id         = $taxonomy_terms[0]->term_id;                
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;

            }
              
             if(!empty($cat_id)) {
              $variables1_titles[]= $cat_name;
              $variables2_links[]=$cat_link;

            } else {
                if($post_type == 'post') { 
                     $variables1_titles[]= get_the_title();
                     $variables2_links[] = get_permalink();                     
                }
            }
              
        } else if ( is_category() ) {
                $category = get_the_category();
             
            if(!empty($category)) {
              $category_values = array_values( $category );
              foreach ($category_values as $category_value) {
                  $category_name = get_category($category_value);
                  $cat_name = $category_name->name;
                  $variables1_titles[]=$cat_name;
                  $variables2_links[]=get_category_link( $category_value );
              
              }
          }                          
        } else if ( is_page() ) {
              
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . esc_attr($ancestor) . '"><a class="bread-parent bread-parent-' . esc_attr($ancestor) . '" href="' . esc_url(get_permalink($ancestor)) . '" title="' . esc_attr(get_the_title($ancestor)) . '">' . esc_html__(get_the_title($ancestor), 'schema-and-structured-data-for-wp' ) . '</a></li>';
                    $parents .= '<li class="separator separator-' . esc_attr($ancestor) . '"> ' . esc_html__($separator, 'schema-and-structured-data-for-wp' ) . ' </li>';
                    $variables1_titles[]= get_the_title($ancestor);
                    $variables2_links[]=get_permalink($ancestor);
                }
             
                    $variables1_titles[]= get_the_title();
                    $variables2_links[]=get_permalink();
                   
            } else {                                                  
                   $variables1_titles[]=get_the_title();
                   $variables2_links[]=get_permalink();
            }
              
        } else if ( is_tag() ) {               
            // Tag page               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;            
            $get_term_name  = $terms[0]->name;
            $term_link      = get_term_link($get_term_id );
               
            // Tag name and link

            $variables1_titles[] = $get_term_name;
            $variables2_links[] = $term_link;           
          }         
          $sd_data['titles']= $variables1_titles;
          $sd_data['links']= $variables2_links;   
          
    }
       
}


//Adding extra columns and displaying its data starts here
function saswp_custom_column_set( $column, $post_id ) {
                
            switch ( $column ) {        
                case 'saswp_schema_type' :
                    
                    $schema_type = get_post_meta( $post_id, $key='schema_type', true);
                    echo esc_attr($schema_type);
                    
                    break; 
                case 'saswp_target_location' :
                    $enabled ='';
                    $exclude ='';
                    $data_group_array = get_post_meta( $post_id, $key='data_group_array', true);
                    if($data_group_array){
                    foreach ($data_group_array as $groups){
                        foreach($groups['data_array'] as $group){                           
                           if($group['key_2'] == 'equal'){
                            $enabled .= $group['key_3'].', ';   
                           }else{
                            $exclude .= $group['key_3']. ', ';   
                           }
                        }
                    } 
                    if($enabled){
                    echo '<div><strong>'.esc_html__( 'Enable on: ', 'schema-and-structured-data-for-wp' ).'</strong> '.esc_attr($enabled).'</div>';    
                    }
                    if($exclude){
                    echo '<div><strong>'.esc_html__( 'Exclude from: ', 'schema-and-structured-data-for-wp' ).'</strong>'.esc_attr($exclude).'</div>';   
                    }                    
                    }                    
                    
                                     
                    break;
               
            }
}
add_action( 'manage_saswp_posts_custom_column' , 'saswp_custom_column_set', 10, 2 );

/**
 * Add the custom columns to the Ads post type:
 * @param array $columns
 * @return string
 */

function saswp_custom_columns($columns) {    
    unset($columns['date']);
    $columns['saswp_schema_type'] = '<a>'.esc_html__( 'Type', 'schema-and-structured-data-for-wp' ).'<a>';
    $columns['saswp_target_location'] = '<a>'.esc_html__( 'Target Location', 'schema-and-structured-data-for-wp' ).'<a>';    
    
    return $columns;
}
add_filter( 'manage_saswp_posts_columns', 'saswp_custom_columns' );

//Adding extra columns and displaying its data ends here


   /**
     * This is a ajax handler function for sending email from user admin panel to us. 
     * @return type json string
     */
function saswp_send_query_message(){   
    
        if ( ! isset( $_POST['saswp_security_nonce'] ) ){
           return; 
        }
        if ( !wp_verify_nonce( $_POST['saswp_security_nonce'], 'saswp_ajax_check_nonce' ) ){
           return;  
        }            
        $message    = sanitize_text_field($_POST['message']);       
        $user       = wp_get_current_user();
        $user_data  = $user->data;        
        $user_email = $user_data->user_email;       
        //php mailer variables        
        $sendto = 'team@magazine3.com';
        $subject = "Customer Query";
        $headers = 'From: '. esc_attr($user_email) . "\r\n" .
        'Reply-To: ' . esc_attr($user_email) . "\r\n";
        // Load WP components, no themes.                      
        $sent = wp_mail($sendto, $subject, strip_tags($message), $headers);        
        if($sent){
        echo json_encode(array('status'=>'t'));            
        }else{
        echo json_encode(array('status'=>'f'));            
        }        
           wp_die();           
}

add_action('wp_ajax_saswp_send_query_message', 'saswp_send_query_message');


   /**
     * This is a ajax handler function for sending email from user admin panel to us. 
     * @return type json string
     */
function saswp_import_plugin_data(){                  
    
        if ( ! isset( $_GET['saswp_security_nonce'] ) ){
           return; 
        }
        if ( !wp_verify_nonce( $_GET['saswp_security_nonce'], 'saswp_ajax_check_nonce' ) ){
           return;  
        }    
        $plugin_name   = sanitize_text_field($_GET['plugin_name']);         
        $result = '';
        switch ($plugin_name) {
            case 'schema':
                if ( is_plugin_active('schema/schema.php')) {
                $result = saswp_import_schema_plugin_data();      
                }                
                break;
                
            case 'schema_pro':                
                if ( is_plugin_active('wp-schema-pro/wp-schema-pro.php')) {
                $result = saswp_import_schema_pro_plugin_data();      
                }                
                break;
            case 'wp_seo_schema':                
                if ( is_plugin_active('wp-seo-structured-data-schema/wp-seo-structured-data-schema.php')) {
                $result = saswp_import_wp_seo_schema_plugin_data();      
                }                
                break;    

            default:
                break;
        }                             
        if($result){
        echo json_encode(array('status'=>'t', 'message'=>esc_html__('Data has been imported succeessfully','schema-and-structured-data-for-wp')));            
        }else{
        echo json_encode(array('status'=>'f', 'message'=>esc_html__('Plugin data is not available or it is not activated','schema-and-structured-data-for-wp')));            
        }        
           wp_die();           
}

add_action('wp_ajax_saswp_import_plugin_data', 'saswp_import_plugin_data');


function saswp_feeback_no_thanks(){                         
        $result = update_option( "saswp_activation_date", date("Y-m-d"));        
        if($result){
        echo json_encode(array('status'=>'t'));            
        }else{
        echo json_encode(array('status'=>'f'));            
        }        
        wp_die();           
}

add_action('wp_ajax_saswp_feeback_no_thanks', 'saswp_feeback_no_thanks');

