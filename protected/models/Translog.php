<?php

/**
 * This is the model class for table "translog".
 *
 * The followings are the available columns in table 'translog':
 * @property integer $translogid
 * @property string $username
 * @property string $model
 * @property string $useraction
 * @property string $createddate
 * @property string $fieldname
 * @property string $fieldoldvalue
 * @property string $fieldnewvalue
 */
class Translog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Translog the static model class
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
		return 'translog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('createddate', 'required'),
			array('username, useraction', 'length', 'max'=>50),
			array('newdata, olddata', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('translogid, username, useraction, createddate, newdata, olddata', 'safe', 'on'=>'search'),
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
			'translogid' => 'ID',
			'username' => 'User',
			'useraction' => 'Action',
			'createddate' => 'Created Date',
			'newdata' => 'New Data',
			'oldata' => 'Old Data',
		);
	}
	
	private function comparedb($criteria)
	{
	if (isset($_GET['createddate']))
{
	$criteria->compare('createddate',$_GET['createddate'],true);
}
	if (isset($_GET['username']))
{
	$criteria->compare('username',$_GET['username'],true);
}
		if (isset($_GET['newdata']))
{
	$criteria->compare('newdata',$_GET['newdata'],true);
}
if (isset($_GET['olddata']))
{
	$criteria->compare('olddata',$_GET['olddata'],true);
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
		$criteria->compare('translogid',$this->translogid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('useraction',$this->useraction,true);
		$criteria->compare('createddate',$this->createddate,true);
		$criteria->compare('newdata',$this->newdata,true);
		$criteria->compare('olddata',$this->olddata,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}
}