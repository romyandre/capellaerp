<?php

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property integer $companyid
 * @property string $companyname
 * @property string $address
 * @property string $city
 * @property string $zipcode
 * @property integer $recordstatus
 */
class Company extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Company the static model class
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
		return 'company';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('companyname, address, city, zipcode, recordstatus, currencyid', 'required'),
			array('recordstatus, currencyid', 'numerical', 'integerOnly'=>true),
			array('companyname, city, taxno,faxno,phoneno', 'length', 'max'=>50),
			array('zipcode', 'length', 'max'=>10),
			array('webaddress,email', 'length'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('companyid, companyname, address, city, email,zipcode, faxno,phoneno,webaddress,taxno, currencyid,recordstatus', 'safe', 'on'=>'search'),
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
			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
			'city' => array(self::BELONGS_TO, 'City', 'city'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'companyid' => 'ID',
			'companyname' => 'Company ',
			'address' => 'Address ',
			'city' => 'City',
			'zipcode' => 'Zip Code',
			'taxno' => 'Tax No',
            'currencyid' => 'Currency',
			'recordstatus' => 'Record Status',
			'faxno'=> 'Fax No',
			'webaddress'=>'Web Address',
			'phoneno'=>'Phone No',
			'email'=>'Email',
			'leftlogofile'=>'Left Logo File',
			'rightlogofile'=>'Right Logo File'
		);
	}
	
	private function comparedb($criteria)
	{
		if (isset($_GET['companyname']))
{
	$criteria->compare('companyname',$_GET['companyname'],true);
}
		if (isset($_GET['address']))
{
	$criteria->compare('address',$_GET['address'],true);
}
if (isset($_GET['city']))
{
	$criteria->compare('cityname',$_GET['city'],true);
}
if (isset($_GET['zipcode']))
{
	$criteria->compare('zipcode',$_GET['zipcode'],true);
}
if (isset($_GET['currency']))
{
	$criteria->compare('currencyname',$_GET['currency'],true);
}
if (isset($_GET['taxno']))
{
	$criteria->compare('taxno',$_GET['taxno'],true);
}
if (isset($_GET['faxno']))
{
	$criteria->compare('faxno',$_GET['faxno'],true);
}
if (isset($_GET['webaddress']))
{
	$criteria->compare('webaddress',$_GET['webaddress'],true);
}
if (isset($_GET['phoneno']))
{
	$criteria->compare('phoneno',$_GET['phoneno'],true);
}
if (isset($_GET['email']))
{
	$criteria->compare('email',$_GET['email'],true);
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
		$criteria->with=array('currency','city');
		$this->comparedb($criteria);
		$criteria->compare('companyid',$this->companyid);
		$criteria->compare('companyname',$this->companyname,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city.cityname',$this->city,true);
		$criteria->compare('zipcode',$this->zipcode,true);
        $criteria->compare('currency.currencyname',$this->currencyid,true);
		$criteria->compare('t.recordstatus',$this->recordstatus);
		$criteria->compare('taxno',$this->taxno,true);
		$criteria->compare('faxno',$this->faxno,true);
		$criteria->compare('webaddress',$this->webaddress,true);
		$criteria->compare('phoneno',$this->phoneno,true);
		$criteria->compare('email',$this->email,true);

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
        $criteria->with=array('currency','city');
		$criteria->condition='t.recordstatus=1';
		$this->comparedb($criteria);
		$criteria->compare('companyid',$this->companyid);
		$criteria->compare('companyname',$this->companyname,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city.cityname',$this->city,true);
		$criteria->compare('zipcode',$this->zipcode,true);
		$criteria->compare('t.recordstatus',$this->recordstatus);
        $criteria->compare('currency.currencyname',$this->currencyid,true);
		$criteria->compare('taxno',$this->taxno,true);
		$criteria->compare('faxno',$this->faxno,true);
		$criteria->compare('webaddress',$this->webaddress,true);
		$criteria->compare('phoneno',$this->phoneno,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
	
	public function getcurrencyid()
	{
		$a = 0;
		$connection=Yii::app()->db;
			  try
			  {
				$sql = 'select currencyid from company limit 1';
				$command=$connection->createCommand($sql);
				$row = $command->queryrow();
				$a = $row['currencyid'];
				}
			  catch(Exception $e) // an exception is raised if a query fails
			  {
			  }
			  return $a;
	}
	
	public function getcity()
	{
		$a = 0;
		$connection=Yii::app()->db;
			  try
			  {
				$sql = 'select city from company limit 1';
				$command=$connection->createCommand($sql);
				$row = $command->queryrow();
				$a = $row['city'];
				}
			  catch(Exception $e) // an exception is raised if a query fails
			  {
			  }
			  return $a;
	}
	
	public function getcurrencyname()
	{
		$a = 0;
		$connection=Yii::app()->db;
			  try
			  {
				$sql = 'select currencyname from company a left join currency b on b.currencyid = a.currencyid limit 1';
				$command=$connection->createCommand($sql);
				$row = $command->queryrow();
				$a = $row['currencyname'];
				}
			  catch(Exception $e) // an exception is raised if a query fails
			  {
			  }
			  return $a;
	}
}