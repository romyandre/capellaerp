<?php

class KelurahanController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'kelurahan';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $subdistrict=new Subdistrict('searchwstatus');
	  $subdistrict->unsetAttributes();  // clear any default values
	  if(isset($_GET['Subdistrict']))
		$subdistrict->attributes=$_GET['Subdistrict'];

		$model=new Kelurahan;

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
	  $subdistrict=new Subdistrict('searchwstatus');
	  $subdistrict->unsetAttributes();  // clear any default values
	  if(isset($_GET['Subdistrict']))
		$subdistrict->attributes=$_GET['Subdistrict'];
	  $model=$this->loadModel($_POST['id']);
      if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $_POST['id']) == false)
        {
          $this->InsertLock($this->menuname, $_POST['id']);
            echo CJSON::encode(array(
                'status'=>'success',
                'kelurahanid'=>$model->kelurahanid,
                'subdistrictid'=>$model->subdistrictid,
                'subdistrictname'=>$model->subdistrict->subdistrictname,
                'kelurahanname'=>$model->kelurahanname,
                'recordstatus'=>$model->recordstatus,
                ));
            Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Kelurahan'], $_POST['Kelurahan']['kelurahanid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Kelurahan']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Kelurahan']['kelurahanname'],'emptysubsubdistrict','emptystring'),
                array($_POST['Kelurahan']['subdistrictid'],'emptysubdistrictname','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Kelurahan'];
		if ((int)$_POST['Kelurahan']['kelurahanid'] > 0)
		{
		  $model=$this->loadModel($_POST['Kelurahan']['kelurahanid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->kelurahanname = $_POST['Kelurahan']['kelurahanname'];
		  $model->subdistrictid = $_POST['Kelurahan']['subdistrictid'];
		  $model->recordstatus = $_POST['Kelurahan']['recordstatus'];
		}
		else
		{
		  $model = new Kelurahan();
		  $model->attributes=$_POST['Kelurahan'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Kelurahan']['kelurahanid']);
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
	  $subdistrict=new Subdistrict('searchwstatus');
	  $subdistrict->unsetAttributes();  // clear any default values
	  if(isset($_GET['Subdistrict']))
		$subdistrict->attributes=$_GET['Subdistrict'];
		$model=new Kelurahan('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Kelurahan']))
			$model->attributes=$_GET['Kelurahan'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
			'subdistrict'=>$subdistrict
		));
	}

  public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select subdistrictname,kelurahanname
				from kelurahan a
left join subdistrict b on b.subdistrictid = a.subdistrictid				";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.kelurahanid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Sub Subdistrict List';
		$this->pdf->AddPage('P');
		$this->pdf->setFont('Arial','B',12);

		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->setaligns(array('C','C'));
		$this->pdf->setwidths(array(90,70));
		$this->pdf->Row(array('Subdistrictname','Kelurahan'));
		$this->pdf->setaligns(array('L','L'));
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['subdistrictname'],$row1['kelurahanname']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	
	protected function gridData($data,$row)
  {     
    $model = Kelurahan::model()->findByPk($data->kelurahanid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Kelurahan::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='kelurahan-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
