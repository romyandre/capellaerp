<?php

class PaymentmethodController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'paymentmethod';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
		$model=new Paymentmethod;

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
	  $model=$this->loadModel($_POST['id']);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $_POST['id']) == false)
        {
          $this->InsertLock($this->menuname, $_POST['id']);
            echo CJSON::encode(array(
                'status'=>'success',
				'paymentmethodid'=>$model->paymentmethodid,
				'paycode'=>$model->paycode,
				'paymentname'=>$model->paymentname,
				'paydays'=>$model->paydays,
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Paymentmethod'], $_POST['Paymentmethod']['paymentmethodid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Paymentmethod']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Paymentmethod']['paycode'],'emptypaycode','emptystring'),
                array($_POST['Paymentmethod']['paymentname'],'emptypaymentname','emptystring'),
                array($_POST['Paymentmethod']['paydays'],'emptypaydays','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Paymentmethod'];
		if ((int)$_POST['Paymentmethod']['paymentmethodid'] > 0)
		{
		  $model=$this->loadModel($_POST['Paymentmethod']['paymentmethodid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->paycode = $_POST['Paymentmethod']['paycode'];
		  $model->paymentname = $_POST['Paymentmethod']['paymentname'];
		  $model->paydays = $_POST['Paymentmethod']['paydays'];
		  $model->recordstatus = $_POST['Paymentmethod']['recordstatus'];
		}
		else
		{
		  $model = new Paymentmethod();
		  $model->attributes=$_POST['Paymentmethod'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Paymentmethod']['paymentmethodid']);
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

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
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
	
	protected function gridData($data,$row)
  {     
    $model = Paymentmethod::model()->findByPk($data->paymentmethodid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
    $model=new Paymentmethod('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Paymentmethod']))
			$model->attributes=$_GET['Paymentmethod'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
		));
	}

  public function actionDownload()
  {
    parent::actionDownload();
    $sql = "select paycode, paymentname, paydays
				from paymentmethod a ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.paymentmethodid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Payment Method List';
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C');
		$this->pdf->setwidths(array(40,90,40));
		$this->pdf->colheader = array('Payment Code','Payment Name','Pay Day');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L','R');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['paycode'],$row1['paymentname'],$row1['paydays']));
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
		$model=Paymentmethod::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='paymentmethod-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
