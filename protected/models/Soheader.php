<?php

/**
 * This is the model class for table "genjournal".
 *
 * The followings are the available columns in table 'genjournal':
 * @property integer $genjournalid
 * @property string $sono
 * @property string $journaldate
 * @property string $journalnote
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Journaldetail[] $journaldetails
 */
class Soheader extends CActiveRecord
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
		return 'soheader';
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
			array('recordstatus,servicetypeid', 'numerical', 'integerOnly'=>true),
			array('sono,addressbookid,contractno,currencyid,startdate,enddate,projectvalue,projecttypeid,projectname,personincharge,employeeid', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('soheaderid, sono, sodate,postdate, recordstatus,startdate,enddate,servicetypeid,addressbookid,currencyid,projecttypeid,projectname,employeeid,
			personincharge', 'safe', 'on'=>'search'),
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
			'customer' => array(self::BELONGS_TO, 'Customer', 'addressbookid'),
			'addressbook' => array(self::BELONGS_TO, 'Addressbook', 'addressbookid'),
			'projecttype' => array(self::BELONGS_TO, 'Projecttype', 'projecttypeid'),
			'employee' => array(self::BELONGS_TO, 'Employee', 'employeeid'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
			'servicetype' => array(self::BELONGS_TO, 'Servicetype', 'servicetypeid'),
			'paymentmethod' => array(self::BELONGS_TO, 'Paymentmethod', 'paymentmethodid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'soheaderid' => 'ID',
			'sono' => 'SO No',
			'sodate' => 'SO Date',
			'postdate' => 'Post Date',
			'addressbookid'=>'Customer',
			'projecttypeid'=>'Project Type',
			'customerid'=>'Customer',
			'employeeid'=>'Sales in Charge',
			'contractno'=>'Contract No',
			'startdate'=>'Start Date',
			'enddate'=>'End Date',
			'projectvalue'=>'Project Value',
			'currencyid'=>'Currency',
			'personincharge'=>'PIC Client/Customer',
			'projectname'=>'Project Name',
			'recordstatus' => 'Record Status',
			'servicetypeid'=>'Service Type',
			'paymentmethodid'=>'Payment Method',
			'headernote'=>'Header Note'
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
		$criteria->with=array('projecttype','employee','customer','servicetype');
		$criteria->compare('soheaderid',$this->soheaderid);
		$criteria->compare('sono',$this->sono,true);
		$criteria->compare('sodate',$this->sodate,true);
		$criteria->compare('postdate',$this->postdate,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('projecttype.projecttypename',$this->projecttypeid,true);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('customer.fullname',$this->addressbookid,true);
		$criteria->compare('servicetype.servicetypename',$this->servicetypeid,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);

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
		$criteria->with=array('projecttype','employee','customer','servicetype');
		 $criteria->condition="t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listso') and upper(e.username)=upper('".Yii::app()->user->name."'))";
		$criteria->compare('soheaderid',$this->soheaderid);
		$criteria->compare('sono',$this->sono,true);
		$criteria->compare('sodate',$this->sodate,true);
		$criteria->compare('postdate',$this->postdate,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('projecttype.projecttypename',$this->projecttypeid,true);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('customer.fullname',$this->addressbookid,true);
		$criteria->compare('servicetype.servicetypename',$this->servicetypeid,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}

        public function beforeSave() {
		if ($this->sodate!==null)
		{
			$this->postdate = date(Yii::app()->params['datetodb'], strtotime($this->sodate));
			$this->sodate = date(Yii::app()->params['datetodb'], strtotime($this->sodate));
		}
		if ($this->startdate!==null)
		{
			$this->startdate = date(Yii::app()->params['datetodb'], strtotime($this->startdate));
		}
		if ($this->enddate!==null)
		{
			$this->enddate = date(Yii::app()->params['datetodb'], strtotime($this->enddate));
		}
    return parent::beforeSave();
}

public function getTotals()
	{
		$total=0;
		$connection=Yii::app()->db;
			  try
			  {
				$sql = 'select sum(ifnull(price,0) * ifnull(qty,0) * ifnull(currencyrate,0)) as total from sodetail where soheaderid = '.$this->soheaderid;
				$command=$connection->createCommand($sql);
				$row = 	$command->queryRow();
				$total = $row['total'];
				return $total;
			  }
			  catch(Exception $e) // an exception is raised if a query fails
			  {
				return $total;
			}
		}
		
		public function getallTotals()
	{
		$total=0;
		$connection=Yii::app()->db;
			  try
			  {
				$sql = "select sum(ifnull(price,0) * ifnull(qty,0) * ifnull(currencyrate,0)) as total from sodetail a
					inner join soheader c on c.soheaderid = a.soheaderid 
					left join paymentmethod b on b.paymentmethodid = c.paymentmethodid
					left join addressbook d on d.addressbookid = c.addressbookid
					where sodate like '%".$this->sodate."%' 
					and upper(paycode) like upper('%".$this->paymentmethodid."%')
					and upper(fullname) like upper('%".$this->addressbookid."%')
					and upper(headernote) like upper('%".$this->headernote."%')
					";
				$command=$connection->createCommand($sql);
				$row = 	$command->queryRow();
				$total = $row['total'];
				return $total;
			  }
			  catch(Exception $e) // an exception is raised if a query fails
			  {
				return $total;
			}
		}

	public function searchwfstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('projecttype','employee','customer','servicetype');
 $criteria->condition="t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listso') and upper(e.username)=upper('".Yii::app()->user->name."'))";

		$criteria->compare('soheaderid',$this->soheaderid);
		$criteria->compare('sono',$this->sono,true);
		$criteria->compare('sodate',$this->sodate,true);
		$criteria->compare('postdate',$this->postdate,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('projecttype.projecttypename',$this->projecttypeid,true);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('customer.fullname',$this->addressbookid,true);
		$criteria->compare('servicetype.servicetypename',$this->servicetypeid,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
	
		public function searchwfinvstatus()
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
where upper(a.wfname) = upper('listso') and upper(e.username)=upper('".Yii::app()->user->name."')) 
and t.soheaderid in (
select zz.soheaderid
from sodetail zz
where zz.invqty < zz.qty
)";
		 $criteria->with=array('customer','paymentmethod','employee');
		$criteria->compare('soheaderid',$this->soheaderid);
		$criteria->compare('paymentmethod.paymentmethodname',$this->paymentmethodid,true);
		$criteria->compare('sodate',$this->sodate,true);
		$criteria->compare('customer.fullname',$this->addressbookid,true);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('t.recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}
	
	public function searchwfqtystatus()
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
where upper(a.wfname) = upper('listso') and upper(e.username)=upper('".Yii::app()->user->name."')) 
and t.soheaderid in (
select zz.soheaderid
from sodetail zz
where zz.giqty < zz.qty
)";
		 $criteria->with=array('customer','paymentmethod','employee');
		$criteria->compare('soheaderid',$this->soheaderid);
		$criteria->compare('paymentmethod.paymentmethodname',$this->paymentmethodid,true);
		$criteria->compare('sodate',$this->sodate,true);
		$criteria->compare('customer.fullname',$this->addressbookid,true);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('t.recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}
}