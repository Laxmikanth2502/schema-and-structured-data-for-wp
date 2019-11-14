       var saswp_meta_list        = [];
       var saswp_meta_fields      = [];
       var saswp_meta_list_fields = []; 
       var saswp_taxonomy_term    = []; 
       var saswp_collection       = [];       
       var saswp_coll_json        = null; 
       
       function saswp_taxonomy_term_html(taxonomy, field_name){
           
            var html ='';
                html += '<td>';
                html += '<select name="saswp_taxonomy_term['+field_name+']">';
                jQuery.each(taxonomy, function(key, value){
                         html += '<option value="'+key+'">'+value+'</option>';
                }); 
                html += '</select>';   
                html += '</td>';              
                html += '<td><a class="button button-default saswp-rmv-modify_row">X</a></td>';
                          
                return html;
           
       }
       
       function saswp_enable_rating_review(){
           var schema_type = "";                      
           if(jQuery('select#schema_type option:selected').val()){
              schema_type = jQuery('select#schema_type option:selected').val();    
           }       
           if(jQuery(".saswp-tab-links.selected").attr('saswp-schema-type')){
              schema_type = jQuery(".saswp-tab-links.selected").attr('saswp-schema-type');    
           }
          
         if(schema_type){
             jQuery(".saswp-enable-rating-review-"+schema_type.toLowerCase()).change(function(){
                               
            if(jQuery(this).is(':checked')){
            jQuery(this).parent().parent().siblings('.saswp-rating-review-'+schema_type.toLowerCase()).show();            
             }else{
            jQuery(this).parent().parent().siblings('.saswp-rating-review-'+schema_type.toLowerCase()).hide(); 
             }
         
            }).change();   
         }
               
     }
     
       function getParameterByName(name, url) {
            if (!url){
            url = window.location.href;    
            } 
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return "";
            return decodeURIComponent(results[2].replace(/\+/g, " "));
       }
       
       function saswpCustomSelect2(){          
       if((saswp_localize_data.post_type == 'saswp' || saswp_localize_data.page_now =='saswp') && saswp_localize_data.page_now !='saswp_page_structured_data_options'){
           
           jQuery('.saswp-custom-fields-select2').select2({
      ajax: {
                        type: "POST",    
          url: ajaxurl, // AJAX URL is predefined in WordPress admin
          dataType: 'json',
          delay: 250, // delay in ms while typing when to perform a AJAX search
          data: function (params) {
              return {
                                        saswp_security_nonce: saswp_localize_data.saswp_security_nonce,
                q: params.term, // search query
                action: 'saswp_get_custom_meta_fields' // AJAX action for admin-ajax.php
              };
          },
          processResults: function( data ) {
        return {
          results: data
        };
      },
      cache: true
    },
    minimumInputLength: 2 // the minimum of symbols to input before perform a search
  });   
           
       }    
           
       }   

       function saswp_reviews_datepicker(){
        
            jQuery('.saswp-reviews-datepicker-picker').datepicker({
             dateFormat: "yy-mm-dd"            
          });
        }
        
       function saswp_schema_datepicker(){
        
            jQuery('.saswp-datepicker-picker').datepicker({
             dateFormat: "yy-mm-dd",             
          });
          
        }
        
       function saswp_schema_timepicker(){
         jQuery('.saswp-timepicker').timepicker({ 'timeFormat': 'H:i:s'});
        }
        
       function saswp_item_reviewed_call(){

        jQuery(".saswp-item-reviewed").change(function(e){
        e.preventDefault();
        var schema_type =""; 

        if(jQuery('select#schema_type option:selected').val()){
           schema_type = jQuery('select#schema_type option:selected').val();    
        }       
        if(jQuery(".saswp-tab-links.selected").attr('saswp-schema-type')){
           schema_type = jQuery(".saswp-tab-links.selected").attr('saswp-schema-type');    
        }

        if(schema_type === 'Review'){

                    var current = jQuery(this);    
                    var item    = jQuery(this).val();
                    var post_id = saswp_localize_data.post_id;
                    var schema_id = jQuery(current).attr('data-id');  
                    var post_specific = jQuery(current).attr('post-specific');  
                     jQuery.get(ajaxurl, 
                         { action:"saswp_get_item_reviewed_fields",schema_id:schema_id,  post_specific:post_specific ,item:item, post_id:post_id, saswp_security_nonce:saswp_localize_data.saswp_security_nonce},
                          function(response){    
                            
                            jQuery("#saswp_specific_"+schema_id).find(".saswp-table-create-onajax").remove();   
                            var onload_class = jQuery("#saswp_specific_"+schema_id).find(".saswp-table-create-onload");
                            
                            jQuery.each(onload_class, function(key, val){
                                if(key != 0){
                                    jQuery(this).remove();
                                }
                                
                            });
                            jQuery("#saswp_specific_"+schema_id).append(response);
                            saswp_schema_datepicker();
                            saswp_schema_timepicker();

                         });

        }


    }).change();

    }
    
       function saswp_compatibliy_notes(current, id){
        
                var plugin_name =  id.replace('-checkbox','');
                var text = jQuery("#"+plugin_name).next('p').text(); 

                if (current.is(':checked') && text !=='') {              
                      jQuery("#"+plugin_name).next('p').removeClass('saswp_hide');                   
                }else{
                    if(jQuery("#"+plugin_name).next('p').attr('data-id') == 1){
                        jQuery("#"+plugin_name).next('p').text('This feature is only available in pro version');
                    }else{
                        jQuery("#"+plugin_name).next('p').addClass('saswp_hide');
                    }                                                        
                }        
        }

       function saswp_meta_list_html(current_fly, response, fields, f_name, id, tr){
                      
                        var field_name = f_name;
                        if(field_name == null){                            
                            field_name = Object.keys(fields)[0];                            
                        }                        
                        var re_html = '';   
                            re_html += '<select class="saswp-custom-meta-list" name="saswp_meta_list_val['+field_name+']">';
                          jQuery.each(response, function(key,value){ 

                               re_html += '<optgroup label="'+value['label']+'">';   

                               jQuery.each(value['meta-list'], function(key, value){
                                   re_html += '<option value="'+key+'">'+value+'</option>';
                               });                                                                                  
                               re_html += '</optgroup>';

                           });                                     
                           re_html += '</select>';
                                            
                      if(fields){ 
                                                    
                                var schema_type    = jQuery('select#schema_type option:selected').val();
                                var schema_subtype = '';

                                if(schema_type == 'Review'){
                                    schema_subtype = jQuery('select.saswp-item-reivewed-list option:selected').val();
                                }
          
                                 var html = '<tr>';                                                                                                                            
                                     html += '<td>';                                     
                                     html += '<select class="saswp-custom-fields-name">';
                                     
                                     if(schema_type == 'Review'){
                                       html += '<optgroup label="Review">';
                                       html += '<option value="saswp_review_name">Review Name</option>';    
                                       html += '<option value="saswp_review_description">Review Description</option>';                                              
                                       html += '<option value="saswp_review_author">Review Author</option>';
                                       html += '<option value="saswp_review_author_url">Review Author Profile URL</option>';
                                       html += '<option value="saswp_review_publisher">Review Publisher</option>';    
                                       html += '<option value="saswp_review_rating_value">Review Rating Value</option>';
                                       html += '<option value="saswp_review_date_published">Review Published Date</option>';
                                       html += '<option value="saswp_review_url">Review URL</option>';
                                       html += '</optgroup>'; 
                                      
                                     }
                                     
                                     if(schema_type == 'Review'){
                                       html += '<optgroup label="'+schema_subtype+'">';   
                                     }
                                     
                                     jQuery.each(fields, function(key,value){                                         
                                       html += '<option value="'+key+'">'+value+'</option>';                                       
                                     });
                                     
                                     if(schema_type == 'Review'){
                                         html += '</optgroup>'; 
                                     }
                                     
                                    html += '</select>';                                     
                                    html += '</td>';                                                                                                                                                                                                       
                                    html += '<td>';                                                                       
                                    html += re_html;
                                    html += '</td>';  
                                    html += '<td></td><td><a class="button button-default saswp-rmv-modify_row">X</a></td>';
                                    html += '</tr>';
                                    jQuery(".saswp-custom-fields-table").append(html); 
                                    if(current_fly != null){
                                        current_fly.removeClass('updating-message');
                                    }
                                    
                                                                                                                     
                      }else{
                          jQuery(id).html(re_html);     
                          if(current_fly != null){
                                        current_fly.removeClass('updating-message');
                          }
                      }                                                          
           
       } 

       function saswp_get_meta_list(current_fly, type, fields, id, fields_name, tr){                           
                            if (!saswp_meta_list[type]) {
                                
                                jQuery.get(ajaxurl, 
                                    { action:"saswp_get_meta_list", saswp_security_nonce:saswp_localize_data.saswp_security_nonce},
                                     function(response){                                  
                                               saswp_meta_list[type] = response[type];                                                                                                                             
                                               saswp_meta_list_html(current_fly, saswp_meta_list[type], fields, fields_name, id, tr);
                                          
                                    },'json');
                                
                            }else{
                                saswp_meta_list_html(current_fly, saswp_meta_list[type], fields, fields_name, id, tr);
                            }
                                                                                     
       }
             
       function saswp_get_post_specific_schema_fields(current_fly, index, meta_name, div_type, schema_id, fields_type){
                            
                            if (!saswp_meta_fields[fields_type]) {
                                
                                jQuery.get(ajaxurl, 
                                    { action:"saswp_get_schema_dynamic_fields_ajax",meta_name:meta_name, saswp_security_nonce:saswp_localize_data.saswp_security_nonce},
                                     function(response){                                  
                                         saswp_meta_fields[fields_type] = response;                                         
                                         var html = saswp_fields_html_generator(index, schema_id, fields_type, div_type, response);

                                           if(html){
                                               jQuery('.saswp-'+div_type+'-section[data-id="'+schema_id+'"]').append(html);
                                               saswp_schema_datepicker();
                                               saswp_schema_timepicker();
                                               current_fly.removeClass('updating-message');
                                           }

                                    },'json');
                                
                            }else{
                                
                              var html = saswp_fields_html_generator(index, schema_id, fields_type, div_type, saswp_meta_fields[fields_type]);

                               if(html){
                                   jQuery('.saswp-'+div_type+'-section[data-id="'+schema_id+'"]').append(html);
                                   saswp_schema_datepicker();
                                   saswp_schema_timepicker();
                                   current_fly.removeClass('updating-message');
                               }
                                                                
                            }
                            
                             
       }
       
       function saswp_fields_html_generator(index, schema_id, fields_type, div_type, schema_fields){
            
            var html = '';
            
            html += '<div class="saswp-'+div_type+'-table-div saswp-dynamic-properties" data-id="'+index+'">'
                        +  '<a class="saswp-table-close">X</a>'
                        + '<table class="form-table saswp-'+div_type+'-table">' 
                
            jQuery.each(schema_fields, function(eachindex, element){
                                
                var meta_class = "";
                if(element.name == 'saswp_tvseries_season_published_date' || element.name == 'saswp_feed_element_date_created' || element.name == 'saswp_product_reviews_created_date'){
                    meta_class = "saswp-datepicker-picker";    
                }
                
                switch(element.type) {
                    
                    case "number":
                    case "text":
                      
                        html += '<tr>'
                        + '<th>'+element.label+'</th><td><input class="'+meta_class+'" style="width:100%" type="'+element.type+'" id="'+element.name+'_'+index+'_'+schema_id+'" name="'+fields_type+schema_id+'['+index+']['+element.name+']"></td>'
                        + '</tr>';                        
                      
                      break;
                      
                    case "textarea":
                      
                        html += '<tr>'
                        + '<th>'+element.label+'</th><td><textarea style="width: 100%" id="'+element.name+'_'+index+'_'+schema_id+'" name="'+fields_type+schema_id+'['+index+']['+element.name+']" rows="5"></textarea></td>'
                        + '</tr>';                        
                      
                      break;
                     case "select":
                        
                        var options_html = "";                        
                        jQuery.each(element.options, function(opt_index, opt_element){                            
                            options_html += '<option value="'+opt_index+'">'+opt_element+'</option>';
                        });
                        
                         html += '<tr>'
                        + '<th>'+element.label+'</th>'
                        + '<td>'
                        
                        + '<select id="'+element.name+'_'+index+'_'+schema_id+'" name="'+fields_type+schema_id+'['+index+']['+element.name+']">'
                        + options_html
                        + '</select>'
                        
                        + '</td>'
                        + '</tr>';
                         
                     break;
                      
                    case "media":
                        
                        html += '<tr>'
                        + '<th>'+element.label+'</th>'
                        + '<td>'
                        + '<fieldset>'
                        + '<input style="width:80%" type="text" id="'+element.name+'_'+index+'_'+schema_id+'" name="'+element.name+'_'+index+'_'+schema_id+'">'
                        + '<input type="hidden" data-id="'+element.name+'_'+index+'_'+schema_id+'_id" name="'+fields_type+schema_id+'['+index+']['+element.name+'_id]" id="'+element.name+'_'+index+'_'+schema_id+'_id">'
                        + '<input data-id="media" style="width: 19%" class="button" id="'+element.name+'_'+index+'_'+schema_id+'_button" name="'+element.name+'_'+index+'_'+schema_id+'_button" type="button" value="Upload">'
                        + '<div class="saswp_image_div_'+element.name+'_'+index+'_'+schema_id+'">'                                                
                        + '</div>'
                        + '</fieldset>'
                        + '</td>'
                        + '</tr>';
                      
                      break;
                    default:
                      // code block
                  }
                                                                                            
            });                                                             
            html += '</table>'
                    + '</div>';
                     
            return html;
            
        }
        
       function saswp_create_rating_html_by_value(rating_val){
                
                
                var starating = '';
        
                     starating += '<div class="saswp-rvw-str">';

                    for(var j=0; j<5; j++){  

                          if(rating_val >j){

                                var explod = rating_val.split('.');

                                if(explod[1]){

                                    if(j < explod[0]){

                                        starating +='<span class="str-ic"></span>';   

                                    }else{

                                        starating +='<span class="half-str"></span>';   

                                    }                                           
                                }else{

                                    starating +='<span class="str-ic"></span>';    

                                }

                          } else{
                                starating +='<span class="df-clr"></span>';   
                          }                                                                                                                                
                        }
                    starating += '</div>';

                    return starating;
                
                
            }   
       
       function saswpChunkArray(myArray, chunk_size){
                
                    var contentArray = JSON.parse(JSON.stringify(myArray));
                    var results = [];
                    while (contentArray.length) {
                        results.push(contentArray.splice(0, chunk_size));
                    }

                    return results;
            }
            
       function saswpCollectionSlider(){
	
                jQuery(".saswp-collection-slider").each( function(){
		
		var $slider = jQuery(this),
				$itemscontainer = $slider.find(".saswp-slider-items-container");
		
		if ($itemscontainer.find(".saswp-slider-item.active").length == 0){
			$itemscontainer.find(".saswp-slider-item").first().addClass("active");
		}
		
		function setWidth(){
			var totalWidth = 0
			
			jQuery($itemscontainer).find(".saswp-slider-item").each( function(){
				totalWidth += jQuery(this).outerWidth();
			});
			
			$itemscontainer.width(totalWidth);
			
		}
		function setTransform(){
			
                        if(jQuery(".saswp-slider-item.active").length > 0){
                        
                            var $activeItem = $itemscontainer.find(".saswp-slider-item.active"),
                                            activeItemOffset = $activeItem.offset().left,
                                            itemsContainerOffset = $itemscontainer.offset().left,
                                            totalOffset = activeItemOffset - itemsContainerOffset;

                            $itemscontainer.css({"transform": "translate( -"+totalOffset+"px, 0px)"})
                            
                        }
                        						
		}
		function nextSlide(){
			var activeItem = $itemscontainer.find(".saswp-slider-item.active"),
					activeItemIndex = activeItem.index(),
					sliderItemTotal = $itemscontainer.find(".saswp-slider-item").length,
					nextSlide = 0;
			
			if (activeItemIndex + 1 > sliderItemTotal - 1){
				nextSlide = 0;
			}else{
				nextSlide = activeItemIndex + 1
			}
			
			var nextSlideSelect = $itemscontainer.find(".saswp-slider-item").eq(nextSlide),
					itemContainerOffset = $itemscontainer.offset().left,
					totalOffset = nextSlideSelect.offset().left - itemContainerOffset
			
			$itemscontainer.find(".saswp-slider-item.active").removeClass("active");
			nextSlideSelect.addClass("active");
			$slider.find(".saswp-slider-dots").find(".dot").removeClass("active")
			$slider.find(".saswp-slider-dots").find(".dot").eq(nextSlide).addClass("active");
			$itemscontainer.css({"transform": "translate( -"+totalOffset+"px, 0px)"})
			
		}
		function prevSlide(){
			var activeItem = $itemscontainer.find(".saswp-slider-item.active"),
					activeItemIndex = activeItem.index(),
					sliderItemTotal = $itemscontainer.find(".saswp-slider-item").length,
					nextSlide = 0;
			
			if (activeItemIndex - 1 < 0){
				nextSlide = sliderItemTotal - 1;
			}else{
				nextSlide = activeItemIndex - 1;
			}
			
			var nextSlideSelect = $itemscontainer.find(".saswp-slider-item").eq(nextSlide),
					itemContainerOffset = $itemscontainer.offset().left,
					totalOffset = nextSlideSelect.offset().left - itemContainerOffset
			
			$itemscontainer.find(".saswp-slider-item.active").removeClass("active");
			nextSlideSelect.addClass("active");
			$slider.find(".saswp-slider-dots").find(".dot").removeClass("active")
			$slider.find(".saswp-slider-dots").find(".dot").eq(nextSlide).addClass("active");
			$itemscontainer.css({"transform": "translate( -"+totalOffset+"px, 0px)"})
			
		}
		function makeDots(){
			var activeItem = $itemscontainer.find(".saswp-slider-item.active"),
					activeItemIndex = activeItem.index(),
					sliderItemTotal = $itemscontainer.find(".saswp-slider-item").length;
			
			for (i = 0; i < sliderItemTotal; i++){
				$slider.find(".saswp-slider-dots").append("<div class='dot'></div>")
			}
			
			$slider.find(".saswp-slider-dots").find(".dot").eq(activeItemIndex).addClass("active")
			
		}
		
		setWidth();
		setTransform();
		makeDots();
		
		jQuery(window).resize( function(){
					setWidth();
					setTransform();
		});
		
		var nextBtn = $slider.find(".saswp-slider-controls").find(".next-btn"),
				prevBtn = $slider.find(".saswp-slider-controls").find(".prev-btn");
		
		nextBtn.on('click', function(e){
			e.preventDefault();
			nextSlide();
		});
		
		prevBtn.on('click', function(e){
			e.preventDefault();
			prevSlide();
		});
		
		$slider.find(".saswp-slider-dots").find(".dot").on('click', function(e){
			
			var dotIndex = jQuery(this).index(),
			totalOffset = $itemscontainer.find(".saswp-slider-item").eq(dotIndex).offset().left - $itemscontainer.offset().left;
					
			$itemscontainer.find(".saswp-slider-item.active").removeClass("active");
			$itemscontainer.find(".saswp-slider-item").eq(dotIndex).addClass("active");
			$slider.find(".saswp-slider-dots").find(".dot").removeClass("active");
			jQuery(this).addClass("active")
			
			$itemscontainer.css({"transform": "translate( -"+totalOffset+"px, 0px)"})
			
		});
		
	});
	
               }     
            
       function saswp_create_collection_slider(slider, slider_type){
                
                
                var html = '';
                var platform_list = '';
                
                if(saswp_collection){
                    
                    html += '<div class="saswp-collection-slider">';
                    html += '<div class="saswp-slider-items-container">';
                                                                                                                                           
                    for (var key in saswp_collection) {
                                                                                                                       
                        if(saswp_collection[key]){
                              
                         if(slider == 'slider'){
                            
                            jQuery.each(saswp_collection[key], function(index, value){
                                                        
                                html += '<div class="saswp-slider-item">';
                                html += '<div>Slider '+index+'</div>';
                                html += '</div>';
                            
                          });
                            
                         }   
                         
                         if(slider == 'carousel'){
                             
                            var chunkarr = saswpChunkArray(saswp_collection[key], 3);
                            
                            if(chunkarr){
                                                                                                                
                            jQuery.each(chunkarr, function(p_index, p_value){
                                                                
                                html += '<div class="saswp-slider-item">';
                                                                    
                                jQuery.each(p_value, function(index, value){
                                   
                                     html += '<div>Slider '+index+'</div>';
                                                                                               
                                });
                                
                                html += '</div>';   
                                
                            });
                                
                            }
                                                       
                         }
                                                                                 
                            platform_list += '<div class="cancel-btn">';
                            platform_list += '<span>'+jQuery("#saswp-plaftorm-list option[value="+key+"]").text()+'</span>';
                            platform_list += '<a platform-id="'+key+'" class="button button-default saswp-remove-platform">X</a>';
                            platform_list += '</div>';
                            
                        }
                                                                                                
                    }
                    
                    html += '</div>';
                    html += '<div class="saswp-slider-controls">';
                    html += '<a href="#" class="prev-btn">Prev</a>';
                    html += '<a href="#" class="next-btn">Next</a>';
                    html += '</div>';
                    html += '<div class="saswp-slider-dots">';
                    html += '</div>';
                    html += '</div>';
                                        
                }
                
                jQuery(".saswp-collection-preview").html('');    
                jQuery(".saswp-platform-added-list").html('');                
                jQuery(".saswp-platform-added-list").append(platform_list);                 
                jQuery(".saswp-collection-preview").append(html); 
                
                console.log('called');
                saswpCollectionSlider();
                
                                                
            }
            
       function saswp_create_collection_badge(){
                
                var html = '';
                var platform_list = '';
                                
                if(saswp_collection){
                    
                    html += '<div class="saswp-rd3-warp">';
                    html += '<ul>';
                                        
                    for (var key in saswp_collection) {
                          
                        var platform_icon  = '';
                        var review_count   = 0;                        
                        var sum_of_rating  = 0;
                        var average_rating = 1;
                        
                        jQuery.each(saswp_collection[key], function(index, value){
                            platform_icon = value.saswp_review_platform_icon;
                            sum_of_rating += parseFloat(value.saswp_review_rating);
                            review_count++;
                        });  
                        if(sum_of_rating > 0){
                        
                            average_rating = sum_of_rating / review_count;
                            
                        }
                        
                        if(saswp_collection[key]){
                            
                            html += '<li>';                       
                      html += '<a href="#">'; 

                        html += '<div class="saswp-rv-lg-txt">';
                          html += '<span>';
                           html += '<img src="'+platform_icon+'"/>';
                          html += '</span>';
                          html += '<h4>Google';
                          html += '</h4">';
                        html += '</div>'


                      html += '<div class="saswp-rv-rtng">';

                        html += '<div class="saswp-rtng-txt">';
                          html += '<span class="saswp-rt-num">';
                            html += average_rating;
                          html += '</span>';
                          html += '<span class="saswp-stars">';
                           html += saswp_create_rating_html_by_value(average_rating.toString()); 
                          html += '</span>';
                        html += '</div>';

                        html += '<span class="saswp-bsd-rv">';
                        html += 'Based on '+review_count+' Reviews';
                        html += '</span>';

                      html += '</div>';
                      html += '</a>';
                      html += '</li>';                            
                            
                            platform_list += '<div class="cancel-btn">';
                            platform_list += '<span>'+jQuery("#saswp-plaftorm-list option[value="+key+"]").text()+'</span>';
                            platform_list += '<a platform-id="'+key+'" class="button button-default saswp-remove-platform">X</a>';
                            platform_list += '</div>';
                            
                        }
                                                                                                
                    }
                    
                    html += '</ul>';
                    html += '</div>';
                                        
                }
                jQuery(".saswp-collection-preview").html('');    
                jQuery(".saswp-platform-added-list").html('');                
                jQuery(".saswp-platform-added-list").append(platform_list);                 
                jQuery(".saswp-collection-preview").append(html); 
            }
            
       function saswp_create_collection_popup(){
                var html          = '';
                var platform_list = '';
                var html_list     = '';
                
                if(saswp_collection){
                                        
                    for (var key in saswp_collection) {
                        
                        var platform_icon  = '';
                        var review_count   = 0;                        
                        var sum_of_rating  = 0;
                        var average_rating = 1;
                        
                        if(saswp_collection[key]){
                            
                            jQuery.each(saswp_collection[key], function(index, value){
                            
                            platform_icon = value.saswp_review_platform_icon;
                            sum_of_rating += parseFloat(value.saswp_review_rating);
                            review_count++;
                            
                            html_list += '<li>';
                            html_list += '<div class="saswp-rvws-dta">';
                            html_list += '<span class="saswp-svg-img">';
                            html_list += saswp_create_rating_html_by_value(value.saswp_review_rating);
                            html_list += '</span>';
                            html_list += '<span class="saswp-rvw-tx saswp-rvw-nm">'+value.saswp_reviewer_name+'</span>';
                            html_list += '<span class="saswp-rvw-tx">'+value.saswp_review_date+'</span>';
                            html_list += '</div>';
                            
                            html_list += '<div class="saswp-rvws-txt">';
                            html_list += '<h3>'+value.saswp_reviewer_name+'</h3>';
                            html_list += '<p>'+value.saswp_review_text+'</p>';
                            html_list += '</div>';
                            
                            html_list += '</li>';
                                                                                  
                        });
                       
                        if(sum_of_rating > 0){
                        
                            average_rating = sum_of_rating / review_count;
                            
                        }
                            
                            platform_list += '<div class="cancel-btn">';
                            platform_list += '<span>'+jQuery("#saswp-plaftorm-list option[value="+key+"]").text()+'</span>';
                            platform_list += '<a platform-id="'+key+'" class="button button-default saswp-remove-platform">X</a>';
                            platform_list += '</div>';
                            
                        }
                                                                                                
                    }
                    
                    if(review_count > 0){
                        
                        html += '<div id="saswp-sticky-review">';
                        html += '<div class="saswp-open-class saswp-popup-btn">';
                        html += '<div class="saswp-opn-cls-btn">';

                        html += '<div class="saswp-onclick-hide">';
                        html += '<span>';
                        html += saswp_create_rating_html_by_value(average_rating.toString());
                        html += '</span>';
                        html += '<span class="saswp-ttl-rvws">'+average_rating+' from '+review_count+' reviews</span>';                    
                        html += '</div>';

                        html += '<div class="saswp-onclick-show">';
                        html += '<span>Ratings and reviews</span>';                    
                        html += '<span class="saswp-mines"></span>';                    
                        html += '</div>';

                        html += '</div>';
                        html += '<div id="saswp-reviews-cntn">';
                        html += '<div class="saswp-reviews-info">';
                        html += '<ul>';

                        html += '<li class="saswp-ttl-rvw">';
                        html += '<span>';
                        html += saswp_create_rating_html_by_value(average_rating.toString());
                        html += '</span>';
                        html += '<span class="saswp-ttl-rvws">'+average_rating+' from '+review_count+' reviews</span>';                    
                        html += '</li>';                                        
                        html += html_list;
                        html += '</ul>';                    
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                                                
                    }
                                                                                
                }
                jQuery(".saswp-collection-preview").html('');    
                jQuery(".saswp-platform-added-list").html('');                
                jQuery(".saswp-platform-added-list").append(platform_list);                 
                jQuery(".saswp-collection-preview").append(html);
            }            
            
       function saswp_create_collection_fomo(){
                
                var html = '';
                var platform_list = '';
                
                if(saswp_collection){
                                                                                                                                          
                    for (var key in saswp_collection) {
                                                                                                                       
                        if(saswp_collection[key]){
                            
                         jQuery.each(saswp_collection[key], function(index, value){
                             
                            html += '<div id="'+index+'" class="saswp-fomo-wrap">';
                            html += '<div class="saswp-fomo-reviews">';                            
                            html += '<div class="saswp-frv-lg">';
                            html += '<span>';
                            html += '<img height="70" width="70" src="'+value.saswp_review_platform_icon+'"/>';
                            html += '</span>';
                            html += '</div>';                            
                            html += '<div class="saswp-str-rtng">';
                              html += saswp_create_rating_html_by_value(value.saswp_review_rating);
                             html +='<div class="saswp-text-rtng">';
                             html +='<span>'+value.saswp_review_rating+' Star Rating</span> by '+ value.saswp_reviewer_name;
                             html += '<span class="saswp-rt-dt">'+value.saswp_review_date+'</span>';
                             html +='</div>';
                            html += '</div>';                            
                            html += '</div>';
                            html += '</div>';                   
                             
                        });
                            
                            platform_list += '<div class="cancel-btn">';
                            platform_list += '<span>'+jQuery("#saswp-plaftorm-list option[value="+key+"]").text()+'</span>';
                            platform_list += '<a platform-id="'+key+'" class="button button-default saswp-remove-platform">X</a>';
                            platform_list += '</div>';
                            
                        }
                                                                                                
                    }
                                        
                                                           
                }
                jQuery(".saswp-collection-preview").html('');    
                jQuery(".saswp-platform-added-list").html('');                
                jQuery(".saswp-platform-added-list").append(platform_list);                 
                jQuery(".saswp-collection-preview").append(html);  
                
                saswp_fomo_slide();
                
            }        
            
       function saswp_fomo_slide(){
                
            var elem = jQuery('.saswp-collection-preview .saswp-fomo-wrap');
            var l = elem.length;
            var i = 0;
                        
            function saswp_fomo_loop() {
                
                elem.eq(i % l).fadeIn(3000, function() {
                    elem.eq(i % l).fadeOut(3000, saswp_fomo_loop);
                    i++;
                });
            }

            saswp_fomo_loop();
            
            } 
                        
       function saswp_collection_sorting(sorting_type){
                
                switch(sorting_type){
                    
                    case 'lowest':
                        
                        for (var key in saswp_collection) {
                            
                             var current_coll = saswp_collection[key];
                            
                            if(current_coll){
                            
                                var done = false;
                                while (!done) {
                                  done = true;
                                  for (var i = 1; i < current_coll.length; i += 1) {
                                    if (current_coll[i - 1]['saswp_review_rating'] > current_coll[i]['saswp_review_rating']) {
                                      done = false;
                                      var tmp = current_coll[i - 1];
                                      current_coll[i - 1] = current_coll[i];
                                      current_coll[i] = tmp;
                                    }
                                  }
                                }
                             saswp_collection[key] =  current_coll;  
                                
                            }
                                                                                    
                       }
                                                
                    break;
                    
                    case 'highest':
                        
                        for (var key in saswp_collection) {
                            
                            var current_coll = saswp_collection[key];
                            
                            if(current_coll){
                            
                                var done = false;
                                while (!done) {
                                  done = true;
                                  for (var i = 1; i < current_coll.length; i += 1) {
                                    if (current_coll[i - 1]['saswp_review_rating'] < current_coll[i]['saswp_review_rating']) {
                                      done = false;
                                      var tmp = current_coll[i - 1];
                                      current_coll[i - 1] = current_coll[i];
                                      current_coll[i] = tmp;
                                    }
                                  }
                                }
                             saswp_collection[key] =  current_coll;  
                                
                            }
                                                                                    
                       }
                                                
                    break;
                    
                }
                                
            }
       
       function saswp_create_collection_grid(cols){
                
                var html = '';
                var platform_list = '';
                
                if(saswp_collection){
                    
                    html += '<div class="saswp-rd1-warp">';
                    
                    if(cols == '4_cols'){
                       html += '<ul style="grid-template-columns:1fr 1fr 1fr 1fr;">'; 
                    }
                    if(cols == '3_cols'){
                        html += '<ul style="grid-template-columns:1fr 1fr 1fr;">';
                    }
                    if(cols == '2_cols'){
                        html += '<ul style="grid-template-columns:1fr 1fr;">';
                    }
                                                                                
                    for (var key in saswp_collection) {
                                                                        
                        jQuery.each(saswp_collection[key], function(index, value){
                            
                            html += '<li>';                       
                            html += '<div class="saswp-rd1-data">';
                            html += '<div class="saswp-rd1-athr">';
                            html += '<div class="saswp-rd1-athr-img">';
                            html += '<img src="'+value.saswp_reviewer_image+'" width="56" height="56"/>';
                            html += '</div>';
                            html += '<div class="saswp-rd1-athr-nm">';
                            html += '<h4><a href="#">'+value.saswp_reviewer_name+'</a></h4>';
                            html += saswp_create_rating_html_by_value(value.saswp_review_rating);                       
                            html += '<span class="saswp-rd1-ptdt">'+value.saswp_review_date+'</span>';
                            html += '</div>';
                            html += '</div>';
                            html += '<div class="saswp-rd1-rv-lg">';
                            html += '</div>';
                            
                            html += '<div class="saswp-rd1-rv-lg">';
                            html += '<img src="'+value.saswp_review_platform_icon+'"/>';
                            html += '</div>';
                            
                            html += '</div>';
                            html +='<div class="saswp-rd1-cnt">';
                            html += '<p>'+value.saswp_review_text+'</p>';
                            html += '</div>';
                            html += '</li>';
                                                                                  
                        });
                       
                        if(saswp_collection[key]){
                            
                            platform_list += '<div class="cancel-btn">';
                            platform_list += '<span>'+jQuery("#saswp-plaftorm-list option[value="+key+"]").text()+'</span>';
                            platform_list += '<a platform-id="'+key+'" class="button button-default saswp-remove-platform">X</a>';
                            platform_list += '</div>';
                            
                        }
                                                                                                
                    }
                    
                    html += '</ul>';
                    html += '</div>';
                                        
                }
                jQuery(".saswp-collection-preview").html('');    
                jQuery(".saswp-platform-added-list").html('');                
                jQuery(".saswp-platform-added-list").append(platform_list);                 
                jQuery(".saswp-collection-preview").append(html);    
                                
                                
            }     
            
       function saswp_create_collection_by_design(design, cols, slider, slider_type){
                              
                var html = '';
                //console.log(saswp_collection);
                switch(design) {
                    
                    case "grid":
                        
                         saswp_create_collection_grid(cols);
                        
                        break;
                        
                    case 'slider':
                        
                         saswp_create_collection_slider(slider, slider_type);
                        
                        break;
                    
                    case 'badge':
                        
                         saswp_create_collection_badge();
                        
                        break;
                        
                    case 'popup':
                        
                         saswp_create_collection_popup();
                        
                        break;
                    
                    case 'fomo':
                        
                         saswp_create_collection_fomo();
                        
                        break;
                                                                
                }                           
                
            } 