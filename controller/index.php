<?php
/**
 * This is a demo class for 
 * @Author:    Jingrong Tian (work_id_tjr@163.com)
 * @DateTime:  2015-09-25 22:14:28
 * @Description: Description
 */
// Read class
if (isset($_POST['properties'])) {
  // Read submit data.
  $class_name = $_POST['class_name'];
  $function_name = $_POST['function_name'];
  $class_path = $_POST['class_path'];
  $properties = $_POST['properties'];
  $properties = make_properties_for_run($properties);

  include_once($class_path);

  $class_invoke = new $class_name();
  $result = call_user_func_array(array($class_invoke, $function_name), $properties);
  print json_encode(array('result' => $result));
}
else {
  print json_encode(array('result' => 'Input can`t be empty.'));
}

/**
 * For example,
 *  $properties = array(
 *    0 => array(
 *        'name' => 'param0',
 *        'value' => 'value0',
 *    ),
 *    1 => array(
 *        'name' => 'param1',
 *        'value' => 'value1',
 *    ),
 *  );
 *  We need to change it into:
 *  $properties = array(
 *    0 => 'value0',
 *    1 => 'value1',
 *  );
 * @param  array  $properties The properties which need to be rebuilded.
 * @return array              The reubild result.
 */
function make_properties_for_run($properties = array()) {
    $result = array();
    if (!empty($properties)) {
        foreach ($properties as $key => $property) {
          if ($property) {
            $result[] = $property['value'];
          }
        }
    }
    return $result;
}