<?php

/**
 * This is the model class for table "invoice".
 *
 * The followings are the available columns in table 'invoice':
 * @property string $invoiceid
 * @property string $invoiceno
 * @property string $pono
 * @property string $sono
 * @property integer $addressbookid
 * @property string $amount
 * @property integer $currencyid
 * @property string $rate
 * @property integer $recordstatus
 * @property string $invoicetypeid
 *
 * The followings are the available model relations:
 * @property Addressbook $addressbook
 * @property Currency $currency
 * @property Invoiceacc[] $invoiceaccs
 * @property Invoicedet[] $invoicedets
 */
class Invoice extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Invoice the static model class
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
		return 'invoice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('currencyid, recordstatus,paymentmethodid,poheaderid,soheaderid,addressid', 'numerical', 'integerOnly'=>true),
			array('invoiceno,supplier', 'length', 'max'=>50),
			array('amount, rate,invoicedate,fpdate', 'length', 'max'=>30),
			array('invoicetypeid', 'length', 'max'=>10),
			array('headernote', 'length'),
			array('fpno', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invoiceid, invoiceno, poheaderid,soheaderid, fpdate,paymentmethodid,headernote, currencyid, 
				invoicedate, recordstatus, invoicetypeid,supplier,customer,
				addressid', 'safe', 'on'=>'search'),
		);
	}
	
	public $supplier;
	public $customer;

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
			'paymentmethod' => array(self::BELONGS_TO, 'Paymentmethod', 'paymentmethodid'),
			'invoiceaccs' => array(self::HAS_MANY, 'Invoiceacc', 'invoiceid'),
			'invoicedets' => array(self::HAS_MANY, 'Invoicedet', 'invoiceid'),
			'tax' => array(self::BELONGS_TO, 'Tax', 'taxid'),
			'poheader' => array(self::BELONGS_TO, 'Poheader', 'poheaderid'),
			'soheader' => array(self::BELONGS_TO, 'Soheader', 'soheaderid'),
			'address' => array(self::BELONGS_TO, 'Address', 'addressid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invoiceid' => 'ID',
			'invoiceno' => 'Invoice No',
			'poheaderid' => 'PO No',
			'soheaderid' => 'SO No',
			'amount' => 'Amount',
			'currencyid' => 'Currency',
			'rate' => 'Rate',
			'recordstatus' => 'Record Status',
			'invoicetypeid' => 'Invoice Type',
			'invoicedate' => 'Invoice Date',
			'headernote' => 'Note',
			'paymentmethodid'=>'Payment Method',
			'taxid'=>'Tax',
			'supplier'=>'Supplier',
			'customer'=>'Customer',
			'fpno'=>'Tax No',
			'fpdate'=>'Tax Date',
			'addressid'=>'Address'
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
$criteria->with=array('poheader','soheader','tax','paymentmethod','currency','addressid');
$criteria->condition = 't.poheaderid in (select poheaderid from poheader a 
inner join addressbook b on b.addressbookid = a.addressbookid
where upper(b.fullname) like upper("%'.$this->supplier.'%")) or t.poheaderid in (select poheaderid from poheader a 
inner join addressbook b on b.addressbookid = a.addressbookid
where upper(b.fullname) like upper("%'.$this->customer.'%"))';
		$criteria->compare('invoiceid',$this->invoiceid,true);
		$criteria->compare('invoiceno',$this->invoiceno,true);
		$criteria->compare('invoicedate',$this->invoicedate,true);
		$criteria->compare('poheader.pono',$this->poheaderid,true);
		$criteria->compare('soheader.sono',$this->soheaderid,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
		$criteria->compare('rate',$this->rate,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('invoicetypeid',$this->invoicetypeid,true);
		$criteria->compare('fpno',$this->fpno,true);
		$criteria->compare('fpdate',$this->fpdate,true);
		$criteria->compare('headernote',$this->headernote,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}
	
	public function searchwfarstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
$criteria->with=array('soheader','tax','paymentmethod','currency','address','soheader.addressbook');
$criteria->condition="t.invoicetypeid = 2 and t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listinvar') and upper(e.username)=upper('".Yii::app()->user->name."'))";
		$criteria->compare('invoiceid',$this->invoiceid,true);
		$criteria->compare('invoiceno',$this->invoiceno,true);
		$criteria->compare('invoicedate',$this->invoicedate,true);
		$criteria->compare('soheader.sono',$this->soheaderid,true);
		$criteria->compare('addressbook.fullname',$this->customer,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
		$criteria->compare('rate',$this->rate,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('invoicetypeid',$this->invoicetypeid,true);
		$criteria->compare('fpno',$this->fpno,true);
		$criteria->compare('fpdate',$this->fpdate,true);
		$criteria->compare('address.addressname',$this->addressid,true);
		$criteria->compare('headernote',$this->headernote,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}
	
	public function searcharstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
$criteria->with=array('soheader','tax','paymentmethod','currency','address','soheader.addressbook');
$criteria->condition="t.invoicetypeid = 2";
		$criteria->compare('invoiceid',$this->invoiceid,true);
		$criteria->compare('invoiceno',$this->invoiceno,true);
		$criteria->compare('invoicedate',$this->invoicedate,true);
		$criteria->compare('soheader.sono',$this->soheaderid,true);
		$criteria->compare('addressbook.fullname',$this->customer,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
		$criteria->compare('rate',$this->rate,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('invoicetypeid',$this->invoicetypeid,true);
		$criteria->compare('fpno',$this->fpno,true);
		$criteria->compare('fpdate',$this->fpdate,true);
		$criteria->compare('address.addressname',$this->addressid,true);
		$criteria->compare('headernote',$this->headernote,true);
		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}
	
	public function searchwfapstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
$criteria->with=array('poheader','tax','paymentmethod','currency','poheader.addressbook');
$criteria->condition="t.invoicetypeid = 1 and t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listinvap') and upper(e.username)=upper('".Yii::app()->user->name."'))
";
		$criteria->compare('invoiceid',$this->invoiceid,true);
		$criteria->compare('invoiceno',$this->invoiceno,true);
		$criteria->compare('invoicedate',$this->invoicedate,true);
		$criteria->compare('poheader.pono',$this->poheaderid,true);
		$criteria->compare('addressbook.fullname',$this->supplier,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
		$criteria->compare('rate',$this->rate,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('invoicetypeid',$this->invoicetypeid,true);
		$criteria->compare('fpno',$this->fpno,true);
		$criteria->compare('fpdate',$this->fpdate,true);
		$criteria->compare('headernote',$this->headernote,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}
	
	public function searchapstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
$criteria->with=array('poheader','tax','paymentmethod','currency','poheader.addressbook');
$criteria->condition="t.invoicetypeid = 1";
		$criteria->compare('invoiceid',$this->invoiceid,true);
		$criteria->compare('invoiceno',$this->invoiceno,true);
		$criteria->compare('invoicedate',$this->invoicedate,true);
		$criteria->compare('poheader.pono',$this->poheaderid,true);
		$criteria->compare('addressbook.fullname',$this->supplier,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
		$criteria->compare('rate',$this->rate,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('invoicetypeid',$this->invoicetypeid,true);
		$criteria->compare('fpno',$this->fpno,true);
		$criteria->compare('fpdate',$this->fpdate,true);
		$criteria->compare('headernote',$this->headernote,true);
		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}
	
	public function beforeSave() {
        $this->invoicedate = ($this->invoicedate!=="")?date(Yii::app()->params['datetodb'], strtotime($this->invoicedate)):new CDbExpression('NOW()');
        $this->fpdate = ($this->fpdate!=="")?date(Yii::app()->params['datetodb'], strtotime($this->fpdate)):null;
    return parent::beforeSave();
}

public function afterFind()
	{
		$this->amount=Yii::app()->format->formatNumber($this->amount);
	}

}