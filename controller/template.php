<?php
/**
 * This is a demo class for 
 * @Author:    Jingrong Tian (work_id_tjr@163.com)
 * @DateTime:  2015-09-25 22:14:28
 * @Description: Description
 */
/**
 * Lode models.
 */
require_once('../model/api.php');

$test_api = new Api('Cohen', 'hello_world', 'A demo function');
$test_api->add_property('user_name', 'Your Name');
$test_api->set_path('../cohen.php');
?>
<div class="tab-pane" id="tab2">
  <div class="page-header">
    <h1>API</h1>
  </div>
  <h2><?php echo $test_api->get_class_name() . '::' . $test_api->get_function_name();?> <small><?php echo $test_api->get_description();?></small></h2>
  <section>
    <form action="./controller/index.php" method="post" id="api-form-<?php echo $test_api->get_class_name() . '-' . $test_api->get_function_name();?>">
      <?php 
      foreach ($test_api->get_properties() as $index => $property) { ?>
        <input type="hidden" name='class_name' value="<?php echo $test_api->get_class_name(); ?>">
        <input type="hidden" name='function_name' value="<?php echo $test_api->get_function_name(); ?>">
        <input type="hidden" name='class_path' value="<?php echo $test_api->get_path(); ?>">
      <div class="form-group">
        <label for="input_<?php echo $property['name']?>"><?php echo $property['description']?></label>
        <input type="text" class="form-control" id="input_<?php echo $property['name']?>" placeholder="Please input here." name="<?php echo $property['name']?>">
      </div>
      <?php
      }
      ?>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>
  </section>
  <section>
    <div class="page-header">
      <h2>Result</h2>
    </div>
    <div class="<?php echo $test_api->get_class_name() . '-' . $test_api->get_function_name();?>-well">
      <samp id="result-<?php echo $test_api->get_class_name() . '-' . $test_api->get_function_name();?>-well">
        The result would display here.
      </samp>
    </div>
  </section>
</div>