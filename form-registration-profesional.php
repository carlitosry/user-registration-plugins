<?php
/**
 * Created by PhpStorm.
 * User: @Carlitosry
 * Date: 22/04/18
 * Time: 7:21 PM
 */


function registration_form($username, $password, $email, $first_name, $last_name, $telephone, $company) {

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
        
        <input type="submit" name="submit" value="Register" class="menu-text fusion-button button-default button-small"/>
    </form>
    ';
}

// Validation of all field of the form
function registration_validation($username, $password, $email, $first_name, $last_name, $telephone)
{
    global $reg_errors;
    $reg_errors = new WP_Error;


    if (empty($username )    || empty($password )   || empty( $email ) || empty($first_name) ||
        empty($last_name)    || empty($telephone)    || empty($company) )
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

    }
}
