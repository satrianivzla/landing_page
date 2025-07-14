<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth
*
* Version: 2.5.2
*
* Author: Ben Edmunds
*		  ben.edmunds@gmail.com
*         @benedmunds
*
* Added Awesomeness: Phil Sturgeon
*
* Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
*
* Created:  10.01.2009
*
* Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
* Original Author name has been kept but that does not mean that the method has not been modified.
*
* Requirements: PHP5 or above
*
*/

/*
| -------------------------------------------------------------------
|  Ion Auth General Settings
| -------------------------------------------------------------------
|
| These are the settings you can use to customize the Ion Auth library.
|
*/

$config['salt_length']                 = 10;
$config['store_salt']                  = TRUE;
$config['email_activation']            = TRUE;
$config['manual_activation']           = FALSE;
$config['remember_users']              = TRUE;
$config['user_expire']                 = 86500;
$config['user_extend_on_login']        = FALSE;
$config['track_login_attempts']        = TRUE;
$config['maximum_login_attempts']      = 3;
$config['lockout_time']                = 600; /* 10 minutes */
$config['forgot_password_expiration']  = 0;

/*
| -------------------------------------------------------------------
|  Ion Auth Database Settings
| -------------------------------------------------------------------
|
| This is the name of the database table you want to use for user storage.
|
*/

$config['tables']['users']           = 'users';
$config['tables']['groups']          = 'groups';
$config['tables']['users_groups']    = 'users_groups';
$config['tables']['login_attempts']  = 'login_attempts';

/*
| -------------------------------------------------------------------
|  Ion Auth Join Settings
| -------------------------------------------------------------------
|
| This is the name of the join column you want to use for user_groups.
|
*/

$config['join']['users']  = 'user_id';
$config['join']['groups'] = 'group_id';

/*
| -------------------------------------------------------------------
|  Ion Auth Hash Method (bcrypt or argon2)
| -------------------------------------------------------------------
|
| This is the hash method you want to use for password hashing.
|
| Bcrypt is the default, but you can use Argon2 as well.
|
| Argon2 is the new default for PHP 7.2.
|
| You can read more about it here: http://php.net/manual/en/function.password-hash.php
|
*/

$config['hash_method']    = 'bcrypt';	// IMPORTANT: Make sure this is set to either bcrypt or argon2
$config['bcrypt_default_cost'] = 10;		// Set cost according to your server benchmark, see note below
$config['bcrypt_admin_cost']   = 12;

/*
| -------------------------------------------------------------------
|  Ion Auth Email Settings
| -------------------------------------------------------------------
|
| This is the email address and name you want to use for admin emails.
|
*/

$config['admin_email'] = "admin@example.com";
$config['admin_name']  = "Administrator";

/*
| -------------------------------------------------------------------
|  Ion Auth Login Redirect Settings
| -------------------------------------------------------------------
|
| This is the URI to redirect to after a successful login.
|
*/

$config['login_redirect'] = "auth";

/*
| -------------------------------------------------------------------
|  Ion Auth Logout Redirect Settings
| -------------------------------------------------------------------
|
| This is the URI to redirect to after a successful logout.
|
*/

$config['logout_redirect'] = "auth/login";

/*
| -------------------------------------------------------------------
|  Ion Auth Activation Email Settings
| -------------------------------------------------------------------
|
| This is the email template for activation emails.
|
| You can either use a file or a string.
|
| If you use a file, it should be located in the views/auth/email/ directory.
|
*/

$config['email_templates'] = 'auth/email/';

/*
| -------------------------------------------------------------------
|  Ion Auth Delimiters
| -------------------------------------------------------------------
|
| This is the start and end delimiter for error messages and other strings.
|
*/

$config['delimiters_source']       = 'config'; // "config" or "view"
$config['message_start_delimiter'] = '<p>';
$config['message_end_delimiter']   = '</p>';
$config['error_start_delimiter']   = '<p>';
$config['error_end_delimiter']     = '</p>';

/* End of file ion_auth.php */
/* Location: ./application/config/ion_auth.php */
