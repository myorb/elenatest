<?php
/* @var $this DictionaryController */
/* @var $data Dictionary */
echo "string";
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'dictionary-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		/*'root',
		'lft',
		'rgt',
		'level',*/
		array(
			'name'=>'id',
			'htmlOptions'=>array('width'=>'20px'),
			),
		'title',
		array(
			'header'=>'Root Categoy',
			'name'=>'root',
			'type'=>'raw',
			'value'=>'$data->isRoot()?"":$data->parent()->find()->title',
			'filter'=>CHtml::listData($model->roots()->findAll(), 'id', 'title'),
		),
		array(
			'name'=>'category_id',
			'type'=>'raw',
			'value'=>'$data->category?$data->category->title:""',
			),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>