<?php

/**
 * This is the model class for table "wfstatus".
 *
 * The followings are the available columns in table 'wfstatus':
 * @property integer $wfstatusid
 * @property integer $workflowid
 * @property integer $wfstat
 * @property string $statusname
 *
 * The followings are the available model relations:
 * @property Workflow $workflow
 */
class Wfstatus extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Wfstatus the static model class
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
		return 'wfstatus';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('workflowid, wfstat, wfstatusname', 'required'),
			array('workflowid, wfstat', 'numerical', 'integerOnly'=>true),
			array('wfstatusname', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('wfstatusid, workflowid, wfstat, wfstatusname', 'safe', 'on'=>'search'),
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
			'workflow' => array(self::BELONGS_TO, 'Workflow', 'workflowid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'wfstatusid' => 'Data',
			'workflowid' => 'Workflow',
			'wfstat' => 'Wf Status',
			'wfstatusname' => 'Status (Text)',
		);
	}

    public function findstatusname($workflowname,$recordstatus)
    {
      $status = Wfstatus::model()->findbysql("select wfstatusname
        from wfstatus a
        inner join workflow b on b.workflowid = a.workflowid
        where b.wfname = '".$workflowname."' and a.wfstat = ".$recordstatus);
      if ($status != null)
      {
        return $status->wfstatusname;
      }
      else 
      {
        return 0;
      }
    }
	
	private function comparedb($criteria)
	{
		if (isset($_GET['wfname']))
{
	$criteria->compare('workflow.wfname',$_GET['wfname'],true);
}
		if (isset($_GET['wfdesc']))
{
	$criteria->compare('workflow.wfdesc',$_GET['wfdesc'],true);
}
if (isset($_GET['wfstat']))
{
	$criteria->compare('wfstat',$_GET['wfstat'],true);
}
if (isset($_GET['wfstatusname']))
{
	$criteria->compare('wfstatusname',$_GET['wfstatusname'],true);
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
$criteria->with=array('workflow');
$this->comparedb($criteria);
		$criteria->compare('wfstatusid',$this->wfstatusid);
		$criteria->compare('workflow.wfdesc',$this->workflowid,true);
		$criteria->compare('wfstat',$this->wfstat);
		$criteria->compare('wfstatusname',$this->wfstatusname,true);
		
		return new CActiveDataProvider($this, array(
						'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}

}