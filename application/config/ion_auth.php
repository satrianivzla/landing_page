<?php
/**
 * Name:    Ion Auth
 * Author:  Ben Edmunds
 *           ben.edmunds@gmail.com
 *           @benedmunds
 *
 * Added Awesomeness: Phil Sturgeon
 *
 * Created:  10.01.2009
 *
 * Description:  Modified auth system based on redux_auth with extensive customization. This is basically what Redux Auth 2 should be.
 * Original Author name has been kept but that does not mean that the method has not been modified.
 *
 * Requirements: PHP 7.2 or above
 *
 * @package    CodeIgniter-Ion-Auth
 * @author     Ben Edmunds
 * @link       http://github.com/benedmunds/CodeIgniter-Ion-Auth
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Database group name option.
| -------------------------------------------------------------------------
| Allows to select a specific group for the database connection
|
| Default is empty; so it will use the default group:
| $config['database_group_name'] = 'special_db_group';
|
*/
$config['database_group_name'] = '';

/*
| -------------------------------------------------------------------------
| Tables.
| -------------------------------------------------------------------------
| Database table names.
*/
$config['tables']['users']           = 'users';
$config['tables']['groups']          = 'groups';
$config['tables']['users_groups']    = 'users_groups';
$config['tables']['login_attempts']  = 'login_attempts';

/*
| -------------------------------------------------------------------------
| JOIN ON
| -------------------------------------------------------------------------
| Joins from users table to other tables.
| This is not used in queries where the join table is already specified.
|
| Joins from users table to other tables.
| Tables and joining conditions.
|
| -------------------------------------------------------------------------
| id:           The id of the user in the users table.
| email:        The email of the user in the users table.
|
| Joins to users table, for example:
| $config['join']['meta'] = array('meta.user_id' => 'users.id');
|
*/
$config['join']['users']  = 'user_id';
$config['join']['groups'] = 'group_id';

/*
 | -------------------------------------------------------------------------
 | Hash Method (bcrypt or argon2)
 | -------------------------------------------------------------------------
 | Bcrypt is available in PHP 5.3+
 | Argon2 is available in PHP 7.2+
 |
 | Argon2 is recommended by OWASP as of 2018
 |
 | See: https://www.php.net/manual/en/function.password-hash.php
 |
 | A note on server load:
 |
 | The cost parameter will affect server load. The cost parameter should be set as high as possible.
 | The step up from 10 to 11 is huge in terms of server load, so you should test a value that you can live with.
 |
 | A value of 10 is a good baseline. If you want to increase this value, I would recommend one step at a time.
 |
 | Valid range for bcrypt is 4-31.
 |
 | Valid range for argon2 is 1-2147483647.
 |
 | The argon2 parameters should be set within the following ranges:
 | - memory_cost (default 65536)
 | - time_cost (default 4)
 | - threads (default 1)
 */
$config['hash_method'] = 'bcrypt'; // bcrypt or argon2
$config['bcrypt_default_cost'] = 10;
$config['argon2_default_params'] = [
    'memory_cost' => 65536,
    'time_cost'   => 4,
    'threads'     => 1
];

/*
 | -------------------------------------------------------------------------
 | Identity
 | -------------------------------------------------------------------------
 | You can use any unique column in your users table as identity column.
 | IMPORTANT: If you are changing it from the default (email), update the UNIQUE constraint in your database.
 |
 | Default: 'email'
 */
$config['identity'] = 'email';

/*
 | -------------------------------------------------------------------------
 | Minimum Password Length
 | -------------------------------------------------------------------------
 |
 | Default: 8
 */
$config['min_password_length'] = 8;

/*
 | -------------------------------------------------------------------------
 | Maximum Password Length
 | -------------------------------------------------------------------------
 |
 | Default: 20
 */
$config['max_password_length'] = 20;

/*
 | -------------------------------------------------------------------------
 | Email Activation
 | -------------------------------------------------------------------------
 | Email activation ensures that new users verify their email address before they can log in.
 | The newly created user will receive an email with a link to activate their account.
 | The link will look like this: http://example.com/auth/activate/1/2205030116
 |
 | Default: FALSE
 |
 | You can also send the activation email in a background process.
 | To do this, set 'email_activation_in_background' to TRUE.
 | This will add a job to the CodeIgniter queue library.
 |
 */
$config['email_activation'] = FALSE;
$config['email_activation_in_background'] = FALSE;

/*
 | -------------------------------------------------------------------------
 | Manual Activation
 | -------------------------------------------------------------------------
 | Manual activation means that an administrator has to manually activate the user.
 | This is useful for websites where you want to control who can access the website.
 |
 | Default: FALSE
 */
$config['manual_activation'] = FALSE;

/*
 | -------------------------------------------------------------------------
 | Remember Me
 | -------------------------------------------------------------------------
 | Allow users to be remembered and stay logged in from one visit to the next.
 |
 | Default: TRUE
 */
$config['remember_users'] = TRUE;

/*
 | -------------------------------------------------------------------------
 | Remember Me Time
 | -------------------------------------------------------------------------
 | The time in seconds that a user will be remembered for.
 |
 | Default: 31536000 (1 year)
 */
$config['user_expire'] = 31536000;

/*
 | -------------------------------------------------------------------------
 | Extend on login
 | -------------------------------------------------------------------------
 | Each time a user logs in, their expiry time will be extended by the value of 'user_expire'.
 | This will keep the user logged in indefinitely as long as they keep logging in.
 |
 | Default: FALSE
 */
$config['user_extend_on_login'] = FALSE;

/*
 | -------------------------------------------------------------------------
 | Track Login Attempts
 | -------------------------------------------------------------------------
 | Track the number of failed login attempts for each user.
 | If the number of failed login attempts exceeds the value of 'maximum_login_attempts',
 | the user will be locked out for the amount of time specified in 'lockout_time'.
 |
 | Default: TRUE
 */
$config['track_login_attempts'] = TRUE;

/*
 | -------------------------------------------------------------------------
 | Track Login IP Address
 | -------------------------------------------------------------------------
 | Track the IP address of the user for each login attempt.
 |
 | Default: TRUE
 */
$config['track_login_ip_address'] = TRUE;

/*
 | -------------------------------------------------------------------------
 | Maximum Login Attempts
 | -------------------------------------------------------------------------
 | The maximum number of failed login attempts a user can make before they are locked out.
 |
 | Default: 3
 */
$config['maximum_login_attempts'] = 3;

/*
 | -------------------------------------------------------------------------
 | Lockout Time
 | -------------------------------------------------------------------------
 | The time in seconds a user will be locked out for after they have exceeded the
 | maximum number of failed login attempts.
 |
 | Default: 600 (10 minutes)
 */
$config['lockout_time'] = 600;

/*
 | -------------------------------------------------------------------------
 | Forgot Password Email
 | -------------------------------------------------------------------------
 | The time in seconds that a forgot password email will be valid for.
 |
 | Default: 86400 (1 day)
 */
$config['forgot_password_expiration'] = 86400;

/*
 | -------------------------------------------------------------------------
 | Recheck Password
 | -------------------------------------------------------------------------
 | When changing a password, check if the old password is correct.
 |
 | Default: TRUE
 */
$config['recheck_password'] = TRUE;

/*
 | -------------------------------------------------------------------------
 | Use CI Email
 | -------------------------------------------------------------------------
 | Send emails using the CodeIgniter Email library.
 |
 | Default: TRUE
 */
$config['use_ci_email'] = TRUE;

/*
 | -------------------------------------------------------------------------
 | Email Settings.
 | -------------------------------------------------------------------------
 | The 'email_templates' setting is the path to the email templates.
 |
 | The 'email_activate', 'email_forgot_password' and 'email_forgot_password_complete'
 | settings are the names of the email templates to use for each email.
 */
$config['email_templates'] = 'auth/email/';
$config['email_activate'] = 'activate.tpl.php';
$config['email_forgot_password'] = 'forgot_password.tpl.php';
$config['email_forgot_password_complete'] = 'new_password.tpl.php';

/*
 | -------------------------------------------------------------------------
 | Salt Length
 | -------------------------------------------------------------------------
 | The length of the salt to use for hashing.
 |
 | Default: 10
 */
$config['salt_length'] = 10;

/*
 | -------------------------------------------------------------------------
 | Store Salt
 | -------------------------------------------------------------------------
 | Should the salt be stored in the database?
 | This will change your password encryption algorithm, so you should not change this after you have users created.
 |
 | Default: TRUE
 */
$config['store_salt'] = TRUE;

/*
 | -------------------------------------------------------------------------
 | Message Delimiters.
 | -------------------------------------------------------------------------
 */
$config['delimiters_source']       = 'config';
$config['message_start_delimiter'] = '<p>';
$config['message_end_delimiter']   = '</p>';
$config['error_start_delimiter']   = '<p>';
$config['error_end_delimiter']     = '</p>';

/*
 | -------------------------------------------------------------------------
 | Admin Group
 | -------------------------------------------------------------------------
 | The name of the group that has administrator privileges.
 |
 | Default: 'admin'
 */
$config['admin_group'] = 'admin';

/*
 | -------------------------------------------------------------------------
 | Default Group
 | -------------------------------------------------------------------------
 | The name of the group that new users will be added to.
 |
 | Default: 'members'
 */
$config['default_group'] = 'members';

/*
 | -------------------------------------------------------------------------
 | Admin Email
 | -------------------------------------------------------------------------
 | The email address of the administrator.
 |
 | Default: 'admin@example.com'
 */
$config['admin_email'] = 'admin@example.com';

/*
 | -------------------------------------------------------------------------
 | Site Title
 | -------------------------------------------------------------------------
 | The title of your website.
 |
 | Default: 'Ion Auth'
 */
$config['site_title'] = 'Ion Auth';

/*
 | -------------------------------------------------------------------------
 | Login Redirect
 | -------------------------------------------------------------------------
 | The URI to redirect to after a successful login.
 |
 | Default: '/'
 */
$config['login_redirect'] = '/';

/*
 | -------------------------------------------------------------------------
 | Logout Redirect
 | -------------------------------------------------------------------------
 | The URI to redirect to after a successful logout.
 |
 | Default: '/'
 */
$config['logout_redirect'] = '/';

/*
 | -------------------------------------------------------------------------
 | Hooks
 | -------------------------------------------------------------------------
 | Allows you to execute a function before or after certain events.
 |
 | For example, you could send a welcome email to a new user after they have registered.
 |
 | Prototype:
 | $config['hooks']['post_account_creation'] = array(
 |     'class'    => 'My_class',
 |     'function' => 'post_account_creation',
 |     'params'   => array('param1', 'param2')
 | );
 */
$config['hooks'] = array();

/*
 | -------------------------------------------------------------------------
 | Groups
 | -------------------------------------------------------------------------
 | A list of groups to automatically create when the library is installed.
 |
 | Prototype:
 | $config['groups'] = array(
 |     'group_name' => 'group_description',
 | );
 */
$config['groups'] = array(
	'admin' => 'Administrator',
	'members'  => 'General User'
);

/*
 | -------------------------------------------------------------------------
 | Users
 | -------------------------------------------------------------------------
 | A list of users to automatically create when the library is installed.
 |
 | Prototype:
 | $config['users'] = array(
 |     array(
 |         'username' => 'username',
 |         'password' => 'password',
 |         'email'    => 'email',
 |         'group'    => 'group_name'
 |     )
 | );
 */
$config['users'] = array(
	array(
		'username' => 'administrator',
		'password' => 'password',
		'email'    => 'admin@admin.com',
		'group'    => 'admin'
	)
);
