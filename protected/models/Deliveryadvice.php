<?php

/**
 * This is the model class for table "deliveryadvice".
 *
 * The followings are the available columns in table 'deliveryadvice':
 * @property integer $deliveryadviceid
 * @property string $dano
 * @property string $headernote
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Deliveryadvicedetail[] $deliveryadvicedetails
 */
class Deliveryadvice extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Deliveryadvice the static model class
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
		return 'deliveryadvice';
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
			array('recordstatus,useraccessid,slocid', 'numerical', 'integerOnly'=>true),
array('dadate,headernote','length'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('deliveryadviceid, dano, headernote, recordstatus,slocid,useraccessid,dadate', 'safe', 'on'=>'search'),
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
			'deliveryadvicedetails' => array(self::HAS_MANY, 'Deliveryadvicedetail', 'deliveryadviceid'),
			'useraccess' => array(self::BELONGS_TO, 'Useraccess', 'useraccessid'),
			'sloc' => array(self::BELONGS_TO, 'Sloc', 'slocid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'deliveryadviceid' => 'Data',
			'dano' => 'Form Req No',
			'headernote' => 'Header Note',
			'dadate' => 'Form Req Date',
			'recordstatus' => 'Record Status',
        'useraccessid'=>'Created By',
		'slocid'=>'Storage Location (Sloc)'
		);
	}
	
	private function comparedb($criteria)
	{
		if (isset($_GET['dano']))
{
	$criteria->compare('dano',$_GET['dano'],true);
}
if (isset($_GET['headernote']))
{
	$criteria->compare('headernote',$_GET['headernote'],true);
}
if (isset($_GET['username']))
{
	$criteria->compare('useraccess.username',$_GET['username'],true);
}
if (isset($_GET['sloccode']))
{
	$criteria->compare('sloc.sloccode',$_GET['sloccode'],true);
}
if (isset($_GET['description']))
{
	$criteria->compare('sloc.description',$_GET['description'],true);
}
if (isset($_GET['startdate']) && ($_GET['startdate']!==''))
{
	$criteria->compare('dadate','>='.date(Yii::app()->params['datetodb'], strtotime($_GET['startdate'])),true);
}
if (isset($_GET['enddate']) && ($_GET['enddate']!==''))
{
	$criteria->compare('dadate','<='.date(Yii::app()->params['datetodb'], strtotime($_GET['enddate'])),true);
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
        $criteria->with=array('useraccess','sloc');
$this->comparedb($criteria);
		$criteria->compare('deliveryadviceid',$this->deliveryadviceid);
		$criteria->compare('dano',$this->dano,true);
		$criteria->compare('headernote',$this->headernote,true);
		$criteria->compare('dadate',$this->dadate,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('sloc.description',$this->slocid,true);
		$criteria->compare('useraccess.username',$this->useraccessid,true);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}

	public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with=array('useraccess','sloc');
		$this->comparedb($criteria);
		$criteria->condition='recordstatus=1';
		$criteria->compare('deliveryadviceid',$this->deliveryadviceid);
		$criteria->compare('dano',$this->dano,true);
		$criteria->compare('headernote',$this->headernote,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('sloc.description',$this->slocid,true);
		$criteria->compare('useraccess.username',$this->useraccessid,true);
		$criteria->compare('dadate',$this->dadate,true);
		$criteria->compare('sloc.description',$this->slocid,true);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}

        public function beforeSave() {
        $this->dadate =  ($this->dadate!=="")?date(Yii::app()->params['datetodb'], strtotime($this->dadate)):new CDbExpression('NOW()');
    return parent::beforeSave();
}

	public function afterFind() {	
		$this->dadate = date(Useraccess::model()->getformatdate(), strtotime($this->dadate));
	}


        public function searchwfstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with=array('useraccess','sloc');
$criteria->condition="t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listda') and upper(e.username)=upper('".Yii::app()->user->name."') and
t.useraccessid in (select gm.menuvalue from groupmenuauth gm
inner join menuauth ma on ma.menuauthid = gm.menuauthid
where upper(ma.menuobject) = upper('useraccess') and gm.groupaccessid = c.groupaccessid)) ";
		$criteria->compare('deliveryadviceid',$this->deliveryadviceid);
		$criteria->compare('dano',$this->dano,true);
		$criteria->compare('headernote',$this->headernote,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('useraccess.username',$this->useraccessid,true);
		$criteria->compare('dadate',$this->dadate,true);
		$this->comparedb($criteria);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
	
	public function searchwfprstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with=array('useraccess','sloc');
		$criteria->condition="t.recordstatus in (select b.wfbefstat
		from workflow a
		inner join wfgroup b on b.workflowid = a.workflowid
		inner join groupaccess c on c.groupaccessid = b.groupaccessid
		inner join usergroup d on d.groupaccessid = c.groupaccessid
		inner join useraccess e on e.useraccessid = d.useraccessid
		where upper(a.wfname) = upper('listda') and upper(e.username)=upper('".Yii::app()->user->name."') and
		t.useraccessid in (select gm.menuvalue from groupmenuauth gm
		inner join menuauth ma on ma.menuauthid = gm.menuauthid
		where upper(ma.menuobject) = upper('useraccess') and gm.groupaccessid = c.groupaccessid)) and
		t.deliveryadviceid in (select dad.deliveryadviceid
		from deliveryadvicedetail dad
		where qty > prqty
		) ";
		if (isset($_GET['slocid']))
		{
			$criteria->condition .= " and t.slocid = ".$_GET['slocid'];
		}
		$criteria->compare('deliveryadviceid',$this->deliveryadviceid);
		$criteria->compare('dano',$this->dano,true);
		$criteria->compare('headernote',$this->headernote,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('useraccess.username',$this->useraccessid,true);
		$criteria->compare('dadate',$this->dadate,true);
		$this->comparedb($criteria);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
			),
			'criteria'=>$criteria,
		));
	}
    
    public function searchwfqtystatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with=array('useraccess','sloc');
		$criteria->condition="t.recordstatus in (select b.wfbefstat
			from workflow a
			inner join wfgroup b on b.workflowid = a.workflowid
			inner join groupaccess c on c.groupaccessid = b.groupaccessid
			inner join usergroup d on d.groupaccessid = c.groupaccessid
			inner join useraccess e on e.useraccessid = d.useraccessid
			where upper(a.wfname) = upper('listda') and upper(e.username)=upper('".Yii::app()->user->name."') and
			t.deliveryadviceid in (select dad.deliveryadviceid
			from deliveryadvicedetail dad
			where qty > giqty))";
		$criteria->compare('deliveryadviceid',$this->deliveryadviceid);
		$criteria->compare('dano',$this->dano,true);
		$criteria->compare('headernote',$this->headernote,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('useraccess.username',$this->useraccessid,true);
		$criteria->compare('sloc.description',$this->slocid,true);
		$this->comparedb($criteria);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
					'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
				),
			'criteria'=>$criteria,
		));
	}
}