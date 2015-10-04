<?php
/**
 * This is a demo class for 
 * @Author:    Jingrong Tian (work_id_tjr@163.com)
 * @DateTime:  2015-09-25 22:14:28
 * @Description: Description
 */
require_once('../model/api.php');

$test_api = new Api('Cohen', 'hello_world', 'A demo function');
$test_api->add_property('user_name', 'Your Name');
$test_api->set_path('../cohen.php');
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Cohen Bible</title>

    <!-- Bootstrap -->
    <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap-3.3.5-dist/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="bootstrap-3.3.5-dist/css/theme.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Cohen Bible</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li class="active"><a href="class_template.php">Class</a></li>
            <li><a href="function_template.php">Function</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container theme-showcase" role="main">
      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Cohen Bible</h1>
        <h3>authored by Jingrong Tian</h3>
        <p>This is a tool which can automize build api documents for your php class.<br/>You can input parameters and excute the function, then view the result.</p>
      </div>
      <div class="page-header">
        <h1>API</h1>
      </div>
      <h2><?php echo $test_api->get_class_name() . '::' . $test_api->get_function_name();?> <small><?php echo $test_api->get_description();?></small></h2>
      <section>
        <form action="./controller/index.php" method="post" id="api-form-<?php echo $test_api->get_class_name() . '-' . $test_api->get_function_name();?>">
          <input type="hidden" name='class_name' value="<?php echo $test_api->get_class_name(); ?>">
          <input type="hidden" name='function_name' value="<?php echo $test_api->get_function_name(); ?>">
          <input type="hidden" name='class_path' value="<?php echo $test_api->get_path(); ?>">
          <?php 
          foreach ($test_api->get_properties() as $index => $property) { ?>
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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <!-- Page script -->
    <script type="text/javascript">
      // A function for bounding events for forms.
      function bound_form(class_name, function_name) {
        var class_function_id = class_name + '-' + function_name;
        var form_id = 'api-form-' + class_function_id;
        $('#' + form_id).on('submit', function (event) {
          var formdata = $(this).serializeArray();
          var input_class_name = formdata[0].value;
          var input_function_name = formdata[1].value;
          var input_class_path = formdata[2].value;
          delete formdata[0];
          delete formdata[1];
          delete formdata[2];
          var options = {
            url: $('#' + form_id).attr('action'),
            type: 'post',
            data: {
              class_name: input_class_name,
              function_name: input_function_name,
              class_path: input_class_path,
              properties: formdata,
            },
            dataType: 'json',
            error: function(e) {
              $('.' + class_function_id + '-well').prepend(e.responseText);
              $('.' + class_function_id + '-well').prepend('<div class="alert alert-danger alert-dismissible" id="alert-unbind-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> 出错!</h4>后端接口响应出错！</div>');
            },
            success: function(data) {

              $('#result-' + class_function_id + '-well').empty();
              $('#result-' + class_function_id + '-well').append(data.result);
            },
          };

          $.ajax(options);
          return false;
        });
      }
      $(function () {
        // Bound event for forms
        $('#create-api').on('click', function (event) {
          // Create the apis
          var options = {
            url: './controller/template.php',
            type: 'get',
            error: function(e) {
              $('#api-class-content').append(e.responseText);
            },
            success: function(data) {
              $('#api-class-content').append(data);
              bound_form('Cohen', 'hello_world');
            },
          };
          $.ajax(options);
        })
      });
    </script>
  </body>
</html>