<?php

class WfstatusController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'wfstatus';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
      $model=new Wfstatus;

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
              'wfstatusid'=>$model->wfstatusid,
              'workflowid'=>$model->workflowid,
              'wfname'=>($model->workflow!==null)?$model->workflow->wfname:"",
              'wfstatusname'=>$model->wfstatusname,
              'wfstat'=>$model->wfstat,
              ));
          Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Wfstatus'], $_POST['Wfstatus']['wfstatusid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Wfstatus']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Wfstatus']['workflowid'],'cpremptyworkflow','emptystring'),
                array($_POST['Wfstatus']['wfstatusname'],'cpremptywfstatusname','emptystring'),
            )
        );
        if ($messages == '') {
          //$dataku->attributes=$_POST['Wfstatus'];
          if ((int)$_POST['Wfstatus']['wfstatusid'] > 0)
          {
            $model=$this->loadModel($_POST['Wfstatus']['wfstatusid']);
			$this->olddata = $model->attributes;
			$this->useraction='update';
            $model->wfstatusname = $_POST['Wfstatus']['wfstatusname'];
            $model->workflowid = $_POST['Wfstatus']['workflowid'];
            $model->wfstat = $_POST['Wfstatus']['wfstat'];
          }
          else
          {
            $model = new Wfstatus();
            $model->attributes=$_POST['Wfstatus'];
			$this->olddata = $model->attributes;
			$this->useraction='new';
          }
		   $this->newdata = $model->attributes;
          try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Wfstatus']['wfstatusid']);
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
    $model = Wfstatus::model()->findByPk($data->wfstatusid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
    $model=new Wfstatus('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Wfstatus']))
			$model->attributes=$_GET['Wfstatus'];
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
		$sql = "select wfname,wfdesc,wfstat,wfstatusname
				from wfstatus a
left join workflow b on b.workflowid = a.workflowid ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.workflowid = ".$_GET['id'];
		}
		$sql = $sql . " order by wfname,wfstat";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Workflow List';
		$this->pdf->AddPage('P');

		$this->pdf->colalign = array('C','C','C','C');
		$this->pdf->setwidths(array(40,60,20,60));
		$this->pdf->colheader = array('Wf Name','Wf Description','Wf Number','Wf Status');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign=array('L','L','C','L');
		$s = '';
		foreach($dataReader as $row1)
		{
			if ($s !== $row1['wfname'])
			{
				$s = $row1['wfname'];
				$this->pdf->row(array($s,$row1['wfdesc'],$row1['wfstat'],$row1['wfstatusname']));
			}
			else
			{
				$this->pdf->row(array('',$row1['wfdesc'],$row1['wfstat'],$row1['wfstatusname']));
			}
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
		$model=Wfstatus::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='wfstatus-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
