<?php

/**
 * This is the model class for table "address".
 *
 * The followings are the available columns in table 'address':
 * @property integer $addressid
 * @property string $fullname
 * @property integer $iscustomer
 * @property integer $isemployee
 * @property integer $isapplicant
 * @property integer $isvendor
 * @property integer $isinsurance
 * @property integer $isbank
 * @property integer $ishospital
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Address[] $addresses
 * @property Addresscontact[] $addresscontacts
 * @property Bankaccount[] $bankaccounts
 * @property Employee[] $employees
 * @property Voucheragent[] $voucheragents
 * @property Warnetmember[] $warnetmembers
 */
class Address extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Address the static model class
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
		return 'address';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('addressname, recordstatus', 'required'),
			array('longitude,latitutde,recordstatus', 'numerical', 'integerOnly'=>true),
			array('fullname', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('addressid, addressname, longitude,latitude, recordstatus', 'safe', 'on'=>'search'),
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
			'addressbook' => array(self::BELONGS_TO, 'Addressbook', 'addressbookid'),
			'city' => array(self::BELONGS_TO, 'City', 'cityid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'addressid' => 'Data',
			'addressname' => 'Address',
			'cityid' => 'City',
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
		$criteria->with=array('addressbook','city');
		$criteria->compare('addressid',$this->addressid);
		$criteria->compare('addressname',$this->addressname,true);
		$criteria->compare('recordstatus',$this->recordstatus);

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
		$criteria->with=array('addressbook','city');
		$criteria->condition='t.recordstatus=1';
		$criteria->compare('addressid',$this->addressid);
		$criteria->compare('addressname',$this->addressname,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
'criteria'=>$criteria,
		));
	}
}