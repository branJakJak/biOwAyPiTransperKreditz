<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2/10/2016
 * Time: 7:03 PM
 */
$remoteDataCacheCollection = CHtml::listData($remoteDataCacheCollection,'sub_user','sub_user');


$toggleAllScript  = <<<EOL
jQuery("#checkAllCheckbox").toggle(function() {
    jQuery("input[type='checkbox']").not(this).prop({
        checked: 'checked'
    });
}, function() {
    jQuery("input[type='checkbox']").not(this).removeProp('checked');
});
EOL;
Yii::app()->clientScript->registerScript('toggleAllScript', $toggleAllScript, CClientScript::POS_READY);

?>

<style type="text/css">
    label{
        display: inline-block;
        margin: 10px 5px;
        position: relative;
        top: 3px;        
    }
</style>

<div class="row-fluid">
    <div class="span8 offset2">


        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title'=>'Select account to deactivate',
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
        <?php echo CHtml::beginForm(array('/subSipAccount/deactivateGroup'), 'post',['style'=>'padding: 30px;padding-bottom: 0px;']); ?>
        <?php echo CHtml::activeHiddenField($formModel, 'accounts', array()); ?>

        <label>
            <strong><?php echo count($remoteDataCacheCollection) ?> active account(s) : </strong>
        </label>
        <br>
        <?php //echo CHtml::button('Toggle box', array('id'=>'checkAllCheckbox')); ?>
        <?php echo CHtml::checkBox('checkAll', false, array('id'=>'checkAllCheckbox')); ?>
        <label> 
            Check all
        </label>
        <br>
        <hr>
        <?php echo CHtml::checkBoxList('accounts', '', $remoteDataCacheCollection, array()); ?>
        <?php echo CHtml::error($formModel, 'accounts'); ?>
        <br>
        <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
        </div>

        <?php echo CHtml::endForm(); ?>
        <?php
        $this->endWidget();
        ?>

    </div>
</div>




<div class="row-fluid">
    <div class="span8 offset2">
        <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'Deactivate Log',
            ));
        ?>

        <?php 
            $this->widget('zii.widgets.grid.CGridView', array(
                'dataProvider'=>$deactivateDataProvider,
                'columns'=>array(
                    array(
                            'header'=>'Log',
                            'value'=>'$data->message',
                        ),
                    'logDate',
                ),
            ));
        ?>
        
        <?php
            $this->endWidget();
        ?>
    </div>
</div>



