<?php 

?>

<div class="row-fluid">
	<div class="span8 offset2">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Control',
			));
		?>
			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'controlGrid',
				'dataProvider'=>$datasource,
				'columns'=>array(
			        array('name'=>'campaign_id', 'header'=>'Campaign ID'),
			        array('name'=>'agents', 'header'=>'Agents'),
			        array('name'=>'channels', 'header'=>'Channels'),
				),
			)); 
			?>
		<?php
			$this->endWidget();
		?>

	</div>
</div>

