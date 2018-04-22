<?php
/**
 * Created by PhpStorm.
 * User: @Carlitosry
 * Date: 22/04/18
 * Time: 7:12 PM
 */

function registration_form($username, $password, $email, $website, $first_name, $last_name, $bio, $gender, $birthdate, $telephone, $availability, $destination, $language, $avatar, $cv) {

    $langs = get_terms( 'language', array(
        'hide_empty' => false,));
    $destinations = get_terms( 'destination' , array(
        'hide_empty' => false,));

// FORM OF CANDIDATE

    echo ' <style>
    
        div {
          margin-bottom:2px;
        }
         
        input{
            margin-bottom:4px;
        }
    </style>
    ';

    echo '
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post" enctype="multipart/form-data" class="form-registration-user">
        <div>
            <label for="username">Username <strong>*</strong></label>
            <input type="text" name="username" value="' . ( isset( $_POST['username'] ) ? $username : null ) . '">
        </div>
            
        <div>
            <label for="email">Email <strong>*</strong></label>
            <input type="text" name="email" value="' . ( isset( $_POST['email']) ? $email : null ) . '">
        </div>
     
        <div>
            <label for="password">Password <strong>*</strong></label>
            <input type="password" name="password" value="' . ( isset( $_POST['password'] ) ? $password : null ) . '">
        </div>
         
        <div>
            <label for="firstname">First Name</label>
            <input type="text" name="fname" value="' . ( isset( $_POST['fname']) ? $first_name : null ) . '">
        </div>
         
        <div>
            <label for="website">Last Name</label>
            <input type="text" name="lname" value="' . ( isset( $_POST['lname']) ? $last_name : null ) . '">
        </div>
         
        <div>
            <label for="gender">Gender</label>
            <select name="gender" id="gender">
                <option '. ( isset( $_POST["gender"]) ? ( ($gender == 'm') ? 'selected' : '' ) : null) .' value="m">Male</option>
                <option '. ( isset( $_POST["gender"]) ? ( ($gender == 'f') ? 'selected' : '' ) : null) .' value="f">Famale</option>';

    echo'
            </select>
           
        </div>
          
         <div>
            <label for="birthdate">Birthdate</label>
            <input type="text" name="birthdate" value="' . ( isset( $_POST['birthdate']) ? $birthdate : null ) . '">
        </div>

        <div>
            <label for="telephone">Telephone</label>
            <input type="text" name="telephone" value="' . ( isset( $_POST['telephone']) ? $telephone : null ) . '">
        </div>

        <div>
            <label for="availability">Availability</label>
            <input type="text" name="availability" value="' . ( isset( $_POST['availability']) ? $availability : null ) . '">
        </div>

        <div>
            <label for="language">Language</label>
            <select multiple name="language[]" id="language">';
    foreach ($langs as $lang){
        echo '<option '. ( isset( $_POST['language']) ? ( in_array($lang->slug, $language ) ? 'selected' : '' ) : null) .' value="'.$lang->slug.'">' . $lang->name . '</option>';
    }
    echo '
            </select>
        </div>

        <div>
            <label for="destination">Work place</label>
            <select name="destination" id="destination">';
    foreach ($destinations as $desti){
        echo '<option '. ( isset( $_POST['destination']) ?  ( in_array($desti->slug, $destination ) ? 'selected' : '' ) : null) .' value="'.$desti->slug.'">' . $desti->name . '</option>';
    }
    echo '
            </select>
        </div>

        <div>
            <label for="website">Link of youtube <strong>*</strong></label>
            <input type="text" name="website" value="' . ( isset( $_POST['website']) ? $website : null ) . '">
        </div>

        <div>
            <label for="bio">About / Experience</label>
            <textarea name="bio">' . ( isset( $_POST['bio']) ? $bio : null ) . '</textarea>
        </div>

        <div>
            <label for="avatar">Upload Photo</label>
            <input type="file" name="avatar" value="' . ( isset( $_FILES['avatar']) ? $avatar : null ) . '">
        </div>

        <div>
            <label for="cv">Upload CV</label>
            <input type="file" name="cv" value="' . ( isset( $_FILES['cv']) ? $cv : null ) . '">
        </div>';

    echo  '<input type="submit" name="submit" value="Register" class="menu-text fusion-button button-default button-small"/>
    </form>
    ';
}

// Validation of all field of the form
function registration_validation($username, $password, $email, $website, $first_name, $last_name, $bio, $gender, $birthdate, $telephone, $availability, $destination, $language, $avatar, $cv)
{
    global $reg_errors;
    $reg_errors = new WP_Error;

    if (sizeof($language) < 1 || is_null($language))
    {
        $reg_errors->add('select', 'Required select one or most option in language');
    }

    if (empty($username )    || empty($password )   || empty( $email )  || empty($birthdate) || empty($first_name) ||
        empty($last_name)    || empty($last_name)   || empty($bio)       || empty($gender)  ||
        empty($telephone)    || empty($availability) || empty($destination))
    {
        $reg_errors->add('field', 'Required form field is missing');
    }

    if( $avatar['error'] ==! UPLOAD_ERR_OK || $cv['error'] ==! UPLOAD_ERR_OK) {
        $reg_errors->add('file_error', 'Required form FILE is missing or is not valid');
    }

    if ( 4 > strlen( $username ) ) {
        $reg_errors->add( 'username_length', 'Username too short. At least 4 characters is required' );
    }

    if ( username_exists( $username ) )
        $reg_errors->add('user_name', 'Sorry, that username already exists!');

    if ( ! validate_username( $username ) ) {
        $reg_errors->add( 'username_invalid', 'Sorry, the username you entered is not valid' );
    }

    if ( 5 > strlen( $password ) ) {
        $reg_errors->add( 'password', 'Password length must be greater than 5' );
    }

    if ( !is_email( $email ) ) {
        $reg_errors->add( 'email_invalid', 'Email is not valid' );
    }

    if ( email_exists( $email ) ) {
        $reg_errors->add( 'email', 'Email Already in use' );
    }

    if ( ! empty( $website ) ) {
        if ( ! filter_var( $website, FILTER_VALIDATE_URL ) ) {
            $reg_errors->add( 'website', 'Website is not a valid URL' );
        }
    }

    if ( is_wp_error( $reg_errors ) ) {

        foreach ( $reg_errors->get_error_messages() as $error ) {

            echo '<div>';
            echo '<strong>ERROR</strong>:';
            echo $error . '<br/>';
            echo '</div>';

        }

    }
}

function complete_registration() {
    global $reg_errors;
    $reg_errors = new WP_Error;

    global $reg_errors, $username, $password, $email, $website, $first_name, $last_name, $bio, $gender, $birthdate,
           $telephone, $availability, $destination, $language, $avatar, $cv;

    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
        $userdata = array(
            'user_login'    =>   $username,
            'user_email'    =>   $email,
            'user_pass'     =>   $password,
            'user_url'      =>   $website,
            'first_name'    =>   $first_name,
            'last_name'     =>   $last_name,
            'nickname'      =>   $username,
            'description'   =>   $bio,
        );
        $user = wp_insert_user( $userdata );

        add_user_meta( $user, 'gender', $gender );
        add_user_meta( $user, 'birthdate', $birthdate );
        add_user_meta( $user, 'telephone', $telephone );
        add_user_meta( $user, 'availability', $availability );
        add_user_meta( $user, 'destination', $destination );

        $langString = json_encode($language);
        add_user_meta( $user, 'language', $langString );


        $_POST['action'] = 'wp_handle_upload';
        $upload_overrides = array( 'test_form' => false );

        $uploadAvatar = wp_handle_upload( $avatar, $upload_overrides );
        $uploadCV = wp_handle_upload( $cv, $upload_overrides );
        add_user_meta( $user, 'avatar', $uploadAvatar );
        add_user_meta( $user, 'cv', $uploadCV );

        echo 'Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.';
    }
}

function registration_candidate_function() {
    if ( isset($_POST['submit'] ) ) {

        if (count($_POST['language']) > 0){
            echo "is not Error";
        }

        registration_validation(
            $_POST['username'],
            $_POST['password'],
            $_POST['email'],
            $_POST['website,'],
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
            $_FILES['cv']
        );



        // sanitize user form input
        global $username, $password, $email, $website, $first_name, $last_name, $bio, $gender, $birthdate,
               $telephone, $availability, $destination, $language, $avatar, $cv;

        $username       =   sanitize_user( $_POST['username'] );
        $password       =   esc_attr( $_POST['password'] );
        $email          =   sanitize_email( $_POST['email'] );
        $website        =   esc_url( $_POST['website'] );
        $first_name     =   sanitize_text_field( $_POST['fname'] );
        $last_name      =   sanitize_text_field( $_POST['lname'] );
        $bio            =   esc_textarea( $_POST['bio'] );
        $gender         =   sanitize_text_field( $_POST['gender'] );
        $birthdate      =   sanitize_text_field($_POST['birthdate']);
        $telephone      =   sanitize_text_field($_POST['telephone']);
        $availability   =   sanitize_text_field($_POST['availability']);
        $destination    =   sanitize_text_field($_POST['destination']);
        $language       =   $_POST['language'];
        $avatar         =   $_FILES['avatar'];
        $cv             =   $_FILES['cv'];

        // call @function complete_registration to create the user
        // only when no WP_error is found
        complete_registration();
    }

    registration_form(
        $username,
        $password,
        $email,
        $website,
        $first_name,
        $last_name,
        $bio,
        $gender,
        $birthdate,
        $telephone,
        $availability,
        $destination,
        $language,
        $avatar,
        $cv
    );
}

// Register a new shortcode: [user_registration_form_candidate]
add_shortcode( 'user_registration_form_candidate', 'user_registration_candidate_shortcode' );

// The callback function that will replace [book]
function user_registration_candidate_shortcode() {
    ob_start();
    registration_candidate_function();
    return ob_get_clean();
}
