<?php

/**
 * This is the model class for table "province".
 *
 * The followings are the available columns in table 'province':
 * @property integer $provinceid
 * @property integer $countryid
 * @property string $provincename
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property City[] $cities
 * @property Country $country
 */
class Province extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Province the static model class
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
		return 'province';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('countryid, provincename, recordstatus', 'required'),
			array('countryid, recordstatus', 'numerical', 'integerOnly'=>true),
			array('provincename', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('provinceid, countryid, provincename, recordstatus', 'safe', 'on'=>'search'),
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
			'cities' => array(self::HAS_MANY, 'City', 'provinceid'),
			'country' => array(self::BELONGS_TO, 'Country', 'countryid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'provinceid' => 'Data',
			'countryid' => 'Country',
			'provincename' => 'Province ',
			'recordstatus' => 'Record Status',
		);
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
    $criteria->with=array('country');
	$this->comparedb($criteria);
		$criteria->compare('t.provinceid',$this->provinceid);
		$criteria->compare('country.countryname',$this->countryid,true);
		$criteria->compare('t.provincename',$this->provincename,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
	
	private function comparedb($criteria)
	{
		if (isset($_GET['provincename']))
{
	$criteria->compare('provincename',$_GET['provincename'],true);
}
		if (isset($_GET['countryname']))
{
	$criteria->compare('country.countryname',$_GET['countryname'],true);
}
}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
    $criteria->with=array('country');
    $criteria->condition='t.recordstatus=1';
	$this->comparedb($criteria);
		$criteria->compare('t.provinceid',$this->provinceid);
		$criteria->compare('country.countryname',$this->countryid);
		$criteria->compare('t.provincename',$this->provincename,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}

}