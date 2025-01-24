<?php
$policy_intent = get_field('policy_intent');
$policy_outcome = get_field('policy_outcome');
$pro_policy = get_field('pro_policy');
$con_policies = get_field('con_policies');
$policy_image = get_field('policy_image');
$image_or_video = get_field('image_or_video');
$policy_video =  get_field('policy_video');
$policy_video_url =  get_field('video_url');

// echo '<pre> image_or_video :';
// print_r($image_or_video);
// echo '</pre>';

if(!empty($policy_image)) {
        $policy_image = (!empty($policy_image['url'])) ? $policy_image['url'] : wp_get_attachment_url(get_field('policy_image'));
}else if(!empty(get_field('policy_video'))){
    
		$policy_video =  wp_get_attachment_url(get_field('policy_video'));
}
if(!empty(get_field('video_url'))){
    $policy_video_url =  get_field('video_url');
}
     
     


$zip_code = get_field('zip_code');
$city = get_field('city');
$country = get_field('country');

$view_count = get_post_meta(get_the_ID(),'post_views_count',true);
$user_reting = get_post_meta(get_the_ID(),'user_reting',true);


// Get the post's ID
$post_id = get_the_ID();

// Get the post's publish time
$publish_time = get_post_time('U', false, $post_id);
// Get the di
// fference between the current time and the post's publish time
$time_diff_seconds = current_time('timestamp') - $publish_time;

// If the time difference is less than 60 seconds, show "just now"
$ago = '';
if ($time_diff_seconds < 60) {
    $ago = 'Published just now';
} else {
    // Get human-readable time difference for time longer than 60 seconds
    $time_diff = human_time_diff($publish_time, current_time('timestamp'));
    // Output the time difference
    $ago = 'Published ' . $time_diff . ' ago';
}
global $post;
$author_id  = $post->post_author;
$author_name = get_the_author_meta('display_name', $author_id);

$profile_image_id = get_user_meta($author_id, 'profile_image', true);
$user_icon = (!empty($profile_image_id)) ? wp_get_attachment_url($profile_image_id) : get_template_directory_uri().'/assets/images/icon.png';

$current_user_id = get_current_user_id();
$check_user_reting = get_user_meta($current_user_id,'user_policy_reting_'.$current_user_id.'_'.$post_id, true);
?>
<section class="pb_detail pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col col-md-12 col-xl-8 mx-auto">
                <div class="pb_detail-title"><h5><?php echo get_the_title(); ?></h5></div>
                <div class="pb_detail-user">
                    <div class="flex">
                        <div class="pb_avtar"><img src="<?php echo $user_icon; ?>" alt="" /></div>
                        <div class="pb_avtar-title">
                            <p><?php echo $author_name; ?></p>
                            <span><?php echo $ago; ?></span>
                             
                        </div>
                    </div>
                    <div class="location">
                        <div class="flex"><img class="in-avg" src="<?php echo get_template_directory_uri(); ?>/assets/images/location.svg" alt="" /><span><?php echo $zip_code.'  '.$city.'-'.$country; ?></span></div>
                    </div>
                </div>
                  <?php
        if($image_or_video == 'choice' || empty($image_or_video)) {
            if(!empty($policy_image)) {
                echo '<div class="pb_detail-img"><img src="'.$policy_image.'" alt="" /></div>';
            }else if(!empty($policy_video)){
            	echo '<div class="pb_detail-img pb_detail-video">
                        <video controls >
                            <source src="'.$policy_video.'" type="video/mp4">
                        </video>
                    </div>';
            }else if($policy_video_url) {
                echo '<div class="pb_detail-img pb_detail-video">
                            <iframe width="420" height="315"
                            src="'.$policy_video_url.'">
                            </iframe></div>';
            }
        }else if($image_or_video == 'image'){
            if(!empty($policy_image)) {
                echo '<div class="pb_detail-img"><img src="'.$policy_image.'" alt="" /></div>';
            }
        }else if($image_or_video == 'video'){
            if(!empty($policy_video)){
        	echo '<div class="pb_detail-img pb_detail-video">
                    <video controls >
                        <source src="'.$policy_video.'" type="video/mp4">
                    </video>
                </div>';
            }
        }else if($image_or_video == 'url') {
            if(!empty($policy_video_url)){
        // 	echo '<div class="pb_detail-img pb_detail-video">
        //             <video controls >
        //                 <source src="'.$policy_video_url.'" type="video/mp4">
        //             </video>
        //         </div>';
                
                       echo '<div class="pb_detail-img pb_detail-video">
                            <iframe width="420" height="315"
                            src="'.$policy_video_url.'">
                            </iframe></div>';
            }
        }
            
//             else{
//                 echo '<div class="pb_detail-img pb_detail-video">
//                             <iframe width="420" height="315"
// src="https://www.youtube.com/embed/tgbNymZ7vqY">
// </iframe>
//                         </div>';
//             }
            
?>
                
                <div class="card-details">
                    <div class="card-inner">
                        <div class="policy_wrapp">
                            <h6>Policy Intent:</h6>
                            <p><?php echo $policy_intent; ?></p>
                        </div>
                        <div class="policy_wrapp">
                            <h6>Policy Outcome:</h6>
                            <?php echo $policy_outcome; ?>
                        </div>
                        
                        <div class="policy_pro-con">
                            <div class="pro_policy">
                                <h6>PRO:</h6>
                                <div class="rate_wrap">
                                    <div class="up_rate"><img class="in-svg" src="<?php echo get_template_directory_uri(); ?>/assets/images/up.svg" alt="icon" /></div>
                                    <div class="input_wrap"><input class="qtyValue" min="1" max="3" type="number" value="1" /></div>
                                    <div class="down_rate"><img class="in-svg" src="<?php echo get_template_directory_uri(); ?>/assets/images/down.svg" alt="icon" /></div>
                                </div>
                            </div>
                            <?php /*
                            <div class="pro_policy-rating">
                                <h6>Rating:</h6>
                                <?php 
                                if(!empty($pro_policy)) :
                                    foreach($pro_policy as $key=>$value) : 
                                        ?>
                                            <div class="rating"><?php echo (!empty($value['policy_rating'])) ? $value['policy_rating'] : 0; ?></div>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                                    
                            </div>
                            */
                            ?>
                            <div class="pro_policy-con">
                                <span class="mr-1">Rating</span>
                                <span>Discussion in favor of policy.</span>
                               
                                <?php 
                                if(!empty($pro_policy)) :
                                    foreach($pro_policy as $key=>$value) : ?>
                                        
                                        <div class="pro_policy-in flex">
                                            <div class="pro-rating">
                                                <?php echo (!empty($value['policy_rating'])) ? $value['policy_rating'] : 0; ?>
                                            </div>
                                            <p class="ml-1">
                                                &lt; <?php echo $key+1; ?> &gt; <?php echo $value['pro_policy_position']; ?>
                                                <a class="flex link_con" href="<?php echo $value['pro_citations']; ?>">
                                                    <img class="in-svg" src="<?php echo get_template_directory_uri(); ?>/assets/images/link.svg" alt="icon" />
                                                    
                                                    <?php echo $value['pro_citations_title']; ?>
                                                </a>
                                            </p>
                                        </div>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                                
                                
                                <div class="col-sm-12 pro-policy" >
                                    <div class="single-policy-field" data-policy="pro-policy"  data-post_id="<?php echo get_the_ID(); ?>">
                                        <div class="row inner_row" data-repeater-item>
                                            <div class="col col-sm-4">
                                                <div class="input_wrapper">
                                                    <label class="form-label">Pro Policy position </label>
                                                    <textarea class="form-control policy-position" cols="30" rows="5" name="inner-text-input" value="inner"></textarea>
                                                </div>
                                            </div>
                                            <div class="col col-sm-3">
                                                <div class="input_wrapper">
                                                    <label class="form-label">Pro Citations</label>
                                                    <textarea class="form-control policy-citations" cols="30" rows="5" name="text-input"></textarea>
                                                </div>
                                            </div>
                                            <div class="col col-sm-3">
                                                <div class="input_wrapper">
                                                    <label class="form-label">Pro Citations Title</label>
                                                    <textarea class="form-control policy-citations-title" cols="30" rows="5" name="text-input"></textarea>
                                                </div>
                                            </div>
                                            <div class="col col-sm-2">
                                                <div class="input_wrapper">
                                                    <label class="form-label">Rating</label>
                                                    
                                                    <input type="number" class="form-control policy-rating" min="1" max="3" name="policy-rating" value="1">
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <a href="javascript:void(0);" class="save-field-policy btn btn--dark mt-1 ml-1">
                                            <div class="btn-ring"></div> 
                                            Save
                                        </a>
                                    </div>
                                    <?php 
                                    if ( is_user_logged_in() ) : 
                                        if(get_the_ID() != $check_user_reting || empty($pro_policy)) :
                                        ?>
                                        <button class="add-field-btn btn-icon" data-repeater-create type="button" value="Add">
                                            <img class="addRemove-icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/plus-s.svg" alt="" />
                                            
                                        </button>
                                        <?php 
                                        endif;
                                    endif;
                                        ?>
                                </div>
                            </div>
                        </div>

                        <div class="policy_pro-con">
                            <div class="pro_policy">
                                <h6>CON:</h6>
                                <div class="rate_wrap">
                                    <div class="up_rate"><img class="in-svg" src="<?php echo get_template_directory_uri(); ?>/assets/images/up.svg" alt="icon" /></div>
                                    <div class="input_wrap"><input class="qtyValue" min="1" max="5" type="number" value="1" /></div>
                                    <div class="down_rate"><img class="in-svg" src="<?php echo get_template_directory_uri(); ?>/assets/images/down.svg" alt="icon" /></div>
                                </div>
                            </div>
                            
                            <div class="pro_policy-con">
                                <span class="mr-1">Rating</span>
                                <span>Discussion in favor of policy.</span>
                                <?php 
                                if(!empty($con_policies)) :
                                    foreach($con_policies as $key=>$value) : 
                                        
                                    ?>
                                        
                                        <div class="pro_policy-in flex">
                                            <div class="con-rating"><?php echo (!empty($value['policy_rating'])) ? $value['policy_rating'] : 0; ?></div>
                                            <p class="ml-1">&lt; <?php echo $key+1; ?> &gt; <?php echo $value['con_policy_position']; ?>
                                                <a class="flex link_con" href="<?php echo $value['con_citations']; ?>">
                                                    <img class="in-svg" src="<?php echo get_template_directory_uri(); ?>/assets/images/link.svg" alt="icon" />
                                                    <?php echo $value['con_citations_title']; ?>
                                                </a>
                                            </p>

                                        </div>
                                    <?php
                                    endforeach;
                                endif;
                                ?>

                                <div class="col-sm-12 pro-policy" >
                                    <div class="single-policy-field" data-policy="con-policy" data-post_id="<?php echo get_the_ID(); ?>">
                                        <div class="row inner_row align-items-center" data-repeater-item>
                                            <div class="col col-sm-4">
                                                <div class="input_wrapper">
                                                    <label class="form-label">Con Policy position</label>
                                                    <textarea class="form-control policy-position" cols="30" rows="5" name="inner-text-input" value="inner"></textarea>
                                                </div>
                                            </div>
                                            <div class="col col-sm-3">
                                                <div class="input_wrapper">
                                                    <label class="form-label">Con Citations</label>
                                                    <textarea class="form-control policy-citations" cols="30" rows="5" name="text-input"></textarea>
                                                </div>
                                            </div>
                                            <div class="col col-sm-3">
                                                <div class="input_wrapper">
                                                    <label class="form-label">Con Citations Title</label>
                                                    <textarea class="form-control policy-citations-title" cols="30" rows="5" name="text-input"></textarea>
                                                </div>
                                            </div>
                                            <div class="col col-sm-2">
                                                <div class="input_wrapper">
                                                    <label class="form-label">Rating</label>
                                                    
                                                    <input type="number" class="form-control policy-rating" min="1" max="3" name="policy-rating" value="1">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <a href="javascript:void(0);" class="save-field-policy btn btn--dark mt-1 ml-1">
                                            <div class="btn-ring"></div> 
                                            Save
                                        </a>
                                    </div>
                                    <?php
                                    if ( is_user_logged_in() ) : 
                                        if(get_the_ID() != $check_user_reting || empty($con_policies)) :
                                        ?>
                                        <button class="add-field-btn btn-icon" data-repeater-create type="button" value="Add">
                                            <img class="addRemove-icon"  src="<?php echo get_template_directory_uri() ?>/assets/images/plus-s.svg" alt="" />                                            
                                        </button>
                                        <?php
                                        endif;
                                    endif;
                                    ?>
                                </div>


                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="like_comment">
                    <div class="like flex"><img class="in-svg" src="<?php echo get_template_directory_uri(); ?>/assets/images/eye.svg" alt="" /><?php echo $view_count; ?></div>
                    <!-- <div class="comment flex"><img class="in-svg" src="<?php echo get_template_directory_uri(); ?>/assets/images/comment.svg" alt="" />158</div> -->
                </div>
            </div>
        </div>
    </div>
</section>