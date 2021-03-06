<?php

/**
 * This is the model class for table "addressbook".
 *
 * The followings are the available columns in table 'addressbook':
 * @property integer $addressbookid
 * @property string $fullname
 * @property integer $iscustomer
 * @property integer $isemployee
 * @property integer $isapplicant
 * @property integer $iscustomer
 * @property integer $isinsurance
 * @property integer $isbank
 * @property integer $isCustomer
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Address[] $addresses
 * @property Addresscontact[] $addresscontacts
 * @property Customeraccount[] $bankaccounts
 * @property Employee[] $employees
 * @property Voucheragent[] $voucheragents
 */
class Customer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Addressbook the static model class
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
		return 'addressbook';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fullname, recordstatus', 'required'),
			array('iscustomer, isemployee, isapplicant, iscustomer, isinsurance, isbank, ishospital, recordstatus,acchutangid', 'numerical', 'integerOnly'=>true),
			array('fullname,taxno', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('addressbookid, fullname, iscustomer, isemployee, isapplicant, iscustomer, ishospital, isbank, isinsurance, 
recordstatus,acchutangid,taxno', 'safe', 'on'=>'search'),
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
			'acchutang' => array(self::BELONGS_TO, 'Account', 'acchutangid'),
			'addresscontact' => array(self::HAS_MANY, 'Addresscontact', 'addressbookid'),
			'address' => array(self::HAS_MANY, 'Address', 'addressbookid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'addressbookid' => 'Data',
			'fullname' => 'Name ',
			'iscustomer' => 'Is Vendor',
			'recordstatus' => 'Record Status',
            'taxno' => 'Tax No',
            'acchutangid'=>'Account Payable'
		);
	}
	
	private function comparedb($criteria)
	{
		if (isset($_GET['fullname']))
{
	$criteria->compare('fullname',$_GET['fullname'],true);
}
if (isset($_GET['contactphoneno']))
{
	$criteria->compare('addresscontact.phoneno',$_GET['contactphoneno'],true);
}
if (isset($_GET['addressphoneno']))
{
	$criteria->compare('address.phoneno',$_GET['addressphoneno'],true);
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
        $criteria->with=array('acchutang','addresscontact','address');
		$criteria->together = true;		
    $criteria->condition='iscustomer=1';
		$criteria->compare('addressbookid',$this->addressbookid);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('iscustomer',$this->iscustomer);
		$criteria->compare('isemployee',$this->isemployee);
		$criteria->compare('isapplicant',$this->isapplicant);
		$criteria->compare('iscustomer',$this->iscustomer);
		$criteria->compare('isinsurance',$this->isinsurance);
		$criteria->compare('isbank',$this->isbank);
		$criteria->compare('ishospital',$this->ishospital);
		$criteria->compare('t.recordstatus',$this->recordstatus);
		$criteria->compare('acchutang.accountname',$this->acchutangid,true);
		$criteria->compare('taxno',$this->taxno,true);
		$this->comparedb($criteria);


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
		// should not be searchedacchutang

		$criteria=new CDbCriteria;
        $criteria->with=array('acchutang','addresscontact','address');
		$criteria->together = true;		
    $criteria->condition='iscustomer=1 and t.recordstatus=1';
		$criteria->compare('addressbookid',$this->addressbookid);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('iscustomer',$this->iscustomer);
		$criteria->compare('isemployee',$this->isemployee);
		$criteria->compare('isapplicant',$this->isapplicant);
		$criteria->compare('iscustomer',$this->iscustomer);
		$criteria->compare('isinsurance',$this->isinsurance);
		$criteria->compare('isbank',$this->isbank);
		$criteria->compare('ishospital',$this->ishospital);
		$criteria->compare('acchutang.accountname',$this->acchutangid,true);
		$criteria->compare('taxno',$this->taxno,true);
		$this->comparedb($criteria);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}

}