<?php

/**
 * This is the model class for table "productstockdet".
 *
 * The followings are the available columns in table 'productstockdet':
 * @property string $productstockdetid
 * @property string $productid
 * @property string $qty
 * @property string $unitofmeasureid
 * @property string $slocid
 * @property string $transtypeid
 * @property string $prodtranstypeid
 */
class Productstockdet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Productstockdet the static model class
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
		return 'productstockdet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('productid, qty, unitofmeasureid, slocid,  
			referenceno,productstockid', 'length'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('productstockdetid, productid, qty, unitofmeasureid, slocid', 'safe', 'on'=>'search'),
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
          'product' => array(self::BELONGS_TO, 'Product', 'productid'),
          'sloc' => array(self::BELONGS_TO, 'Sloc', 'slocid'),
          'unitofmeasure' => array(self::BELONGS_TO, 'Unitofmeasure', 'unitofmeasureid'),
          'productstock' => array(self::BELONGS_TO, 'Productstock', 'productstockid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'productstockdetid' => 'ID',
			'productid' => 'Product',
			'qty' => 'Qty',
			'unitofmeasureid' => 'UOM',
			'slocid' => 'Sloc',
			'referenceno'=> 'Reference No',
			'productstockid'=>'Product Stock'
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
$criteria->with=array('product','sloc','unitofmeasure','productstock');
		$criteria->compare('productstockdetid',$this->productstockdetid,true);
		$criteria->compare('productid',$this->productid,true);
		$criteria->compare('qty',$this->qty,true);
		$criteria->compare('unitofmeasureid',$this->unitofmeasureid,true);
		$criteria->compare('slocid',$this->slocid,true);
		$criteria->compare('t.productstockid',$this->productstockid,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),			'criteria'=>$criteria,
		));
	}
}