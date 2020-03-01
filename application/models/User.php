<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model
{
    const TABLE_NAME = 'user';
    private static $USER_SALT = "'v(=3`l|ZT/DnovezF50w37J|c}--f?BoQw.b!7??~]#NC0xw# |[S)<CN_;;%aJy')";
    private $id;
    private $username;
    private $email;
    private $first_name;
    private $last_name;
    private $password;
    
    public function __construct($data = false)
    {
        parent::__construct();
        // assume data can be an existing row or a new one
        if (is_numeric($data)) {
            return $this->get_where([['column' => 'id', 'value' => $data]]);
        } elseif (is_object($data)) {
            return $this->load($data);
        }
    }
    
    public function get_where($where = [])
    {
        $query = $this->db;
        foreach ($where as $where_clause) {
            $query->where($where_clause['column'], $where_clause['value']);
        }
        $test = $query->get(self::TABLE_NAME)->row();
        
        return $this->load($test);
    }
    
    public function load($data, $prefix = '')
    {
        foreach ($data as $key => $value) {
            $object_key = str_replace($prefix, '', $key);
            // Ensure the property exists and can be changed
            if (property_exists($this, $object_key) && method_exists($this, "set_{$object_key}")) {
                $this->{"set_{$object_key}"}($value);
            }
        }
        
        return $this;
    }
    
    public static function validate_login($email, $password)
    {
        $result = get_instance()->db->where('email', $email)->where('password', self::hash_password($password))->get(self::TABLE_NAME);
        if ($result->num_rows() === 1) {
            return $result->row()->id;
        } else {
            return false;
        }
    }
    
    public static function hash_password($password)
    {
        return hash('sha256', $password.self::$USER_SALT);
    }
    
    public function save()
    {
        if ($this->id) {
            $this->update();
        } else {
            $this->insert();
        }
        
        return $this;
    }
    
    private function update()
    {
        $this->db->set($this->instance())->update(self::TABLE_NAME, $this)->where('id', $this->id);
    }
    
    public function instance()
    {
        $instance = [];
        // Only return properties that have a value, and are allowed to be accessed via public function (checked via method_exists)
        foreach (get_object_vars($this) as $key => $property) {
            if ($this->{$key} && method_exists($this, "get_{$key}")) {
                $instance[$key] = $this->{"get_{$key}"}();
            }
        }
        
        return $instance;
    }
    
    private function insert()
    {
        $this->db->set($this->instance())->insert(self::TABLE_NAME);
        $this->set_id($this->db->insert_id());
    }
    
    private function set_id($id)
    {
        $this->id = $id;
    }
    
    /**
     * @return mixed
     */
    public function get_id()
    {
        return $this->id;
    }
    
    /**
     * @return mixed
     */
    public function get_username()
    {
        return $this->username;
    }
    
    /**
     * @param mixed $username
     */
    public function set_username($username)
    {
        $this->username = $username;
    }
    
    /**
     * @return mixed
     */
    public function get_email()
    {
        return $this->email;
    }
    
    /**
     * @param mixed $email
     */
    public function set_email($email)
    {
        $this->email = $email;
    }
    
    /**
     * @return mixed
     */
    public function get_first_name()
    {
        return $this->first_name;
    }
    
    /**
     * @param mixed $first_name
     */
    public function set_first_name($first_name)
    {
        $this->first_name = $first_name;
    }
    
    /**
     * @return mixed
     */
    public function get_last_name()
    {
        return $this->last_name;
    }
    
    /**
     * @param mixed $last_name
     */
    public function set_last_name($last_name)
    {
        $this->last_name = $last_name;
    }
    
    /**
     * @return mixed
     */
    public function get_password()
    {
        return $this->password;
    }
    
    public function get($limit = 10)
    {
        $query = $this->db->get('users', $limit);
        
        return $query->result();
    }
    
    public function get_user($where = [])
    {
        $query = $this->db;
        foreach ($where as $where_clause) {
            $query->where($where_clause['column'], $where_clause['value']);
        }
        
        return $query->get(self::TABLE_NAME)->result();
    }
    
    public function add_new_user($data)
    {
        $insert['first_name'] = $data['register_first_name'];
        $insert['last_name'] = $data['register_last_name'];
        $insert['username'] = $data['register_username'];
        $insert['email'] = $data['register_email'];
        $insert['password'] = hash('sha256', "{$data['register_password']} ".self::$USER_SALT);
        $this->db->insert(self::TABLE_NAME, $insert);
        $insert['id'] = $this->db->insert_id();
        
        return $insert;
    }
    
    private function set_password($password)
    {
        $this->password = $password;
    }
    
}