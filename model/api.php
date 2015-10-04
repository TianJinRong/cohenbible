<?php
/**
 * This class is the api model class.
 * 
 * @Author:    Jingrong Tian (work_id_tjr@163.com)
 * @DateTime:  2015-09-25 22:14:28
 * @Description: Description
 */

class Api
{
    /**
     * The class name.
     * @var string
     */
    private $__class_name;

    /**
     * The function name.
     * @var string
     */
    private $__function_name;

    /**
     * The description of the function.
     * @var string
     */
    private $__description;

    /**
     * The path of the class file.
     * @var string
     */
    private $__path;

    /**
     * The url for excuting the function.
     * @var string
     */
    private $__url;

    /**
     * The properties of the function
     * @var array
     */
    private $__properties;

    /**
     * The constructor of the Api class.
     * @param string $class_name    The class name.
     * @param string $function_name The function name.
     * @param string $description   The description of the function.
     */
    function __construct($class_name, $function_name, $description)
    {
        $this->__class_name = $class_name;
        $this->__function_name = $function_name;
        $this->__description = $description;
        $this->__properties = array();
    }

    /**
     * Set the path of the class file.
     * @param   string  $path   The path of the class file.
     * @return  boolean         The result of setting.
     */
    public function set_path ($path) {
        $this->__path = $path;
    }

    /**
     * Set the url of executing the function.
     * @param   string  $url   The url of executing the function.
     * @return  boolean        The result of setting.
     */
    public function set_url ($url) {
        $this->__url = $url;
    }

    /**
     * Add a property of the function.
     * @param  string $property_name        The name of property.
     * @param  string $property_description The description of property.
     * @return array                        The property which has been added in successfully.
     */
    public function add_property($property_name, $property_description) {
        try {
            if (!$property_name) {
                throw new Exception('Property can`t null.');
            }

            if ($this->__property_exist($property_name)) {
                throw new Exception('Property has been existed.');
            }

            $property = array(
                'name' => $property_name,
                'description' => $property_description
            );
            $this->__properties[] = $property;
            return $property;
        } catch (Exception $e) {
            echo $e->errorMessage();
        }
    }

    /**
     * Check whether the property is exist.
     * @param  string $property_name The property_name
     * @return boolean               The result of checking.
     */
    private function __property_exist($property_name) {
        if ($this->get_property($property_name)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the property.
     * @param  string $property_name The name of property.
     * @return array                 The property which got.
     *                               Return false if get nothing.
     */
    public function get_property($property_name) {
        foreach ($this->__properties as $index => $property) {
            if ($property['name'] == $property_name) {
                return $property;
            }
        }
        return false;
    }

    public function get_class_name() {
        return $this->__class_name;
    }

    public function get_function_name() {
        return $this->__function_name;
    }

    public function get_description() {
        return $this->__description;
    }

    public function get_path() {
        return $this->__path;
    }

    public function get_url() {
        return $this->__url;
    }

    public function get_properties() {
        return $this->__properties;
    }
}