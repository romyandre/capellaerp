<?php

class BsheaderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'bsheader';

	public $bsdetail,$sloc,$product,$unitofmeasure,$currency,$ownership,$materialstatus;

	public function lookupdetail()
	{
		$this->sloc=new Sloc('search');
	  $this->sloc->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$this->sloc->attributes=$_GET['Sloc'];

	  $this->product=new Product('search');
	  $this->product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$this->product->attributes=$_GET['Product'];

		$this->unitofmeasure=new Unitofmeasure('search');
	  $this->unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$this->unitofmeasure->attributes=$_GET['Unitofmeasure'];
		
		$this->currency=new Currency('search');
	  $this->currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$this->currency->attributes=$_GET['Currency'];
		
		$this->ownership=new Ownership('search');
	  $this->ownership->unsetAttributes();  // clear any default values
	  if(isset($_GET['Ownership']))
		$this->ownership->attributes=$_GET['Ownership'];
		
		$this->materialstatus=new Materialstatus('search');
	  $this->materialstatus->unsetAttributes();  // clear any default values
	  if(isset($_GET['Materialstatus']))
		$this->materialstatus->attributes=$_GET['Materialstatus'];
	}

	public function lookupdata()
	{
		$this->bsdetail=new Bsdetail('search');
	  $this->bsdetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Bsdetail']))
		$this->bsdetail->attributes=$_GET['Bsdetail'];

		$this->lookupdetail();
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		parent::actionCreate();
	  $this->lookupdata();
		$model=new Bsheader;
		$model->recordstatus=Wfgroup::model()->findstatusbyuser('insbs');
		if (Yii::app()->request->isAjaxRequest)
        {
			if ($model->save()) {
			  echo CJSON::encode(array(
				  'status'=>'success',
				  'bsheaderid'=>$model->bsheaderid,
				  ));
			  Yii::app()->end();
			}
        }
	}

	public function actionCreatedetail()
	{
		parent::actionCreate();
		$this->lookupdetail();

		$bsdetail=new Bsdetail;

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
		parent::actionCreate();
		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);

	  $this->lookupdata();
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'bsheaderid'=>$model->bsheaderid,
				'bsdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->bsdate)),
				'recordstatus'=>$model->recordstatus,
				'headernote'=>$model->headernote,
				));
            Yii::app()->end();
        }
        }
	}

	public function actionUpdatedetail()
	{
		$this->lookupdetail();

		$id=$_POST['id'];
	  $bsdetail=$this->loadModeldetail($id[0]);
if ($bsdetail != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'bsdetailid'=>$bsdetail->bsdetailid,
				'productid'=>$bsdetail->productid,
				'productname'=>($bsdetail->product!==null)?$bsdetail->product->productname:"",
				'unitofmeasureid'=>$bsdetail->unitofmeasureid,
				'uomcode'=>($bsdetail->unitofmeasure!==null)?$bsdetail->unitofmeasure->uomcode:"",
				'quantity'=>$bsdetail->quantity,
				'slocid'=>$bsdetail->slocid,
				'sloccode'=>($bsdetail->sloc!==null)?$bsdetail->sloc->description:"",
				'itemnote'=>$bsdetail->itemnote,
				'buyprice'=>$bsdetail->buyprice,
				'buydate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($bsdetail->buydate)),
				'expiredate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($bsdetail->expiredate)),
				'currencyid'=>$bsdetail->currencyid,
				'currencyname'=>($bsdetail->currency!==null)?$bsdetail->currency->currencyname:"",
				'ownershipid'=>$bsdetail->ownershipid,
				'ownershipname'=>($bsdetail->ownership!==null)?$bsdetail->ownership->ownershipname:"",
				'materialstatusid'=>$bsdetail->materialstatusid,
				'materialstatusname'=>($bsdetail->materialstatus!==null)?$bsdetail->materialstatus->materialstatusname:"",
				'pono'=>$bsdetail->pono,
				'serialno'=>$bsdetail->serialno,
				'location'=>$bsdetail->location,
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Bsheader'], 
              $_POST['Bsheader']['bsheaderid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Bsheader']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Bsheader']['bsdate'],'emptydate','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Bsheader']['bsheaderid'] > 0)
		{
		  $model=$this->loadModel($_POST['Bsheader']['bsheaderid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->bsdate = $_POST['Bsheader']['bsdate'];
		  $model->headernote = $_POST['Bsheader']['headernote'];
		}
		else
		{
		  $model = new Bsheader();
		  $model->attributes=$_POST['Bsheader'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Bsheader']['bsheaderid']);
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

	public function actionWritedetail()
	{
	  if(isset($_POST['Bsdetail']))
	  {
	  $messages = $this->ValidateData(
                array(array($_POST['Bsdetail']['productid'],'emptyproductid','emptystring'),
				array($_POST['Bsdetail']['quantity'],'emptyquantity','emptystring'),
				array($_POST['Bsdetail']['slocid'],'emptyslocid','emptystring'),
				array($_POST['Bsdetail']['unitofmeasureid'],'emptyunitofmeasureid','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Bsdetail']['bsdetailid'] > 0)
		{
		  $model=Bsdetail::model()->findbyPK($_POST['Bsdetail']['bsdetailid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->bsheaderid = $_POST['Bsdetail']['bsheaderid'];
		  $model->productid = $_POST['Bsdetail']['productid'];
		  $model->unitofmeasureid = $_POST['Bsdetail']['unitofmeasureid'];
		  $model->quantity = $_POST['Bsdetail']['quantity'];
		  $model->slocid = $_POST['Bsdetail']['slocid'];
		  $model->itemnote = $_POST['Bsdetail']['itemnote'];
		  $model->buyprice = $_POST['Bsdetail']['buyprice'];
		  $model->buydate = $_POST['Bsdetail']['buydate'];
		  $model->pono = $_POST['Bsdetail']['pono'];
		  $model->currencyid = $_POST['Bsdetail']['currencyid'];
		  $model->serialno = $_POST['Bsdetail']['serialno'];
		  $model->location = $_POST['Bsdetail']['location'];
		  $model->ownershipid = $_POST['Bsdetail']['ownershipid'];
		  $model->materialstatusid = $_POST['Bsdetail']['materialstatusid'];
		  $model->expiredate = $_POST['Bsdetail']['expiredate'];
		}
		else
		{
		  $model = new Bsdetail();
		  $model->attributes=$_POST['Bsdetail'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
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
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=$this->loadModel($ids);
		  $model->recordstatus=0;
		  $model->save();
		}
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeletedetail()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Bsdetail::model()->findbyPK($ids);
		  $model->delete();
		}
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}

	public function actionApprove()
	{
		parent::actionApprove();
		$id=$_POST['id'];
		foreach($id as $ids)
		{
			$model=$this->loadModel($ids);
			$connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call Approvebs(:vid, :vlastupdateby)';
				$command=$connection->createCommand($sql);
				$command->bindValue(':vid',$model->bsheaderid,PDO::PARAM_INT);
				$command->bindValue(':vlastupdateby', Yii::app()->user->name,PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
					  'status'=>'success',
					  'div'=>"Data saved"
					));
				}
			  }
			  catch(Exception $e) // an exception is raised if a query fails
			  {
				  $transaction->rollBack();
				  if (Yii::app()->request->isAjaxRequest)
				  {
					  echo CJSON::encode(array(
						'status'=>'failure',
						'div'=>$e->getMessage()
					  ));
				  }
			  }
		}
        Yii::app()->end();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		parent::actionIndex();
	  $this->lookupdata();
		$model=new Bsheader('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Bsheader']))
			$model->attributes=$_GET['Bsheader'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
					'bsdetail'=>$this->bsdetail,
					'product'=>$this->product,
					'unitofmeasure'=>$this->unitofmeasure,
					'currency'=>$this->currency,
					'ownership'=>$this->ownership,
					'materialstatus'=>$this->materialstatus,
				  'sloc'=>$this->sloc
		));
	}

	public function actionIndexdetail()
	{
		$this->lookupdata();
	  $this->renderPartial('indexdetail',
		array('bsdetail'=>$this->bsdetail,
					'product'=>$this->product,
					'unitofmeasure'=>$this->unitofmeasure,
					'currency'=>$this->currency,
					'ownership'=>$this->ownership,
					'materialstatus'=>$this->materialstatus,
				  'sloc'=>$this->sloc));
	  Yii::app()->end();
	}

	public function actionDownload()
  {
    Yii::import('application.extensions.fpdf.*');
    require_once("pdf.php");
    $pdf = new PDF();
    $pdf->title='Absence Schedule List';
    $pdf->AddPage('L');
    $pdf->setFont('Arial','B',12);

    // definisi font
    $pdf->setFont('Arial','B',8);

    // menuliskan tabel
    $header = array('No','ID','Schedule Name','Absence In','Absence Out', 'Status', 'Wage Name', 'Currency', 'Insentif');
    $model=new Absschedule('searchwstatus');
    $dataprovider=$model->searchwstatus();
    $dataprovider->pagination=false;
    $data = $dataprovider->getData();
    $cols = $dataprovider->getKeys();
    $dataku=array(count($data));
    //var_dump($dataku);
    $w= array(20,25,30,30,30,30,30,30,30);
    $pdf->SetTableHeader();
    //Header
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $pdf->Ln();
    $pdf->SetTableData();
    //Data
    $fill=false;
    foreach($data as $n=>$datas)
    {
        $pdf->Cell($w[0],6,$n,'LR',0,'C',$fill);
        $pdf->Cell($w[1],6,$datas['absscheduleid'],'LR',0,'C',$fill);
        $pdf->Cell($w[2],6,$datas['absschedulename'],'LR',0,'C',$fill);
        $pdf->Cell($w[3],6,$datas['absin'],'LR',0,'C',$fill);
        $pdf->Cell($w[4],6,$datas['absout'],'LR',0,'C',$fill);
        $pdf->Cell($w[5],6,Absstatus::model()->findByPk($datas['absstatusid'])->shortstat,'LR',0,'C',$fill);
        $pdf->Cell($w[6],6,Wagetype::model()->findByPk($datas['wagetypeid'])->wagename,'LR',0,'C',$fill);
        $pdf->Cell($w[7],6,Currency::model()->findByPk($datas['currencyid'])->currencyname,'LR',0,'C',$fill);
        $pdf->Cell($w[8],6,number_format($datas['insentif']),'LR',0,'C',$fill);
        $pdf->Ln();
        $fill=!$fill;
    }
    $pdf->Cell(array_sum($w),0,'','T');


    // me-render ke browser
    $pdf->Output();
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Bsheader::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Bsdetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='bsheader-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='bsdetail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
