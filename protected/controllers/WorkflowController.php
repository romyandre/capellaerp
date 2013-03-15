<?php

class WorkflowController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'workflow';
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
      parent::actionCreate();
      $model=new Workflow;
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
      $id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
      if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
          echo CJSON::encode(array(
              'status'=>'success',
              'workflowid'=>$model->workflowid,
              'wfname'=>$model->wfname,
              'wfdesc'=>$model->wfdesc,
              'wfminstat'=>$model->wfminstat,
              'wfmaxstat'=>$model->wfmaxstat,
              'recordstatus'=>$model->recordstatus,
              ));
          Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Workflow'], $_POST['Workflow']['workflowid']);
    }

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Workflow']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Workflow']['wfname'],'emptywfname','emptystring'),
            array($_POST['Workflow']['wfdesc'],'emptywfdesc','emptystring'),
            array($_POST['Workflow']['wfminstat'],'emptywfminstat','emptystring'),
            array($_POST['Workflow']['wfmaxstat'],'emptywfmaxstat','emptystring'),
            )
        );
        if ($messages == '') {
          //$_POST['Workflow']=$_POST['Workflow'];
          if ((int)$_POST['Workflow']['workflowid'] > 0)
          {
            $model=$this->loadModel($_POST['Workflow']['workflowid']);
			$this->olddata = $model->attributes;
			$this->useraction='update';
            $model->wfname = $_POST['Workflow']['wfname'];
            $model->wfdesc = $_POST['Workflow']['wfdesc'];
            $model->wfminstat = $_POST['Workflow']['wfminstat'];
            $model->wfmaxstat = $_POST['Workflow']['wfmaxstat'];
            $model->recordstatus = $_POST['Workflow']['recordstatus'];
          }
          else
          {
            $model = new Workflow();
            $model->attributes=$_POST['Workflow'];
			$this->olddata = $model->attributes;
			$this->useraction='new';
          }
		  $this->newdata = $model->attributes;
          try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Workflow']['workflowid']);
              $this->GetSMessage('swfinsertsuccess');
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
    $model = Workflow::model()->findByPk($data->workflowid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		parent::actionIndex();
    $model=new Workflow('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Workflow']))
			$model->attributes=$_GET['Workflow'];
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
		$sql = "select *
				from workflow a ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.workflowid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Workflow List';
		$this->pdf->AddPage('P');
		$this->pdf->setFont('Arial','B',12);

		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->setaligns(array('C','C','C','C'));
		$this->pdf->setwidths(array(70,70,20,20));
		$this->pdf->Row(array('Workflow Name','Description','Min Status','Max Status'));
		$this->pdf->setaligns(array('L','L','L','L'));
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['wfname'],$row1['wfdesc'],$row1['wfminstat'],$row1['wfmaxstat']));
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
		$model=Workflow::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='workflow-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
