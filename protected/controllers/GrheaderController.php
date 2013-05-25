<?php

class GrheaderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'grheader';

	public function actionHelp()
	{
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $this->txt = '_help'; break;
				case 2 : $this->txt = '_helpmodif'; break;
				case 3 : $this->txt = '_helpdetail'; break;
				case 4 : $this->txt = '_helpdetailmodif'; break;
			}
		}
		parent::actionHelp();
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $grdetail=new Grdetail('search');
	  $grdetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Grdetail']))
		$grdetail->attributes=$_GET['Grdetail'];

		$poheader=new Poheader('search');
	  $poheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Poheader']))
		$poheader->attributes=$_GET['Poheader'];

      $giheader=new Giheader('search');
	  $giheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Giheader']))
		$giheader->attributes=$_GET['Giheader'];

		$model=new Grheader;
		$model->recordstatus=Wfgroup::model()->findstatusbyuser('insgr');
		if (Yii::app()->request->isAjaxRequest)
        {
			if ($model->save()) {
			  echo CJSON::encode(array(
				  'status'=>'success',
				  'grheaderid'=>$model->grheaderid,
				  'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
					'poheader'=>$poheader,
					'grdetail'=>$grdetail,
                      'giheader'=>$giheader), true)
				  ));
			  Yii::app()->end();
			}
        }
	}

	public function actionCreatedetail()
	{
		$grdetail=new Grdetail;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_formdetail',
				  array('model'=>$grdetail), true)
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
	   $grdetail=new Grdetail('search');
	  $grdetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Grdetail']))
		$grdetail->attributes=$_GET['Grdetail'];

		$poheader=new Poheader('search');
	  $poheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Poheader']))
		$poheader->attributes=$_GET['Poheader'];

      $giheader=new Giheader('search');
	  $giheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Giheader']))
		$giheader->attributes=$_GET['Giheader'];

		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'grheaderid'=>$model->grheaderid,
				'grno'=>$model->grno,
				'grdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->grdate)),
				'poheaderid'=>$model->poheaderid,
				'pono'=>($model->poheader!==null)?$model->poheader->pono:"",
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
					'poheader'=>$poheader,
					'grdetail'=>$grdetail,
                    'giheader'=>$giheader), true)
				));
            Yii::app()->end();
        }
	}

	public function actionUpdatedetail()
	{
		$id=$_POST['id'];
	  $grdetail=$this->loadModeldetail($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'grdetailid'=>$grdetail->grdetailid,
				'productid'=>$grdetail->productid,
				'productname'=>($grdetail->product!==null)?$grdetail->product->productname:"",
				'unitofmeasureid'=>$grdetail->unitofmeasureid,
				'uomcode'=>($grdetail->unitofmeasure!==null)?$grdetail->unitofmeasure->uomcode:"",
				'qty'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$grdetail->qty),
				'slocid'=>$grdetail->slocid,
				'sloccode'=>($grdetail->sloc!==null)?$grdetail->sloc->description:"",
                'div'=>$this->renderPartial('_formdetail',
				  array('model'=>$grdetail), true)
				));
            Yii::app()->end();
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Grheader'], $_POST['Grheader']['grheaderid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Grheader']))
	  {
		if ((int)$_POST['Grheader']['grheaderid'] > 0)
		{
		  $model=$this->loadModel($_POST['Grheader']['grheaderid']);
		  $model->poheaderid = $_POST['Grheader']['poheaderid'];
		  $model->giheaderid = $_POST['Grheader']['giheaderid'];
		  $model->grdate = $_POST['Grheader']['grdate'];
		}
		else
		{
		  $model = new Grheader();
		  $model->attributes=$_POST['Grheader'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Grheader']['grheaderid']);
              $this->GetSMessage('scoinsertsuccess');
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

        public function actionGeneratedetail()
        {
          if(isset($_POST['id']))
	  {
              $connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call GenerateGRPO(:vid, :vhid)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['id'],PDO::PARAM_INT);
				$command->bindvalue(':vhid', $_POST['hid'],PDO::PARAM_INT);
				$command->execute();
				$transaction->commit();
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
					  'status'=>'success',
					  'div'=>"Data generated"
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

        public function actionGenerategidetail()
        {
          if(isset($_POST['id']))
	  {
              $connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call GenerateGIGR(:vid, :vhid)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['id'],PDO::PARAM_INT);
				$command->bindvalue(':vhid', $_POST['hid'],PDO::PARAM_INT);
				$command->execute();
				$transaction->commit();
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
					  'status'=>'success',
					  'div'=>"Data generated"
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

	public function actionWritedetail()
	{
	  if(isset($_POST['Grdetail']))
	  {
		//$dataku->attributes=$_POST['Grdetail'];
		if ((int)$_POST['Grdetail']['grdetailid'] > 0)
		{
		  $model=Grdetail::model()->findbyPK($_POST['Grdetail']['grdetailid']);
		  $model->grheaderid = $_POST['Grdetail']['grheaderid'];
		  $model->productid = $_POST['Grdetail']['productid'];
		  $model->unitofmeasureid = $_POST['Grdetail']['unitofmeasureid'];
		  $model->qty = $_POST['Grdetail']['qty'];
		  $model->slocid = $_POST['Grdetail']['slocid'];
		$model->qty = str_replace(",","",$model->qty);
		}
		else
		{
		  $model = new Grdetail();
		  $model->attributes=$_POST['Grdetail'];
		$model->qty = str_replace(",","",$model->qty);
		}
		try
		{
		  if($model->save())
		  {
			if (Yii::app()->request->isAjaxRequest)
			  {
				echo CJSON::encode(array(
				  'status'=>'success',
				  'div'=>"Data saved"
				));
			  }
		  }
		  else
		  {
			$errormessage=$model->getErrors();
			if (Yii::app()->request->isAjaxRequest)
			{
			  echo CJSON::encode(array(
				'status'=>'failure',
				'div'=>$errormessage
              ));
            }
		  }
		}
		catch (Exception $e)
		{
		  $errormessage=$e->getMessage();
		  if (Yii::app()->request->isAjaxRequest)
			{
			  echo CJSON::encode(array(
				'status'=>'failure',
				'div'=>$errormessage
              ));
            }
		}
	  }
	}

        public function actionApprove()
	{
            parent::actionApprove();
		$id=$_POST['id'];
		foreach($id as $ids)
		{
          //$model=$this->loadModel($ids);
          $a = Yii::app()->user->name;
          $connection=Yii::app()->db;
          $transaction=$connection->beginTransaction();
          try
          {
            $sql = 'call ApproveGR(:vid, :vlastupdateby)';
            $command=$connection->createCommand($sql);
            $command->bindvalue(':vid',$ids,PDO::PARAM_INT);
            $command->bindvalue(':vlastupdateby', $a,PDO::PARAM_STR);
            $command->execute();
            $transaction->commit();
            $this->GetSMessage('igrapprovesuccess');
          }
          catch(Exception $e) // an exception is raised if a query fails
          {
             $transaction->rollBack();
            $this->GetMessage($e->getMessage());
          }
		}
        Yii::app()->end();
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
		  $model=Grdetail::model()->findbyPK($ids);
		  $model->delete();
		}
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
	  $grdetail=new Grdetail('search');
	  $grdetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Grdetail']))
		$grdetail->attributes=$_GET['Grdetail'];

		$poheader=new Poheader('search');
	  $poheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Poheader']))
		$poheader->attributes=$_GET['Poheader'];

      $giheader=new Giheader('search');
	  $giheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Giheader']))
		$giheader->attributes=$_GET['Giheader'];

		$model=new Grheader('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Grheader']))
			$model->attributes=$_GET['Grheader'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}
		$this->render('index',array(
			'model'=>$model,
					'poheader'=>$poheader,
					'grdetail'=>$grdetail,
                    'giheader'=>$giheader
		));
	}

	public function actionIndexdetail()
	{
	  $grdetail=new Grdetail('search');
	  $grdetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Grdetail']))
		$grdetail->attributes=$_GET['Grdetail'];

	  $this->renderPartial('indexdetail',
		array('grdetail'=>$grdetail));
	  Yii::app()->end();
	}

	public function actionDownload()
  {
	parent::actionDownload();
    $sql = "select a.grno,a.grdate,a.grheaderid,b.pono,c.fullname
      from grheader a
      left join poheader b on b.poheaderid = a.poheaderid
      left join addressbook c on c.addressbookid = b.addressbookid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.grheaderid = ".$_GET['id'];
		}
		    $command=$this->connection->createCommand($sql);
    $dataReader=$command->queryAll();
	  $this->pdf->title='Goods Received';
	  $this->pdf->AddPage('P');
	  // definisi font
	  $this->pdf->setFont('Arial','B',8);

    foreach($dataReader as $row)
    {
	        $this->pdf->Rect(10,60,190,25);
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->text(15,$this->pdf->gety()+5,'No ');$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['grno']);
      $this->pdf->text(15,$this->pdf->gety()+10,'Date ');$this->pdf->text(50,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['grdate'])));
      $this->pdf->text(15,$this->pdf->gety()+15,'PO No ');$this->pdf->text(50,$this->pdf->gety()+15,': '.$row['pono']);
      $this->pdf->text(15,$this->pdf->gety()+20,'Vendor ');$this->pdf->text(50,$this->pdf->gety()+20,': '.$row['fullname']);

      $sql1 = "select b.productname, a.qty, c.uomcode,d.description
        from grdetail a
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
        left join sloc d on d.slocid = a.slocid
        where grheaderid = ".$row['grheaderid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

	  $this->pdf->sety($this->pdf->gety()+25);
      $this->pdf->colalign = array('C','C','C','C','C','C');
      $this->pdf->setFont('Arial','B',6);
      $this->pdf->setwidths(array(10,100,20,20,40));
	  $this->pdf->colheader = array('No','Nama Barang','Qty','Unit','Gudang');
      $this->pdf->RowHeader();
      $this->pdf->setFont('Arial','',6);
      $this->pdf->coldetailalign = array('L','L','R','L','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['qty']),
            $row1['uomcode'],
            $row1['description']));
      }
      
      $this->pdf->setFont('Arial','',8);
      $this->pdf->text(10,$this->pdf->gety()+15,'Inventory Staff');$this->pdf->text(100,$this->pdf->gety()+15,'Supplier');
      $this->pdf->text(10,$this->pdf->gety()+30,'----------------------');$this->pdf->text(95,$this->pdf->gety()+30,'----------------------');
      
      $this->pdf->AddPage('P');
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
		$model=Grheader::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Grdetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='grheader-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='grdetail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
