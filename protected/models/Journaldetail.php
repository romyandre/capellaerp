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
class Journaldetail extends CActiveRecord
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
		return 'journaldetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('genjournalid, accountid, debit, credit,ratevalue,currencyid', 'required',
				'message'=>'harus diisi'),
			array('genjournalid, accountid', 'numerical', 'integerOnly'=>true,
				'message'=>'harus angka'),
			array('debit, credit,ratevalue', 'length',
				'message'=>'harus angka'),
			array('detailnote', 'length',
				'message'=>'ka'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('journaldetailid, genjournalid, accountid, debit, credit,currencyid,detailnote,ratevalue', 'safe', 'on'=>'search'),
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
			'genjournal' => array(self::BELONGS_TO, 'Genjournal', 'genjournalid'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'journaldetailid' => 'Data',
			'genjournalid' => 'Header',
			'accountid' => 'Account',
			'debit' => 'Debit',
			'credit' => 'Credit',
			'currencyid' => 'Currency',
			'detailnote' => 'Detail Note',
			'ratevalue'=>'Rate'
		);
	}
	
	public function afterFind()
	{
		$this->debit=Yii::app()->format->formatNumber($this->debit);
		$this->credit=Yii::app()->format->formatNumber($this->credit);
		$this->ratevalue=Yii::app()->format->formatNumber($this->ratevalue);
	}
	
	public function beforeSave()
	{
		$this->debit=Yii::app()->format->unformatNumber($this->debit);
		$this->credit=Yii::app()->format->unformatNumber($this->credit);
		$this->ratevalue=Yii::app()->format->unformatNumber($this->ratevalue);
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
		$criteria->with=array('genjournal','account','currency');
		if (isset($_GET['Journaldetail'])) {
$criteria->condition='t.genjournalid='.$_GET['Journaldetail']['genjournalid'];
} else {
$criteria->condition='t.genjournalid=0';
}
		$criteria->compare('journaldetailid',$this->journaldetailid);
		$criteria->compare('genjournal.genjournalid',$this->genjournalid,true);
		$criteria->compare('t.accountid',$this->accountid);
		$criteria->compare('debit',$this->debit,true);
		$criteria->compare('credit',$this->credit,true);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Useraccess::model()->findbyattributes(array('username'=>Yii::app()->user->id))->pagesize),
    ),'criteria'=>$criteria,
		));
	}
	
	public function getTotalDebit()
	{
		$total=0;
		$connection=Yii::app()->db;
			  try
			  {
				$sql = 'select sum((ifnull(debit,0) * ifnull(ratevalue,0))) as total 
				from journaldetail a 
				where a.genjournalid = '.$this->genjournalid;
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
		
		public function getTotalCredit()
	{
		$total=0;
		$connection=Yii::app()->db;
			  try
			  {
				$sql = 'select sum((ifnull(credit,0) * ifnull(ratevalue,0))) as total 
				from journaldetail a 
				where a.genjournalid = '.$this->genjournalid;
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