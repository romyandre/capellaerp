<?php

class AccountController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
 protected $menuname = 'account';
	public $parentaccount,$currency,$accounttype;
	
	public function lookupdata()
	{
	  $this->parentaccount=new Account('searchwstatus');
	  $this->parentaccount->unsetAttributes();  // clear any default values
	  if(isset($_GET['Account']))
		$this->parentaccount->attributes=$_GET['Account'];

	  $this->currency=new Currency('searchwstatus');
	  $this->currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$this->currency->attributes=$_GET['Currency'];

      $this->accounttype=new Accounttype('searchwstatus');
	  $this->accounttype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Accounttype']))
		$this->accounttype->attributes=$_GET['Accounttype'];
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $this->lookupdata();
	  $model=new Account;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  ));
		  Yii::app()->end();
	  }
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
	  parent::actionUpdate();
	  $this->lookupdata();
	  $model=$this->loadModel($_POST['id']);
	  if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $_POST['id']) == false)
        {
          $this->InsertLock($this->menuname, $_POST['id']);
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'accountid'=>$model->accountid,
			  'accountname'=>$model->accountname,
			  'accountcode'=>$model->accountcode,
			  'parentaccountid'=>$model->parentaccountid,
			  'parentaccountname'=>($model->parentaccount!==null)?$model->parentaccount->accountcode:"",
			  'accounttypeid'=>$model->accounttypeid,
			  'accounttypename'=>($model->accounttype!==null)?$model->accounttype->accounttypename:"",
			  'currencyid'=>$model->currencyid,
			  'currencyname'=>$model->currency->currencyname,
			  'recordstatus'=>$model->recordstatus,
			  ));
		  Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
	  $this->DeleteLockCloseForm($this->menuname, $_POST['Account'], $_POST['Account']['accountid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Account']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Account']['accountname'],'emptyaccountname','emptystring'),
                array($_POST['Account']['accountcode'],'emptyaccountcode','emptystring'),
                array($_POST['Account']['currencyid'],'emptycurrency','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Account'];
		if ((int)$_POST['Account']['accountid'] > 0)
		{
		  $model=$this->loadModel($_POST['Account']['accountid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->accountname = $_POST['Account']['accountname'];
		  $model->accountcode = $_POST['Account']['accountcode'];
		  $model->parentaccountid = $_POST['Account']['parentaccountid'];
		  $model->currencyid = $_POST['Account']['currencyid'];
		  $model->accounttypeid = $_POST['Account']['accounttypeid'];
		  $model->recordstatus = $_POST['Account']['recordstatus'];
		}
		else
		{
		  $model = new Account();
		  $model->attributes=$_POST['Account'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname,$_POST['Account']['accountid']);
              $this->GetSMessage('insertsuccess');
            }
            else
            {
              $this->GetMessage($model->getErrors());
            }
          }
          catch (Exception $e)
          {
            $this->GetMessage($e->getMessage());
          }
        }
	  }
	}
	
	protected function gridData($data,$row)
  {     
    $model = Account::model()->findByPk($data->accountid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
      parent::actionDelete();
      $model=$this->loadModel($_POST['id']);
		  $model->recordstatus=0;
		  $model->save();
      echo CJSON::encode(array(
              'status'=>'success',
              'div'=>'Data deleted'
              ));
      Yii::app()->end();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
      parent::actionIndex();
	  $this->lookupdata();
	  $model=new Account('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Account']))
			$model->attributes=$_GET['Account'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		'model'=>$model,
				  'parentaccount'=>$this->parentaccount,
				  'currency'=>$this->currency,
                  'accounttype'=>$this->accounttype
	  ));
	}
  
	public function coa($connection,$pdf,$accountid)
	{
		$sql = "select distinct a.accountid, a.accountcode, a.accountname,d.symbol,c.accounttypename
				from account a
				left join accounttype c on c.accounttypeid = a.accounttypeid
				left join currency d on d.currencyid = a.currencyid
				where a.parentaccountid = ".$accountid." and accounttypename = 'Detail'
				order by a.accountcode ";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		foreach($dataReader as $row)
		{
			$this->pdf->row(array($row['accountcode'],'       '.$row['accountname'],$row['accounttypename'],$row['symbol']));
		}
  }
  
  public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select distinct a.accountid, a.accountcode, a.accountname,d.symbol,c.accounttypename
from account a
inner join account b on b.parentaccountid = a.accountid
left join accounttype c on c.accounttypeid = a.accounttypeid
left join currency d on d.currencyid = a.currencyid
where accounttypename = 'Header' ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "and a.accountid = ".$_GET['id'];
		}
		$sql = $sql . " order by a.accountcode ";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Chart of Account List';
		$this->pdf->AddPage('P');		$this->pdf->colalign = array('C','C','C','C','C'); 
		$this->pdf->colheader = array('Account Code','Account Name','Account Type','Currency');
		$this->pdf->setwidths(array(30,100,40,20));
		$this->pdf->rowheader();
		$this->pdf->coldetailalign=array('L','L','L','L','L');
		foreach($dataReader as $row)
		{
			$this->pdf->row(array($row['accountcode'],$row['accountname'],$row['accounttypename'],$row['symbol']));
			$this->coa($this->connection,$this->pdf,$row['accountid']);
		}
		// me-render ke browser
		$this->pdf->Output();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Account::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='account-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
