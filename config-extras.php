<?php
/**
 * Created by PhpStorm.
 * User: @Carlitosry
 * Date: 22/04/18
 * Time: 7:21 PM
 */


//ASSET files load admin
add_action( 'admin_enqueue_scripts', 'load_wp_media_files' );
add_action( 'wp_enqueue_scripts', 'load_wp_media_files' );
function load_wp_media_files( $page ) {

    if( $page == 'profile.php' || $page == 'user-edit.php' || is_page_template( 'page-profile.php' ) || is_page_template( 'login.php' ) ) {
        wp_enqueue_media();
        wp_enqueue_style('user_registration_bootstrap_css', plugins_url( '/vendors/bootstrap-3/css/bootstrap.css' , __FILE__ ), array(),  '3.3.7');
        wp_enqueue_style('user_registration_datepicker_css', plugins_url( '/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css' , __FILE__ ), array(),  '3.3.7');
        wp_enqueue_script( 'user_registration_bootstrap_script', plugins_url( '/vendors/bootstrap-3/js/bootstrap.js' , __FILE__ ), array('jquery'), '3.3.7' );
        wp_enqueue_script( 'user_registration_bootstrap_datepicker_script', plugins_url( '/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js' , __FILE__ ), array('jquery'), '3.3.7' );

        wp_enqueue_style('user_registration_select_css', plugins_url( '/vendors/jquery.sumoselect/sumoselect.min.css' , __FILE__ ), array(),  '0.1');
        wp_enqueue_script( 'user_registration_bootstrap_select_script', plugins_url( '/vendors/jquery.sumoselect/jquery.sumoselect.min.js' , __FILE__ ), array('jquery'), '0.1' );
        wp_enqueue_style('user_registration_css', plugins_url( '/css/admin.css' , __FILE__ ), array(),  '0.1');
        wp_enqueue_script('user_registration_script', plugins_url( '/js/script.js' , __FILE__ ), array('jquery'), '0.1' );
    }
}




function footer_script(){ ?>
    <script>
        jQuery(document).ready(function(){
            //put your js code here
            jQuery(".datetimepicker").datepicker({
                    format: "dd/mm/yyyy",
                    inline: true,
                    todayHighlight: false,
                    startDate: '01/01/1960',
                    autoclose: true,
                    startView: 2
                });

            var selectedDates=[];
            dp = jQuery(".datepicker-multiple").datepicker({
                format: "dd/mm/yyyy",
                multidate: true,
                multidateSeparator: " - ",
                inline: true,
                todayHighlight: false,
                startDate: 'today'
            });

            dp.on('changeDate', function(e) {

                if(e.dates.length <3){
                    selectedDates = e.dates
                }else{
                    dp.data('datepicker').setDates(selectedDates);
                    alert('Can only select 2 dates')
                }

            });

            jQuery('#language').SumoSelect();
        })
    </script>
<?php }

add_action('wp_footer', 'footer_script');

// Register Taxonomies of pluigins
function user_registration_taxonomy() {

    $labels = array(
        'name'                       => _x( 'List language', 'Taxonomy General Name', 'text_domain' ),
        'singular_name'              => _x( 'List language', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'Languages', 'text_domain' ),
        'all_items'                  => __( 'All languages', 'text_domain' ),
        'parent_item'                => __( 'Items parent', 'text_domain' ),
        'parent_item_colon'          => __( 'items parent:', 'text_domain' ),
        'new_item_name'              => __( 'New language', 'text_domain' ),
        'add_new_item'               => __( 'Add new language', 'text_domain' ),
        'edit_item'                  => __( 'Edit language', 'text_domain' ),
        'update_item'                => __( 'Update language', 'text_domain' ),
        'view_item'                  => __( 'View language', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate language with comma', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or remove language', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose one from the most used', 'text_domain' ),
        'popular_items'              => __( 'Language most used', 'text_domain' ),
        'search_items'               => __( 'Search language', 'text_domain' ),
        'not_found'                  => __( 'No found Language', 'text_domain' ),
        'no_terms'                   => __( 'There are no languages', 'text_domain' ),
        'items_list'                 => __( 'List Language', 'text_domain' ),
        'items_list_navigation'      => __( 'Nav List', 'text_domain' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'language', array( 'post' ), $args );

    $labels2 = array(
        'name'                       => _x( 'List destination', 'Taxonomy General Name', 'text_domain' ),
        'singular_name'              => _x( 'List destination', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'Destinations', 'text_domain' ),
        'all_items'                  => __( 'All destinations', 'text_domain' ),
        'parent_item'                => __( 'Items parent', 'text_domain' ),
        'parent_item_colon'          => __( 'items parent:', 'text_domain' ),
        'new_item_name'              => __( 'New destination', 'text_domain' ),
        'add_new_item'               => __( 'Add new destination', 'text_domain' ),
        'edit_item'                  => __( 'Edit destination', 'text_domain' ),
        'update_item'                => __( 'Update destination', 'text_domain' ),
        'view_item'                  => __( 'View destination', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate destination with comma', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or remove destination', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose one from the most used', 'text_domain' ),
        'popular_items'              => __( 'destination most used', 'text_domain' ),
        'search_items'               => __( 'Search destination', 'text_domain' ),
        'not_found'                  => __( 'No found destination', 'text_domain' ),
        'no_terms'                   => __( 'There are no destinations', 'text_domain' ),
        'items_list'                 => __( 'List destination', 'text_domain' ),
        'items_list_navigation'      => __( 'Nav List', 'text_domain' ),
    );
    $args = array(
        'labels'                     => $labels2,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'destination', array( 'post' ), $args );

}
add_action( 'init', 'user_registration_taxonomy', 0 );

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );
function extra_user_profile_fields( $user ){
    $langs = get_terms( 'language', array(
        'hide_empty' => false,));
    $destinations = get_terms( 'destination' , array(
        'hide_empty' => false,));
    ?>
    <h3><?php _e("Extra profile information", "blank"); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="phone"><?php _e("Phone"); ?></label></th>
            <td>
                <input type="text" name="phone" id="phone" class="regular-text"
                       value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" /><br />
                <span class="description"><?php _e("Please enter your phone."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="gender">Gender</label></th>
            <td>
                <select name="gender" id="gender">
                    <?php $gender = esc_attr( get_the_author_meta( 'gender', $user->ID ) )?>
                    <option <?php echo ($gender == 'm') ? 'selected' : '' ?> value="m">Male</option>
                    <option <?php echo ($gender == 'f') ? 'selected' : '' ?> value="f">Female</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="birthdate">Birthdate</label></th>
            <td>
                <input type="text" name="birthdate" id="birthdate" class="datetimepicker" value="<?php echo esc_attr( get_the_author_meta( 'birthdate', $user->ID ) ); ?>">
            </td>
        </tr>
        <tr>
            <th><label for="telephone">Telephone</label></th>
            <td>
                <input type="text" name="telephone" value="<?php echo esc_attr( get_the_author_meta( 'telephone', $user->ID ) ); ?>">
            </td>
        </tr>
        <tr>
            <th><label for="availability">Availability</label></th>
            <td>
                <input type="text" name="availability" value="<?php echo esc_attr( get_the_author_meta( 'availability', $user->ID ) ); ?>">
            </td>
        </tr>
        <tr>
            <th><label for="company">Company</label></th>
            <td>
                <input type="text" name="company" value="<?php echo esc_attr( get_the_author_meta( 'company', $user->ID ) ); ?>">
            </td>
        </tr>
        <tr>
            <th><label for="language">language</label></th>
            <td>
                <select multiple name="language[]" id="language">
                    <?php

                        $languages = json_decode( get_the_author_meta( 'language', $user->ID ) );
                        foreach ($langs as $lang){ ?>
                            <option <?php echo is_array($languages) && in_array($lang->slug, $languages) ? 'selected' : '' ; ?> value="<?php echo $lang->slug; ?>"><?php echo $lang->name; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="destination">Destination</label></th>
            <td>
                <select name="destination" id="destination">
                    <?php
                        $destination = get_the_author_meta( 'destination', $user->ID );
                        foreach ($destinations as $desti){ ?>
                            <option <?php echo (!empty($destination) && $desti->slug == $destination) ? 'selected' : ''; ?> value="<?php echo $desti->slug; ?>"><?php echo $desti->name; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>

        <tr>
            <th><label for="avatar">Upload Photo</label></th>
            <td class="upload-content">
                <?php $file = get_the_author_meta( 'avatar', $user->ID ); ?>

                <label for="avatar" class="upload-file-label button-primary">Upload Avatar</label>
                <input type="file" name="avatar" id="avatar" class="upload-file-buttom">
                <?php if (array_key_exists('url', $file)){?>
                    <img src="<?php echo $file['url']?>" alt="Avatar User" class="upload-file-preview">
                    <span class="description">The image loaded, upload new to change.</span>
                <?php }?>
            </td>
        </tr>

        <tr>
            <th><label for="cv">Upload CV</label></th>
            <td class="upload-content">
                <?php $fileCV = get_the_author_meta( 'cv', $user->ID ); ?>
                <label for="cv" class="upload-file-label button-primary">Upload Avatar</label>
                <input type="file" name="cv" id="cv" class="upload-file-buttom">

                <?php if (array_key_exists('url', $fileCV)){?>
                    <a href="<?php echo $fileCV['url']?>" target="_blank" class="upload-file-preview">View CV</a>
                    <span class="description">The file loaded, upload new to change.</span>
                <?php }?>

            </td>
        </tr>
    </table>
    <?php
}

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );
function save_extra_user_profile_fields( $user_id ) {
    $saved = false;
    
    $gender         =   $_POST['gender'];
    $birthdate      =   $_POST['birthdate'];
    $telephone      =   $_POST['telephone'];
    $availability   =   $_POST['availability'];
    $destination    =   $_POST['destination'];
    $language       =   $_POST['language'];
    $avatar         =   $_FILES['avatar'];
    $cv             =   $_FILES['cv'];
    $company        =   $_POST['company'];


    if ( current_user_can( 'edit_user', $user_id ) ) {
        update_user_meta( $user_id, 'gender', $gender );
        update_user_meta( $user_id, 'birthdate', $birthdate );
        update_user_meta( $user_id, 'telephone', $telephone );
        update_user_meta( $user_id, 'availability', $availability );
        update_user_meta( $user_id, 'destination', $destination );
        update_user_meta( $user_id, 'company', $company );

        $langString = json_encode($language);
        update_user_meta( $user_id, 'language', $langString );

        $_POST['action'] = 'wp_handle_upload';
        $upload_overrides = array( 'test_form' => false );

        $uploadAvatar = wp_handle_upload( $avatar, $upload_overrides );
        $uploadCV = wp_handle_upload( $cv, $upload_overrides );

        update_user_meta( $user_id, 'avatar', $uploadAvatar );
        update_user_meta( $user_id, 'cv', $uploadCV );
        $saved = true;
    }

    return true;
}

function send_email_after_signup( $user){
    $user_info = get_userdata($user);

    $to = 'info@workinspain.sk';
    $subject = 'New sign up of '.implode(', ', $user_info->roles).' in the Site '.get_option( 'blogname' ).'.';
    $body = '
    <div>
        <p>
            You have new register of user like '.implode(', ', $user_info->roles).' with the following information:
        </p>';

        if (in_array('candidate',  $user_info->roles)){
            $body .= '
            <ul>
                <li><b>Full Name: </b>'.$user_info->first_name.' '.$user_info->last_name.'</li>
                <li><b>Email: </b>'.$user_info->user_email.'</li >
                <li><b>Telephone: </b>'.get_the_author_meta( 'telephone', $user ).'</li>
                <li><b>Availability: </b>'.get_the_author_meta( 'availability', $user ).'</li>
            </ul>
            ';
        }elseif (in_array('professional',  $user_info->roles)){
            $body .= '
            <ul>
                <li><b>Fullname Contact: </b>'.$user_info->first_name.' '.$user_info->last_name.'</li>
                <li><b>Company: </b>'.get_the_author_meta( 'company', $user ).'</li>
                <li><b>Email: </b>'.$user_info->user_email.'</li>
                <li><b>Telephone: </b>'.get_the_author_meta( 'telephone', $user ).'</li>
            </ul>
            ';
        }
        $body.= '<p><b>Note:</b> if you reply this email, you could contact directly with the email register by '.implode(', ', $user_info->roles).'.</p>

    </div>';

    $headers = array('Content-Type: text/html; charset=UTF-8','From: '.get_option( 'blogname' ).' register@workinspain.sk', 'Reply-To: '.$user_info->first_name.' '.$user_info->last_name.' <'.$user_info->user_email.'>',);

    wp_mail( $to, $subject, $body, $headers );
}
