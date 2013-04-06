<?php

/**
 * This is the model class for table "menuaccess".
 *
 * The followings are the available columns in table 'menuaccess':
 * @property integer $menuaccessid
 * @property string $menucode
 * @property string $menuname
 * @property string $menuurl
 * @property integer $recordstatus
 */
class Menuaccess extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Menuaccess the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'menuaccess';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menucode, menuname, menuurl, recordstatus', 'required'),
			array('recordstatus', 'numerical', 'integerOnly'=>true),
			array('menucode', 'length', 'max'=>10),
			array('menuname, menuurl,description,menuicon', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('menuaccessid, menucode, menuname, menuurl, menuicon,recordstatus,description', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'menuaccessid' => 'Data',
			'menucode' => 'Menu Code',
			'menuname' => 'Menu',
			'menuurl' => 'Menu Url',
			'menuicon' => 'Menu Icon',
            'description'=> 'Description',
			'recordstatus' => 'Record Status',
		);
	}
	
	private function comparedb($criteria)
	{
		if (isset($_GET['menucode']))
{
	$criteria->compare('menucode',$_GET['menucode'],true);
}
		if (isset($_GET['menuname']))
{
	$criteria->compare('menuname',$_GET['menuname'],true);
}
if (isset($_GET['menuurl']))
{
	$criteria->compare('menuurl',$_GET['menuurl'],true);
}
if (isset($_GET['description']))
{
	$criteria->compare('description',$_GET['description'],true);
}
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
$this->comparedb($criteria);
		$criteria->compare('menuaccessid',$this->menuaccessid);
		$criteria->compare('menucode',$this->menucode,true);
		$criteria->compare('menuname',$this->menuname,true);
		$criteria->compare('menuurl',$this->menuurl,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}

public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition='recordstatus=1';
		$this->comparedb($criteria);
		$criteria->compare('menuaccessid',$this->menuaccessid);
		$criteria->compare('menucode',$this->menucode,true);
		$criteria->compare('menuname',$this->menuname,true);
		$criteria->compare('menuurl',$this->menuurl,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}
}
