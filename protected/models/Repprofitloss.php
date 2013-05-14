<?php

/**
 * This is the model class for table "repprofitloss".
 *
 * The followings are the available columns in table 'repprofitloss':
 * @property string $repprofitlossid
 * @property string $accountid
 * @property integer $recordstatus
 * @property string $price
 */
class Repprofitloss extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Repprofitloss the static model class
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
		return 'repprofitloss';
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
			array('recordstatus', 'numerical', 'integerOnly'=>true),
			array('accountid', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('repprofitlossid, accountid, recordstatus', 'safe', 'on'=>'search'),
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
			'repprofitlossid' => 'Data',
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
		$criteria->compare('repprofitlossid',$this->repprofitlossid,true);
		$criteria->compare('accountid',$this->accountid,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}
}