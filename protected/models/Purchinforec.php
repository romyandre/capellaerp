<?php

/**
 * This is the model class for table "purchinforec".
 *
 * The followings are the available columns in table 'purchinforec':
 * @property integer $purcinforecid
 * @property integer $addressbookid
 * @property integer $productid
 * @property integer $materialgroupid
 * @property integer $purchasingorgid
 * @property integer $deliverytime
 * @property integer $purchasinggroupid
 * @property double $underdelvtol
 * @property double $overdelvtol
 * @property integer $isunlimited
 * @property integer $isgrbased4
 * @property integer $isconfaknow
 *
 * The followings are the available model relations:
 * @property Addressbook $addressbook
 * @property Product $product
 * @property Materialgroup $materialgroup
 * @property Purchasinggroup $purchasingorg
 */
class Purchinforec extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Purchinforec the static model class
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
		return 'purchinforec';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('addressbookid, productid', 'required'),
			array('addressbookid, productid, deliverytime, purchasinggroupid,recordstatus,currencyid', 'numerical', 'integerOnly'=>true),
			array('underdelvtol, overdelvtol', 'numerical'),
			array('biddate,price', 'length','max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('purchinforecid, addressbookid, productid,
              deliverytime, purchasinggroupid, underdelvtol, overdelvtol,currencyid', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'productid'),
			'purchasinggroup' => array(self::BELONGS_TO, 'Purchasinggroup', 'purchasinggroupid'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'purchinforecid' => 'Data',
			'addressbookid' => 'Supplier',
			'productid' => 'Material',
			'deliverytime' => 'Delivery Time',
			'purchasinggroupid' => 'Purchasing Group',
			'underdelvtol' => 'Under Delv Tol',
			'overdelvtol' => 'Over Delv Tol',
            'price' => 'Price',
            'currencyid' => 'Currency',
            'biddate'=>'Bid Date'
		);
	}

        public function beforeSave()
    {
      $this->biddate = ($this->biddate!=="")?date(Yii::app()->params['datetodb'], strtotime($this->biddate)):new CDbExpression('NOW()');
	  $this->price = Yii::app()->format->unformatNumber($this->price);
      return parent::beforeSave();
    }
	
	public function afterFind() {	
		$this->biddate = date(Useraccess::model()->getformatdate(), strtotime($this->biddate));
		$this->price=Yii::app()->format->formatNumber($this->price);
	}

private function comparedb($criteria)
	{
		if (isset($_GET['fullname']))
{
	$criteria->compare('addressbook.fullname',$_GET['fullname'],true);
}
		if (isset($_GET['productname']))
{
	$criteria->compare('product.productname',$_GET['productname'],true);
}
		if (isset($_GET['purchasinggroupcode']))
{
	$criteria->compare('purchasinggroup.purchasinggroupcode',$_GET['purchasinggroupcode'],true);
}
		if (isset($_GET['purchasinggroupdesc']))
{
	$criteria->compare('purchasinggroup.description',$_GET['purchasinggroupdesc'],true);
}
if (isset($_GET['pricestart']) && ($_GET['pricestart']!==''))
{
	$criteria->compare('price','>='.$_GET['pricestart'],true);
}
if (isset($_GET['priceend']) && ($_GET['priceend']!==''))
{
	$criteria->compare('price','<='.$_GET['priceend'],true);
}
if (isset($_GET['startbiddate']) && ($_GET['startbiddate']!==''))
{
	$criteria->compare('biddate','>='.date(Yii::app()->params['datetodb'], strtotime($_GET['startbiddate'])),true);
}
if (isset($_GET['endbiddate']) && ($_GET['endbiddate']!==''))
{
	$criteria->compare('biddate','<='.date(Yii::app()->params['datetodb'], strtotime($_GET['endbiddate'])),true);
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
        $criteria->with=array('purchasinggroup','addressbook','product','purchasinggroup','currency');
		$this->comparedb($criteria);
		$criteria->compare('purchinforecid',$this->purchinforecid);
		$criteria->compare('addressbook.fullname',$this->addressbookid,true);
		$criteria->compare('product.productname',$this->productid,true);
		$criteria->compare('deliverytime',$this->deliverytime);
		$criteria->compare('purchasinggroup.purchasinggroupname',$this->purchasinggroupid,true);
		$criteria->compare('underdelvtol',$this->underdelvtol);
		$criteria->compare('overdelvtol',$this->overdelvtol);
		$criteria->compare('currency.currencyname',$this->currencyid,true);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
}