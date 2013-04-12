<?php

/**
 * This is the model class for table "productpurchase".
 *
 * The followings are the available columns in table 'productpurchase':
 * @property integer $productpurchaseid
 * @property integer $productid
 * @property integer $plantid
 * @property integer $orderunit
 * @property integer $purchasinggroupid
 * @property string $validfrom
 * @property integer $isbatch
 * @property integer $isautoPO
 *
 * The followings are the available model relations:
 * @property Unitofmeasure $orderunit0
 * @property Plant $plant
 * @property Product $product
 * @property Purchasinggroup $purchasinggroup
 */
class Productpurchase extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Productpurchase the static model class
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
		return 'productpurchase';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('productid, plantid, orderunit, validfrom, validto', 'required'),
			array('productid, plantid, orderunit, isautoPO', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('productpurchaseid, productid, plantid, orderunit, validfrom, validto, isautoPO', 'safe', 'on'=>'search'),
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
			'orderunit0' => array(self::BELONGS_TO, 'Unitofmeasure', 'orderunit'),
			'plant' => array(self::BELONGS_TO, 'Plant', 'plantid'),
			'product' => array(self::BELONGS_TO, 'Product', 'productid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'productpurchaseid' => 'Data',
			'productid' => 'Product',
			'plantid' => 'Plant',
			'orderunit' => 'Order Unit',
			'validfrom' => 'Valid From',
			'validto' => 'Valid To',
			'isautoPO' => 'Is Auto PR ?',
		);
	}

            public function beforeSave()
    {
      $this->validfrom = date(Yii::app()->params['datetodb'], strtotime($this->validfrom));
      $this->validto = date(Yii::app()->params['datetodb'], strtotime($this->validto));
      return parent::beforeSave();
    }
	
	private function comparedb($criteria)
	{
		if (isset($_GET['productname']))
{
	$criteria->compare('product.productname',$_GET['productname'],true);
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
$criteria->with=array('orderunit0','plant','product');
$this->comparedb($criteria);
		$criteria->compare('productpurchaseid',$this->productpurchaseid);
		$criteria->compare('product.productname',$this->productid,true);
		$criteria->compare('plant.plantcode',$this->plantid,true);
		$criteria->compare('orderunit0.uomcode',$this->orderunit,true);
		$criteria->compare('validfrom',$this->validfrom,true);
		$criteria->compare('validto',$this->validto,true);
		$criteria->compare('isautoPO',$this->isautoPO);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
}