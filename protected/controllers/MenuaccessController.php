<?php

class MenuaccessController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'menuaccess';
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $model=new Menuaccess;

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
				'menuaccessid'=>$model->menuaccessid,
				'menuname'=>$model->menuname,
				'menucode'=>$model->menucode,
				'menuurl'=>$model->menuurl,
                'description'=>$model->description,
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
      }
	}
	
	protected function gridData($data,$row)
  {     
    $model = menuaccess::model()->findByPk($data->menuaccessid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

   public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Menuaccess'], $_POST['Menuaccess']['menuaccessid']);
    }

    public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Menuaccess']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Menuaccess']['menucode'],'emptymenucode','emptystring'),
            array($_POST['Menuaccess']['menuname'],'emptymenuname','emptystring'),
            array($_POST['Menuaccess']['menuurl'],'emptymenuurl','emptystring'),
            )
        );
        if ($messages == '') {
          if ((int)$_POST['Menuaccess']['menuaccessid'] > 0)
          {
            $model=$this->loadModel($_POST['Menuaccess']['menuaccessid']);
			$this->olddata = $model->attributes;
			$this->useraction='update';
            $model->menuname = $_POST['Menuaccess']['menuname'];
            $model->menucode = $_POST['Menuaccess']['menucode'];
            $model->menuurl = $_POST['Menuaccess']['menuurl'];
            $model->description = $_POST['Menuaccess']['description'];
            $model->recordstatus = $_POST['Menuaccess']['recordstatus'];
          }
          else
          {
            $model = new Menuaccess();
            $model->attributes=$_POST['Menuaccess'];
			$this->olddata = $model->attributes;
			$this->useraction='new';
          }
		  $this->newdata = $model->attributes;
          try
            {
              if($model->save())
              {
			  $this->InsertTranslog();
                $this->DeleteLock($this->menuname, $_POST['Menuaccess']['menuaccessid']);
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
		$model=new Menuaccess('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Menuaccess']))
			$model->attributes=$_GET['Menuaccess'];
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
		$sql = "select menucode, menuname,description,menuurl
				from menuaccess a ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.menuaccessid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Menu Access List';
		$this->pdf->AddPage('P');
		$this->pdf->setFont('Arial','B',12);

		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->colalign = array('C');
		$this->pdf->setwidths(array(90));
		$this->pdf->colheader=array('Menu Code','Menu Name','Description','Menu Url');
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign=array('L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['menucode'],$row1['menuname'],$row1['menuname']));
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
		$model=Menuaccess::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='menuaccess-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
