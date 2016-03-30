<?php 
/* @var $this Controller */ 


?>
<?php $this->beginContent('//layouts/main'); ?>

  <div class="row-fluid">
    <div class="span12">
      <?php if(isset($this->breadcrumbs)):?>
  		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
              'links'=>$this->breadcrumbs,
    			'homeLink'=>CHtml::link('Dashboard'),
    			'htmlOptions'=>array('class'=>'breadcrumb')
          )); ?><!-- breadcrumbs -->
      <?php endif?>
      <?php echo $content; ?>
	   </div><!--/span-->
  </div><!--/row-->


<?php $this->endContent(); ?>