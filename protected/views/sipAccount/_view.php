<?php
/* @var $this SipAccountController */
/* @var $data SipAccount */

$baseUrl = Yii::app()->theme->baseUrl;
$status = 'none';
if (count($data->subSipAccounts) > 0) {
	$singleSubSip = $data->subSipAccounts[0];
	$status = $singleSubSip->account_status;
}

?>

<div class="account-panels">
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>".CHtml::encode($data->username)." - ".CHtml::encode($data->account_status)."</strong>",
			'titleCssClass'=>''
		));
	?>
	
		<?php 
			$criteria = new CDbCriteria;
			$criteria->compare("parent_sip",$data->id);
			$dt =  new CActiveDataProvider('SubSipAccount', array(
				'criteria'=>$criteria,
				'pagination'=>false,
			));			
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'sub-sip-account-grid',
				'dataProvider'=>$dt,
				'columns'=>array(
					// 'username',
					'customer_name',
					// array(
					// 	'type'=>"raw",
					// 	'value'=>'($data->exact_balance < 5) ? "blocked":"active"',
					// 	'header'=>"status",
					// ),
					// 'account_status',
					// 'balance',
					'exact_balance',
					array(
						'class'=>'CButtonColumn',
						'header'=>'Update Blnc.',
						'template'=>'{update_balance}',
						'buttons'=>array(
							'update_balance'=>array(
								'label'=>"Update Balance",
								'imageUrl'=>$baseUrl."/img/1442268678_shopcartdown_32x32.png",
								'url'=>'$this->grid->controller->createUrl("/subSipAccount/updateBalance", array("subAccount"=>$data->id))',
							),
						)
					),
					array(
						'class'=>'CButtonColumn',
						'header'=>'Activate',
						'template'=>'{activate}',
						'buttons'=>array(
							'activate'=>array(
								'label'=>"Activate",
								'imageUrl'=>$baseUrl."/img/Accept-icon16.png",
								'url'=>'$this->grid->controller->createUrl("/subSipAccount/activate", array("subAccount"=>$data->id))',
							),
							'deactivate'=>array(
								'label'=>"Deactive",
								'imageUrl'=>$baseUrl."/img/Warning-icon16.png",
								'url'=>'$this->grid->controller->createUrl("/subSipAccount/deactivate", array("subAccount"=>$data->id))',
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
								'imageUrl'=>$baseUrl."/img/Warning-icon16.png",
								'url'=>'$this->grid->controller->createUrl("/subSipAccount/deactivate", array("subAccount"=>$data->id))',
							),							
						)
					),
					// array(
					// 	'class'=>'CButtonColumn',
					// 	'template'=>'{view}',
					// 	'buttons'=>array(
					// 		'view'=>array(
					// 			'label'=>"View Information",
					// 			'url'=>'$this->grid->controller->createUrl("/subSipAccount/view", array("id"=>$data->id))',
					// 		),
					// 	)
					// ),
				),
				'htmlOptions'=>array('style'=>"min-height: 200px")
			)); 
		?>
		
	<hr>
	<div class="btn-toolbar">
		<?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
		'type'=>'primary',
		'buttons'=>array(
			array('label'=>'Action', 'items'=>array(
				array('label'=>'Register Client Account', 'url'=>$this->createUrl("/subSipAccount/create",array("SubSipAccount[parent_sip]" => $data->id)) ),
				'---',
				array('label'=>'View Current SIP Account', 'url'=>array('view', 'id'=>$data->id)),
			)),
		),
	)); ?>
	</div>
	<?php $this->endWidget(); ?>
</div>