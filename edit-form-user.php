<?php
/**
 * Created by PhpStorm.
 * User: Carlitosry
 * Date: 24/04/18
 * Time: 1:32 PM
 */


//Edit Form Candidate
function edit_user_form(WP_User $user) {

    $langs = get_terms( 'language', array('hide_empty' => false,));
    $destinations = get_terms( 'destination' , array('hide_empty' => false,));  ?>

    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" enctype="multipart/form-data" class="form-edit-user" style="display: block; position: relative">
        <div class="row">
            <div class="col-md-6">
                <label for="username">Username</label>
                <input type="text" id="username" disabled readonly value="<?php echo esc_attr( $user->user_nicename); ?>">
            </div>

            <div class="col-md-6">
                <label for="email">Email <strong>*: </strong></label>
                <input type="text" name="email" id="email" value="<?php echo esc_attr( $user->user_email); ?>">
            </div>
        </div>

        <?php if (current_user_can( 'professional' )) { // BEGIN PROFESSIONAL FIELDS IF ?>
            <div>
                <label for="company">Nombre de la Empresa</label>
                <input type="text" name="company" value="<?php echo get_the_author_meta( 'company', $user->ID ) ?>">
            </div>

            <div>
                <label for="firstname">Nombre de la persona de Contacto </label>
                <input type="text" name="fname" value="<?php echo $user->first_name; ?>">
            </div>

            <div>
                <label for="lname">Apellido de la persona de Contacto</label>
                <input type="text" name="lname" value="<?php echo $user->last_name; ?>">
            </div>
        <?php } // END PROFESSIONAL IF ?>


        <?php if (current_user_can( 'candidate' )) { // BEGIN CANDIDATES FIELDS IF ?>

            <div class="row">
                <div class="col-md-6">
                    <label for="firstname">First Name</label>
                    <input type="text" name="fname" id="firstname" value="<?php echo $user->first_name; ?>">
                </div>

                <div class="col-md-6">
                    <label for="lname">Last Name</label>
                    <input type="text" name="lname"  id="lname" value="<?php echo $user->last_name; ?>">
                </div>
            </div>

        <?php } // END CANDIDATES IF ?>


        <div class="row">
            <h3 class="col-md-12">Change Password</h3>
            <div class="col-md-6">
                <label for="password">Password <strong>*: </strong></label>
                <input type="password" name="password" id="password" value="">
            </div>
            <div class="col-md-6">
                <label for="passwordconfirm">Confirm Password <strong>*: </strong></label>
                <input type="password" name="passwordconfirm" id="passwordconfirm" value="">
            </div>

        </div>

        <?php if (current_user_can( 'candidate' )) { // BEGIN CANDIDATES FIELDS IF ?>

            <div class="row">
                <div class="col-md-6">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender">
                        <?php $gender = esc_attr( get_the_author_meta( 'gender', $user->ID ) )?>
                        <option <?php echo ($gender == 'm') ? 'selected' : '' ?> value="m">Male</option>
                        <option <?php echo ($gender == 'f') ? 'selected' : '' ?> value="f">Famale</option>
                    </select>

                </div>

                <div class="col-md-6">
                    <label for="birthdate">Birthdate</label>
                    <input type="text" name="birthdate" id="birthdate" class="datetimepicker" value="<?php echo esc_attr( get_the_author_meta( 'birthdate', $user->ID ) ); ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="telephone">Telephone</label>
                    <input type="text" name="telephone" value="<?php echo esc_attr( get_the_author_meta( 'telephone', $user->ID ) ); ?>">
                </div>

                <div class="col-md-6">
                    <label for="availability">Availability</label>
                    <input type="text" name="availability" class="datepicker-multiple" value="<?php echo esc_attr( get_the_author_meta( 'availability', $user->ID ) ); ?>">
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <label for="language">Language</label>
                    <select multiple name="language[]" id="language">
                        <?php
                        $languages = json_decode( get_the_author_meta( 'language', $user->ID ) );
                        foreach ($langs as $lang){ ?>
                            <option <?php echo is_array($languages) && in_array($lang->slug, $languages) ? 'selected="selected"' : ''; ?> value="<?php echo $lang->slug; ?>"><?php echo $lang->name; ?></option>
                        <?php }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="destination">Work place</label>
                    <select name="destination" id="destination">
                        <?php
                        $destination = get_the_author_meta( 'destination', $user->ID );
                        foreach ($destinations as $desti){ ?>
                            <option <?php echo ($desti->slug == $destination) ? 'selected' : ''; ?> value="<?php echo $desti->slug; ?>"><?php echo $desti->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="website">Link of youtube <strong>*: </strong></label>
                    <input type="text" name="website" id="website" value="<?php echo $user->user_url; ?>">
                </div>

                <div class="col-md-6">
                    <label for="bio">About / Experience</label>
                    <textarea name="bio" id="bio"><?php echo $user->description; ?></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="avatar">Upload Photo</label>
                    <div class="upload-content">
                        <?php $file = get_the_author_meta( 'avatar', $user->ID ); ?>

                        <label for="avatar" class="upload-file-label fusion-button button-flat fusion-button-round button-small button-custom button-2">Upload Avatar</label>
                        <input type="file" name="avatar" id="avatar" class="upload-file-buttom">

                        <?php if (array_key_exists('url', $file)){?>
                            <img src="<?php echo $file['url']?>" alt="Avatar User" class="upload-file-preview">
                            <span class="description">Image loaded, upload new to change.</span>
                        <?php }?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="cv">Upload CV</label>
                    <div class="upload-content">
                        <?php $fileCV = get_the_author_meta( 'cv', $user->ID ); ?>
                        <label for="cv" class="upload-file-label fusion-button button-flat fusion-button-round button-small button-custom button-2">Upload Avatar</label>
                        <input type="file" name="cv" id="cv" class="upload-file-buttom">


                        <?php if (array_key_exists('url', $fileCV)){?>
                            <a href="<?php echo $fileCV['url']?>" target="_blank" class="upload-file-preview">View CV</a>
                            <span class="description">File loaded, upload new to change.</span>
                        <?php }?>
                    </div>
                </div>
            </div>
        <?php } // END CANDIDATES IF ?>
        <input type="submit" name="submit" value="Register" class="menu-text fusion-button button-default button-small"/>
    </form>
    <?php
}

function edit_field_validation(WP_User $user, $password, $email, $website, $first_name, $last_name, $bio, $gender, $birthdate,
                               $telephone, $availability, $destination, $language, $avatar, $cv, $company){

    global $reg_errors;
    $reg_errors = new WP_Error;

    if (current_user_can( 'candidate' )) {

        if (empty($email) || empty($birthdate) || empty($first_name) ||
            empty($last_name) || empty($last_name) || empty($bio) || empty($gender) ||
            empty($telephone) || empty($availability) || empty($destination)) {
            $reg_errors->add('field', 'Required form field is missing');
        }

        if (sizeof($language) < 1 || is_null($language)) {
            $reg_errors->add('select_multiple', 'Required select one or most option in language');
        }

        if ($avatar['size'] =! 0 && $avatar['error'] =! 4 && $avatar['error'] =! 0) {

            $reg_errors->add('file_error', 'Required form FILE is missing or is not valid: Avatar');
        }

        if ($cv['size'] =! 0 && $cv['error'] =! 4 && $cv['error'] =! 0) {

            $reg_errors->add('file_error', 'Required form FILE is missing or is not valid: CV');
        }

        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $reg_errors->add('website', 'Link of youtube is not a valid URL. (' . $website . ')');
        }

    }elseif (current_user_can('professional')) {

        if (empty($username) || empty($password) || empty($email) || empty($first_name) ||
            empty($last_name) || empty($telephone) || empty($company)) {
            $reg_errors->add('field', 'Required form field is missing');
        }

    }

    if (!empty($password) && 5 > strlen( $password ) ) {
        $reg_errors->add( 'password', 'Password length must be greater than 5' );
    }

    if ( !is_email( $email ) ) {
        $reg_errors->add( 'email_invalid', 'Email is not valid' );
    }

    if ($email != $user->user_email &&  email_exists( $email )) {
        $reg_errors->add( 'email', 'Email Already in use' );
    }



    if ( is_wp_error( $reg_errors ) && ! empty( $reg_errors->errors ) ) {

        foreach ( $reg_errors->get_error_messages() as $error ) {

            echo '<div>';
            echo '<strong>ERROR: : </strong>';
            echo $error . '<br/>';
            echo '</div>';

        }
        return false;
    }
    return true;

}

function complete_edit_user(WP_User $userCurrent) {
    global $reg_errors;
    $reg_errors = new WP_Error;

    global $username, $password, $email, $website, $first_name, $last_name, $bio, $gender, $birthdate,
           $telephone, $availability, $destination, $language, $avatar, $cv;

    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
        $userdata = array(
            'ID'            =>   $userCurrent->ID,
            'user_email'    =>   $email,
            'user_pass'     =>   (!empty($password)) ? $password : $userCurrent->user_pass,
            'user_url'      =>   $website,
            'first_name'    =>   $first_name,
            'last_name'     =>   $last_name,
            'nickname'      =>   $username,
            'description'   =>   $bio,
        );

        wp_update_user( $userdata );

        update_user_meta( $userCurrent->ID, 'gender', $gender );
        update_user_meta( $userCurrent->ID, 'birthdate', $birthdate );
        update_user_meta( $userCurrent->ID, 'telephone', $telephone );
        update_user_meta( $userCurrent->ID, 'availability', $availability );
        update_user_meta( $userCurrent->ID, 'destination', $destination );

        $langString = json_encode($language);
        update_user_meta( $userCurrent->ID, 'language', $langString );


        require_once( ABSPATH . 'wp-admin/includes/admin.php' );
        $_POST['action'] = 'wp_handle_upload';
        $upload_overrides = array( 'test_form' => false );

        if ($avatar['size'] =! 0 && $avatar['error'] =! 4){
            $uploadAvatar = wp_handle_upload( $avatar, $upload_overrides );

            if( isset($uploadAvatar['error'] ) || isset( $uploadAvatar['upload_error_handler'] ) ) {
                echo 'The File Avatar not was loaded: '. $uploadAvatar['error'] ;
            }else{
                update_user_meta( $userCurrent->ID, 'avatar', $uploadAvatar );
            }
        }

        if ($cv['size'] =! 0 && $cv['error'] =! 4) {
            $uploadCV = wp_handle_upload($cv, $upload_overrides);

            if( isset($uploadCV['error']) || isset( $uploadCV['upload_error_handler'] ) ) {
                echo 'The File CV not was loaded: '. $uploadAvatar['error'] ;
            }else{
                update_user_meta($userCurrent->ID, 'cv', $uploadCV);
            }
        }

        echo 'The profile was update Corretly';
    }
}

function edit_user_function()
{
    $user = new WP_User(get_current_user_id());

    if (isset($_POST['submit'])) {

        $isValid = edit_field_validation(
            $user,
            $_POST['password'],
            $_POST['email'],
            $_POST['website'],
            $_POST['fname'],
            $_POST['lname'],
            $_POST['bio'],
            $_POST['gender'],
            $_POST['birthdate'],
            $_POST['telephone'],
            $_POST['availability'],
            $_POST['destination'],
            $_POST['language'],
            $_FILES['avatar'],
            $_FILES['cv'],
            $_POST['company']
        );

        // sanitize user form input
        global $password, $email, $website, $first_name, $last_name, $bio, $gender, $birthdate,
               $telephone, $availability, $destination, $language, $avatar, $cv;

        $password = esc_attr($_POST['password']);
        $email = sanitize_email($_POST['email']);
        $website = esc_url($_POST['website']);
        $first_name = sanitize_text_field($_POST['fname']);
        $last_name = sanitize_text_field($_POST['lname']);
        $bio = esc_textarea($_POST['bio']);
        $gender = sanitize_text_field($_POST['gender']);
        $birthdate = sanitize_text_field($_POST['birthdate']);
        $telephone = sanitize_text_field($_POST['telephone']);
        $availability = sanitize_text_field($_POST['availability']);
        $destination = sanitize_text_field($_POST['destination']);
        $language = $_POST['language'];
        $avatar = $_FILES['avatar'];
        $cv = $_FILES['cv'];

        // call @function complete_registration to create the user
        // only when no WP_error is found
        if ($isValid) {
            complete_edit_user($user);
        }
    }

    edit_user_form(
        $user
    );
}

function information_profile_form(WP_User $user) {

    $langs = get_terms( 'language', array(
        'hide_empty' => false,));
    $destinations = get_terms( 'destination' , array(
        'hide_empty' => false,));
    ?>
    <div class="container-fluid user-information">

        <div class="fusion-fullwidth fullwidth-box hundred-percent-fullwidth non-hundred-percent-height-scrolling" style="background-color: rgba(255,255,255,0);background-position: center center;background-repeat: no-repeat;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;">
            <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_2  fusion-one-half fusion-column-first 1_2" style="margin-top:0px;margin-bottom:20px;width:48%; margin-right: 4%;">
                <div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                    <div class="fusion-title title fusion-title-size-two" style="margin-top:0px;margin-bottom:31px;">
                        <h2 class="title-heading-left" data-fontsize="18" data-lineheight="27">Profile User</h2>
                        <div class="title-sep-container">
                            <div class="title-sep sep-double" style="border-color:#e0dede;"></div>
                        </div>
                    </div>
                    <div class="fusion-person person fusion-person-left fusion-person-icon-top">
                        <div class="person-shortcode-image-wrapper hover-type-liftup">
                            <div class="person-image-container" style="-webkit-border-radius:0px;-moz-border-radius:0px;border-radius:0px;">
                                <?php $file = get_the_author_meta( 'avatar', $user->ID );
                                    if (array_key_exists('url', $file)){?>
                                    <img class="person-img img-responsive" style="-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;border:0 solid #f6f6f6;" width="580" height="388" src="<?php echo $file['url']?>" alt="<?php echo $user->first_name; ?> <?php echo $user->last_name; ?>">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="fusion-clearfix"></div>
                </div>
            </div>

            <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_2  fusion-one-half fusion-column-last 1_2" style="margin-top:0px;margin-bottom:20px;width:48%">
                <div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                    <div class="fusion-title title fusion-title-size-two" style="margin-top:0px;margin-bottom:31px;">
                        <h2 class="title-heading-left" data-fontsize="18" data-lineheight="27">About / Experience: </h2>
                        <div class="title-sep-container">
                            <div class="title-sep sep-single sep-solid" style="border-color:#e0dede;"></div>
                        </div>
                    </div>
                    <div class="fusion-text">
                        <?php if (current_user_can( 'candidate' )) { // BEGIN CANDIDATES FIELDS IF ?>
                            <h3 class="person-name"><?php echo $user->first_name; ?> <?php echo $user->last_name; ?></h3>
                        <?php }else{ ?>
                            <h3 class="person-name"><?php echo esc_attr( get_the_author_meta( 'company', $user->ID ) ); ?></h3>
                            <h5 class="person-title">
                                <strong>Persona de Contacto: </strong><?php echo $user->first_name; ?> <?php echo $user->last_name; ?></h5>
                        <?php }?>
                        <p><?php echo $user->description; ?></p>
                    </div>
                    <div class="fusion-sep-clear"></div>

                    <div class="fusion-separator fusion-full-width-sep sep-none" style="margin-left: auto;margin-right: auto;margin-top:10px;margin-bottom:10px;"></div>
                    <style type="text/css" scoped="scoped">.fusion-accordian  #accordion-5002-1 .panel-title a .fa-fusion-box{ color: #ffffff;}.fusion-accordian  #accordion-5002-1 .panel-title a .fa-fusion-box:before{ font-size: 13px; width: 13px;}</style>

                    <div class="accordian fusion-accordian">
                        <div class="panel-group" id="accordion-5002-1">
                            <div class="fusion-panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title toggle" data-fontsize="14" data-lineheight="20">
                                        <a data-toggle="collapse" data-parent="#accordion-5002-1" data-target="#7a176008c82d626db" href="#7a176008c82d626db" class="collapsed">
                                            <div class="fusion-toggle-icon-wrapper"><i class="fa-fusion-box"></i></div>
                                            <div class="fusion-toggle-heading">Personal Information</div>
                                        </a>
                                    </h4>
                                </div>
                                <div id="7a176008c82d626db" class="panel-collapse collapse">
                                    <div class="panel-body toggle-content fusion-clearfix">
                                        <ul class="fusion-checklist fusion-checklist-2" style="font-size:14px;line-height:23.8px;">
                                            <li class="fusion-li-item">
                                                <span style="background-color:#a0ce4e;font-size:12.32px;height:23.8px;width:23.8px;margin-right:9.8px;" class="icon-wrapper circle-yes"><i class="fusion-li-icon  fa fa-plus" style="color:#fff;"></i></span>
                                                <div class="fusion-li-item-content" style="margin-left:33.6px;">
                                                    <strong>First name: </strong> <?php echo $user->first_name; ?>
                                                </div>
                                            </li>
                                            <li class="fusion-li-item">
                                                <span style="background-color:#a0ce4e;font-size:12.32px;height:23.8px;width:23.8px;margin-right:9.8px;" class="icon-wrapper circle-yes"><i class="fusion-li-icon  fa fa-plus" style="color:#fff;"></i></span>
                                                <div class="fusion-li-item-content" style="margin-left:33.6px;">
                                                    <strong>Last name: </strong> <?php echo $user->last_name; ?>
                                                </div>
                                            </li>
                                            <li class="fusion-li-item">
                                                <span style="background-color:#a0ce4e;font-size:12.32px;height:23.8px;width:23.8px;margin-right:9.8px;" class="icon-wrapper circle-yes"><i class="fusion-li-icon  fa fa-plus" style="color:#fff;"></i></span>
                                                <div class="fusion-li-item-content" style="margin-left:33.6px;">
                                                    <strong>Gender: </strong> <?php $gender = esc_attr( get_the_author_meta( 'gender', $user->ID ) )?>
                                                    <?php echo ($gender == 'm') ? 'Male' : 'Female' ?>
                                                </div>
                                            </li>
                                            <li class="fusion-li-item">
                                                <span style="background-color:#a0ce4e;font-size:12.32px;height:23.8px;width:23.8px;margin-right:9.8px;" class="icon-wrapper circle-yes"><i class="fusion-li-icon  fa fa-plus" style="color:#fff;"></i></span>
                                                <div class="fusion-li-item-content" style="margin-left:33.6px;">
                                                    <strong>Birthdate:</strong> <?php echo $birthDate = esc_attr( get_the_author_meta( 'birthdate', $user->ID ) ); ?>
                                                </div>
                                            </li>
                                            <li class="fusion-li-item">
                                                <span style="background-color:#a0ce4e;font-size:12.32px;height:23.8px;width:23.8px;margin-right:9.8px;" class="icon-wrapper circle-yes"><i class="fusion-li-icon  fa fa-plus" style="color:#fff;"></i></span>
                                                <div class="fusion-li-item-content" style="margin-left:33.6px;">
                                                    <strong>Age:</strong>
                                                    <?php
                                                    $birthDate = explode("/", $birthDate);
                                                    //get age from date or birthdate
                                                    echo $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[0], $birthDate[2]))) > date("md")
                                                        ? ((date("Y") - $birthDate[2]) - 1)
                                                        : (date("Y") - $birthDate[2]));
                                                    ?>

                                                </div>
                                            </li>
                                            <li class="fusion-li-item">
                                                <span style="background-color:#a0ce4e;font-size:12.32px;height:23.8px;width:23.8px;margin-right:9.8px;" class="icon-wrapper circle-yes"><i class="fusion-li-icon  fa fa-plus" style="color:#fff;"></i></span>
                                                <div class="fusion-li-item-content" style="margin-left:33.6px;">
                                                    <strong for="telephone">Telephone: </strong><?php echo esc_attr( get_the_author_meta( 'telephone', $user->ID ) ); ?>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="fusion-panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title toggle" data-fontsize="14" data-lineheight="20">
                                        <a data-toggle="collapse" data-parent="#accordion-5002-1" data-target="#1af23241c0a9813eb" href="#1af23241c0a9813eb" class="collapsed">
                                            <div class="fusion-toggle-icon-wrapper"><i class="fa-fusion-box"></i></div>
                                            <div class="fusion-toggle-heading">User Information</div>
                                        </a>
                                    </h4>
                                </div>
                                <div id="1af23241c0a9813eb" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body toggle-content fusion-clearfix">
                                        <ul class="fusion-checklist fusion-checklist-2" style="font-size:14px;line-height:23.8px;">
                                            <li class="fusion-li-item">
                                                <span style="background-color:#a0ce4e;font-size:12.32px;height:23.8px;width:23.8px;margin-right:9.8px;" class="icon-wrapper circle-yes"><i class="fusion-li-icon  fa fa-plus" style="color:#fff;"></i></span>
                                                <div class="fusion-li-item-content" style="margin-left:33.6px;">
                                                    <strong>Username: </strong>  <?php echo esc_attr( $user->user_nicename); ?>
                                                </div>
                                            </li>
                                            <li class="fusion-li-item">
                                                <span style="background-color:#a0ce4e;font-size:12.32px;height:23.8px;width:23.8px;margin-right:9.8px;" class="icon-wrapper circle-yes"><i class="fusion-li-icon  fa fa-plus" style="color:#fff;"></i></span>
                                                <div class="fusion-li-item-content" style="margin-left:33.6px;">
                                                    <strong>Email: </strong>  <?php echo esc_attr( $user->user_email); ?>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="fusion-panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title toggle" data-fontsize="14" data-lineheight="20">
                                        <a data-toggle="collapse" data-parent="#accordion-5002-1" data-target="#ab7f42a2008ad4649" href="#ab7f42a2008ad4649" class="collapsed">
                                            <div class="fusion-toggle-icon-wrapper"><i class="fa-fusion-box"></i></div>
                                            <div class="fusion-toggle-heading">Skill / Interesing </div>
                                        </a>
                                    </h4>
                                </div>
                                <div id="ab7f42a2008ad4649" class="panel-collapse collapse ">
                                    <div class="panel-body toggle-content fusion-clearfix">
                                        <ul class="fusion-checklist fusion-checklist-2" style="font-size:14px;line-height:23.8px;">
                                            <li class="fusion-li-item">
                                                <span style="background-color:#a0ce4e;font-size:12.32px;height:23.8px;width:23.8px;margin-right:9.8px;" class="icon-wrapper circle-yes"><i class="fusion-li-icon  fa fa-plus" style="color:#fff;"></i></span>
                                                <div class="fusion-li-item-content" style="margin-left:33.6px;">
                                                    <strong>Languages: </strong>
                                                        <?php $languages = json_decode(get_the_author_meta( 'language', $user->ID ));
                                                        foreach ($langs as $lang) {
                                                            echo (in_array($lang->slug, $languages)) ? $lang->name.', ' : '';
                                                        }
                                                        ?>
                                                </div>
                                            </li>
                                            <li class="fusion-li-item">
                                                <span style="background-color:#a0ce4e;font-size:12.32px;height:23.8px;width:23.8px;margin-right:9.8px;" class="icon-wrapper circle-yes"><i class="fusion-li-icon  fa fa-plus" style="color:#fff;"></i></span>
                                                <div class="fusion-li-item-content" style="margin-left:33.6px;">
                                                    <strong>Destination: </strong>
                                                        <?php  echo $destination = get_the_author_meta( 'destination', $user->ID ); ?>
                                                </div>
                                            </li>
                                            <li class="fusion-li-item">
                                                <span style="background-color:#a0ce4e;font-size:12.32px;height:23.8px;width:23.8px;margin-right:9.8px;" class="icon-wrapper circle-yes"><i class="fusion-li-icon  fa fa-plus" style="color:#fff;"></i></span>
                                                <div class="fusion-li-item-content" style="margin-left:33.6px;">
                                                    <strong>Availability: </strong><?php echo esc_attr( get_the_author_meta( 'availability', $user->ID ) ); ?>
                                                </div>
                                            </li>
                                            <?php $fileCV = get_the_author_meta( 'cv', $user->ID );
                                            if (array_key_exists('url', $fileCV)){?>
                                                <li class="fusion-li-item">
                                                    <span style="background-color:#a0ce4e;font-size:12.32px;height:23.8px;width:23.8px;margin-right:9.8px;" class="icon-wrapper circle-yes"><i class="fusion-li-icon  fa fa-plus" style="color:#fff;"></i></span>
                                                    <div class="fusion-li-item-content" style="margin-left:33.6px;">
                                                        <div class="upload-content">
                                                            <strong>CV: </strong>
                                                            <a href="<?php echo $fileCV['url']?>" target="_blank">Click here to view file</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fusion-clearfix"></div>
                </div>
            </div>

            <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_1  fusion-one-full fusion-column-first fusion-column-last fusion-column-no-min-height 1_1" style="margin-top:0px;margin-bottom:0px;">
                <div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                    <div class="fusion-title title fusion-title-size-two" style="margin-top:0px;margin-bottom:31px;">
                        <h2 class="title-heading-left" data-fontsize="18" data-lineheight="27">Video User</h2>
                        <div class="title-sep-container">
                            <div class="title-sep sep-double" style="border-color:#e0dede;"></div>
                        </div>
                    </div>

                    <div class="fusion-sep-clear"></div>
                    <div class="embed-responsive embed-responsive-4by3">

                        <?php
                        $youtubeUrl = $user->user_url;
                        echo preg_replace(
                            "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
                            "<iframe class='embed-responsive-item' src=\"//www.youtube.com/embed/$2\" allowfullscreen></iframe>",
                            $youtubeUrl)
                        ?>
                    </div>
                    <div class="fusion-clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <?php
}



add_shortcode( 'edit_form_user', 'edit_form_user_shortcode' );
add_shortcode( 'information_user', 'information_user_shortcode' );

// The callback function that will replace [book]
function edit_form_user_shortcode() {
    ob_start();
    edit_user_function();
    return ob_get_clean();
}

// The callback function that will replace [book]
function information_user_shortcode() {
    ob_start();
    $user = new WP_User(get_current_user_id());
    information_profile_form($user);
    return ob_get_clean();
}
