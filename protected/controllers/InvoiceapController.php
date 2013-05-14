<?php

class InvoiceapController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'invoiceap';

	public $invoicedet,$invoiceacc;

	public function lookupdata()
	{
		$this->invoicedet=new Invoicedet('search');
		$this->invoicedet->unsetAttributes();  
		if(isset($_GET['Invoicedet']))
		$this->invoicedet->attributes=$_GET['Invoicedet'];
		
		$this->invoiceacc=new Invoiceacc('search');
		$this->invoiceacc->unsetAttributes();  
		if(isset($_GET['Invoiceacc']))
		$this->invoiceacc->attributes=$_GET['Invoiceacc'];

	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		parent::actionCreate();
	  $this->lookupdata();
		$model=new Invoice;
		$model->invoicetypeid = 1;
		$model->recordstatus=Wfgroup::model()->findstatusbyuser('insinvap');
		if (Yii::app()->request->isAjaxRequest)
        {
			if ($model->save()) {
			  echo CJSON::encode(array(
				  'status'=>'success',
				  'invoiceid'=>$model->invoiceid,
				  'currencyid'=>Company::model()->getcurrencyid(),
				  'currencyname'=>Company::model()->getcurrencyname(),
				  ));
			  Yii::app()->end();
			}
        }
	}

	public function actionCreateinvoicedet()
	{
		parent::actionCreate();
		$invoicedet=new Invoicedet;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'currencyid'=>Company::model()->getcurrencyid(),
				  'currencyname'=>Company::model()->getcurrencyname(),
				));
            Yii::app()->end();
        }
	}
	
	public function actionCreateinvoiceacc()
	{
		parent::actionCreate();
		$invoiceacc=new Invoiceacc;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'currencyid'=>Company::model()->getcurrencyid(),
				  'currencyname'=>Company::model()->getcurrencyname(),
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

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'invoiceid'=>$model->invoiceid,
					'invoicedate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->invoicedate)),
				  'amount'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$model->amount),
				  'invoiceno'=>$model->invoiceno,
				  'poheaderid'=>$model->poheaderid,
				  'pono'=>($model->poheader!==null)?$model->poheader->pono:"",
				  'headernote'=>$model->headernote,
				  'currencyid'=>$model->currencyid,
				  'currencyname'=>($model->currency!==null)?$model->currency->currencyname:"",
				  'taxid'=>$model->taxid,
				  'taxcode'=>($model->tax!==null)?$model->tax->taxcode:"",
				  'paymentmethodid'=>$model->paymentmethodid,
				  'paycode'=>($model->paymentmethod!==null)?$model->paymentmethod->paycode:"",
				  'rate'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$model->rate),
				  'amount'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$model->amount),
				  'fpno'=>$model->fpno,
				  'fpdate'=>$model->fpdate,
				));
            Yii::app()->end();
        }
	}

	public function actionUpdateinvoiceacc()
	{
		$id=$_POST['id'];
	  $invoiceacc=$this->loadModeldetailinvoiceacc($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'invoiceaccid'=>$invoiceacc->invoiceaccid,
				'accountid'=>$invoiceacc->accountid,
                'accountname'=>($invoiceacc->account!==null)?$invoiceacc->account->accountname:"",
                'currencyid'=>$invoiceacc->currencyid,
                'currencyname'=>($invoiceacc->currency!==null)?$invoiceacc->currency->currencyname:"",
                'debit'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$invoiceacc->debit),
                'credit'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$invoiceacc->credit),
                'currencyrate'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$invoiceacc->currencyrate),
                'description'=>$invoiceacc->description,
				));
            Yii::app()->end();
        }
	}
	
	public function actionUpdateinvoicedet()
	{
		$id=$_POST['id'];
	  $invoicedet=$this->loadModelinvoicedet($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'invoicedetid'=>$invoicedet->invoicedetid,
				'productid'=>$invoicedet->productid,
				'productname'=>($invoicedet->product!==null)?$invoicedet->product->productname:"",
                'currencyid'=>$invoicedet->currencyid,
                'currencyname'=>($invoicedet->currency!==null)?$invoicedet->currency->currencyname:"",
                'unitofmeasureid'=>$invoicedet->unitofmeasureid,
                'uomcode'=>($invoicedet->unitofmeasure!==null)?$invoicedet->unitofmeasure->uomcode:"",
                'price'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$invoicedet->price),
                'qty'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$invoicedet->qty),
                'rate'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$invoicedet->rate),
                'description'=>$invoicedet->description,
				));
            Yii::app()->end();
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
				$poheader = Poheader::model()->findbypk($_POST['id']);
				$docdate;
				$paymentmethodid;
				$paycode;
				if ($poheader !== null)
				{
					$docdate = $poheader->docdate;
					$paycode= ($poheader->paymentmethod !== null) ? $poheader->paymentmethod->paycode:"";
					$paymentmethodid= $poheader->paymentmethodid;
					$headernote= $poheader->headernote;
				}		
				$sql = 'call GenerateINVPO(:vid, :vhid)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['id'],PDO::PARAM_INT);
				$command->bindvalue(':vhid', $_POST['hid'],PDO::PARAM_INT);
				$command->execute();
				$transaction->commit();
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
					  'status'=>'success',
					  'docdate'=>$docdate,
					  'paycode'=>$paycode,
					  'paymentmethodid'=>$paymentmethodid,
					  'headernote'=>$headernote,
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
		
    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Invoice'], $_POST['Invoice']['invoiceid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Invoice']))
	  {
         $messages = $this->ValidateData(
                array(
				array($_POST['Invoice']['invoicedate'],'emptyinvoicedate','emptystring'),
				array($_POST['Invoice']['amount'],'emptyamount','emptystring'),
				array($_POST['Invoice']['currencyid'],'emptycurrency','emptystring'),
				array($_POST['Invoice']['taxid'],'emptytax','emptystring'),
				array($_POST['Invoice']['rate'],'emptyrate','emptystring'),
				array($_POST['Invoice']['paymentmethodid'],'emptypaymentmethod','emptystring'),
            )
        );
         if ($messages == '') {
		if ((int)$_POST['Invoice']['invoiceid'] > 0)
		{
		  $model=$this->loadModel($_POST['Invoice']['invoiceid']);
		  $model->invoiceno = $_POST['Invoice']['invoiceno'];
		  $model->poheaderid = $_POST['Invoice']['poheaderid'];
		  $model->amount = $_POST['Invoice']['amount'];
		  $model->currencyid = $_POST['Invoice']['currencyid'];
		  $model->taxid = $_POST['Invoice']['taxid'];
		  $model->rate = $_POST['Invoice']['rate'];
		  $model->invoicedate = $_POST['Invoice']['invoicedate'];
		  $model->paymentmethodid = $_POST['Invoice']['paymentmethodid'];
		  $model->headernote = $_POST['Invoice']['headernote'];
		  $model->fpno = $_POST['Invoice']['fpno'];
		  $model->fpdate = $_POST['Invoice']['fpdate'];
		$model->amount = str_replace(",","",$model->amount);
		$model->rate = str_replace(",","",$model->rate);
		}
		else
		{
		  $model = new Invoice();
		  $model->attributes=$_POST['Invoice'];
		$model->amount = str_replace(",","",$model->amount);
		$model->rate = str_replace(",","",$model->rate);
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Invoice']['invoiceid']);
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
	
	public function actionCancelWriteinvoiceacc()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Invoiceacc'], $_POST['Invoiceacc']['invoiceaccid']);
    }
	
	public function actionWriteinvoiceacc()
	{
	  if(isset($_POST['Invoiceacc']))
	  {
	  $messages = $this->ValidateData(
                array(
				array($_POST['Invoiceacc']['accountid'],'emptyaccount','emptystring'),
                array($_POST['Invoiceacc']['debit'],'emptydebit','emptystring'),
                array($_POST['Invoiceacc']['credit'],'emptycredit','emptystring'),
                array($_POST['Invoiceacc']['currencyid'],'emptycurrency','emptystring'),
                array($_POST['Invoiceacc']['currencyrate'],'emptyrate','emptystring'),
            )
        );
         if ($messages == '') {
		if ((int)$_POST['Invoiceacc']['invoiceaccid'] > 0)
		{
		  $model=Invoiceacc::model()->findbyPK($_POST['Invoiceacc']['invoiceaccid']);
		  $model->invoiceid = $_POST['Invoiceacc']['invoiceid'];
		  $model->accountid = $_POST['Invoiceacc']['accountid'];
		  $model->debit = $_POST['Invoiceacc']['debit'];
		  $model->credit = $_POST['Invoiceacc']['credit'];
		  $model->currencyid = $_POST['Invoiceacc']['currencyid'];
		  $model->currencyrate = $_POST['Invoiceacc']['currencyrate'];
		  $model->description = $_POST['Invoiceacc']['description'];
		$model->debit = str_replace(",","",$model->debit);
		$model->credit = str_replace(",","",$model->credit);
		$model->currencyrate = str_replace(",","",$model->currencyrate);
		}
		else
		{
		  $model = new Invoiceacc();
		  $model->attributes=$_POST['Invoiceacc'];
		$model->debit = str_replace(",","",$model->debit);
		$model->credit = str_replace(",","",$model->credit);
		$model->currencyrate = str_replace(",","",$model->currencyrate);
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Invoiceacc']['invoiceaccid']);
              $this->GetSMessage('ppinsertsuccess');
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
	
	public function actionCancelWriteinvoicedet()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Invoicedet'], $_POST['Invoicedet']['invoicedetid']);
    }
	
	public function actionWriteinvoicedet()
	{
	  if(isset($_POST['Invoicedet']))
	  {
	  $messages = $this->ValidateData(
                array(
				array($_POST['Invoicedet']['productid'],'emptyproduct','emptystring'),
                array($_POST['Invoiceacc']['price'],'emptyprice','emptystring'),
                array($_POST['Invoiceacc']['qty'],'emptyqty','emptystring'),
                array($_POST['Invoiceacc']['currencyid'],'emptycurrency','emptystring'),
                array($_POST['Invoiceacc']['unitofmeasureid'],'emptyunitofmeasure','emptystring'),
                array($_POST['Invoiceacc']['rate'],'emptyrate','emptystring'),
            )
        );
         if ($messages == '') {
		if ((int)$_POST['Invoicedet']['invoicedetid'] > 0)
		{
		  $model=Invoicedet::model()->findbyPK($_POST['Invoicedet']['invoicedetid']);
		  $model->invoicedetid = $_POST['Invoicedet']['invoicedetid'];
		  $model->productid = $_POST['Invoicedet']['productid'];
		  $model->price = $_POST['Invoicedet']['price'];
		  $model->currencyid = $_POST['Invoicedet']['currencyid'];
		  $model->qty = $_POST['Invoicedet']['qty'];
		  $model->unitofmeasureid = $_POST['Invoicedet']['unitofmeasureid'];
		  $model->currencyid = $_POST['Invoicedet']['currencyid'];
		  $model->rate = $_POST['Invoicedet']['rate'];
		  $model->description = $_POST['Invoicedet']['description'];
		$model->price = str_replace(",","",$model->price);
		$model->qty = str_replace(",","",$model->qty);
		$model->rate = str_replace(",","",$model->rate);
		}
		else
		{
		  $model = new Invoicedet();
		  $model->attributes=$_POST['Invoicedet'];
		$model->price = str_replace(",","",$model->price);
		$model->qty = str_replace(",","",$model->qty);
		$model->rate = str_replace(",","",$model->rate);
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Invoicedet']['invoicedetid']);
              $this->GetSMessage('ppinsertsuccess');
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
	
	public function actionDownload()
	{
	  parent::actionDownload();
	   $sql = "select journalno,invoiceid,invoiceno,f.pono,fullname,amount,symbol,rate,invoicedate,a.headernote, taxvalue,
	   (select addressname from address e where e.addressbookid = f.addressbookid limit 1) as addressname,
	   (select cityname from address e left join city f on f.cityid = e.cityid where e.addressbookid = f.addressbookid limit 1) as cityname
		from invoice a 
		left join poheader f on f.poheaderid = a.poheaderid
		left join currency b on b.currencyid = a.currencyid 
		left join tax c on c.taxid = a.taxid 
		left join addressbook d on d.addressbookid = f.addressbookid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.invoiceid = ".$_GET['id'];
		}
		$sql = $sql . " order by invoiceid ";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
	  $this->pdf->title='Journal Adjustment';
	  $this->pdf->AddPage('P');
	  $this->pdf->setFont('Arial','B',8);

    foreach($dataReader as $row)
    {
		$this->pdf->rect(10,60,190,30);
		$this->pdf->setFont('Arial','B',10);
		$this->pdf->text(20,$this->pdf->gety()+5,'PO No: '.$row['pono']);
		$this->pdf->text(150,$this->pdf->gety()+5,'Tanggal: '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])));
		$this->pdf->text(20,$this->pdf->gety()+10,'J.NO: '.$row['journalno']);
		$this->pdf->text(20,$this->pdf->gety()+15,'Note: '.$row['headernote']);
	  
      $sql1 = "select accountcode, accountname,debit,credit,a.currencyid,currencyrate,a.description,symbol
        from invoiceacc a
		left join currency b on b.currencyid = a.currencyid
		left join account d on d.accountid = a.accountid 
        where invoiceid = ".$row['invoiceid'] . " order by debit desc ";
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $this->pdf->SetY($this->pdf->gety()+30);
		$this->pdf->setFont('Arial','B',8);
      $this->pdf->colalign = array('C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(20,30,30,30,30,50));
      $this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
	  $this->pdf->colheader = array('Account Code','Account Name','Debit','Credit','Rate','Description');
      $this->pdf->RowHeader();
		$this->pdf->setFont('Arial','',8);
      $this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
      $this->pdf->coldetailalign = array('L','L','R','R','R','L');
      foreach($dataReader1 as $row1)
      {
        $this->pdf->row(array($row1['accountcode'],
		$row1['accountname'],
			Yii::app()->numberFormatter->formatCurrency($row1['debit'],$row1['symbol']),
			Yii::app()->numberFormatter->formatCurrency($row1['credit'],$row1['symbol']),
			Yii::app()->numberFormatter->formatCurrency($row1['currencyrate'],$row1['symbol']),
			$row1['description']
));
      }
      $this->pdf->setbordercell(array('LTB','TB','TB','TB','TB','TB','LTRB'));
      $this->pdf->setaligns(array('R','L','R','C','R','R','R'));
      $this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
		$this->pdf->text(10,$this->pdf->gety()+5,'INWORD : '.strtoupper($this->eja($row['amount'])));
		$this->pdf->setFont('Arial','',10);
	$this->pdf->text(10,$this->pdf->gety()+35,'Prepared By');$this->pdf->text(50,$this->pdf->gety()+35,'Checked By');
      $this->pdf->text(10,$this->pdf->gety()+55,'(------------------)');$this->pdf->text(50,$this->pdf->gety()+55,'(------------------)');
	$this->pdf->text(90,$this->pdf->gety()+35,'Approved By');$this->pdf->text(130,$this->pdf->gety()+35,'Acknowladge By');
      $this->pdf->text(90,$this->pdf->gety()+55,'(------------------)');$this->pdf->text(130,$this->pdf->gety()+55,'(------------------)');
	$this->pdf->text(175,$this->pdf->gety()+35,'Received By');
      $this->pdf->text(175,$this->pdf->gety()+55,'(------------------)');
	
    }
	  $this->pdf->Output();
	  }
	
	public function actionApprove()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
			//$model=$this->loadModel($ids);
                    $a = Yii::app()->user->name;
			$connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call ApproveInvoiceAP(:vid, :vlastupdateby)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$ids,PDO::PARAM_INT);
				$command->bindvalue(':vlastupdateby', $a,PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				$this->GetSMessage('pprinsertsuccess');
			  }
			  catch(CDbexception $e) // an exception is raised if a query fails
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
		  if ($model->recordstatus > 1)
		  {
			$model->recordstatus=1;
			}
			else
			{
			$model->recordstatus = 0;
			}
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
	public function actionDeleteinvoicedet()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Invoicedet::model()->findbyPK($ids);
		  $model->delete();
		}
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}
	
	public function actionDeleteinvoiceacc()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Invoiceacc::model()->findbyPK($ids);
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
	  $this->lookupdata();
		$model=new Invoice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Invoice']))
			$model->attributes=$_GET['Invoice'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
				  'invoicedet'=>$this->invoicedet,
				  'invoiceacc'=>$this->invoiceacc
		));
	}

	public function actionIndexinvoicedet()
	{
		$this->lookupdata();
	  $this->renderPartial('indexinvoicedet',
		array('invoicedet'=>$this->invoicedet));
	  Yii::app()->end();
	}
	
	public function actionIndexinvoiceacc()
	{
		$this->lookupdata();
	  $this->renderPartial('indexinvoiceacc',
		array('invoiceacc'=>$this->invoiceacc));
	  Yii::app()->end();
	}
		
	public function actionUpload()
	{
      parent::actionUpload();
	   $folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/upload/';// folder for uploaded files
		$file = $folder . basename($_FILES['uploadfile']['name']); 
		if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) 
		{ 
			$row = 0;
			if (($handle = fopen($file, "r")) !== FALSE) 
			{
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
				{
					if ($row>0) {
						$model=Company::model()->findByPk((int)$data[0]);
						if ($model=== null) {
							$model = new Company();
						}
						$model->companyid = (int)$data[0];
						$model->companyname = $data[1];
						$model->address = $data[2];
						$city = City::model()->findbyattributes(array('cityname'=>$data[3]));
						if ($city !== null)
						{
							$model->cityid = $city->cityid;
						}
						$model->zipcode = $data[4];
						$model->taxno = $data[5];
						$currency = Currency::model()->findbyattributes(array('currencyname'=>$data[6]));
						if ($currency !== null)
						{
							$model->currencyid = $currency->currencyid;
						}
						$model->recordstatus = (int)$data[7];
						try
						{
							if(!$model->save())
							{
								$this->messages = $this->messages . Catalogsys::model()->getcatalog(' upload error at '.$data[0]);
							}
						}
						catch (Exception $e)
						{
							$this->messages = $this->messages .  $e->getMessage();
						}
					}
					$row++;
				}
			}
			else
			{
				$this->messages = $this->messages . ' memory or harddisk full';
			}
			fclose($handle);
		}
		else
		{
			$this->messages = $this->messages . ' check your directory permission';
		}
		if ($this->messages == '') {
			$this->messages = 'success';
		}		
		echo $this->messages;
}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Invoice::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelinvoicedet($id)
	{
		$model=Invoicedet::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModeldetailinvoiceacc($id)
	{
		$model=Invoiceacc::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='invoiceap-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='invoiceapservice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
