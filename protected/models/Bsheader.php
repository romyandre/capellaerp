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
class Bsheader extends CActiveRecord
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
		return 'bsheader';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('recordstatus', 'required'),
			array('recordstatus', 'numerical', 'integerOnly'=>true),
			array('headernote', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bsheaderid, bsdate,postdate, recordstatus', 'safe', 'on'=>'search'),
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
			//'bsdetail' => array(self::HAS_MANY, 'Bsdetail', 'bsheaderid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bsheaderid' => 'ID',
			'bsdate' => 'Tools Stock Date',
			'postdate' => 'Post Date',
			'recordstatus' => 'Record Status',
			'headernote'=>'Header Note'
		);
	}

    public function beforeSave() {
        $this->bsdate = date(Yii::app()->params['datetodb'], strtotime($this->bsdate));
        $this->postdate = $this->bsdate;
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

		$criteria->compare('bsheaderid',$this->bsheaderid);
		$criteria->compare('bsdate',$this->bsdate,true);
		$criteria->compare('postdate',$this->postdate,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('headernote',$this->headernote,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}

	public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition='recordstatus=1';
		$criteria->compare('bsheaderid',$this->bsheaderid);
		$criteria->compare('bsdate',$this->bsdate,true);
		$criteria->compare('postdate',$this->postdate,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('headernote',$this->headernote,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}

	public function searchwfstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
$criteria->condition="t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listbs') and upper(e.username)=upper('".Yii::app()->user->name."'))";
		$criteria->compare('bsheaderid',$this->bsheaderid);
		$criteria->compare('bsdate',$this->bsdate,true);
		$criteria->compare('postdate',$this->postdate,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('headernote',$this->headernote,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
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
