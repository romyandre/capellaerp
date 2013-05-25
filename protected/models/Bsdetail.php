<?php

/**
 * This is the model class for table "journaldetail".
 *
 * The followings are the available columns in table 'journaldetail':
 * @property integer $journaldetailid
 * @property integer $genjournalid
 * @property integer $accountid
 * @property string $debit
 * @property string $credit
 *
 * The followings are the available model relations:
 * @property Account $account
 * @property Genjournal $genjournal
 */
class Bsdetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Journaldetail the static model class
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
		return 'bsdetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bsheaderid, productid, unitofmeasureid, quantity,slocid', 'required'),
			array('bsheaderid, productid, unitofmeasureid,currencyid,materialstatusid,ownershipid', 'numerical', 'integerOnly'=>true),
			array('quantity,itemnote,productcode,buyprice,buydate,pono,serialno,expiredate', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bsheaderid, productid, unitofmeasureid, quantity,slocid', 'safe', 'on'=>'search'),
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
			'bsheader' => array(self::BELONGS_TO, 'Bsheader', 'bsheaderid'),
			'product' => array(self::BELONGS_TO, 'Product', 'productid'),
			'unitofmeasure' => array(self::BELONGS_TO, 'Unitofmeasure', 'unitofmeasureid'),
			'sloc' => array(self::BELONGS_TO, 'Sloc', 'slocid'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
			'ownership' => array(self::BELONGS_TO, 'Ownership', 'ownershipid'),
			'materialstatus' => array(self::BELONGS_TO, 'Materialstatus', 'materialstatusid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bsdetailid' => 'ID',
			'bsheaderid' => 'Header',
			'productid' => 'Material',
			'unitofmeasureid' => 'Unit of Measure',
			'slocid' => 'Sloc',
			'quantity' => 'Quantity',
			'itemnote' => 'Item Note',
			'productcode'=>'Material Code',
			'buyprice'=>'Buy Price',
			'buydate'=>'Buy Date',
			'pono'=>'PO No',
			'currencyid'=>'Currency',
			'serialno'=>'Serial No',
			'ownershipid'=>'Ownership',
			'materialstatusid'=>'Material Status'
		);
	}
	
	public function beforeSave()
    {
      $this->buydate = date(Yii::app()->params['datetodb'], strtotime($this->buydate));
      $this->expiredate = date(Yii::app()->params['datetodb'], strtotime($this->expiredate));
      return parent::beforeSave();
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
		$criteria->with=array('product','unitofmeasure','bsheader','sloc','ownership','materialstatus');
if (isset($_GET['Bsdetail'])) {
$model=new Bsdetail('search');
$model->attributes = $_GET['Bsdetail'];
$criteria->condition='t.bsheaderid='.$model->bsheaderid;
} else {
$criteria->condition='t.bsheaderid=0';
}
		$criteria->compare('bsdetailid',$this->bsdetailid);
		$criteria->compare('bsheader.bsheaderid',$this->bsheaderid,true);
		$criteria->compare('product.productname',$this->productid,true);
		$criteria->compare('unitofmeasure.uomcode',$this->unitofmeasureid,true);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('sloc.sloccode',$this->slocid,true);
		$criteria->compare('itemnote',$this->itemnote,true);
		$criteria->compare('ownership.ownershipname',$this->ownershipid,true);
		$criteria->compare('materialstatus.materialstatusname',$this->materialstatusid,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function behaviors()
  {
    return array(
        // Classname => path to Class
        'ActiveRecordLogableBehavior'=>
            'application.behaviors.ActiveRecordLogableBehavior',
    );
  }
}
