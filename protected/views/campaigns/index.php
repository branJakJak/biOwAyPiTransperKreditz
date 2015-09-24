<?php
/* @var $this FreeVoipAccountsController */
/* @var $gridDataProvider CArrayDataProvider */

Yii::app()->clientScript->registerScript('addClass', '
jQuery(".items").addClass("table table-striped table-bordered table-condensed").removeClass("items");
	', CClientScript::POS_READY);
$baseUrl = Yii::app()->theme->baseUrl;
?>
<div class="span10">
	<h1>List of Campaigns</h1>
	<hr>
	<?php 
	$this->widget('bootstrap.widgets.TbAlert', array(
	    'fade'=>true, // use transitions?
	    'closeText'=>'×', // close link text - if set to false, no close link is displayed
	    'alerts'=>array( // configurations per alert type
		    'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), 
		    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), 
		    'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), 
	    ),
	)); ?>
	 <?php $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$gridDataProvider,
		'template'=>"{summary}\n{items}\n{pager}",
		'columns'=>array(
			array('name'=>'campaign_id', 'header'=>'Campaign ID','type'=>'raw'),
			array('name'=>'name', 'header'=>'Campaign Name','type'=>'raw'),
			array('name'=>'is_active', 'header'=>'Is Active','type'=>'raw'),
			array(
				'class'=>'CButtonColumn',
				'header'=>'Activate',
				'template'=>'{activate}',
				'buttons'=>array(
					'activate'=>array(
						'label'=>"Activate",
						'imageUrl'=>$baseUrl."/img/Start-icon.png",
						'url'=>'$this->grid->controller->createUrl("/campaigns/activate", array("campaign"=>trim($data["campaign_id"])))',
						'options'=>array('style'=>'text-align:center;display:block')
					),
				)
			),
			array(
				'class'=>'CButtonColumn',
				'header'=>'Deactivate',
				'template'=>'{deactivate}',
				'buttons'=>array(
					'deactivate'=>array(
						'label'=>"Deactive",
						'imageUrl'=>$baseUrl."/img/Stop-red-icon.png",
						'url'=>'$this->grid->controller->createUrl("/campaigns/deactivate", array("campaign"=>trim($data["campaign_id"])))',
						'options'=>array(
							'style'=>'text-align:center;display:block',
							'confirm'=>'Are you sure you want to deactivate this campaign ?'
						)
					),
				)
			),
		),
	)); ?>
</div>
