<?php

/**
 * This is the model class for table "repneraca".
 *
 * The followings are the available columns in table 'repneraca':
 * @property string $repneracaid
 * @property string $accountid
 * @property integer $recordstatus
 * @property string $price
 */
class Repneraca extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Repneraca the static model class
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
		return 'repneraca';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('accountid, recordstatus', 'required'),
			array('recordstatus,accountid', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('repneracaid, accountid, recordstatus', 'safe', 'on'=>'search'),
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
          'account' => array(self::BELONGS_TO, 'Account', 'accountid'),
          'debit' => array(self::HAS_MANY, 'Genledger', 'accountid'),
          'credit' => array(self::HAS_MANY, 'Genledger', 'accountid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'repneracaid' => 'Data',
			'accountid' => 'Account',
			'recordstatus' => 'Record Status',
		);
	}
	
	private function comparedb($criteria)
	{
		if (isset($_GET['accountcode']))
{
	$criteria->compare('account.accountcode',$_GET['accountcode'],true);
}
		if (isset($_GET['accountname']))
{
	$criteria->compare('account.accountname',$_GET['accountname'],true);
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
		$criteria->with=array('account');
		$this->comparedb($criteria);
		$criteria->compare('repneracaid',$this->repneracaid,true);
		$criteria->compare('accountid',$this->accountid,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}