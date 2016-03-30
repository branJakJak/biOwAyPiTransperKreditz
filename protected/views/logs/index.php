<?php 

?>

<?php 
	$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
	    'id'=>'exportRange',
	    'options'=>array(
	        'title'=>'Export Range',
	        'autoOpen'=>false,
	        'modal'=>true,
	    ),
	));
?>
<?php echo CHtml::beginForm(array('/logs/exportRange'), 'GET', array()); ?>

<label>From : </label>
<?php 
	$this->widget('zii.widgets.jui.CJuiDatePicker',array(
	    'name'=>'dateFrom',
	    'options'=>array(
	        'showAnim'=>'fold',
	        'changeYear'=>true,
	        'changeMonth'=>true,
	    ),
	    'htmlOptions'=>array(
	        'style'=>'height:20px;'
	    ),
	));
?>
<label>To : </label>
<?php 
	$this->widget('zii.widgets.jui.CJuiDatePicker',array(
	    'name'=>'dateTo',
	    'options'=>array(
	        'showAnim'=>'fold',
	        'changeYear'=>true,
	        'changeMonth'=>true,
	    ),
	    'htmlOptions'=>array(
	        'style'=>'height:20px;'
	    ),
	));
?>
<button type="submit" class="btn btn-default">Submit</button>
<?php echo CHtml::endForm(); ?>

<?php 
	$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<div class="row-fluid">
	<div class="span4 offset1">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Export Logs',
			));
		?>
		<h3>Export Today's Log</h3>

		<hr>
		<div class="btn-group">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
			Export
			<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li>
					<a href="/logs/exportToday" class="">
						Today
					</a>
				</li>
				<li>
					<?php 
						echo CHtml::link('Range', '#', array(
						   'onclick'=>'$("#exportRange").dialog("open"); return false;',
						   'class'=>'',
						));
					?>
				</li>
			</ul>
		</div>
		<?php
			$this->endWidget();
		?>
	</div>
</div>