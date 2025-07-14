<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ion_auth_model extends CI_Model
{
	/**
	 * Holds an array of tables used
	 *
	 * @var array
	 **/
	public $tables = array();

	/**
	 * activation code
	 *
	 * @var string
	 **/
	public $activation_code;

	/**
	 * forgotten password code
	 *
	 * @var string
	 **/
	public $forgotten_password_code;

	/**
	 * new password
	 *
	 * @var string
	 **/
	public $new_password;

	/**
	 * __construct
	 *
	 * @return void
	 * @author Ben
	 **/
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->config('ion_auth', TRUE);
		$this->load->helper('cookie');
		$this->load->helper('date');
		$this->lang->load('ion_auth');

		//initialize the database
		$this->tables = $this->config->item('tables', 'ion_auth');
	}

	/**
	 * forgotten password
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function forgotten_password($identity)
	{
		if (empty($identity))
		{
			$this->trigger_events('post_forgotten_password');
			return FALSE;
		}

		//All some more randomness
		$this->forgotten_password_code = $this->salt();
		$this->activation_code         = $this->salt();

		$this->trigger_events('pre_forgotten_password');

		$update = array(
			'forgotten_password_code' => $this->forgotten_password_code,
			'forgotten_password_time' => time()
		);

		$this->trigger_events('extra_where');
		$this->db->update($this->tables['users'], $update, array($this->config->item('identity', 'ion_auth') => $identity));

		if ($this->db->affected_rows() > 0)
		{
			$this->trigger_events('post_forgotten_password');
			return TRUE;
		}
		else
		{
			$this->trigger_events('post_forgotten_password_unsuccessful');
			return FALSE;
		}
	}

	/**
	 * forgotten_password_complete
	 *
	 * @return string
	 * @author Mathew
	 **/
	public function forgotten_password_complete($code, $salt=FALSE)
	{
		$this->trigger_events('pre_forgotten_password_complete');

		if (empty($code))
		{
			$this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));
			return FALSE;
		}

		$profile = $this->where('forgotten_password_code', $code)->users()->row(); //pass the code to profile

		if ($profile)
		{

			if ($this->config->item('forgot_password_expiration', 'ion_auth') > 0)
			{
				//Make sure it isn't expired
				$expiration = $this->config->item('forgot_password_expiration', 'ion_auth');
				if (time() - $profile->forgotten_password_time > $expiration)
				{
					//it has expired
					$this->set_error('forgot_password_expired');
					$this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));
					return FALSE;
				}
			}

			$password = $this->salt();

			$data = array(
				'password'                => $this->hash_password($password, $salt),
				'forgotten_password_code' => NULL,
				'active'                  => 1,
			);

			$this->db->update($this->tables['users'], $data, array('forgotten_password_code' => $code));

			$this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_successful'));
			return $password;
		}

		$this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));
		return FALSE;
	}


	/**
	 * register
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function register($username, $password, $email, $additional_data=array(), $group_ids = array())
	{
		$this->trigger_events('pre_register');

		$manual_activation = $this->config->item('manual_activation', 'ion_auth');

		if ($this->identity_check($email))
		{
			$this->set_error('account_creation_duplicate_email');
			return FALSE;
		}

		// If username is taken, use username1, username2, etc.
		$original_username = $username;
		$i = 0;
		while($this->username_check($username))
		{
			if($i > 0)
			{
				$username = $original_username . $i;
			}
			$i++;
		}
		$this->trigger_events('extra_where');
		// IP Address
		$ip_address = $this->_prepare_ip($this->input->ip_address());
		$salt       = $this->store_salt ? $this->salt() : FALSE;
		$password   = $this->hash_password($password, $salt);

		// Users table.
		$data = array(
			'username'   => $username,
			'password'   => $password,
			'email'      => $email,
			'ip_address' => $ip_address,
			'created_on' => time(),
			'last_login' => time(),
			'active'     => ($manual_activation === false ? 1 : 0)
		);

		if ($this->store_salt)
		{
			$data['salt'] = $salt;
		}

		if (!is_null($additional_data) && is_array($additional_data))
		{
			$data = array_merge($additional_data, $data);
		}

		$this->trigger_events('extra_set');

		$this->db->insert($this->tables['users'], $data);

		$id = $this->db->insert_id();

		if(!empty($group_ids))
		{
			//add to groups
			foreach ($group_ids as $group_id)
			{
				$this->add_to_group($group_id, $id);
			}
		}

		//add to default group if not already in a group
		if(empty($group_ids))
		{
			$default_group = $this->config->item('default_group', 'ion_auth');
			if(!empty($default_group))
			{
				$this->add_to_group($default_group, $id);
			}
		}

		$this->trigger_events('post_register');

		return (isset($id)) ? $id : FALSE;
	}

	/**
	 * login
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function login($identity, $password, $remember=FALSE)
	{
		$this->trigger_events('pre_login');

		if (empty($identity) || empty($password))
		{
			$this->set_error('login_unsuccessful');
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select($this->config->item('identity', 'ion_auth') . ', username, email, id, password, active, last_login, salt')
		                  ->where($this->config->item('identity', 'ion_auth'), $identity)
		                  ->limit(1)
		                  ->get($this->tables['users']);

		if($this->is_time_locked_out($identity))
		{
			//Hash something anyway, just to take up time
			$this->hash_password($password);

			$this->trigger_events('post_login_unsuccessful');
			$this->set_error('login_timeout');

			return FALSE;
		}

		if ($query->num_rows() === 1)
		{
			$user = $query->row();

			$password = $this->hash_password($password, $user->salt);

			if ($password === $user->password)
			{
				if ($user->active == 0)
				{
					$this->trigger_events('post_login_unsuccessful');
					$this->set_error('login_unsuccessful_not_active');

					return FALSE;
				}

				$this->set_session($user);

				$this->update_last_login($user->id);

				$this->clear_login_attempts($identity);

				if ($remember && $this->config->item('remember_users', 'ion_auth'))
				{
					$this->remember_user($user->id);
				}

				$this->trigger_events(array('post_login', 'post_login_successful'));
				$this->set_message('login_successful');

				return TRUE;
			}
		}

		//Hash something anyway, just to take up time
		$this->hash_password($password);

		$this->increase_login_attempts($identity);

		$this->trigger_events('post_login_unsuccessful');
		$this->set_error('login_unsuccessful');

		return FALSE;
	}

	/**
	 * is_time_locked_out
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function is_time_locked_out($identity)
	{
		return $this->is_max_login_attempts_exceeded($identity) && $this->get_last_attempt_time($identity) > time() - $this->config->item('lockout_time', 'ion_auth');
	}

	/**
	 * get_last_attempt_time
	 *
	 * @return int
	 * @author Ben Edmunds
	 **/
	public function get_last_attempt_time($identity)
	{
		if ($this->config->item('track_login_attempts', 'ion_auth'))
		{
			$ip_address = $this->_prepare_ip($this->input->ip_address());

			$this->db->select('time');
			if ($this->config->item('track_login_ip_address', 'ion_auth'))
				$this->db->where('ip_address', $ip_address);
			else if (strlen($identity) > 0)
				$this->db->or_where('login', $identity);
			$this->db->order_by('id', 'desc');
			$qres = $this->db->get($this->tables['login_attempts'], 1);

			if ($qres->num_rows() > 0)
			{
				return $qres->row()->time;
			}
		}

		return 0;
	}

	/**
	 * get_attempts_num
	 *
	 * @return int
	 * @author Ben Edmunds
	 **/
	public function get_attempts_num($identity)
	{
		if ($this->config->item('track_login_attempts', 'ion_auth'))
		{
			$ip_address = $this->_prepare_ip($this->input->ip_address());
			$this->db->select('1', FALSE);
			if ($this->config->item('track_login_ip_address', 'ion_auth'))
				$this->db->where('ip_address', $ip_address);
			else if (strlen($identity) > 0)
				$this->db->or_where('login', $identity);
			$qres = $this->db->get($this->tables['login_attempts']);
			return $qres->num_rows();
		}
		return 0;
	}

	/**
	 * is_max_login_attempts_exceeded
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function is_max_login_attempts_exceeded($identity)
	{
		if ($this->config->item('track_login_attempts', 'ion_auth'))
		{
			$max_attempts = $this->config->item('maximum_login_attempts', 'ion_auth');
			if ($max_attempts > 0)
			{
				$attempts = $this->get_attempts_num($identity);
				return $attempts >= $max_attempts;
			}
		}
		return FALSE;
	}

	/**
	 * increase_login_attempts
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function increase_login_attempts($identity)
	{
		if ($this->config->item('track_login_attempts', 'ion_auth'))
		{
			$ip_address = $this->_prepare_ip($this->input->ip_address());
			return $this->db->insert($this->tables['login_attempts'], array('ip_address' => $ip_address, 'login' => $identity, 'time' => time()));
		}
		return FALSE;
	}

	/**
	 * clear_login_attempts
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function clear_login_attempts($identity, $expire_period = 86400)
	{
		if ($this->config->item('track_login_attempts', 'ion_auth'))
		{
			$ip_address = $this->_prepare_ip($this->input->ip_address());

			$this->db->where(array('login' => $identity, 'ip_address' => $ip_address));
			// Purge obsolete login attempts
			$this->db->or_where('time <', time() - $expire_period, FALSE);

			return $this->db->delete($this->tables['login_attempts']);
		}
		return FALSE;
	}

	/**
	 * login_remembered_user
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function login_remembered_user()
	{
		$this->trigger_events('pre_login_remembered');

		//check for valid data
		if (!get_cookie('identity') || !get_cookie('remember_code') || !$this->identity_check(get_cookie('identity')))
		{
			$this->trigger_events('post_login_remembered_unsuccessful');
			return FALSE;
		}

		//get the user
		$this->trigger_events('extra_where');
		$query = $this->db->select($this->config->item('identity', 'ion_auth') . ', id, email, last_login, password, salt, active')
						  ->where($this->config->item('identity', 'ion_auth'), get_cookie('identity'))
						  ->limit(1)
						  ->get($this->tables['users']);

		//if the user was found
		if ($query->num_rows() == 1)
		{
			$user = $query->row();

			//check the remember code
			if ($user->remember_code == get_cookie('remember_code'))
			{
				if ($user->active == 0)
				{
					$this->trigger_events('post_login_remembered_unsuccessful');
					return FALSE;
				}

				//set session
				$this->set_session($user);

				//update last login
				$this->update_last_login($user->id);

				//extend the users cookies if the option is enabled
				if ($this->config->item('user_extend_on_login', 'ion_auth'))
				{
					$this->remember_user($user->id);
				}

				$this->trigger_events(array('post_login_remembered', 'post_login_remembered_successful'));
				return TRUE;
			}
		}

		$this->trigger_events('post_login_remembered_unsuccessful');
		return FALSE;
	}

	/**
	 * activate
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function activate($id, $code = false)
	{
		$this->trigger_events('pre_activate');

		if ($code !== FALSE)
		{
			$query = $this->db->select('id')
			                  ->where('activation_code', $code)
			                  ->where('id', $id)
			                  ->limit(1)
			                  ->get($this->tables['users']);

			$result = $query->row();

			if ($query->num_rows() !== 1)
			{
				$this->trigger_events(array('post_activate', 'post_activate_unsuccessful'));
				$this->set_error('activate_unsuccessful');
				return FALSE;
			}

			$data = array(
				'activation_code' => NULL,
				'active'          => 1
			);

			$this->trigger_events('extra_where');
			$this->db->update($this->tables['users'], $data, array('id' => $id));
		}
		else
		{
			$data = array(
				'activation_code' => NULL,
				'active'          => 1
			);

			$this->trigger_events('extra_where');
			$this->db->update($this->tables['users'], $data, array('id' => $id));
		}


		if ($this->db->affected_rows() > 0)
		{
			$this->trigger_events(array('post_activate', 'post_activate_successful'));
			$this->set_message('activate_successful');
		}
		else
		{
			$this->trigger_events(array('post_activate', 'post_activate_unsuccessful'));
			$this->set_error('activate_unsuccessful');
		}

		return $this->db->affected_rows() > 0;
	}

	/**
	 * deactivate
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function deactivate($id = NULL)
	{
		$this->trigger_events('pre_deactivate');

		if (!isset($id))
		{
			$this->set_error('deactivate_unsuccessful');
			return FALSE;
		}

		$activation_code = $this->salt();
		$this->activation_code = $activation_code;

		$data = array(
			'activation_code' => $activation_code,
			'active'          => 0
		);

		$this->trigger_events('extra_where');
		$this->db->update($this->tables['users'], $data, array('id' => $id));

		$return = $this->db->affected_rows() > 0;
		if($return)
		{
			$this->set_message('deactivate_successful');
			$this->trigger_events(array('post_deactivate', 'post_deactivate_successful'));
		}
		else
		{
			$this->set_error('deactivate_unsuccessful');
			$this->trigger_events(array('post_deactivate', 'post_deactivate_unsuccessful'));
		}

		return $return;
	}

	/**
	 * clear_forgotten_password_code
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function clear_forgotten_password_code($code)
	{

		if (empty($code))
		{
			return FALSE;
		}

		$this->db->where('forgotten_password_code', $code);

		if ($this->db->count_all_results($this->tables['users']) > 0)
		{
			$data = array(
				'forgotten_password_code' => NULL,
				'forgotten_password_time' => NULL
			);

			$this->db->update($this->tables['users'], $data, array('forgotten_password_code' => $code));

			return TRUE;
		}

		return FALSE;
	}

	/**
	 * reset_password
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function reset_password($identity, $new)
	{
		$this->trigger_events('pre_reset_password');

		if (!$this->identity_check($identity))
		{
			$this->trigger_events(array('post_reset_password', 'post_reset_password_unsuccessful'));
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select('id, password, salt')
		                  ->where($this->config->item('identity', 'ion_auth'), $identity)
		                  ->limit(1)
		                  ->get($this->tables['users']);

		if ($query->num_rows() !== 1)
		{
			$this->trigger_events(array('post_reset_password', 'post_reset_password_unsuccessful'));
			$this->set_error('password_change_unsuccessful');
			return FALSE;
		}

		$result = $query->row();

		$new = $this->hash_password($new, $result->salt);

		//store the new password and reset the remember code so all remembered instances have to re-login
		$data = array(
			'password'      => $new,
			'remember_code' => NULL,
		);

		$this->trigger_events('extra_where');
		$this->db->update($this->tables['users'], $data, array($this->config->item('identity', 'ion_auth') => $identity));

		$return = $this->db->affected_rows() == 1;
		if ($return)
		{
			$this->trigger_events(array('post_reset_password', 'post_reset_password_successful'));
			$this->set_message('password_change_successful');
		}
		else
		{
			$this->trigger_events(array('post_reset_password', 'post_reset_password_unsuccessful'));
			$this->set_error('password_change_unsuccessful');
		}

		return $return;
	}

	/**
	 * change_password
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function change_password($identity, $old, $new)
	{
		$this->trigger_events('pre_change_password');

		$this->trigger_events('extra_where');

		$query = $this->db->select('id, password, salt')
		                  ->where($this->config->item('identity', 'ion_auth'), $identity)
		                  ->limit(1)
		                  ->get($this->tables['users']);

		if ($query->num_rows() !== 1)
		{
			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
			$this->set_error('password_change_unsuccessful');
			return FALSE;
		}

		$user = $query->row();

		$old_password = $this->hash_password($old, $user->salt);
		if ($old_password === $user->password)
		{
			$new_password = $this->hash_password($new, $user->salt);

			//store the new password and reset the remember code so all remembered instances have to re-login
			$data = array(
				'password'      => $new_password,
				'remember_code' => NULL,
			);

			$this->trigger_events('extra_where');
			$this->db->update($this->tables['users'], $data, array($this->config->item('identity', 'ion_auth') => $identity));

			$return = $this->db->affected_rows() == 1;
			if ($return)
			{
				$this->trigger_events(array('post_change_password', 'post_change_password_successful'));
				$this->set_message('password_change_successful');
			}
			else
			{
				$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
				$this->set_error('password_change_unsuccessful');
			}

			return $return;
		}

		$this->set_error('password_change_unsuccessful');
		return FALSE;
	}

	/**
	 * username_check
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function username_check($username = '')
	{
		$this->trigger_events('username_check');

		if (empty($username))
		{
			return FALSE;
		}

		$this->trigger_events('extra_where');
		return $this->db->where('username', $username)
		                ->count_all_results($this->tables['users']) > 0;
	}

	/**
	 * email_check
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function email_check($email = '')
	{
		$this->trigger_events('email_check');

		if (empty($email))
		{
			return FALSE;
		}

		$this->trigger_events('extra_where');
		return $this->db->where('email', $email)
		                ->count_all_results($this->tables['users']) > 0;
	}

	/**
	 * identity_check
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function identity_check($identity = '')
	{
		$this->trigger_events('identity_check');

		if (empty($identity))
		{
			return FALSE;
		}

		$this->trigger_events('extra_where');

		return $this->db->where($this->config->item('identity', 'ion_auth'), $identity)
		                ->count_all_results($this->tables['users']) > 0;
	}

	/**
	 * get_users_groups
	 *
	 * @return array
	 * @author Ben Edmunds
	 **/
	public function get_users_groups($id=false)
	{
		$this->trigger_events('get_users_group');

		$id || $id = $this->session->userdata('user_id');

		return $this->db->select($this->tables['users_groups'].'.'.$this->config->item('join', 'ion_auth')['groups'].' as id, '.$this->tables['groups'].'.name, '.$this->tables['groups'].'.description')
		                ->where($this->tables['users_groups'].'.'.$this->config->item('join', 'ion_auth')['users'], $id)
		                ->join($this->tables['groups'], $this->tables['users_groups'].'.'.$this->config->item('join', 'ion_auth')['groups'].'='.$this->tables['groups'].'.id')
		                ->get($this->tables['users_groups']);
	}

	/**
	 * add_to_group
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function add_to_group($group_id, $user_id=false)
	{
		$this->trigger_events('add_to_group');

		$user_id || $user_id = $this->session->userdata('user_id');

		$data = array(
			$this->config->item('join', 'ion_auth')['groups'] => $group_id,
			$this->config->item('join', 'ion_auth')['users']  => $user_id
		);

		$this->db->insert($this->tables['users_groups'], $data);

		// log the user's group to the user's group cache
		if(isset($this->_cache_user_in_group[$user_id]))
		{
			$group = $this->group($group_id)->row();
			$this->_cache_user_in_group[$user_id][$group_id] = $group->name;
		}

		$this->trigger_events('post_add_to_group');
		return $this->db->insert_id();
	}

	/**
	 * remove_from_group
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function remove_from_group($group_id=false, $user_id=false)
	{
		$this->trigger_events('remove_from_group');

		if (empty($group_id) && empty($user_id))
		{
			$this->set_error('remove_from_group_failed');
			return FALSE;
		}

		$user_id || $user_id = $this->session->userdata('user_id');

		// if group id is present remove user from this group
		if(!empty($group_id))
		{
			$this->db->delete($this->tables['users_groups'], array($this->config->item('join', 'ion_auth')['groups'] => (int) $group_id, $this->config->item('join', 'ion_auth')['users'] => (int) $user_id));
			if(isset($this->_cache_user_in_group[$user_id]))
			{
				unset($this->_cache_user_in_group[$user_id][(int) $group_id]);
			}
		}
		// if group id isn't present remove user from all groups
		else
		{
			$this->db->delete($this->tables['users_groups'], array($this->config->item('join', 'ion_auth')['users'] => (int) $user_id));
			if(isset($this->_cache_user_in_group[$user_id]))
			{
				$this->_cache_user_in_group[$user_id] = array();
			}
		}

		$this->trigger_events('post_remove_from_group');
		return TRUE;
	}

	/**
	 * groups
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function groups()
	{
		$this->trigger_events('groups');

		//run each where that was passed
		if (isset($this->_where) && !empty($this->_where))
		{
			foreach ($this->_where as $where)
			{
				$this->db->where($where);
			}
			$this->_where = array();
		}

		$this->db->from($this->tables['groups']);

		$this->trigger_events('extra_group_by');

		if (isset($this->_like) && !empty($this->_like))
		{
			foreach ($this->_like as $like)
			{
				$this->db->or_like($like['like'], $like['value'], $like['position']);
			}
			$this->_like = array();
		}

		if (isset($this->_limit) && isset($this->_offset))
		{
			$this->db->limit($this->_limit, $this->_offset);

			$this->_limit  = NULL;
			$this->_offset = NULL;
		}
		else if (isset($this->_limit))
		{
			$this->db->limit($this->_limit);

			$this->_limit  = NULL;
		}

		//set the order
		if (isset($this->_order_by) && isset($this->_order))
		{
			$this->db->order_by($this->_order_by, $this->_order);
		}

		$this->response = $this->db->get();

		return $this;
	}

	/**
	 * group
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function group($id = NULL)
	{
		$this->trigger_events('group');

		if (isset($id))
		{
			$this->db->where($this->tables['groups'].'.id', $id);
		}

		$this->limit(1);

		return $this->groups();
	}

	/**
	 * create_group
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function create_group($group_name = FALSE, $group_description = '')
	{
		$this->trigger_events('create_group');

		// bail if the group name was not passed
		if(!$group_name)
		{
			$this->set_error('group_name_required');
			return FALSE;
		}

		// bail if the group name already exists
		$existing_group = $this->db->get_where($this->tables['groups'], array('name' => $group_name))->num_rows();
		if($existing_group !== 0)
		{
			$this->set_error('group_already_exists');
			return FALSE;
		}

		$data = array('name'=>$group_name, 'description'=>$group_description);

		$this->db->insert($this->tables['groups'], $data);
		$this->trigger_events('post_create_group');

		// return the brand new group id
		return $this->db->insert_id();
	}

	/**
	 * update_group
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function update_group($id = FALSE, $name = FALSE, $description = '')
	{
		$this->trigger_events('update_group');

		$group = $this->group($id)->row();

		// bail if the group name was not passed
		if(!$name || !$group)
		{
			return FALSE;
		}

		// bail if the group name already exists
		$existing_group = $this->db->get_where($this->tables['groups'], array('name' => $name))->row();
		if(isset($existing_group->id) && $existing_group->id != $group->id)
		{
			return FALSE;
		}

		$data = array();
		if($name)
		{
			$data['name'] = $name;
		}
		if($description)
		{
			$data['description'] = $description;
		}


		$this->db->update($this->tables['groups'], $data, array('id'=>$id));
		$this->trigger_events('post_update_group');

		return TRUE;
	}

	/**
	 * delete_group
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function delete_group($id = FALSE)
	{
		// bail if no id given
		if(!$id || empty($id))
		{
			return FALSE;
		}

		$this->trigger_events('pre_delete_group');

		$this->db->delete($this->tables['users_groups'], array($this->config->item('join', 'ion_auth')['groups'] => $id));
		$this->db->delete($this->tables['groups'], array('id' => $id));

		$this->trigger_events('post_delete_group');
		return TRUE;
	}

	/**
	 * user
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function user($id = NULL)
	{
		$this->trigger_events('user');

		//if no id was passed use the current users id
		$id || $id = $this->session->userdata('user_id');

		$this->limit(1);
		$this->where($this->tables['users'].'.id', $id);

		$this->users();

		return $this;
	}


	/**
	 * users
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function users($groups=NULL)
	{
		$this->trigger_events('users');

		if (isset($this->_select) && !empty($this->_select))
		{
			foreach ($this->_select as $select)
			{
				$this->db->select($select);
			}
			$this->_select = array();
		}
		else
		{
			//default selects
			$this->db->select(array(
				$this->tables['users'].'.*',
				$this->tables['users'].'.id as id',
				$this->tables['users'].'.id as user_id'
			));
		}


		//filter by group id(s) if passed
		if (isset($groups))
		{
			//build an array if only one group was passed
			if (!is_array($groups))
			{
				$groups = Array($groups);
			}

			//join and then run a where_in against the group ids
			if (isset($groups) && !empty($groups))
			{
				$this->db->distinct();
				$this->db->join(
					$this->tables['users_groups'],
					$this->tables['users_groups'].'.'.$this->config->item('join', 'ion_auth')['users'].'='.$this->tables['users'].'.id',
					'inner'
				);
			}

			//now we run the where_in
			$this->db->where_in($this->tables['users_groups'].'.'.$this->config->item('join', 'ion_auth')['groups'], $groups);
		}

		//run each where that was passed
		if (isset($this->_where) && !empty($this->_where))
		{
			foreach ($this->_where as $where)
			{
				$this->db->where($where);
			}
			$this->_where = array();
		}

		if (isset($this->_like) && !empty($this->_like))
		{
			foreach ($this->_like as $like)
			{
				$this->db->or_like($like['like'], $like['value'], $like['position']);
			}
			$this->_like = array();
		}

		if (isset($this->_limit) && isset($this->_offset))
		{
			$this->db->limit($this->_limit, $this->_offset);

			$this->_limit  = NULL;
			$this->_offset = NULL;
		}
		else if (isset($this->_limit))
		{
			$this->db->limit($this->_limit);

			$this->_limit  = NULL;
		}

		//set the order
		if (isset($this->_order_by) && isset($this->_order))
		{
			$this->db->order_by($this->_order_by, $this->_order);
		}

		$this->response = $this->db->get($this->tables['users']);

		return $this;
	}

	/**
	 * update
	 *
	 * @return bool
	 * @author Phil Sturgeon
	 **/
	public function update($id, array $data)
	{
		$this->trigger_events('pre_update_user');

		$user = $this->user($id)->row();

		$this->db->trans_begin();

		if (array_key_exists($this->config->item('identity', 'ion_auth'), $data) && $this->identity_check($data[$this->config->item('identity', 'ion_auth')]) && $user->{$this->config->item('identity', 'ion_auth')} !== $data[$this->config->item('identity', 'ion_auth')])
		{
			$this->db->trans_rollback();
			$this->set_error('account_creation_duplicate_identity');

			$this->trigger_events(array('post_update_user', 'post_update_user_unsuccessful'));
			$this->set_error('update_unsuccessful');

			return FALSE;
		}

		//Unset any data which cannot be changed with this method
		unset($data['id']);
		unset($data['ip_address']);

		//If the password is being changed, hash it
		if (array_key_exists('password', $data))
		{
			if ( ! empty($data['password']))
			{
				$data['password'] = $this->hash_password($data['password'], $user->salt);
			}
			else
			{
				//unset password so it doesn't effect database
				unset($data['password']);
			}
		}

		$this->trigger_events('extra_where');
		$this->db->update($this->tables['users'], $data, array('id' => $user->id));

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			$this->trigger_events(array('post_update_user', 'post_update_user_unsuccessful'));
			$this->set_error('update_unsuccessful');
			return FALSE;
		}

		$this->db->trans_commit();

		$this->trigger_events(array('post_update_user', 'post_update_user_successful'));
		$this->set_message('update_successful');
		return TRUE;
	}

	/**
	 * delete_user
	 *
	 * @return bool
	 * @author Phil Sturgeon
	 **/
	public function delete_user($id)
	{
		$this->trigger_events('pre_delete_user');

		$this->db->trans_begin();

		//remove user from groups
		$this->remove_from_group(NULL, $id);

		//delete user from users table should be placed after remove from group
		$this->db->delete($this->tables['users'], array('id' => $id));

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->trigger_events(array('post_delete_user', 'post_delete_user_unsuccessful'));
			$this->set_error('delete_unsuccessful');
			return FALSE;
		}

		$this->db->trans_commit();

		$this->trigger_events(array('post_delete_user', 'post_delete_user_successful'));
		$this->set_message('delete_successful');
		return TRUE;
	}

	/**
	 * update_last_login
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function update_last_login($id)
	{
		$this->trigger_events('update_last_login');

		$this->load->helper('date');

		$this->trigger_events('extra_where');

		$this->db->update($this->tables['users'], array('last_login' => time()), array('id' => $id));

		return $this->db->affected_rows() == 1;
	}

	/**
	 * set_session
	 *
	 * @return bool
	 * @author jrmadsen67
	 **/
	public function set_session($user)
	{
		$this->trigger_events('pre_set_session');

		$session_data = array(
			'identity'             => $user->{$this->config->item('identity', 'ion_auth')},
			'username'             => $user->username,
			'email'                => $user->email,
			'user_id'              => $user->id, //everyone likes user_id instead of id
			'old_last_login'       => $user->last_login
		);

		$this->session->set_userdata($session_data);

		$this->trigger_events('post_set_session');

		return TRUE;
	}

	/**
	 * remember_user
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function remember_user($id)
	{
		$this->trigger_events('pre_remember_user');

		if (!$id)
		{
			return FALSE;
		}

		//if the user was found, create random codes
		$user = $this->user($id)->row();

		$salt = $this->salt();

		$this->db->update($this->tables['users'], array('remember_code' => $salt), array('id' => $id));

		//if the user was found
		if ($this->db->affected_rows() > -1)
		{
			//set the cookies
			$this->trigger_events('post_remember_user');
			set_cookie(array(
				'name'   => 'identity',
				'value'  => $user->{$this->config->item('identity', 'ion_auth')},
				'expire' => $this->config->item('user_expire', 'ion_auth')
			));

			set_cookie(array(
				'name'   => 'remember_code',
				'value'  => $salt,
				'expire' => $this->config->item('user_expire', 'ion_auth')
			));

			return TRUE;
		}

		return FALSE;
	}

	/**
	 * hash_password
	 *
	 * @return
	 * @author Identity Couple
	 **/
	public function hash_password($password, $salt=false, $use_sha1_override=FALSE)
	{
		if (empty($password))
		{
			return FALSE;
		}

		//bcrypt
		if ($use_sha1_override === FALSE && $this->config->item('hash_method', 'ion_auth') == 'bcrypt')
		{
			return $this->bcrypt->hash($password);
		}


		if ($this->store_salt && $salt)
		{
			return  sha1($password . $salt);
		}
		else
		{
			$salt = $this->salt();
			return  $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
		}
	}

	/**
	 * hash_password_db
	 *
	 * @return
	 * @author Phil Sturgeon
	 **/
	public function hash_password_db($id, $password)
	{
		if (empty($id) || empty($password))
		{
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select('password, salt')
		                  ->where('id', $id)
		                  ->limit(1)
		                  ->get($this->tables['users']);

		$hash_password_db = $query->row();

		if ($query->num_rows() !== 1)
		{
			return FALSE;
		}

		//sha1
		if ($this->config->item('hash_method', 'ion_auth') == 'sha1')
		{
			if ($this->store_salt)
			{
				$db_password = sha1($password . $hash_password_db->salt);
			}
			else
			{
				$salt = substr($hash_password_db->password, 0, $this->salt_length);
				$db_password = $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
			}

			if($db_password == $hash_password_db->password)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}

		//bcrypt
		return $this->bcrypt->compare($password, $hash_password_db->password);
	}

	/**
	 * salt
	 *
	 * @return
	 * @author lawrence
	 **/
	public function salt()
	{
		return substr(md5(uniqid(rand(), true)), 0, $this->salt_length);
	}

	/**
	 * row
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function row()
	{
		$this->trigger_events('row');
		return $this->response->row();
	}

	/**
	 * row_array
	 *
	 * @return array
	 * @author Ben Edmunds
	 **/
	public function row_array()
	{
		$this->trigger_events('row_array');
		return $this->response->row_array();
	}

	/**
	 * result
	 *
	 * @return array
	 * @author Ben Edmunds
	 **/
	public function result()
	{
		$this->trigger_events('result');
		return $this->response->result();
	}

	/**
	 * result_array
	 *
	 * @return array
	 * @author Ben Edmunds
	 **/
	public function result_array()
	{
		$this->trigger_events('result_array');
		return $this->response->result_array();
	}

	/**
	 * num_rows
	 *
	 * @return integer
	 * @author Ben Edmunds
	 **/
	public function num_rows()
	{
		$this->trigger_events('num_rows');
		return $this->response->num_rows();
	}

	/**
	 * set_message
	 *
	 * @return
	 * @author Ben Edmunds
	 **/
	public function set_message($message)
	{
		$this->messages[] = $message;

		return $message;
	}

	/**
	 * messages
	 *
	 * @return
	 * @author Ben Edmunds
	 **/
	public function messages()
	{
		$_output = '';
		foreach ($this->messages as $message)
		{
			$messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
			$_output .= $this->message_start_delimiter . $messageLang . $this->message_end_delimiter;
		}

		return $_output;
	}

	/**
	 * set_error
	 *
	 * @return
	 * @author Ben Edmunds
	 **/
	public function set_error($error)
	{
		$this->errors[] = $error;

		return $error;
	}

	/**
	 * errors
	 *
	 * @return
	 * @author Ben Edmunds
	 **/
	public function errors()
	{
		$_output = '';
		foreach ($this->errors as $error)
		{
			$errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
			$_output .= $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;
		}

		return $_output;
	}

	protected function _prepare_ip($ip_address) {
		// just return the string if it's a v4 address
		if (filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
			return $ip_address;
		}
		// சுர発見 v6 addresses, compress them
		if (filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
			return inet_ntop(inet_pton($ip_address));
		}
		// return the original string if it's invalid
		return $ip_address;
	}

}
