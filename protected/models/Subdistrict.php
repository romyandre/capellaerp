<?php

/**
 * This is the model class for table "subdistrict".
 *
 * The followings are the available columns in table 'subdistrict':
 * @property integer $subdistrictid
 * @property integer $cityid
 * @property string $subdistrictname
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Address[] $addresses
 */
class Subdistrict extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Subdistrict the static model class
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
		return 'subdistrict';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cityid, subdistrictname, zipcode,recordstatus', 'required'),
			array('cityid, recordstatus', 'numerical', 'integerOnly'=>true),
			array('subdistrictname,zipcode', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subdistrictid, cityid, subdistrictname, recordstatus,zipcode', 'safe', 'on'=>'search'),
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
			'addresses' => array(self::HAS_MANY, 'Address', 'subdistrictid'),
      'city' => array(self::BELONGS_TO, 'City', 'cityid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subdistrictid' => 'Data',
			'cityid' => 'City',
			'subdistrictname' => 'Subdistrict ',
			'zipcode'=>'Zip Code',
			'recordstatus' => 'Record Status',
		);
	}
	
	private function comparedb($criteria)
	{
		if (isset($_GET['cityname']))
{
	$criteria->compare('city.cityname',$_GET['cityname'],true);
}
		if (isset($_GET['subdistrictname']))
{
	$criteria->compare('subdistrictname',$_GET['subdistrictname'],true);
}
		if (isset($_GET['zipcode']))
{
	$criteria->compare('zipcode',$_GET['zipcode'],true);
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
    $criteria->with=array('city');
	$this->comparedb($criteria);
		$criteria->compare('subdistrictid',$this->subdistrictid);
		$criteria->compare('city.cityname',$this->cityid,true);
		$criteria->compare('subdistrictname',$this->subdistrictname,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
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
    $criteria->condition='t.recordstatus=1';
    $criteria->with=array('city');
	$this->comparedb($criteria);
		$criteria->compare('subdistrictid',$this->subdistrictid);
		$criteria->compare('city.cityname',$this->cityid,true);
		$criteria->compare('subdistrictname',$this->subdistrictname,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
}