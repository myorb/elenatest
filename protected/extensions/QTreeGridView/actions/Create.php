<?php

class Create extends CAction {

    public function run() {
        $modelClassName = $this->getController()->CQtreeGreedView['modelClassName'];
        $model = new $modelClassName();

        if (Yii::app()->request->getPost($modelClassName)) {
            $model->attributes = $_POST[$this->getController()->CQtreeGreedView['modelClassName']];

            try {
                if ($model->tree->hasManyRoots == true) {
                    
                    if ($_POST[$this->getController()->CQtreeGreedView['modelClassName']]['root'] == 0) {
                        if($model->saveNode()) {
                            $this->getController()->redirect(array($this->getController()->CQtreeGreedView['adminAction']));
                        }
                    }else{
                        $root = CActiveRecord::model($this->getController()->CQtreeGreedView['modelClassName'])->findByPk((int) $_POST[$this->getController()->CQtreeGreedView['modelClassName']]['root']);
                        if ($root && $model->appendTo($root)) {
                            $this->getController()->redirect(array($this->getController()->CQtreeGreedView['adminAction']));
                        }                        
                    }
                } else {
                    $root = CActiveRecord::model($this->getController()->CQtreeGreedView['modelClassName'])->roots()->find();

                    if ($root && $model->appendTo($root)) {
                        $this->getController()->redirect(array($this->getController()->CQtreeGreedView['adminAction']));
                    }
                }
            } catch (Exception $e) {
                $model->addError("CQTeeGridView", $e->getMessage());
            }
        }

        $this->getController()->render('create', array(
            'model' => $model,
        ));
    }
}
?>
