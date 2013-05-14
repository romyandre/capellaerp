<?php

/**
 * This is the model class for table "genjournal".
 *
 * The followings are the available columns in table 'genjournal':
 * @property integer $genjournalid
 * @property string $referenceno
 * @property string $journaldate
 * @property string $journalnote
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Journaldetail[] $journaldetails
 */
class Genjournal extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Genjournal the static model class
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
		return 'genjournal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('recordstatus', 'numerical', 'integerOnly'=>true),
			array('referenceno,journaldate,postdate', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('genjournalid, referenceno, journaldate, journalnote, recordstatus', 'safe', 'on'=>'search'),
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
			'journaldetails' => array(self::HAS_MANY, 'Journaldetail', 'genjournalid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'genjournalid' => 'Data',
			'journalno'=>'Journal No',
			'referenceno' => 'Reference No',
			'journaldate' => 'Journal Date',
			'journalnote' => 'Journal Note',
			'postdate'=>'Post Date',
			'recordstatus' => 'Record Status',
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
		$this->comparedb($criteria);
		$criteria->compare('genjournalid',$this->genjournalid);
		$criteria->compare('referenceno',$this->referenceno,true);
		$criteria->compare('journaldate',$this->journaldate,true);
		$criteria->compare('postdate',$this->postdate,true);
		$criteria->compare('journalnote',$this->journalnote,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Useraccess::model()->findbyattributes(array('username'=>Yii::app()->user->id))->pagesize),
    ),
			'criteria'=>$criteria,
		));
	}

    public function beforeSave() {
        $this->journaldate = ($this->journaldate!=="")?date(Yii::app()->params['datetodb'], strtotime($this->journaldate)):new CDbExpression('NOW()');;
        $this->postdate = ($this->postdate!=="")?date(Yii::app()->params['datetodb'], strtotime($this->postdate)):new CDbExpression('NOW()');;
		return parent::beforeSave();
	}

	public function afterFind() {	
		$this->journaldate = date(Useraccess::model()->getformatdate(), strtotime($this->journaldate));
		$this->postdate = date(Useraccess::model()->getformatdate(), strtotime($this->postdate));
	}

	public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$this->comparedb($criteria);
		$criteria->condition='recordstatus=1';
		$criteria->compare('genjournalid',$this->genjournalid);
		$criteria->compare('referenceno',$this->referenceno,true);
		$criteria->compare('journaldate',$this->journaldate,true);
		$criteria->compare('journalnote',$this->journalnote,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Useraccess::model()->findbyattributes(array('username'=>Yii::app()->user->id))->pagesize),
    ),
			'criteria'=>$criteria,
		));
	}

	private function comparedb($criteria)
	{
		if (isset($_GET['journalno']))
{
	$criteria->compare('journalno',$_GET['journalno'],true);
}
if (isset($_GET['referenceno']))
{
	$criteria->compare('referenceno',$_GET['referenceno'],true);
}
if (isset($_GET['journalnote']))
{
	$criteria->compare('journalnote',$_GET['journalnote'],true);
}
if (isset($_GET['startdate']))
{
	$criteria->compare('journaldate','>='.date(Yii::app()->params['datetodb'], strtotime($_GET['startdate'])),true);
}
if (isset($_GET['enddate']))
{
	$criteria->compare('journaldate','<='.date(Yii::app()->params['datetodb'], strtotime($_GET['enddate'])),true);
}
}

	public function searchwfstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$this->comparedb($criteria);
$criteria->condition="t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listjournal') and upper(e.username)=upper('".Yii::app()->user->name."'))";
		$criteria->compare('genjournalid',$this->genjournalid);
		$criteria->compare('referenceno',$this->referenceno,true);
		$criteria->compare('journaldate',$this->journaldate,true);
		$criteria->compare('journalnote',$this->journalnote,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Useraccess::model()->findbyattributes(array('username'=>Yii::app()->user->id))->pagesize),
    ),
			'criteria'=>$criteria,
		));
	}
}
