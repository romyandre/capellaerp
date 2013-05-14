<?php

/**
 * This is the model class for table "podetail".
 *
 * The followings are the available columns in table 'podetail':
 * @property integer $podetailid
 * @property integer $poheaderid
 * @property integer $productid
 * @property double $poqty
 * @property integer $unitofmeasureid
 * @property string $delvdate
 * @property double $netprice
 * @property integer $currencyid
 * @property integer $slocid
 * @property integer $taxid
 *
 * The followings are the available model relations:
 * @property Poheader $poheader
 * @property Product $product
 * @property Unitofmeasure $unitofmeasure
 * @property Currency $currency
 * @property Sloc $sloc
 * @property Tax $tax
 */
class Podetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Podetail the static model class
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
		return 'podetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('poheaderid, productid, poqty, unitofmeasureid, netprice, currencyid, slocid, taxid', 'required'),
			array('poheaderid, productid, unitofmeasureid, currencyid, slocid, taxid, underdelvtol, overdelvtol,prdetailid', 'numerical', 'integerOnly'=>true),
			array('poqty, netprice,ratevalue', 'numerical'),
			array('itemtext', 'length'),
			array('delvdate', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('podetailid, poheaderid, productid, poqty, unitofmeasureid, delvdate, netprice, currencyid, slocid, taxid,itemtext', 'safe', 'on'=>'search'),
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
			'poheader' => array(self::BELONGS_TO, 'Poheader', 'poheaderid'),
			'product' => array(self::BELONGS_TO, 'Product', 'productid'),
			'unitofmeasure' => array(self::BELONGS_TO, 'Unitofmeasure', 'unitofmeasureid'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
			'sloc' => array(self::BELONGS_TO, 'Sloc', 'slocid'),
			'tax' => array(self::BELONGS_TO, 'Tax', 'taxid'),
			'prdetail' => array(self::BELONGS_TO, 'Prmaterial', 'prdetailid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'podetailid' => 'Data',
			'poheaderid' => 'Header',
			'productid' => 'Product',
			'poqty' => 'Qty',
			'unitofmeasureid' => 'UOM',
			'delvdate' => 'Delivery Date',
			'netprice' => 'Price',
			'currencyid' => 'Currency',
			'slocid' => 'Sloc',
			'taxid' => 'Tax',
			'itemtext' => 'Item Text',
                        'prdetailid' => 'Pr Material',
                    'underdelvtol' => 'Under Delivery Tolerance',
                    'overdelvtol' => 'Over Delivery Tolerance',
            'qtyres'=>'GR Qty',
			'ratevalue'=>'Rate'
		);
	}
	
	public $subtotal,$taxvalue;
	
	public function beforeSave() {
      $this->delvdate = ($this->delvdate!=="")?date(Yii::app()->params['datetodb'], strtotime($this->delvdate)):new CDbExpression('NOW()');
	  $this->poqty = Yii::app()->format->unformatNumber($this->poqty);
	  $this->qtyres=Yii::app()->format->unformatNumber($this->qtyres);
		$this->netprice=Yii::app()->format->unformatNumber($this->netprice);
		$this->ratevalue=Yii::app()->format->unformatNumber($this->ratevalue);
      return parent::beforeSave();
    }
	
		public function afterFind() {	
		$this->delvdate = date(Useraccess::model()->getformatdate(), strtotime($this->delvdate));
		$this->taxvalue = Yii::app()->format->formatNumber(($this->poqty * $this->netprice * $this->ratevalue * $this->tax->taxvalue)/100);
		$this->subtotal = (($this->poqty * $this->netprice * $this->ratevalue * $this->tax->taxvalue)/100) + 
					($this->poqty * $this->netprice * $this->ratevalue);	
		$this->subtotal = Yii::app()->format->formatNumber($this->subtotal);
		$this->poqty=Yii::app()->format->formatNumber($this->poqty);
		$this->qtyres=Yii::app()->format->formatNumber($this->qtyres);
		$this->netprice=Yii::app()->format->formatNumber($this->netprice);
		$this->ratevalue=Yii::app()->format->formatNumber($this->ratevalue);
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
		$criteria->with=array('poheader','tax','currency','product','unitofmeasure','sloc','prdetail');
                if (isset($_GET['Podetail'])) {
$model=new Podetail('search');
$criteria->condition='t.poheaderid='.$_GET['Podetail']['poheaderid'];
} else {
$criteria->condition='t.poheaderid=0';
}
		$criteria->compare('podetailid',$this->podetailid);
		$criteria->compare('poheader.poheaderid',$this->poheaderid,true);
		$criteria->compare('product.productname',$this->productid,true);
		$criteria->compare('poqty',$this->poqty);
		$criteria->compare('unitofmeasure.uomcode',$this->unitofmeasureid,true);
		$criteria->compare('delvdate',$this->delvdate,true);
		$criteria->compare('netprice',$this->netprice);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
		$criteria->compare('sloc.sloccode',$this->slocid,true);
		$criteria->compare('tax.taxcode',$this->taxid,true);
		$criteria->compare('itemtext',$this->itemtext,true);
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function searchwfqtystatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with=array('prheader');
$criteria->condition="prheader.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listpo') and upper(e.username)=upper('".Yii::app()->user->name."') and t.qty > t.qtyres and poheader.pono is not null)";
		$criteria->compare('podetailid',$this->podetailid);
		$criteria->compare('poheader.poheaderid',$this->poheaderid,true);
		$criteria->compare('product.productname',$this->productid,true);
		$criteria->compare('poqty',$this->poqty);
		$criteria->compare('unitofmeasure.uomcode',$this->unitofmeasureid,true);
		$criteria->compare('delvdate',$this->delvdate,true);
		$criteria->compare('netprice',$this->netprice);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
		$criteria->compare('sloc.sloccode',$this->slocid,true);
		$criteria->compare('tax.taxcode',$this->taxid,true);
		$criteria->compare('itemtext',$this->itemtext,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
	
	public function getTotals()
	{
		$total=0;
		$connection=Yii::app()->db;
			  try
			  {
				$sql = 'select sum((ifnull(netprice,0) * ifnull(poqty,0) * ifnull(ratevalue,0)) + ((ifnull(netprice,0) * ifnull(poqty,0) * ifnull(b.taxvalue,0) * ifnull(ratevalue,0) / 100))) as total 
				from podetail a 
				left join tax b on b.taxid = a.taxid
				where a.poheaderid = '.$this->poheaderid;
				$command=$connection->createCommand($sql);
				$row = 	$command->queryRow();
				$total = $row['total'];
				return Yii::app()->format->formatNumber($total);
			  }
			  catch(Exception $e) // an exception is raised if a query fails
			  {
				return $total;
			}
		}
}