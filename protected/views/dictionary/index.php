<?php
/* @var $this DictionaryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Dictionaries',
);

$this->menu=array(
	array('label'=>'Create Dictionary', 'url'=>array('create')),
	array('label'=>'Manage Dictionary', 'url'=>array('admin')),
);
?>

<h1>Dictionaries</h1>

<?php $this->renderPartial('_view', array('model'=>$model)); ?>