<?php

/**
 * This is the model class for table "prheader".
 *
 * The followings are the available columns in table 'prheader':
 * @property integer $prheaderid
 * @property string $prno
 * @property string $headernote
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Prheaderdetail[] $prheaderdetails
 */
class Prheader extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Prheader the static model class
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
		return 'prheader';
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
			array('recordstatus,slocid,deliveryadviceid', 'numerical', 'integerOnly'=>true),
			array('prno', 'length', 'max'=>50),
			array('headernote', 'length'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('prheaderid, prno, headernote, recordstatus,slocid,deliveryadviceid', 'safe', 'on'=>'search'),
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
			'prheaderdetails' => array(self::HAS_MANY, 'Prheaderdetail', 'prheaderid'),
			'sloc' => array(self::BELONGS_TO, 'Sloc', 'slocid'),
			'deliveryadvice' => array(self::BELONGS_TO, 'Deliveryadvice', 'deliveryadviceid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'prheaderid' => 'Data',
			'prno' => 'PR No',
			'headernote' => 'Header Note',
			'prdate' => 'PR Date',
            'slocid'=>'Storage Location',
			'recordstatus' => 'Record Status',
            'deliveryadviceid'=>'Form Request'
		);
	}
	
	private function comparedb($criteria)
	{
		if (isset($_GET['prno']))
		{
			$criteria->compare('prno',$_GET['prno'],true);
		}
		if (isset($_GET['headernote']))
		{
			$criteria->compare('headernote',$_GET['headernote'],true);
		}
		if (isset($_GET['sloccode']))
		{
			$criteria->compare('sloc.sloccode',$_GET['sloccode'],true);
		}
		if (isset($_GET['description']))
		{
			$criteria->compare('sloc.description',$_GET['description'],true);
		}
		if (isset($_GET['dano']))
		{
			$criteria->compare('deliveryadvice.dano',$_GET['dano'],true);
		}
		if (isset($_GET['startdate']) && ($_GET['startdate']!==''))
		{
			$criteria->compare('prdate','>='.date(Yii::app()->params['datetodb'], strtotime($_GET['startdate'])),true);
		}
		if (isset($_GET['enddate']) && ($_GET['enddate']!==''))
		{
			$criteria->compare('prdate','<='.date(Yii::app()->params['datetodb'], strtotime($_GET['enddate'])),true);
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
        $criteria->with=array('sloc','deliveryadvice');
		$this->comparedb($criteria);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
			),'criteria'=>$criteria,
		));
	}

    public function beforeSave() {
       $this->prdate = ($this->prdate!=="")?date(Yii::app()->params['datetodb'], strtotime($this->prdate)):new CDbExpression('NOW()');;
		return parent::beforeSave();
	}

	public function afterFind() {	
		$this->prdate = date(Useraccess::model()->getformatdate(), strtotime($this->prdate));
	}

        public function searchwfstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with=array('sloc','deliveryadvice');
		$criteria->condition="t.recordstatus in (select b.wfbefstat
			from workflow a
			inner join wfgroup b on b.workflowid = a.workflowid
			inner join groupaccess c on c.groupaccessid = b.groupaccessid
			inner join usergroup d on d.groupaccessid = c.groupaccessid
			inner join useraccess e on e.useraccessid = d.useraccessid
			where upper(a.wfname) = upper('listpr') and upper(e.username)=upper('".Yii::app()->user->name."') and
			t.slocid in (select gm.menuvalue from groupmenuauth gm
			inner join menuauth ma on ma.menuauthid = gm.menuauthid
			where upper(ma.menuobject) = upper('sloc') and gm.groupaccessid = c.groupaccessid))";
		$criteria->compare('prheaderid',$this->prheaderid);
		$criteria->compare('prno',$this->prno,true);
		$criteria->compare('t.headernote',$this->headernote,true);
		$criteria->compare('deliveryadvice.dano',$this->deliveryadviceid,true);
		$criteria->compare('sloc.description',$this->slocid,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$this->comparedb($criteria);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
}