<?php

/**
 * This is the model class for table "sloc".
 *
 * The followings are the available columns in table 'sloc':
 * @property integer $slocid
 * @property integer $plantid
 * @property string $sloccode
 * @property integer $description
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Plant $plant
 */
class Sloc extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Sloc the static model class
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
		return 'sloc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('plantid, sloccode, description, recordstatus', 'required'),
			array('plantid, recordstatus', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>50),
			array('sloccode', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('slocid, plantid, sloccode, description, recordstatus', 'safe', 'on'=>'search'),
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
			'plant' => array(self::BELONGS_TO, 'Plant', 'plantid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'slocid' => 'Data',
			'plantid' => 'Plant',
			'sloccode' => 'Sloc Code',
			'description' => 'Description',
			'recordstatus' => 'Record Status',
		);
	}
	
	private function comparedb($criteria)
	{
		if (isset($_GET['plantcode']))
{
	$criteria->compare('plant.plantcode',$_GET['plantcode'],true);
}
		if (isset($_GET['plantdescription']))
{
	$criteria->compare('plant.description',$_GET['plantdescription'],true);
}
		if (isset($_GET['sloccode']))
{
	$criteria->compare('sloccode',$_GET['sloccode'],true);
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
$criteria->with=array('plant');
$this->comparedb($criteria);
		$criteria->compare('slocid',$this->slocid);
		$criteria->compare('plant.plantcode',$this->plantid,true);
		$criteria->compare('sloccode',$this->sloccode,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('t.recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}

	public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
$criteria->with=array('plant');
$this->comparedb($criteria);
		$criteria->condition='t.recordstatus=1';
		$criteria->compare('slocid',$this->slocid);
		$criteria->compare('plant.plantcode',$this->plantid,true);
		$criteria->compare('sloccode',$this->sloccode,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('t.recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}

    public function searchslocfrompr()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
$criteria->with=array('plant');
$this->comparedb($criteria);
		$criteria->condition="t.recordstatus=1 and 
slocid in (select gm.menuvalue from groupaccess c
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
inner join groupmenuauth gm on gm.groupaccessid = c.groupaccessid
inner join menuauth ma on ma.menuauthid = gm.menuauthid
where upper(e.username)=upper('".Yii::app()->user->name."') and upper(ma.menuobject) = upper('sloc'))";
		$criteria->compare('slocid',$this->slocid);
		$criteria->compare('plant.plantcode',$this->plantid,true);
		$criteria->compare('sloccode',$this->sloccode,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('t.recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
}