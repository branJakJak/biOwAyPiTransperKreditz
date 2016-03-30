<?php 

?>
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'template' => "{summary}\n{items}\n{pager}",
    'columns'=>array(
		array(
			'name'=>'ip_address', 
			'header'=>'IP Address',
			'type'=>'raw',
			'value'=>'$data->ip_address',
		),
		array(
			'header'=>'Location',
			'type'=>'raw',
			'value'=>'$data->getFlagImageLabel()',
		),
		array(
			'name'=>'date_created', 
			'header'=>'Last access',
			'type'=>'raw',
			'value'=>'$data->date_created',
		),
	)
));

?>

