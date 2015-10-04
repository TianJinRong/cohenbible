<?php
/**
 * This is a demo class for 
 * @Author:    Jingrong Tian (work_id_tjr@163.com)
 * @DateTime:  2015-09-25 22:14:28
 * @Description: Description
 */
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
            <li class="active"><a href="#">Home</a></li>
            <li><a href="view/class_template.php">Class</a></li>
            <li><a href="view/function_template.php">Function</a></li>
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
      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="page-header">
            <h1>Create API</h1>
          </div>
          <button type="button" class="btn btn-default" id="create-api">Create</button>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
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
            url: '../controller/create_api.php',
            type: 'get',
            error: function(e) {
              $('#api-class-content').append(e.responseText);
            },
            success: function(data) {
              $('#api-class-content').append(data);            },
          };
          $.ajax(options);
        })
      });
    </script>
  </body>
</html>