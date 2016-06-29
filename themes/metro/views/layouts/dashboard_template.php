<?php 
$baseUrl = Yii::app()->theme->baseUrl; 

Yii::app()->clientScript->registerCssFile($baseUrl.'/dist/css/metro-bootstrap.min.css');
Yii::app()->clientScript->registerCssFile($baseUrl.'/styles/font-awesome.min.css');

/*bottom scripts inclusion*/
// Yii::app()->clientScript->registerScriptFile('//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($baseUrl.'/scripts/vendor/bootstrap.min.js', CClientScript::POS_END);
/*growl*/
Yii::app()->clientScript->registerScriptFile($baseUrl.'/bower_components/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js', CClientScript::POS_END);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title><?php echo Yii::app()->name ?> : <?php echo $this->pageTitle ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
  </head>  
  <body >
    <?php echo $content ?>
  <!-- Le javascript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>