<?php

class GroupaccessController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'groupaccess';
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
		$model=new Groupaccess;
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
				'groupaccessid'=>$model->groupaccessid,
				'groupname'=>$model->groupname,
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
      }
	}
	
	protected function gridData($data,$row)
  {     
    $model = Groupaccess::model()->findByPk($data->groupaccessid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }
  
    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Groupaccess'], $_POST['Groupaccess']['groupaccessid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Groupaccess']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Groupaccess']['groupname'],'emptygroupname','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Groupaccess'];
		if ((int)$_POST['Groupaccess']['groupaccessid'] > 0)
		{
		  $model=$this->loadModel($_POST['Groupaccess']['groupaccessid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->groupname = $_POST['Groupaccess']['groupname'];
		  $model->recordstatus = $_POST['Groupaccess']['recordstatus'];
		}
		else
		{
		  $model = new Groupaccess();
		  $model->attributes=$_POST['Groupaccess'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Groupaccess']['groupaccessid']);
              $this->GetSMessage('sugainsertsuccess');
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
		$model=new Groupaccess('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Groupaccess']))
			$model->attributes=$_GET['Groupaccess'];
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
		$sql = "select groupname
				from groupaccess a ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.groupaccessid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Group Access List';
		$this->pdf->AddPage('P');
		$this->pdf->setFont('Arial','B',12);

		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->colalign = array('C');
		$this->pdf->setwidths(array(90));
		$this->pdf->colheader =array('Group Name'); 
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign=array('L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['groupname']));
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
		$model=Groupaccess::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='groupaccess-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
