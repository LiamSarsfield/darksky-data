<?php

class Darksky_data extends CI_Model
{
    const TABLE_NAME = 'darksky_data';
    private $id;
    private $user_id;
    private $user;
    private $lat;
    private $lng;
    private $date_requested;
    private $time;
    private $summary;
    private $icon;
    private $sunrise_time;
    private $sunset_time;
    private $temp_high;
    private $temp_low;
    private $dewpoint;
    private $humidity;
    private $pressure;
    private $windspeed;
    private $visibility;
    
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
        
        return $this->load($query->get(self::TABLE_NAME)->row());
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
    
    public static function get_datatable($filter)
    {
        $CI =& get_instance();
        $query = $CI->db;
        $columns = ['user.username', self::TABLE_NAME.'.lat', self::TABLE_NAME.'.lng', self::TABLE_NAME.'.date_requested'];
        $query->select('SQL_CALC_FOUND_ROWS '.self::TABLE_NAME.'.id', false)->select($columns)->from(self::TABLE_NAME)->join('user', 'darksky_data.user_id = user.id', 'inner');
        if (!empty($filter['search']['value'])) {
            $query->group_start();
            foreach ($columns as $column) {
                $query->or_like($column, $filter['search']['value']);
            }
            $query->group_end();
        }
        foreach ($filter['order'] as $order) {
            $query->order_by($columns[$order['column']], $order['dir']);
        }
        $query->where(self::TABLE_NAME.'.deleted', 0);
        $result = $query->get();
        $return['data'] = $result->result_object();
        $return['recordsFiltered'] = $result->num_rows();
        $return['recordsTotal'] = $query->query('SELECT FOUND_ROWS() AS total')->row('total');
        
        return $return;
    }
    
    public static function assign_deleted($id)
    {
        $CI =& get_instance();
        $CI->db->set('deleted', 1)->where('id', $id)->update(self::TABLE_NAME);
        
        return true;
    }
    
    public function save()
    {
        if ($this->id) {
            $this->update();
        } else {
            $this->insert();
        }
    }
    
    private function update($id, $data)
    {
        $this->db->update(self::TABLE_NAME, $this->instance(true))->where('id', $this->id);
    }
    
    public function instance($db_crud = false)
    {
        $instance = [];
        // Only return properties that have a value, and are allowed to be accessed via public function (checked via method_exists)
        foreach (get_object_vars($this) as $key => $property) {
            if ($this->{$key} && method_exists($this, "get_{$key}") && (($db_crud && is_scalar($property)) || !$db_crud)) {
                $instance[$key] = $this->{"get_{$key}"}();
            }
        }
        
        return $instance;
    }
    
    private function insert()
    {
        $this->db->set($this->instance(true))->insert(self::TABLE_NAME);
        $this->set_id($this->db->insert_id());
    }
    
    /**
     * @return mixed
     */
    public function get_lat()
    {
        return $this->lat;
    }
    
    /**
     * @param mixed $lat
     */
    public function set_lat($lat)
    {
        $this->lat = $lat;
    }
    
    /**
     * @return mixed
     */
    public function get_lng()
    {
        return $this->lng;
    }
    
    /**
     * @param mixed $lng
     */
    public function set_lng($lng)
    {
        $this->lng = $lng;
    }
    
    /**
     * @return mixed
     */
    public function get_date_requested()
    {
        return $this->date_requested;
    }
    
    /**
     * @param mixed $date_requested
     */
    public function set_date_requested($date_requested)
    {
        $this->date_requested = $date_requested;
    }
    
    /**
     * @return mixed
     */
    public function get_time()
    {
        return $this->time;
    }
    
    /**
     * @param mixed $time
     */
    public function set_time($time)
    {
        $this->time = $time;
    }
    
    /**
     * @return mixed
     */
    public function get_summary()
    {
        return $this->summary;
    }
    
    /**
     * @param mixed $summary
     */
    public function set_summary($summary)
    {
        $this->summary = $summary;
    }
    
    /**
     * @return mixed
     */
    public function get_icon()
    {
        return $this->icon;
    }
    
    /**
     * @param mixed $icon
     */
    public function set_icon($icon)
    {
        $this->icon = $icon;
    }
    
    /**
     * @return mixed
     */
    public function get_sunrise_time()
    {
        return $this->sunrise_time;
    }
    
    /**
     * @param mixed $sunrise_time
     */
    public function set_sunrise_time($sunrise_time)
    {
        $this->sunrise_time = $sunrise_time;
    }
    
    /**
     * @return mixed
     */
    public function get_sunset_time()
    {
        return $this->sunset_time;
    }
    
    /**
     * @param mixed $sunset_time
     */
    public function set_sunset_time($sunset_time)
    {
        $this->sunset_time = $sunset_time;
    }
    
    /**
     * @return mixed
     */
    public function get_temp_high()
    {
        return $this->temp_high;
    }
    
    /**
     * @param mixed $temp_high
     */
    public function set_temp_high($temp_high)
    {
        $this->temp_high = $temp_high;
    }
    
    /**
     * @return mixed
     */
    public function get_temp_low()
    {
        return $this->temp_low;
    }
    
    /**
     * @param mixed $temp_low
     */
    public function set_temp_low($temp_low)
    {
        $this->temp_low = $temp_low;
    }
    
    /**
     * @return mixed
     */
    public function get_dewpoint()
    {
        return $this->dewpoint;
    }
    
    /**
     * @param mixed $dewpoint
     */
    public function set_dewpoint($dewpoint)
    {
        $this->dewpoint = $dewpoint;
    }
    
    /**
     * @return mixed
     */
    public function get_humidity()
    {
        return $this->humidity;
    }
    
    /**
     * @param mixed $humidity
     */
    public function set_humidity($humidity)
    {
        $this->humidity = $humidity;
    }
    
    /**
     * @return mixed
     */
    public function get_id()
    {
        return $this->id;
    }
    
    /**
     * @param mixed $id
     */
    public function set_id($id)
    {
        $this->id = $id;
    }
    
    /**
     * @return mixed
     */
    public function get_pressure()
    {
        return $this->pressure;
    }
    
    /**
     * @param mixed $pressure
     */
    public function set_pressure($pressure)
    {
        $this->pressure = $pressure;
    }
    
    /**
     * @return mixed
     */
    public function get_windspeed()
    {
        return $this->windspeed;
    }
    
    /**
     * @param mixed $windspeed
     */
    public function set_windspeed($windspeed)
    {
        $this->windspeed = $windspeed;
    }
    
    /**
     * @return mixed
     */
    public function get_visibility()
    {
        return $this->visibility;
    }
    
    /**
     * @param mixed $visibility
     */
    public function set_visibility($visibility)
    {
        $this->visibility = $visibility;
    }
    
    /**
     * @return mixed
     */
    public function get_user_id()
    {
        return $this->user_id;
    }
    
    /**
     * @param mixed $user_id
     */
    public function set_user_id($user_id)
    {
        $this->user_id = $user_id;
        $this->load->model('User');
        $this->set_user(new User($user_id));
    }
    
    /**
     * @return mixed
     */
    public function get_user()
    {
        return $this->user;
    }
    
    /**
     * @param mixed $user
     */
    public function set_user($user)
    {
        $this->user = $user;
    }
    
}