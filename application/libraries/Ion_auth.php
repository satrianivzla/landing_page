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

/**
 * Class Ion_auth
 */
class Ion_auth
{
	/**
	 *
	 * @var array
	 */
	public $tables = [];

	/**
	 *
	 * @var array
	 */
	public $join = [];

	/**
	 *
	 * @var array
	 */
	public $hooks = [];

	/**
	 *
	 * @var string
	 */
	public $salt_length = 10;

	/**
	 *
	 * @var boolean
	 */
	public $store_salt = TRUE;

	/**
	 *
	 * @var string
	 */
	public $identity = 'email';

	/**
	 *
	 * @var int
	 */
	public $min_password_length = 8;

	/**
	 *
	 * @var int
	 */
	public $max_password_length = 20;

	/**
	 *
	 * @var boolean
	 */
	public $email_activation = FALSE;

	/**
	 *
	 * @var boolean
	 */
	public $manual_activation = FALSE;

	/**
	 *
	 * @var boolean
	 */
	public $remember_users = TRUE;

	/**
	 *
	 * @var int
	 */
	public $user_expire = 31536000;

	/**
	 *
	 * @var boolean
	 */
	public $user_extend_on_login = FALSE;

	/**
	 *
	 * @var boolean
	 */
	public $track_login_attempts = TRUE;

	/**
	 *
	 * @var boolean
	 */
	public $track_login_ip_address = TRUE;

	/**
	 *
	 * @var int
	 */
	public $maximum_login_attempts = 3;

	/**
	 *
	 * @var int
	 */
	public $lockout_time = 600;

	/**
	 *
	 * @var int
	 */
	public $forgot_password_expiration = 0;

	/**
	 *
	 * @var boolean
	 */
	public $recheck_password = TRUE;

	/**
	 *
	 * @var boolean
	 */
	public $use_ci_email = TRUE;

	/**
	 *
	 * @var string
	 */
	public $email_templates = 'auth/email/';

	/**
	 *
	 * @var string
	 */
	public $email_activate = 'activate.tpl.php';

	/**
	 *
	 * @var string
	 */
	public $email_forgot_password = 'forgot_password.tpl.php';

	/**
	 *
	 * @var string
	 */
	public $email_forgot_password_complete = 'new_password.tpl.php';

	/**
	 *
	 * @var string
	 */
	public $message_start_delimiter = '<p>';

	/**
	 *
	 * @var string
	 */
	public $message_end_delimiter = '</p>';

	/**
	 *
	 * @var string
	 */
	public $error_start_delimiter = '<p>';

	/**
	 *
	 * @var string
	 */
	public $error_end_delimiter = '</p>';

	/**
	 *
	 * @var string
	 */
	public $admin_group = 'admin';

	/**
	 *
	 * @var string
	 */
	public $default_group = 'members';

	/**
	 *
	 * @var string
	 */
	public $admin_email = 'admin@example.com';

	/**
	 *
	 * @var string
	 */
	public $site_title = 'Ion Auth';

	/**
	 *
	 * @var string
	 */
	public $login_redirect = '/';

	/**
	 *
	 * @var string
	 */
	public $logout_redirect = '/';

	/**
	 *
	 * @var string
	 */
	protected $response;

	/**
	 *
	 * @var \CI_Controller
	 */
	protected $ci;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->ci = &get_instance();

		$this->ci->load->config('ion_auth', TRUE);

		$this->tables = $this->ci->config->item('tables', 'ion_auth');
		$this->join = $this->ci->config->item('join', 'ion_auth');
		$this->hooks = $this->ci->config->item('hooks', 'ion_auth');
		$this->salt_length = $this->ci->config->item('salt_length', 'ion_auth');
		$this->store_salt = $this->ci->config->item('store_salt', 'ion_auth');
		$this->identity = $this->ci->config->item('identity', 'ion_auth');
		$this->min_password_length = $this->ci->config->item('min_password_length', 'ion_auth');
		$this->max_password_length = $this->ci->config->item('max_password_length', 'ion_auth');
		$this->email_activation = $this->ci->config->item('email_activation', 'ion_auth');
		$this->manual_activation = $this->ci->config->item('manual_activation', 'ion_auth');
		$this->remember_users = $this->ci->config->item('remember_users', 'ion_auth');
		$this->user_expire = $this->ci->config->item('user_expire', 'ion_auth');
		$this->user_extend_on_login = $this->ci->config->item('user_extend_on_login', 'ion_auth');
		$this->track_login_attempts = $this->ci->config->item('track_login_attempts', 'ion_auth');
		$this->track_login_ip_address = $this->ci->config->item('track_login_ip_address', 'ion_auth');
		$this->maximum_login_attempts = $this->ci->config->item('maximum_login_attempts', 'ion_auth');
		$this->lockout_time = $this->ci->config->item('lockout_time', 'ion_auth');
		$this->forgot_password_expiration = $this->ci->config->item('forgot_password_expiration', 'ion_auth');
		$this->recheck_password = $this->ci->config->item('recheck_password', 'ion_auth');
		$this->use_ci_email = $this->ci->config->item('use_ci_email', 'ion_auth');
		$this->email_templates = $this->ci->config->item('email_templates', 'ion_auth');
		$this->email_activate = $this->ci->config->item('email_activate', 'ion_auth');
		$this->email_forgot_password = $this->ci->config->item('email_forgot_password', 'ion_auth');
		$this->email_forgot_password_complete = $this->ci->config->item('email_forgot_password_complete', 'ion_auth');
		$this->message_start_delimiter = $this->ci->config->item('message_start_delimiter', 'ion_auth');
		$this->message_end_delimiter = $this->ci->config->item('message_end_delimiter', 'ion_auth');
		$this->error_start_delimiter = $this->ci->config->item('error_start_delimiter', 'ion_auth');
		$this->error_end_delimiter = $this->ci->config->item('error_end_delimiter', 'ion_auth');
		$this->admin_group = $this->ci->config->item('admin_group', 'ion_auth');
		$this->default_group = $this->ci->config->item('default_group', 'ion_auth');
		$this->admin_email = $this->ci->config->item('admin_email', 'ion_auth');
		$this->site_title = $this->ci->config->item('site_title', 'ion_auth');
		$this->login_redirect = $this->ci->config->item('login_redirect', 'ion_auth');
		$this->logout_redirect = $this->ci->config->item('logout_redirect', 'ion_auth');

		$this->ci->load->model('ion_auth_model');

		$this->ci->load->helper('cookie');
		$this->ci->load->helper('date');

		if ($this->use_ci_email)
		{
			$this->ci->load->library('email');
		}

		$this->ci->lang->load('ion_auth');

		// auto-login the user if they are remembered
		if ($this->remember_users && !$this->logged_in() && get_cookie('identity') && get_cookie('remember_code'))
		{
			$this->ci->ion_auth_model->login_remembered_user();
		}

		$this->ci->ion_auth_model->trigger_events('library_constructor');
	}

	/**
	 *
	 * @param $method
	 * @param $arguments
	 *
	 * @return mixed
	 */
	public function __call($method, $arguments)
	{
		if (!method_exists($this->ci->ion_auth_model, $method))
		{
			throw new Exception('Undefined method Ion_auth::' . $method . '() called');
		}

		return call_user_func_array([$this->ci->ion_auth_model, $method], $arguments);
	}

	/**
	 *
	 * @param string $identity
	 *
	 * @return boolean
	 */
	public function forgotten_password($identity)
	{
		if ($this->ci->ion_auth_model->forgotten_password($identity))
		{
			// get user information
			$user = $this->where($this->identity, $identity)->where('active', 1)->users()->row();

			if ($user)
			{
				$data = [
					'identity'                => $user->{$this->identity},
					'forgotten_password_code' => $user->forgotten_password_code,
				];

				if (!$this->use_ci_email)
				{
					$this->set_message('forgot_password_successful');
					return $data;
				}
				else
				{
					$message = $this->ci->load->view($this->email_templates . $this->email_forgot_password, $data, TRUE);
					$this->ci->email->clear();
					$this->ci->email->from($this->admin_email, $this->site_title);
					$this->ci->email->to($user->email);
					$this->ci->email->subject($this->site_title . ' - ' . $this->ci->lang->line('email_forgotten_password_subject'));
					$this->ci->email->message($message);

					if ($this->ci->email->send())
					{
						$this->set_message('forgot_password_successful');
						return TRUE;
					}
				}
			}
		}

		$this->set_error('forgot_password_unsuccessful');
		return FALSE;
	}

	/**
	 *
	 * @param string $code
	 *
	 * @return boolean
	 */
	public function forgotten_password_complete($code)
	{
		$this->ci->ion_auth_model->trigger_events('pre_password_change');

		$profile = $this->where('forgotten_password_code', $code)->users()->row(); //pass the code to profile

		if (!$profile)
		{
			$this->ci->ion_auth_model->trigger_events(['post_password_change', 'password_change_unsuccessful']);
			$this->set_error('password_change_unsuccessful');
			return FALSE;
		}

		$new_password = $this->ci->ion_auth_model->forgotten_password_complete($code);

		if ($new_password)
		{
			$data = [
				'identity'     => $profile->{$this->identity},
				'new_password' => $new_password,
			];
			if (!$this->use_ci_email)
			{
				$this->set_message('password_change_successful');
				$this->ci->ion_auth_model->trigger_events(['post_password_change', 'password_change_successful']);
				return $data;
			}
			else
			{
				$message = $this->ci->load->view($this->email_templates . $this->email_forgot_password_complete, $data, TRUE);

				$this->ci->email->clear();
				$this->ci->email->from($this->admin_email, $this->site_title);
				$this->ci->email->to($profile->email);
				$this->ci->email->subject($this->site_title . ' - ' . $this->ci->lang->line('email_new_password_subject'));
				$this->ci->email->message($message);

				if ($this->ci->email->send())
				{
					$this->set_message('password_change_successful');
					$this->ci->ion_auth_model->trigger_events(['post_password_change', 'password_change_successful']);
					return TRUE;
				}
			}
		}

		$this->ci->ion_auth_model->trigger_events(['post_password_change', 'password_change_unsuccessful']);
		return FALSE;
	}

	/**
	 *
	 * @param string $identity
	 * @param string $password
	 * @param string $email
	 * @param array  $additional_data
	 * @param array  $groups
	 *
	 * @return int|boolean
	 */
	public function register($identity, $password, $email, $additional_data = [], $groups = [])
	{
		$this->ci->ion_auth_model->trigger_events('pre_account_creation');

		$id = $this->ci->ion_auth_model->register($identity, $password, $email, $additional_data, $groups);

		if (!$id)
		{
			$this->set_error('account_creation_unsuccessful');
			return FALSE;
		}

		if ($this->email_activation)
		{
			$deactivate = $this->deactivate($id);

			if (!$deactivate)
			{
				$this->set_error('deactivate_unsuccessful');
				return FALSE;
			}

			$activation_code = $this->ci->ion_auth_model->activation_code;
			$identity        = $this->identity;
			$user            = $this->user($id)->row();

			$data = [
				'identity'   => $user->{$identity},
				'id'         => $user->id,
				'email'      => $email,
				'activation' => $activation_code,
			];
			if (!$this->use_ci_email)
			{
				$this->ci->ion_auth_model->trigger_events(['post_account_creation', 'post_account_creation_successful', 'activation_email_successful']);
				$this->set_message('activation_email_successful');
				return $data;
			}
			else
			{
				$message = $this->ci->load->view($this->email_templates . $this->email_activate, $data, TRUE);
				$this->ci->email->clear();
				$this->ci->email->from($this->admin_email, $this->site_title);
				$this->ci->email->to($email);
				$this->ci->email->subject($this->site_title . ' - ' . $this->ci->lang->line('email_activation_subject'));
				$this->ci->email->message($message);

				if ($this->ci->email->send())
				{
					$this->ci->ion_auth_model->trigger_events(['post_account_creation', 'post_account_creation_successful', 'activation_email_successful']);
					$this->set_message('activation_email_successful');
					return $id;
				}
			}
		}
		else
		{
			$this->ci->ion_auth_model->trigger_events(['post_account_creation', 'post_account_creation_successful']);
			$this->set_message('account_creation_successful');
			return $id;
		}

		$this->ci->ion_auth_model->trigger_events(['post_account_creation', 'post_account_creation_unsuccessful', 'activation_email_unsuccessful']);
		$this->set_error('activation_email_unsuccessful');
		return FALSE;
	}

	/**
	 *
	 * @return boolean
	 */
	public function logged_in()
	{
		$this->ci->ion_auth_model->trigger_events('logged_in');

		return (bool)$this->ci->session->userdata('identity');
	}

	/**
	 *
	 * @param int $id
	 *
	 * @return boolean
	 */
	public function is_admin($id = FALSE)
	{
		$this->ci->ion_auth_model->trigger_events('is_admin');

		return $this->in_group($this->admin_group, $id);
	}

	/**
	 *
	 * @param string|array $check_group
	 * @param int          $id
	 * @param boolean      $check_all
	 *
	 * @return boolean
	 */
	public function in_group($check_group, $id = FALSE, $check_all = FALSE)
	{
		$this->ci->ion_auth_model->trigger_events('in_group');

		$id || $id = $this->ci->session->userdata('user_id');

		if (!is_array($check_group))
		{
			$check_group = [$check_group];
		}

		if (isset($this->_cache_user_in_group[$id]))
		{
			$groups_array = $this->_cache_user_in_group[$id];
		}
		else
		{
			$users_groups = $this->ci->ion_auth_model->get_users_groups($id)->result();
			$groups_array = [];
			foreach ($users_groups as $group)
			{
				$groups_array[$group->id] = $group->name;
			}
			$this->_cache_user_in_group[$id] = $groups_array;
		}
		foreach ($check_group as $key => $value)
		{
			$groups = (is_string($value)) ? $groups_array : array_keys($groups_array);

			/**
			 * if !all (default), in_array
			 * if all, !in_array
			 */
			if (in_array($value, $groups) xor $check_all)
			{
				/**
				 * if !all (default), found group, return true
				 * if all, found group, return false
				 */
				return !$check_all;
			}
		}

		/**
		 * if !all (default), not found group, return false
		 * if all, not found group, return true
		 */
		return $check_all;
	}
}
