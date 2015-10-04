<?php
/**
 * This is a demo class for 
 * @Author:    Jingrong Tian (work_id_tjr@163.com)
 * @DateTime:  2015-09-25 22:14:28
 * @Description: Description
 */

/**
 * Excute function create_api of specificated class and get the apis.
 * @return array Api objects.
 */

function get_class_package($apis, $function_template, $property_template) {
  $class_packages = array();
  foreach ($apis as $key => $class_api) {
    $function_packages = get_function_package($class_api['apis'], $function_template, $property_template);
    $class_package = array(
      'classname' => $class_api['classname'],
      'functions' => $function_packages
    );
    $class_packages[] = $class_package;
  }
  return $class_packages;
}

function get_function_package($apis, $function_template, $property_template) {
  $temp_function_template = $function_template;
  $function_packages = array();
  foreach ($apis as $key => $api) {
    $temp_function_template = str_replace('{<classname>}', $api->get_class_name(), $temp_function_template);
    $temp_function_template = str_replace('{<function_name>}', $api->get_function_name(), $temp_function_template);
    $temp_function_template = str_replace('{<description>}', $api->get_description(), $temp_function_template);
    $temp_function_template = str_replace('{<class_path>}', $api->get_path(), $temp_function_template);

    // Make properties.
    $property_section = '';
    foreach ($api->get_properties() as $key => $property) {
      $temp_property_template = $property_template;
      $temp_property_template = str_replace('{<property_name>}', $property['name'], $temp_property_template);
      $temp_property_template = str_replace('{<property_description>}', $property['description'], $temp_property_template);
      $property_section = $property_section . $temp_property_template . PHP_EOL;
    }
    $temp_function_template = str_replace('{<property_section>}', $property_section, $temp_function_template);

    // Output the html file.
    if (!is_dir('../apis')) {
      mkdir('../apis');
    }
    if (!is_dir('../apis/' . $api->get_class_name())) {
      mkdir('../apis/' . $api->get_class_name());
    }
    $html_link = '../apis/' . $api->get_class_name() . '/' . $api->get_function_name() . '.html';
    file_put_contents($html_link, $temp_function_template);

    // Package the function link.
    $function_package = array();
    $function_package['name'] = $api->get_function_name();
    $function_package['link'] = $html_link;
    $function_packages[] = $function_package;
  }
  return $function_packages;
}

function make_class_html($class_packages, $class_template, $class_section) {
  $temp_class_template = $class_template;

  // Make class and function links.
  $class_content = '';
  foreach ($class_packages as $key => $class_package) {
    $temp_class_section = $class_section;

    // Replace the class title.
    $temp_class_section = str_replace('{<classname>}', $class_package['classname'], $temp_class_section);

    // Add function link.
    $links = '';
    foreach ($class_package['functions'] as $link) {
      if ($links) {
        $links = $links . '<li role="presentation"><a href="' . $link['link'] . '">' . $link['name'] . '</a></li>' . PHP_EOL;
      } else {
        $links = '<li role="presentation" class="active"><a href="' . $link['link'] . '">' . $link['name'] . '</a></li>' . PHP_EOL;
      }
    }
    $temp_class_section = str_replace('{<function_links>}', $links, $temp_class_section);
    $class_content = $class_content . $temp_class_section . PHP_EOL;
  }

  // Replace the class and function links.
  $temp_class_template = str_replace('{<class_content>}', $class_content, $temp_class_template);

  // Output the html file.
  file_put_contents('api_list.html',$temp_class_template);
}

// Set the class path.
$class_paths = array(
  '../cohen.php'
);
$classnames = array(
  'Cohen'
);
// Include class.
foreach ($class_paths as $key => $class_path) {
  include_once($class_path);
}
// Load templates.
$class_template = file_get_contents('template/class_template.tpl');
$class_section = file_get_contents('template/class_section.tpl');
$function_template = file_get_contents('template/function_template.tpl');
$property_template = file_get_contents('template/property_template.tpl');

// Get api objects.
$apis = array();
foreach ($classnames as $key => $classname) {
  $apis[] = $classname::make_api();
}

// Get class packages.
$class_packages = get_class_package($apis, $function_template, $property_template);
// Make class htmls.
make_class_html($class_packages, $class_template, $class_section);
