<?php 
/* @var $this Controller */ 


?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="container">
  <div class="row">
    <div class="span3">
      <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
          'title'=>'Manage Accounts',
        ));
      ?>
    <!-- side menu -->
      <?php $this->widget('zii.widgets.CMenu',array(
              'encodeLabel'=>false,
              'items'=>$this->menu,
      )); ?>      
      <div class="clearfix"></div>
      <?php
        $this->endWidget();
      ?>
    </div>
    <div class="span9">
      <?php if(isset($this->breadcrumbs)):?>
      <?php $this->widget('zii.widgets.CBreadcrumbs', array(
              'links'=>$this->breadcrumbs,
              'homeLink'=>CHtml::link('Home'),
              'htmlOptions'=>array('class'=>'breadcrumb')
          )); ?><!-- breadcrumbs -->
          <?php echo $content; ?>
      <?php endif?>
    </div>
  </div>
</div>
<?php $this->endContent(); ?>