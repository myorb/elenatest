<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property string $id
 * @property string $root
 * @property string $lft
 * @property string $rgt
 * @property integer $level
 * @property string $title
 * @property string $price
 * @property integer $status
 */
class Category extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}

	public $parentId;
	public $searchOrderCondition;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, price, status', 'required'),
			array('level, status', 'numerical', 'integerOnly'=>true),
			array('root, lft, rgt, price', 'length', 'max'=>10),
			array('title', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, root, lft, rgt, level, title, price, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return ['dictionary' => array(self::HAS_MANY, 'Dictionary', 'category_id')];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'root' => 'Root',
			'lft' => 'Lft',
			'rgt' => 'Rgt',
			'level' => 'Level',
			'title' => 'Title',
			'price' => 'Price',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('root',$this->root,true);
		$criteria->compare('lft',$this->lft,true);
		$criteria->compare('rgt',$this->rgt,true);
		$criteria->compare('level',$this->level);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('status',$this->status);
		if ($this->searchOrderCondition) {
			$criteria->order = $this->tree->hasManyRoots?$this->tree->rootAttribute . ', ' . $this->tree->leftAttribute:$this->tree->leftAttribute;
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	 public function defaultScope(){
	 	$order = $this->tree->hasManyRoots?$this->tree->rootAttribute . ', ' . $this->tree->leftAttribute:$this->tree->leftAttribute;

        return array(
            'order'=>$order
        );
    }
    static function treeOrder(){
        return ['order'=>$this->tree->hasManyRoots?$this->tree->rootAttribute . ', ' . $this->tree->leftAttribute:$this->tree->leftAttribute];
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	* Seting behaviors for using 
	* NestedSetBehavior
	*/
	public function behaviors()
	{
	    return array(
	        'tree'=>array(
	            'class'=>'NestedSetBehavior',
	            'leftAttribute'=>'lft',
	            'rightAttribute'=>'rgt',
	            'levelAttribute'=>'level',
	            'hasManyRoots'=>true,
	        ),
	    );
	}
}
