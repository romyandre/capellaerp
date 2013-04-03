<?php

/**
 * This is the model class for table "translock".
 *
 * The followings are the available columns in table 'translock':
 * @property integer $translockid
 * @property integer $menuaccessid
 * @property integer $tableid
 * @property integer $lockedby
 * @property string $lockeddate
 * @property integer $recordstatus
 */
class Translock extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Translock the static model class
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
		return 'translock';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menuname, tableid, lockedby, lockeddate', 'required'),
			array('menuname, tableid, lockedby', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('translockid, menuname, tableid, lockedby, lockeddate', 'safe', 'on'=>'search'),
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
			'translockid' => 'Data',
			'menuname' => 'Menu ',
			'tableid' => 'Table ID',
			'lockedby' => 'Locked By',
			'lockeddate' => 'Locked Date',
	);
	}
	
	private function comparedb($criteria)
	{
		if (isset($_GET['menuname']))
{
	$criteria->compare('menuname',$_GET['menuname'],true);
}
		if (isset($_GET['lockedby']))
{
	$criteria->compare('lockedby',$_GET['lockedby'],true);
}
if (isset($_GET['lockeddate']))
{
	$criteria->compare('lockeddate',$_GET['lockeddate'],true);
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
		$criteria->compare('translockid',$this->translockid);
		$criteria->compare('menuname',$this->menuname);
		$criteria->compare('tableid',$this->tableid);
		$criteria->compare('lockedby',$this->lockedby);
		$criteria->compare('lockeddate',$this->lockeddate,true);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}
}