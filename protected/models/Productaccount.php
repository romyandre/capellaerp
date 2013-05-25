<?php

/**
 * This is the model class for table "productaccount".
 *
 * The followings are the available columns in table 'productaccount':
 * @property string $productaccountid
 * @property integer $productid
 * @property integer $expenseaccount
 * @property integer $salesaccount
 * @property integer $salesretaccount
 * @property integer $salesitemaccount
 * @property integer $purcretaccount
 * @property integer $isactiva
 *
 * The followings are the available model relations:
 * @property Account $salesitemaccount0
 * @property Account $purcretaccount0
 * @property Product $product
 * @property Account $expenseaccount0
 * @property Account $salesaccount0
 * @property Account $salesretaccount0
 */
class Productaccount extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Productaccount the static model class
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
		return 'productaccount';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('productid', 'required'),
			array('productid, expenseaccount, salesaccount, salesretaccount, 
			salesitemaccount, purcretaccount, isactiva,unbilledaccount', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('productaccountid, productid, expenseaccount, salesaccount, 
			salesretaccount, salesitemaccount, purcretaccount, unbilledaccount,
			isactiva', 'safe', 'on'=>'search'),
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
			'salesitemaccount0' => array(self::BELONGS_TO, 'Account', 'salesitemaccount'),
			'purcretaccount0' => array(self::BELONGS_TO, 'Account', 'purcretaccount'),
			'product' => array(self::BELONGS_TO, 'Product', 'productid'),
			'expenseaccount0' => array(self::BELONGS_TO, 'Account', 'expenseaccount'),
			'salesaccount0' => array(self::BELONGS_TO, 'Account', 'salesaccount'),
			'salesretaccount0' => array(self::BELONGS_TO, 'Account', 'salesretaccount'),
			'unbilledaccount0' => array(self::BELONGS_TO, 'Account', 'unbilledaccount'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'productaccountid' => 'Data',
			'productid' => 'Product',
			'expenseaccount' => 'Expense Account',
			'salesaccount' => 'Sales Account',
			'salesretaccount' => 'Sales Return Account',
			'salesitemaccount' => 'Sales Item Account',
			'purcretaccount' => 'Purchasing Return Account',
			'isactiva' => 'Is Activa',
			'unbilledaccount'=>'Unbilled Account'
		);
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
$criteria->with=array('product','salesitemaccount0','purcretaccount0','expenseaccount0',
'salesaccount0','salesretaccount0','unbilledaccount0');
$this->comparedb($criteria);
		$criteria->compare('productaccountid',$this->productaccountid,true);
		$criteria->compare('productid',$this->productid);
		$criteria->compare('expenseaccount',$this->expenseaccount);
		$criteria->compare('salesaccount',$this->salesaccount);
		$criteria->compare('salesretaccount',$this->salesretaccount);
		$criteria->compare('salesitemaccount',$this->salesitemaccount);
		$criteria->compare('purcretaccount',$this->purcretaccount);
		$criteria->compare('unbilledaccount',$this->unbilledaccount);
		$criteria->compare('isactiva',$this->isactiva);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}
}