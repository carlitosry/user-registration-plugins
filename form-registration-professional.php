<?php
/**
 * Created by PhpStorm.
 * User: @Carlitosry
 * Date: 22/04/18
 * Time: 7:21 PM
 */

session_start();
$_SESSION['captcha'] = simple_php_captcha();

function registration_form_professional($username, $password, $email, $first_name, $last_name, $telephone, $company) {

// FORM OF COMPANY

    echo '
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post" enctype="multipart/form-data" class="form-registration-user">
        <div>
            <label for="username">Nombre de Usuario <strong>*</strong></label>
            <input type="text" name="username" value="' . ( isset( $_POST['username'] ) ? $username : null ) . '">
        </div>
            
        <div>
            <label for="email">Email <strong>*</strong></label>
            <input type="text" name="email" value="' . ( isset( $_POST['email']) ? $email : null ) . '">
        </div>
     
        <div>
            <label for="password">Contraseña <strong>*</strong></label>
            <input type="password" name="password" value="' . ( isset( $_POST['password'] ) ? $password : null ) . '">
        </div>
         
        <div>
            <label for="company">Nombre de la Empresa</label>
            <input type="text" name="company" value="' . ( isset( $_POST['company']) ? $company : null ) . '">
        </div>
        
        <div>
            <label for="firstname">Nombre de la persona de Contacto </label>
            <input type="text" name="fname" value="' . ( isset( $_POST['fname']) ? $first_name : null ) . '">
        </div>
         
        <div>
            <label for="lname">Apellido de la persona de Contacto</label>
            <input type="text" name="lname" value="' . ( isset( $_POST['lname']) ? $last_name : null ) . '">
        </div>

        <div>
            <label for="telephone">Teléfono</label>
            <input type="text" name="telephone" value="' . ( isset( $_POST['telephone']) ? $telephone : null ) . '">
        </div>
        
        <div>  
            <label for="captcha">Ingrese los caracteres de la imagen</label>
            <input type="text" name="captcha">    
            <img src="'.$_SESSION['captcha']['image_src'].'">
        </div>
       
        <input type="hidden" name="diferentedihidden" value="'. $_SESSION['captcha']['code'] .'">
        
        <input type="submit" name="submit" value="Register" class="menu-text fusion-button button-default button-small"/>
    </form>
    ';
}

// Validation of all field of the form
function registration_professional_validation($username, $password, $email, $first_name, $last_name, $telephone, $company, $captcha, $diferentedihidden)
{
    global $reg_errors;
    $reg_errors = new WP_Error;

    if( strtolower($captcha) != strtolower($diferentedihidden)){
        $reg_errors->add('captcha', "the code entered is invalid");
    }

    if (empty($username ) || empty($password )  || empty( $email ) || empty($first_name) ||
        empty($last_name) || empty($telephone)  || empty($company) )
    {
        $reg_errors->add('field', 'Required form field is missing');
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


    if ( is_wp_error( $reg_errors ) ) {

        foreach ( $reg_errors->get_error_messages() as $error ) {

            echo '<div>';
            echo '<strong>ERROR</strong>:';
            echo $error . '<br/>';
            echo '</div>';

        }
        return true;
    }
    return true;
}


function complete_registration_professional() {
    global $reg_errors;
    $reg_errors = new WP_Error;

    global $reg_errors, $username, $password, $email, $first_name, $last_name, $telephone, $company;

    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
        $userdata = array(
            'user_login'    =>   $username,
            'user_email'    =>   $email,
            'user_pass'     =>   $password,
            'first_name'    =>   $first_name,
            'last_name'     =>   $last_name,
            'nickname'      =>   $username,
            'role'          =>   'profesional',
        );
        $user = wp_insert_user( $userdata );

        add_user_meta( $user, 'company', $company );
        add_user_meta( $user, 'telephone', $telephone );

        send_email_after_signup($user);


        echo 'Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.';
    }
}


function registration_professional_function() {
    if ( isset($_POST['submit'] ) ) {

        $isValid = registration_professional_validation(
            $_POST['username'],
            $_POST['password'],
            $_POST['email'],
            $_POST['fname'],
            $_POST['lname'],
            $_POST['telephone'],
            $_POST['company'],
            $_POST['captcha'],
            $_POST['diferentedihidden']
        );


        // sanitize user form input
        global $username, $password, $email, $first_name, $last_name, $telephone, $company;

        $username       =   sanitize_user( $_POST['username'] );
        $password       =   esc_attr( $_POST['password'] );
        $email          =   sanitize_email( $_POST['email'] );
        $first_name     =   sanitize_text_field( $_POST['fname'] );
        $last_name      =   sanitize_text_field( $_POST['lname'] );
        $telephone      =   sanitize_text_field($_POST['telephone']);
        $company      =   sanitize_text_field($_POST['company']);

        // call @function complete_registration_professional to create the user
        // only when no WP_error is found
        if($isValid){
            complete_registration_professional();
        }
    }

    registration_form_professional(
        $username, $password, $email, $first_name, $last_name, $telephone, $company
    );
}

// Register a new shortcode: [user_registration_form_candidate]
add_shortcode( 'user_registration_form_professional', 'user_registration_professional_shortcode' );

// The callback function that will replace [book]
function user_registration_professional_shortcode() {
    ob_start();
    registration_professional_function();
    return ob_get_clean();
}