<?php
/**
 * This is a demo class for 
 * @Author:    Jingrong Tian (work_id_tjr@163.com)
 * @DateTime:  2015-09-25 22:14:28
 * @Description: Description
 */
include_once('api.php');

class Cohen
{
    
    function __construct()
    {
    }

    /**
     * a demo funtion
     * @param   string $user_name   The user`s name of this function.
     * @return  string              Print the user.
     */
    public function hello_world ($user_name) {
        return 'Welcome to cohen`s world, dear ' . $user_name;
    }

    public static function make_api() {
        $api = new Api('Cohen', 'hello_world', 'A demo function.');
        $api->add_property('user_name', 'Your Name');
        $api->set_path('cohen.php');
        $apis = array();
        $apis[] = $api;
        $results = array(
            'classname' => 'Cohen',
            'apis' => $apis
        );
        return $results;
    }
}