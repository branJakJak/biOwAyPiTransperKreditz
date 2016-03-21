<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 3/18/16
 * Time: 12:43 AM
 */
?>
<div class="row-fluid">
    <div class="span12">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title'=>'Activate selected account',
        ));
        ?>
        <?php
        $this->widget('bootstrap.widgets.TbAlert', array(
            'block'=>true, // display a larger alert block?
            'fade'=>true, // use transitions?
            'closeText'=>'×', // close link text - if set to false, no close link is displayed
            'alerts'=>array( // configurations per alert type
                'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
                'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
            ),
        )); ?>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Main Account</th>
					<th>Sub Account</th>
					<th>Vici Id</th>
					<th>Current Balance</th>
					<th>Active</th>
					<th>Topup Value</th>
					<th>Budget</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($allRemoteDataCache as $key => $value): ?>
					<?php 
						$currentAutoTopupConfig = AutoTopupConfiguration::model()->findByAttributes(array('remote_data_cache'=>$value->id));
						if (is_null($currentAutoTopupConfig)) {
							throw new Exception("$value->id | $value->main_user has no configured auto toptup");
						}
					?>
					<?php echo CHtml::beginForm(array('/config/autoTopUp'), 'POST', array()); ?>
						<tr>
							<td>
								<?php echo CHtml::hiddenField('AutoTopUpUpdateForm[remoteDataCacheId]', $value->id); ?>
								<?php echo CHtml::hiddenField('AutoTopUpUpdateForm[autoConfigIdentity]', $currentAutoTopupConfig->id); ?>
								<?php echo $key+1 ?>
							</td>
							<td><?php echo $value->main_user ?></td>
							<td><?php echo $value->sub_user ?></td>
							<td><?php echo $value->vici_user ?></td>
							<td><?php echo $value->balance ?></td>
							<td>
								<?php echo CHtml::checkBox('AutoTopUpUpdateForm[activated]', $currentAutoTopupConfig->activated, array()); ?>
							</td>
							<td>
								<?php echo CHtml::textField('AutoTopUpUpdateForm[newTopUpValue]', $currentAutoTopupConfig->topUpValue,array('type'=>'number','min'=>-1)); ?>
							</td>
							<td>
								<?php echo CHtml::textField('AutoTopUpUpdateForm[newBudget]', $currentAutoTopupConfig->budget,array('type'=>'number','min'=>-1)); ?>
							</td>
							<td>
								<?php echo CHtml::submitButton('Update',array('class'=>'btn btn-default')); ?>
							</td>
						</tr>
					<?php echo CHtml::endForm(); ?>
				<?php endforeach ?>
			</tbody>
		</table>
        <?php
        $this->endWidget();
        ?>

    </div>
</div>
