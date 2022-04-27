<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\causaFallecimiento;
use App\Models\BitacoraDetail;
use App\Models\Place;
use App\Models\Localidad;
use App\Models\Colonia;
use App\Models\Personal;
use App\Models\Sucursal;
use App\Models\Capilla;
use App\Models\Interplaza;
use App\Models\Parentesco;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Supplier;
use App\Models\Templo;
use App\Models\Panteon;
use App\Models\AppConfig;
use App\Models\Address;
use App\Models\Contactos;
use App\Models\Comments;
use App\Models\Urna;
use App\Models\Pagos;
use App\Models\Concepto;
use App\Models\VehiculoGestoria;
use App\Models\BitacoraDetailDataChangesHistory;
use App\Models\BitacoraDetailsAppliancesAndDocuments;
use DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\SupplierBitacora;
use App\Models\CommentsEsquela;
use App\Models\Ataud;
use App\Models\UserToken;
use App\Models\Notification;
use App\Models\ProcesosInicioYFin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use App\Models\InvoiceDataChangesHistory;
use App\Models\Invoices;
use App\Models\ImageSurvey;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


use Illuminate\Support\Facades\Log;

class BitacoraDetailController extends Controller {

	public function __construct()
	{


		/*$this->beforeFilter('ver_lugares', array('only' => 'index') );
		$this->beforeFilter('crear_lugares', array('only' => 'create') );
		$this->beforeFilter('crear_lugares', array('only' => 'store') );
		$this->beforeFilter('editar_lugares', array('only' => 'edit') );
		$this->beforeFilter('editar_lugares', array('only' => 'update') );
		$this->beforeFilter('eliminar_lugares', array('only' => 'delete') );*/

		date_default_timezone_set('America/Mexico_City');
		
		\DB::statement("SET SQL_MODE=''");


		ini_set('memory_limit', '-1');
    	ini_set('max_execution_time', 12000);


	}

	
	public function index(Request $request)
	{
		//

		//$suppliersdriver = SuppliersDriver::where('status', '=', 'Activo')->get();
		//$bitacora = BitacoraDetail::orderBy('created_at','desc')->limit(500)->get();
		//$bitacora = BitacoraDetail::bitacoraOrder->orderBy('order','desc')->orderBy('substring(bitacora, 9)','desc')->limit(100)->get();

		if ( auth()->user()->name == 'PRUEBAS' ) {
			if ( $request->ajax() ) {
	           return datatables()->of(BitacoraDetail::select('id', 'bitacora', 'name_dead', 'fecha_captura', 'id_atiende_servicio', 'id_suc_velacion')->where('bitacora', 'GDL30JUN001')->latest()->limit(15))
	                    ->addColumn('id_suc_velacion', function($data){
	                        if ( $data->id_suc_velacion != null ) {
	                            $mSucursal = Sucursal::find($data->id_suc_velacion);
	                            if ( $mSucursal != null ) {
	                                return $mSucursal->name;
	                            }
	                        }
	                        return '';
	                    })
	                    ->addColumn('id_atiende_servicio', function($data){
	                        if ( $data->id_atiende_servicio != null ) {
	                            $mPersonal = Personal::find($data->id_atiende_servicio);
	                            if ( $mPersonal != null ) {
	                                return $mPersonal->name;
	                            }
	                        }
	                        return '';
	                    })
	                    ->addColumn('acciones', function($data){
	                        $button = '<a class="btn btn-sm btn-success" href="'.route('bitacora-details.show',$data->id).'">Mostrar</a>';
	                        if ( auth()->user()->can('bitacoras-edit') ) {
	                            $button .= '<a class="btn btn-sm btn-primary" href="'.route('bitacora-details.edit',$data->id).'">Editar</a>';
	                        }
	                        return $button;
	                    })
	                    ->rawColumns(['id_atiende_servicio','id_suc_velacion','acciones'])
	                    ->make(true);
	        }

			$bitacora = DB::select("
				SELECT 
					substring(bitacora, 4, 2), substring(bitacora, 6, 3), substring(bitacora, 9), bitacora,
					name_dead, fecha_captura, 
					case 
						when p.name = '- -' then '' 
						when p.name is null then ''
						else p.name
					end as 'quien_atiende_servicio',
					ifnull(s.name, '') as 'cual_sucursal_velacion', bd.id
				From bitacora_details bd
				inner join bitacora_order bo on substring(bd.bitacora, 6, 3) = bo.month
				left join personal p on bd.id_atiende_servicio = p.id
				left join sucursal s on bd.id_suc_velacion = s.id
				WHERE bitacora = 'GDL30JUN001'
				order by

					bo.order desc, substring(bd.bitacora, 9) desc
				limit 5
			");
		} else {
			if ( $request->ajax() ) {
	           return datatables()->of(BitacoraDetail::select('id', 'bitacora', 'name_dead', 'fecha_captura', 'id_atiende_servicio', 'id_suc_velacion')->latest()->limit(15))
	                    ->addColumn('id_suc_velacion', function($data){
	                        if ( $data->id_suc_velacion != null ) {
	                            $mSucursal = Sucursal::find($data->id_suc_velacion);
	                            if ( $mSucursal != null ) {
	                                return $mSucursal->name;
	                            }
	                        }
	                        return '';
	                    })
	                    ->addColumn('id_atiende_servicio', function($data){
	                        if ( $data->id_atiende_servicio != null ) {
	                            $mPersonal = Personal::find($data->id_atiende_servicio);
	                            if ( $mPersonal != null ) {
	                                return $mPersonal->name;
	                            }
	                        }
	                        return '';
	                    })
	                    ->addColumn('acciones', function($data){
	                        $button = '<a class="btn btn-sm btn-success" href="'.route('bitacora-details.show',$data->id).'">Mostrar</a>';
	                        if ( auth()->user()->can('bitacoras-edit') ) {
	                            $button .= '<a class="btn btn-sm btn-primary" href="'.route('bitacora-details.edit',$data->id).'">Editar</a>';
	                        }
	                        return $button;
	                    })
	                    ->rawColumns(['id_atiende_servicio','id_suc_velacion','acciones'])
	                    ->make(true);
	        }

			$bitacora = DB::select("
				SELECT 
					substring(bitacora, 4, 2), substring(bitacora, 6, 3), substring(bitacora, 9), bitacora,
					name_dead, fecha_captura, 
					case 
						when p.name = '- -' then '' 
						when p.name is null then ''
						else p.name
					end as 'quien_atiende_servicio',
					ifnull(s.name, '') as 'cual_sucursal_velacion', bd.id
				From bitacora_details bd
				inner join bitacora_order bo on substring(bd.bitacora, 6, 3) = bo.month
				left join personal p on bd.id_atiende_servicio = p.id
				left join sucursal s on bd.id_suc_velacion = s.id
				#WHERE bitacora = 'GDL21FEB626'
				order by

					bo.order desc, substring(bd.bitacora, 9) desc
				limit 15
			");
		}

		
		return view('layouts.bitacora-details.index', compact('bitacora'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$causa = causaFallecimiento::where('status','=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$bitacora = BitacoraDetail::pluck('bitacora','id')->prepend('','');
		$place = Place::where('status', '=', 'Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$localidad = Localidad::orderBy('name')->pluck('name','id')->prepend('','');
		$colonia = Colonia::orderBy('name')->pluck('name','id')->prepend('','');
		$personalAtiende = Personal::where('status','=','Activo')->whereIn('profile_id',['ATN CLIENTES FUN','ATN CLIENTES FUNE','ENCARGADO  FUNERARIA'])->Select("id", DB::raw("CONCAT(personal.name,' ',personal.first_last_name) as nombre"))->orderBy('name')->pluck('nombre','id')->prepend('','');
		$sucursalVelacion = Sucursal::where('status','=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$sucursalCenizas = Sucursal::Where('cenizas',1)->orderBy('name')->pluck('name','id')->prepend('','');
		$capilla = Capilla::where('status','=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$interplaza = Interplaza::where('status','=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$parentesco = Parentesco::where('status','=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$operativo = Driver::where('status','=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$carroza = Vehicle::where('status', '=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$proveedor = Supplier::where('status','=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$templo = Templo::where('status', '=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$capilla = Capilla::where('status', '=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$panteon = Panteon::where('status', '=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		//$cobrador = Personal::whereIn('profile_id',['Cobrador'])->orderBy('name')->pluck('name','id')->prepend('','');
		//$users = User::select("id", DB::raw("CONCAT(users.first_name,' ',users.last_name) as full_name"))->pluck('full_name', 'id');
		$cobrador = Personal::where('status','=','Activo')->whereIn('profile_id',['Cobrador'])->Select ("id", DB::raw("CONCAT(personal.no_empleado,'-',personal.name,' ',personal.first_last_name) as nombre"))->pluck('nombre','id')->prepend('',''); 

		$medico = Personal::whereIn('profile_id',['MEDICO'])->Select ("id", DB::raw("CONCAT(personal.name,' ',personal.first_last_name) as nombre"))->pluck('nombre','id')->prepend('',''); 
		$toldos = Personal::whereIn('profile_id',['INSTALADOR DE TOLDOS'])->Select ("id", DB::raw("CONCAT(personal.name,' ',personal.first_last_name) as nombre"))->pluck('nombre','id')->prepend('','');

		$ataud = Urna::where([['inventory_group_id', '=', '8'],['status','=','Activo']])->Select("id", "description as name")->orderBy('name')->pluck('name','id')->prepend('','');
		$urna = Urna::where([['inventory_group_id', '=', '9'],['status','=','Activo']])->Select("id", "description as name")->orderBy('name')->pluck('name','id')->prepend('','');
		return view('layouts.bitacora-details.create', compact('bitacora','causa','place', 'localidad', 'colonia', 'personalAtiende','sucursalVelacion',
		'sucursalCenizas','capilla','interplaza','parentesco', 'operativo','carroza','proveedor','templo', 'capilla', 'panteon','cobrador', 'ataud', 'urna','medico','toldos'));
	}

	public function store_pay(Request $request,$id)
	{
		$arrayPay = array('datePay' =>'Fecha de pago' ,
		'montoPago' =>  'Monto de pago',
		'concepto' =>  'Concepto de pago');


		$rules = array('datePay' => 'required',
						'montoPago' => 'required',
						'concepto' => 'required'
		 );

		$messages = array(
			'required' => 'El campo :attribute es requerido' ,
			'Unique' => 'El Número de empleado :attribute ya ha sido registrado',
			'min' => 'Mínimo 10 caracteres'
			 );

		$validator = Validator::make($request->all(),$rules,$messages);
		$validator->setAttributeNames($arrayPay);

		if($validator->fails()){
			
			$messages = $validator->messages();

			echo $id.$request->input('datePay').$request->input('montoPago');
			return back()
				->withErrors($messages)
				->withInput($request->all());

		}
		else{
			$pago = new Pagos();
			$pago->bitacora = $id;
			$pago->fecha_pago = $request->input('datePay');
			$pago->monto = $request->input('montoPago');
			$pago->concepto_id  = $request->input('concepto');
			$pago->user_create = auth()->user()->name;
			
			$pagos_realizados = True;

			if ($pago->save()) {
				# code...
				 $msg = [
				        'message' => 'true',
				       ];
				return redirect()->route('bitacora-details.show', $id)->with($msg);
			}

			
			
		}
	}

	public function store_pay2(Request $request)
	{
		$arrayPay = array('datePay1' =>'Fecha de pago' ,
		'montoPago1' =>  'Monto de pago',
		'concepto1' =>  'Concepto de pago');


		$rules = array('datePay1' => 'required',
						'montoPago1' => 'required',
						'concepto1' => 'required'
		 );

		$messages = array(
			'required' => 'El campo :attribute es requerido' ,
			'Unique' => 'El Número de empleado :attribute ya ha sido registrado',
			'min' => 'Mínimo 10 caracteres'
			 );

		$validator = Validator::make($request->all(),$rules,$messages);
		$validator->setAttributeNames($arrayPay);

		if($validator->fails()){
			
			$messages = $validator->messages();
			return back()
				->withErrors($messages)
				->withInput($request->all());

		}
		else{
			$pago = new Pagos();
			$pago->bitacora = $request->input('id_bitacora');
			$pago->fecha_pago = $request->input('fecha_pago');
			$pago->monto = $request->input('monto');
			$pago->concepto_id  = $request->input('concepto_id');
			$pago->user_create = auth()->user()->name;
			
			

			$pago->save();
				# retornar panel de pagos
			return redirect()->route('bitacora-details.show', 5587);
				
			 $data = Pagos::where('bitacora','=',$request->input('id_bitacora'))->get();	

			      $output = '<table class="table table-hover" id="tabla_pagos"><thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>Concepto</th>
                                    <th>Acciones</th>
                                 </tr>
                                </thead>
                                <tbody>';
			      	if($data->count()){
			      			foreach($data as $row)
						      {
						      	$output.='<tr>';
						      	$output.='<td>'.$row->id.'</td>';
						      	$output.='<td>'.$row->fecha_pago.'</td>';
						      	$output.='<td>'.$row->monto.'</td>';
						      	$output.='<td>'.$row->Concepto == null ? '' : $row->Concepto->name.'</td>';
							       $output .= '<li class="list-group-item"><a href="#">'.$row->name_dead.'</a></li>';
						      }

						$output .= '</ul>';
			      		echo $output;
			      	}

			      	else{
			      		$output .= '<li class="list-group-item"><a href="#">NO SE ENCONTRARON RESULTADOS</a></li> </ul>';
			      		 echo $output;
			      	}

			
			
		}
	}

	public function edit_pay(Request $request)
	{
		
		$arrayPay = array('fecha_pago' =>'Fecha de pago' ,
		'monto_pago' =>  'Monto de pago',
		'concepto' =>  'Concepto de pago');


		$rules = array('fecha_pago' => 'required',
						'monto_pago' => 'required',
						'concepto' => 'required'
		 );

		$messages = array(
			'required' => 'El campo :attribute es requerido' ,
			'Unique' => 'El Número de empleado :attribute ya ha sido registrado',
			'min' => 'Mínimo 10 caracteres'
			 );

		$validator = Validator::make($request->all(),$rules,$messages);
		$validator->setAttributeNames($arrayPay);

		if($validator->fails()){
			
			$messages = $validator->messages();
			return back()
				->withErrors($messages)
				->withInput($request->all());

		}
		else{
			$id = $request->input('idPay');
			$pago = Pagos::find($id);
			$pago->fecha_pago = $request->input('fecha_pago');
			$pago->monto = $request->input('monto_pago');
			$pago->concepto_id  = $request->input('concepto');
			
			$pagos_realizados = True;

			if ($pago->save()) {
				# code...
				 $msg = [
				        'message1' => 'Registro Actualizado con éxito',
				       ];
				return redirect()->route('bitacora-details.show', $pago->bitacora)->with($msg);
			}
			
			else
			{
				$msg = [
				        'message1' => 'Registro Actualizado con éxito',
				       ];
				return redirect()->route('bitacora-details.show', $pago->bitacora)->with($msg);
			}
			
			
			
		}
	}

	public function getDataChangesHistory( $id ) {

		//return;

		$bitacoraDetailDataChangesHistory = BitacoraDetailDataChangesHistory::where('id', $id)->orderBy('fecha_tabla', 'desc')->get();
		$invoiceDataChangesHistory = InvoiceDataChangesHistory::where('bitacora_invoice', $id)->orderBy('fecha_tabla_invoice', 'desc')->get();
		return view('layouts.bitacora-details.history', compact( 'bitacoraDetailDataChangesHistory','invoiceDataChangesHistory' ) );

		/*$bitacoraToModify = BitacoraDetail::find($id);

		echo json_encode($bitacoraToModify);
		$timestamp = time();

		DB::table('bitacora_details_being_updated')
	    ->updateOrInsert(
	        ['id' => 5587, 'timestamp' => $timestamp, 'user' => "Jordan Alvarez T"],
	        $bitacoraToModify->toArray()
	    );*/

	}

	public function getConcepto($id){
		 
		$pago = Pagos::find($id);
		$conceptos = Concepto:: all();
		$modalConcepto ="";
		$modalConcepto.= '<select class="form-control"   name="concepto" id="concepto">';
		if($id == 1){
			$modalConcepto.= '<option value="" disabled selected hidden >Selecciona...</option>';
		}
		foreach ($conceptos as $key => $concepto) {
			$modalConcepto.= '<option value="'.$concepto->id.'"';
 			$modalConcepto.= ($concepto->id == $pago->concepto_id)? 'selected':"" ;
			$modalConcepto.='>'.$concepto->name.'</option>';
		}


		$modalConcepto.= ' </select> ';
		return $modalConcepto;
	}

	public function store(Request $request)
	{

		Log::channel('create_bitacora')->info('app.requests', ['request_name' => 'store', 'request' => $request->all()] );

		/*echo json_encode( $request->input('createDateBitacora') );
		return;*/
		
		$arrayBitacora  = array(
			'bitacora' => 'Número Bitacora',
			'finado' =>'Nombre de fallecido',
			//'folioCertificado' => 'Folio de certificado',
			//'contrato'=>'Número de contrato',
			//'titularContrato'=>'Titular del contrato',
			//'agente'=>'Agente',
			//'clienteConfirma'=>'Cliente que confirma',
			//'telefonoCliente'=>'Teléfono del cliente'
		);		

		$rules = array('bitacora' => 'Unique:bitacora_details,bitacora|min:11',
						//'finado' => 'required',
						'createDateBitacora' => 'required',
						'createHourBitacora' => 'required'
		 );

		$messages = array(
			'required' => 'El campo :attribute es requerido' ,
			'Unique' => 'El Número de empleado :attribute ya ha sido registrado',
			'min' => 'Mínimo 10 caracteres'
			 );
		$validator = Validator::make($request->all(),$rules,$messages);
		$validator->setAttributeNames($arrayBitacora);


		if($validator->fails()){
			
			$messages = $validator->messages();


			return back()
				->withErrors($messages)
				->withInput($request->all());

		}
		else{

			//echo json_encode($request->all());
			//echo "<br>";

			//echo json_encode($request->input('municipio'));
			//echo "<br>";
			//echo json_encode($request->input('colonia'));
		
			
			//Objetos donde se almacenan las direcciones y los contactos
			$colonia = $request->input('colonia'); //$_POST['colonia'];
			$localidad = $request->input('municipio'); //$_POST['municipio'];
			$nombre = $request->input('name'); //$_POST['name'];
			$telefono = $request->input('telefono'); //$_POST['telefono'];
			$parentesco = $request->input('parentesco'); //$_POST['parentesco'];
			$calle = $request->input('calle'); //$_POST['calle'];
			$entre_calle = $request->input('entre_calles'); //$_POST['calle'];
			$nombres=[];
			$telefonos=[];
			$parentescos=[];
			$calles=[];
			$colonias=[];
			$localidades=[];
			$entre_calles=[];

			//Agregar los valores a los arreglos 
			foreach ($calle as $val) {
				//if ( $val != null ) {
					/*echo "<br>";
					echo "inside for 1";*/
					array_push($calles, $val);
				//}
			}
				
			foreach ($colonia as $val) {
				//if ( $val != null ) {
					/*echo "<br>";
					echo "inside for 2";*/
					array_push($colonias, $val);
				//}
			}

			foreach ($localidad as $val) {
				//if ( $val != null ) {
					/*echo "<br>";
					echo "inside for 3";*/
					array_push($localidades, $val);
				//}
			}
			foreach ($nombre as $val) {
				//if ( $val != null ) {
				/*	echo "<br>";
					echo "inside for 4";*/
					array_push($nombres, $val);
				//}
			}
				
			foreach ($telefono as $val) {
				//if ( $val != null ) {
					/*echo "<br>";
					echo "inside for 5";*/
					array_push($telefonos, $val);
				//}
			}

			foreach ($parentesco as $val) {
				//if ( $val != null ) {
					/*echo "<br>";
					echo "inside for 6";*/
					array_push($parentescos, $val);
				//}
			}

			foreach ($entre_calle as $val) {
				//if ( $val != null ) {
					/*echo "<br>";
					echo "inside for 6";*/
					array_push($entre_calles, $val);
				//}
			}

			/*echo "<br>";
			echo $request->input('agente');
			echo "<br>";*/
				

			//Valores del formularios

			$bitacora = new BitacoraDetail();
			//Obtener por medio del método automático
			$bitacora->bitacora = $this->getNewBitacora();
			
			$bitacora->name_dead = $request->input('finado'); //Input::get('finado');
			$bitacora->fecha_captura = $request->input('createDateBitacora') . ' ' . $request->input('createHourBitacora'); //Input::get('createDateBitacora');
			//$bitacora->hora_captura = $request->input('createHourBitacora'); //Input::get('createHourBitacora');
			$bitacora->llamada = $request->input('llamada'); //Input::get('llamada');
			$bitacora->certifica = $request->input('certifica'); //Input::get('certifica');
			//$bitacora->visita_personal = $request->input('Visita'); //Input::get('visita');Se omite por requerimiento de call center
			$bitacora->ataud = $request->input('ataud'); //Input::get('llamada');
			$bitacora->urna = $request->input('urna'); //Input::get('llamada');
			$bitacora->edad_finado = $request->input('edadFinado');
			$bitacora->persona_otorga_datos = $request->input('personaConfirma');
			$bitacora->folio_certificado = $request->input('folioCertificado'); //Input::get('folioCertificado');
			$bitacora->tipo_servicio = $request->input('tipoServicio'); //Input::get('tipoServicio');

			$causaFallecimientoTemp = $request->input('causaFallecimiento');
			if ( is_numeric( $causaFallecimientoTemp ) ) {
				$bitacora->id_causa = $request->input('causaFallecimiento'); //Input::get('causaFallecimiento');
			} else {
				$causaF = new causaFallecimiento();
				$causaF->name = $causaFallecimientoTemp;
				$causaF->save();
				$bitacora->id_causa = $causaF->id;
			}

			$bitacora->lugar_fallece= $request->input('place'); //Input::get('place');
			$bitacora->no_contrato= $request->input('contrato'); //Input::get('contrato');
			$bitacora->name_titular= $request->input('titularContrato'); //Input::get('titularContrato');
			$bitacora->agente_captura= $request->input('agente'); //Input::get('agente');
			$bitacora->confirma_servicio= $request->input('servicioConfirmado'); //Input::get('servicioConfirmado');
			$bitacora->cobrador= $request->input('cobrador');
			$bitacora->persona_confirma= $request->input('clienteConfirma'); //Input::get('clienteConfirma');
			$bitacora->telefono_cliente= $request->input('telefonoCliente'); //Input::get('telefonoCliente');
			$bitacora->fecha_confirma= $request->input('dateConfirma'); //Input::get('dateConfirma');
			$bitacora->hour_confirma= $request->input('hourConfirma'); //Input::get('hourConfirma');
			//$bitacora->observaciones= $request->input('newComment'); //Input::get('observaciones');
			$bitacora->id_atiende_servicio= $request->input('atiendeServicio'); //Input::get('atiendeServicio');
			$bitacora->id_suc_velacion= $request->input('sucursalVelacion'); //Input::get('sucursalVelacion');
			$bitacora->origen_servicio= $request->input('tipoServicioDetalle'); //Input::get('tipoServicioDetalle');
			$bitacora->tipo_capilla= $request->input('tipoCapilla'); //Input::get('tipoCapilla');
			$bitacora->interplaza = $request->input('interplaza'); //Input::get('interplaza');
			$bitacora->id_interplaza= $request->input('origenInterplaza'); //Input::get('origenInterplaza');
			$bitacora->personas_autorizadas= $request->input('personasAutorizadas'); //Input::get('personasAutorizadas');
			$bitacora->fecha_entrega_cenizas= $request->input('dateEntregaCenizas'); //Input::get('dateEntregaCenizas');
			$bitacora->id_sucursal_cenizas= $request->input('sucursalCenizas'); //Input::get('sucursalCenizas');
			$bitacora->seguro= $request->input('seguro'); //Input::get('seguro');
			$bitacora->fecha_fallecimiento= $request->input('dateDead'); //Input::get('dateDead');
			$bitacora->totalServiciosAdicionales= $request->input('totalServiciosAdicionales'); //Input::get('dateDead');

			$bitacora->tipo_proceso_proveedor= $request->input('tipo_proceso_proveedor'); //Input::get('dateDead');

			$valuesForAdicionales = "";
			if ( $request->input('ataudCambio') != null && $request->input('ataudCambio') != "" ) {
				$valuesForAdicionales .= "Cambio de ataúd. ";
			}
			if ( $request->input('embalsamado') != null && $request->input('embalsamado') != "" ) {
				$valuesForAdicionales .= "Embalsamado. ";
			}
			if ( $request->input('cremacion') != null && $request->input('cremacion') != "" ) {
				$valuesForAdicionales .= "Cremación. ";
			}
			if ( $request->input('capillaDom') != null && $request->input('capillaDom') != "" ) {
				$valuesForAdicionales .= "Capilla a domicilio. ";
			}
			if ( $request->input('capillaRec') != null && $request->input('capillaRec') != "" ) {
				$valuesForAdicionales .= "Capilla en recinto. ";
			}
			if ( $request->input('cafeteria') != null && $request->input('cafeteria') != "" ) {
				$valuesForAdicionales .= "Cambio de ataúd. ";
			}
			if ( $request->input('traslado') != null && $request->input('traslado') != "" ) {
				$valuesForAdicionales .= "Traslado. ";
			}
			if ( $request->input('tramites') != null && $request->input('tramites') != "" ) {
				$valuesForAdicionales .= "Trámites. ";
			}
			if ( $request->input('camion') != null && $request->input('camion') != "" ) {
				$valuesForAdicionales .= "Camión. ";
			}
			if ( $request->input('certificado') != null && $request->input('certificado') != "" ) {
				$valuesForAdicionales .= "Certificado médico. ";
			}
			if ( $request->input('discos') != null && $request->input('discos') != "" ) {
				$valuesForAdicionales .= "Discos. ";
			}
			if ( $request->input('cantos') != null && $request->input('cantos') != "" ) {
				$valuesForAdicionales .= "Cantos. ";
			}

			//$bitacora->adicionales= $request->input('adicionales'); //Input::get('adicionales');
			$bitacora->adicionales= $valuesForAdicionales;

			$bitacora->costo_paquete= $request->input('costoPaquete'); //Input::get('costoPaquete');
			$bitacora->saldo_PABS= $request->input('saldoPABS'); //Input::get('saldoPABS');

			$bitacora->costo_ataud= $request->input('ataudCambio'); //Input::get('ataudCambio');
			$bitacora->costo_embalsamado= $request->input('embalsamado'); //Input::get('embalsamado');
			$bitacora->costo_cremacion= $request->input('cremacion'); //Input::get('cremacion');
			$bitacora->costo_capilla_dom= $request->input('capillaDom'); //Input::get('capillaDom');
			$bitacora->costo_capilla_recinto= $request->input('capillaRec'); //Input::get('capillaRec');
			$bitacora->costo_cafeteria= $request->input('cafeteria'); //Input::get('cafeteria');
			$bitacora->costo_traslado= $request->input('traslado'); //Input::get('traslado');
			$bitacora->costo_tramites= $request->input('tramites'); //Input::get('tramites');
			$bitacora->costo_camion= $request->input('camion'); //Input::get('camion');
			$bitacora->costo_certificado= $request->input('certificado'); //Input::get('certificado');
			$bitacora->costo_discos= $request->input('discos');
			$bitacora->costo_cantos= $request->input('cantos');
			$bitacora->costo_capilla_elite= $request->input('capillaElite');
			//$bitacora->costo_otros= $request->input('otros'); //Input::get('otros');
			$bitacora->cantidad_discos= $request->input('cantidadDiscos'); //Input::get('otros');
			

			$bitacora->lugar_velacion= $request->input('lugarVelacion'); //Input::get('lugarVelacion');
			$bitacora->id_capilla= $request->input('nameCapilla'); //Input::get('nameCapilla');
			//$bitacora->fecha_velacion= $request->input('startDateVelacion'); //Input::get('startDateVelacion');
			//$bitacora->hora_velacion= $request->input('starHourVelacion'); //Input::get('starHourVelacion');

			$saldoConvenidoTemp = str_replace(',','',$request->input('saldoConvenido'));
			$bitacora->saldo_convenido= $saldoConvenidoTemp; //Input::get('saldoConvenido');

			$bitacora->fecha_inicio_pagos= $request->input('startDatePagos'); //Input::get('startDatePagos');
			//Calcular fecha fin de pagos
			$bitacora->id_realiza_convenio = $request->input('realizaConvenio'); //Input::get('realizaConvenio');
			$bitacora->cantidad_pagos= $request->input('noPagos'); //Input::get('noPagos');
			$bitacora->forma_pago= $request->input('formaPago'); //Input::get('formaPago');

			$bitacora->id_operativo_recolecta1= $request->input('operativoRecolecta1'); //Input::get('operativoRecolecta1');
			$bitacora->id_operativo_recolecta2= $request->input('operativoRecolecta2'); //Input::get('operativoRecolecta2');
			$bitacora->id_carroza_recolecta= $request->input('carrozaRecolecta'); //Input::get('carrozaRecolecta');
			$bitacora->fecha_recoleccion= $request->input('startDateRecoleccion'); //Input::get('startDateRecoleccion');
			$bitacora->hora_recoleccion= $request->input('startHourRecoleccion'); //Input::get('startHourRecoleccion');
			$bitacora->fecha_termina_recoleccion = $request->input('endDateRecoleccion'); //Input::get('endDateRecoleccion');
			$bitacora->hora_fin_recoleccion= $request->input('endHourRecoleccion'); //Input::get('endHourRecoleccion');

			$bitacora->id_operativo_instala1= $request->input('operativoInstala1'); //Input::get('operativoInstala1');
			$bitacora->id_operativo_instala2= $request->input('operativoInstala2'); //Input::get('operativoInstala2');
			$bitacora->id_carroza_instala= $request->input('carrozaInstala'); //Input::get('carrozaInstala');
			$bitacora->fecha_instalacion= $request->input('startDateInstala'); //Input::get('startDateInstala');
			$bitacora->hora_instalacion= $request->input('startHourInstala'); //Input::get('startHourInstala');
			$bitacora->fecha_termina_instalacion= $request->input('endDateInstala'); //Input::get('endDateInstala');
			$bitacora->hora_fin_instalacion= $request->input('endHourInstala'); //Input::get('endHourInstala');

			$bitacora->id_operativo_cortejo1= $request->input('operativoCortejo1'); //Input::get('operativoCortejo1');
			$bitacora->id_operativo_cortejo2= $request->input('operativoCortejo2'); //Input::get('operativoCortejo2');
			$bitacora->id_carroza_cortejo= $request->input('carrozaCortejo'); //Input::get('carrozaCortejo');
			$bitacora->fecha_cortejo= $request->input('startDateCortejo'); //Input::get('startDateCortejo');
			$bitacora->hora_cortejo= $request->input('startHourCortejo'); //Input::get('startHourCortejo');
			$bitacora->fecha_termina_cortejo= $request->input('endDateCortejo'); //Input::get('endDateCortejo');
			$bitacora->hora_fin_cortejo= $request->input('endHourCortejo'); //Input::get('endHourCortejo');

			$bitacora->ropa_entregada= $request->input('entregaRopa'); //Input::get('entregaRopa');
			$bitacora->id_embalsamador = $request->input('proveedor'); //Input::get('proveedor');
			$bitacora->id_templo= $request->input('templo'); //Input::get('templo');
			$bitacora->hora_misa= $request->input('startDateMisa'); //Input::get('startDateMisa');
			$bitacora->fecha_misa= $request->input('fecha_misa'); //Input::get('startDateMisa');
			$bitacora->acta_defuncion= $request->input('actaDefuncion'); //Input::get('actaDefuncion');
			$bitacora->ingreso_covid = $request->input('covid');

			$panteonTemp = $request->input('panteon');
			if ( is_numeric( $panteonTemp ) ) {
				//$bitacora->id_causa = $request->input('causaFallecimiento'); //Input::get('causaFallecimiento');
				$bitacora->panteon= $request->input('panteon'); //Input::get('panteon');
			} else {
				$mPanteon = new Panteon();
				$mPanteon->name = $panteonTemp;
				$mPanteon->save();
				$bitacora->panteon = $mPanteon->id;
			}

			$bitacora->user_captura = auth()->user()->name;
			$bitacora->observaciones_servicio= $request->input('observacionesServicio'); //Input::get('panteon');
			$bitacora->medico_certifica= $request->input('medicoCertifica');//medicoCertifica



			//if($bitacora->save()){

			/*echo "<br>";
			echo "mmmmm = " . json_encode($bitacora);
			echo "<br>";*/
			

			if ( $bitacora->save() ) {

				$id_bitacora = $bitacora->id;

				/*echo "<br>";
				echo "mmmmm = " . json_encode($bitacora);
				echo "<br>";
				//return;

				echo "local = ".count($localidades);
				echo "local = ".json_encode($localidades);
				echo "nombres = ".count($nombres);
				echo "nombres = ".json_encode($nombres);*/

				for ($i=0; $i <= 3; $i++) { 
					$address = new Address();
					$address->type = $i +1;
					$address->bitacora = $id_bitacora;
					$address->calle = $calles[$i];
					$address->entre_calles = $entre_calles[$i];
					$address->colonia =$colonias[$i];
					$address->municipio = $localidades[$i];
					$address->save();
				}

			
				for ($i=0; $i <= 4; $i++) { 
					$contact = new Contactos();
					$contact->type = $i +1;
					$contact->bitacora = $id_bitacora;
					$contact->name = $nombres[$i];
					$contact->telefono =$telefonos[$i];
					$contact->parentesco = $parentescos[$i];
					$contact->save();
				}

				/*echo "<br>";
				echo json_encode(auth()->user()->name);
				echo "<br>";*/

				if ( $request->input('newComment') != null ) {
					$comment = new Comments();
					$comment->bitacora = $bitacora->bitacora;
					$comment->comentario = $request->input('newComment');
					$comment->usuario = auth()->user()->name;
					$comment->fecha_captura = date('Y-m-d H:i:s');

					$comment->save();
				}



				$procesosInicioYFin = new ProcesosInicioYFin();
				$procesosInicioYFin->bitacora = $bitacora->bitacora;
				$procesosInicioYFin->save();


			}

			//return view('layouts.bitacora-details.show', compact('bitacora')); //uncomment
			//return Redirect::to('bitacoraD')->with('success_message', 'Personal agregado correctamente.');

			//$this->show($bitacora->id);

			return redirect()->route('bitacora-details.show', $id_bitacora);

			//}
		}			

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		/*echo "<br>";
		echo "<br>";
		echo  "SHOW START";
		echo "<br>";
		echo "<br>";*/
		$id_array = explode("|",$id);
		$id = count($id_array) > 1 ? intval($id_array[1]) : $id;
		$is_factura = count($id_array) > 1 ? true : false;

		$causa = causaFallecimiento::orderBy('name')->pluck('name','id')->prepend('','');
		$singleBitacora = BitacoraDetail::find($id);
		$place = Place::where('status', '=', 'Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$localidad = Localidad::orderBy('name')->pluck('name','id')->prepend('','');
		$colonia = Colonia::orderBy('name')->pluck('name','name')->prepend('','');
		$personalAtiende = Personal::whereIn('profile_id',['ATN CLIENTES FUN','ATN CLIENTES FUNE','ENCARGADO  FUNERARIA','ASESOR FUNERARIO','GESTOR','ATENCION AL CLIENTE','RECEPCION','GESTOR DE TRAMITES','SERVICIOS'])->Select("id", DB::raw("CONCAT(personal.name,' ',personal.first_last_name) as nombre"))->orderBy('name')->pluck('nombre','id')->prepend('','');
		$sucursalVelacion = Sucursal::orderBy('name')->pluck('name','id')->prepend('','');
		$sucursalCenizas = Sucursal::Where('cenizas',1)->orderBy('name')->pluck('name','id')->prepend('','');
		$capilla = Capilla::orderBy('name')->pluck('name','id')->prepend('','');
		$interplaza = Interplaza::orderBy('name')->pluck('name','id')->prepend('','');
		$parentesco = Parentesco::orderBy('name')->pluck('name','id')->prepend('','');
		$operativo = Driver::where('status','=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$carroza = Vehicle::where('status', '=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$proveedor = Supplier::where('status','=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$templo = Templo::orderBy('name')->pluck('name','id')->prepend('','');
		$capilla = Capilla::orderBy('name')->pluck('name','id')->prepend('','');
		$panteon = Panteon::orderBy('name')->pluck('name','id')->prepend('','');
		$pagos = Pagos::Where([['bitacora','=',$id],['status','=','Activo']])->get();
		//$cobrador = Personal::whereIn('profile_id',['Cobrador'])->orderBy('name')->pluck('name','id')->prepend('','');
		$ataud = Ataud::where([['type', '=', '13'],['status','=','Activo']])->orderBy('name')->pluck('name','id')->prepend('','');
		$urna = Ataud::where([['type', '=', '12'],['status','=','Activo']])->orderBy('name')->pluck('name','id')->prepend('','');
		$cobrador = Personal::whereIn('profile_id',['Cobrador'])->Select ("id", DB::raw("CONCAT(personal.no_empleado,'-',personal.name,' ',personal.first_last_name) as nombre"))->pluck('nombre','id')->prepend('',''); 
		$conceptos =DB::table('concepto_pago')->pluck('name','id')->prepend('','');
		$pagos_realizados = False;
		$bitacoraDetailDataChangesHistoryCount = BitacoraDetailDataChangesHistory::where('id', $id)->count();
		$medico = Personal::whereIn('profile_id',['MEDICO'])->Select ("id", DB::raw("CONCAT(personal.name,' ',personal.first_last_name) as nombre"))->pluck('nombre','id')->prepend('',''); 
		$toldos = Personal::whereIn('profile_id',['INSTALADOR DE TOLDOS'])->Select ("id", DB::raw("CONCAT(personal.name,' ',personal.first_last_name) as nombre"))->pluck('nombre','id')->prepend('','');
		$gestor = Personal::whereIn('profile_id',['GESTOR','GESTOR DE TRAMITES'])->where('status','=','Activo')->Select ("id", DB::raw("CONCAT(personal.name,' ',personal.first_last_name) as nombre"))->orderBy('name')->pluck('nombre','id')->prepend('','');
		$vehiculoGest = VehiculoGestoria::where('status', '=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$motocicleta = Vehicle::where([['status', '=','Activo'],['name','like','moto%']])->orderBy('name')->pluck('name','id')->prepend('','');
		$supervisor = Personal::where('status', 'Activo')/*whereIn('profile_id',['SUPERVISOR SERVICIOS'])*/->Select ("id", DB::raw("CONCAT(personal.name,' ',personal.first_last_name) as nombre"))->pluck('nombre','id')->prepend('','');

		$otrosDocumentos = BitacoraDetailsAppliancesAndDocuments::where('bitacora_details_id', $singleBitacora->id)
																->where('inventory_type_id', 21)
																->where('status', 'Activo')
																->select('name')
																->get();
		/*$eventos_cremacion = DB::Select("SELECT 
										    t1.bitacora_details_id,
										    t2.descripcion evento,
										    t1.quien_recibe_cenizas,
										    t1.usuario usuario,
										    DATE(t1.fecha_evento) fecha_evento,
										    DATE_FORMAT(t1.fecha_evento, '%H:%i:%S') hora
										FROM
										    bitacora_cremacion t1
										        INNER JOIN
										    cremacion_tipo_eventos t2 ON t1.tipo_evento = t2.id
										    WHERE t1.bitacora_details_id = $singleBitacora->id
										ORDER BY t1.bitacora_details_id , t1.tipo_evento;");*/


		$eventos_cremacion = DB::Select("
									SELECT * from (
										SELECT 
										    t1.bitacora_details_id,
										    t2.descripcion evento,
										    t1.quien_recibe_cenizas,
										    t1.usuario usuario,
                                            t1.tipo_evento,
										    DATE(t1.fecha_evento) fecha_evento,
										    DATE_FORMAT(t1.fecha_evento, '%H:%i:%S') hora, '' as 'codigo_ataurna'
										FROM
										    bitacora_cremacion t1
										        INNER JOIN
										    cremacion_tipo_eventos t2 ON t1.tipo_evento = t2.id
										    WHERE t1.bitacora_details_id = $singleBitacora->id
										#ORDER BY t1.bitacora_details_id , t1.tipo_evento
                                        
                                        union all
                                        
										select
											bitacora_details_id, 
											case
												when codigo_ataurna like 'UR%' then 'Urna escaneada'
												else 'Ataúd escaneado'
											end as 'evento', '' AS 'quien_recibe_cenizas', usuario as 'usuario', 100 as 'tipo_evento',
											SUBSTRING_INDEX(fecha_captura , ' ', 1) as 'fecha_evento', SUBSTRING_INDEX(fecha_captura , ' ', -1) as 'hora', concat( codigo_ataurna, '|', serie_ataurna) as 'codigo_ataurna'  from bitacora_details_appliances_documents 
										where 
											bitacora_details_id = $singleBitacora->id and 
											inventory_type_id in (12, 13)
											#and codigo_ataurna like 'UR%'
											AND status = 'Activo'
											#order by id desc limit 1000;
											) as t2
											ORDER BY t2.bitacora_details_id , t2.tipo_evento;
		");

		$eventos_recoleccion_embalsamado = DB::Select("
										SELECT 
										    t1.bitacora_details_id,
										    t2.descripcion evento,
										    t1.quien_recibe_cenizas,
										    t1.usuario usuario,
                                            t1.tipo_evento,
										    DATE(t1.fecha_evento) fecha_evento,
										    DATE_FORMAT(t1.fecha_evento, '%H:%i:%S') hora
										FROM
										    bitacora_recoleccion_y_proveedor t1
										        INNER JOIN
										    recoleccion_y_proveedor_tipo_eventos t2 ON t1.tipo_evento = t2.id
										    WHERE t1.bitacora_details_id = $singleBitacora->id
										ORDER BY t1.bitacora_details_id , t1.tipo_evento
		");

		$calc =  Invoices::where('bitacora_invoice','=',$singleBitacora->id)->get();
        $pictures = ImageSurvey::where('bitacora','=',$singleBitacora->bitacora)->whereIn('tipoArchivo',[4,5])->get();
        $categorias = DB::table('tipo_archivo')->select('id','name')->whereIn('id',[4,5])->get();

        if (count($calc) > 0 ) {
            $factura = Invoices::find($calc[0]["id"]);
        }else{
            $factura = array();

        }
        if (count($pictures) == 0 ) {
            $pictures = array();
        }

		return view('layouts.bitacora-details.show', compact('singleBitacora','causa','place', 'localidad', 'colonia', 'personalAtiende',
			'sucursalVelacion','sucursalCenizas','capilla','interplaza','parentesco', 'operativo','carroza',
			'proveedor','templo', 'capilla', 'panteon', 'cobrador', 'ataud', 'urna','conceptos','pagos','pagos_realizados', 'bitacoraDetailDataChangesHistoryCount','medico','toldos','gestor','vehiculoGest','motocicleta','otrosDocumentos','supervisor','eventos_cremacion','eventos_recoleccion_embalsamado','factura','pictures','categorias','is_factura'));
		
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		$id_array = explode("|",$id);
		$id = count($id_array) > 1 ? intval($id_array[1]) : $id;
		$is_factura = count($id_array) > 1 ? true : false;

		$causa = causaFallecimiento::orderBy('name')->pluck('name','id')->prepend('','');
		$singleBitacora = BitacoraDetail::find($id);
		$place = Place::where('status', '=', 'Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$localidad = Localidad::orderBy('name')->pluck('name','id')->prepend('','');
		$colonia = Colonia::orderBy('name')->pluck('name','name')->prepend('','');
		$personalAtiende = Personal::whereIn('profile_id',['ATN CLIENTES FUN','ATN CLIENTES FUNE','ENCARGADO  FUNERARIA','ASESOR FUNERARIO','GESTOR','ATENCION AL CLIENTE','RECEPCION','GESTOR DE TRAMITES','SERVICIOS'])->Select("id", DB::raw("CONCAT(personal.name,' ',personal.first_last_name) as nombre"))->orderBy('name')->pluck('nombre','id')->prepend('','');
		$sucursalVelacion = Sucursal::where('status','=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$sucursalCenizas = Sucursal::Where([['cenizas','=','1'],['status','=','Activo']])->orderBy('name')->pluck('name','id')->prepend('','');
		$capilla = Capilla::where('status','=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$interplaza = Interplaza::where('status','=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$parentesco = Parentesco::where('status','=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$operativo = Driver::where('status','=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$carroza = Vehicle::where('status', '=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$proveedor = Supplier::where('status','=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$templo = Templo::orderBy('name')->pluck('name','id')->prepend('','');
		$capilla = Capilla::where('status','=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$panteon = Panteon::where('status','=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		//$cobrador = Personal::whereIn('profile_id',['Cobrador'])->orderBy('name')->pluck('name','id')->prepend('','');
		$ataud = Ataud::where([['type', '=', '13'],['status','=','Activo']])->orderBy('name')->pluck('name','id')->prepend('','');
		$urna = Ataud::where([['type', '=', '12'],['status','=','Activo']])->orderBy('name')->pluck('name','id')->prepend('','');
		$cobrador = Personal::whereIn('profile_id',['Cobrador'])->Select ("id", DB::raw("CONCAT(personal.no_empleado,'-',personal.name,' ',personal.first_last_name) as nombre"))->orderBy('no_empleado')->pluck('nombre','id')->prepend('',''); 
		$medico = Personal::whereIn('profile_id',['MEDICO'])->Select ("id", DB::raw("CONCAT(personal.name,' ',personal.first_last_name) as nombre"))->pluck('nombre','id')->prepend('',''); 
		$toldos = Personal::whereIn('profile_id',['INSTALADOR DE TOLDOS'])->Select ("id", DB::raw("CONCAT(personal.name,' ',personal.first_last_name) as nombre"))->pluck('nombre','id')->prepend('','');
		$gestor = Personal::whereIn('profile_id',['GESTOR','GESTOR DE TRAMITES'])->where('status','=','Activo')->Select ("id", DB::raw("CONCAT(personal.name,' ',personal.first_last_name) as nombre"))->orderBy('name')->pluck('nombre','id')->prepend('','');
		$vehiculoGest = VehiculoGestoria::where('status', '=','Activo')->orderBy('name')->pluck('name','id')->prepend('','');
		$proveedor_driver = Driver::where('tipo_empleado','=','PROVEEDOR')->where('status','=','Activo')->OrderBy('name','asc')->pluck('name','id');
        $latino_driver = Driver::whereNotIn('tipo_empleado',['PROVEEDOR'])->where('status','=','Activo')->OrderBy('name','asc')->pluck('name','id');
        $motocicleta = Vehicle::where([['status', '=','Activo'],['name','like','moto%']])->orderBy('name')->pluck('name','id')->prepend('','');
        $centinela_driver = Driver::where('tipo_empleado','=','CENTINELA')->where('status','=','Activo')->OrderBy('name','asc')->pluck('name','id');
        $supervisor = Personal::where('status', 'Activo')/*whereIn('profile_id',['SUPERVISOR SERVICIOS'])*/->Select ("id", DB::raw("CONCAT(personal.name,' ',personal.first_last_name) as nombre"))->pluck('nombre','id')->prepend('','');

		$otrosDocumentos = BitacoraDetailsAppliancesAndDocuments::where('bitacora_details_id', $singleBitacora->id)
																->where('inventory_type_id', 21)
																->where('status', 'Activo')
																->select('name')
																->get();
		$sucursalFactura = Sucursal::whereIn('id',[1])->pluck('name','id')->prepend('','');															
        /*$latino_driver_aux = DB::SELECT("SELECT p.id, p.name from login l1
										inner join 
										(
											select max(id) as 'sub_id', login.user from login where type in (3,4) and fecha >= DATE_ADD(now(), INTERVAL -1 DAY) group by login.user
										) as l2 on l1.id = l2.sub_id
										left join drivers p on l1.user = p.name
										where l1.type = 3 and 
										p.tipo_empleado in ('SERVICIOS')
										;");
		$collection = collect($latino_driver_aux);
		$plucked = $collection->pluck('name', 'id');
		//echo json_encode( $plucked->all() );
		$latino_driver = $plucked->all();*/

		$timestamp_edit = time();
		$userName = auth()->user()->name;
		$singleBitacoraTemp = $singleBitacora;
		$singleBitacoraTemp->timestamp = $timestamp_edit;
		$singleBitacoraTemp->user = $userName;

		unset( $singleBitacoraTemp->created_at );
		unset( $singleBitacoraTemp->updated_at );

		//echo json_encode($singleBitacoraTemp->toArray());

		DB::table('bitacora_details_being_updated')
	    ->updateOrInsert(
	        ['id' => $id, 'timestamp' => $timestamp_edit, 'user' => $userName],
	        $singleBitacoraTemp->toArray()
	    );

		 $calc =  Invoices::where('bitacora_invoice','=',$singleBitacora->id)->get();
        $image = ImageSurvey::where('bitacora','=',$singleBitacora->bitacora)->whereIn('tipoArchivo',[4,5])->get();
        $categorias = DB::table('tipo_archivo')->select('id','name')->whereIn('id',[4,5])->get();

        if (count($calc) > 0 ) {
            $factura = Invoices::find($calc[0]["id"]);
            $userName = auth()->user()->name;
            $singleInvoiceTemp = $factura;
            $singleInvoiceTemp->timestamp_invoice = $timestamp_edit;
            $singleInvoiceTemp->user_invoice = $userName;

            unset( $singleInvoiceTemp->created_at );
            unset( $singleInvoiceTemp->updated_at );

            DB::table('bitacora_invoice_beign_updated')
            ->updateOrInsert(
                ['bitacora_invoice' => $id, 'timestamp_invoice' => $timestamp_edit, 'user_invoice' => $userName],
                $factura->toArray()
            );

        }else{
            $factura = array();
            $userName = auth()->user()->name;

            DB::table('bitacora_invoice_beign_updated')
            ->updateOrInsert(
                ['bitacora_invoice' => $id, 'timestamp_invoice' => $timestamp_edit, 'user_invoice' => $userName],
                [
                    'bitacora_invoice' => $id,
                    'timestamp_invoice' => $timestamp_edit,
                    'user_invoice' => $userName
                ]
            );


        }
        if (count($image) == 0 ) {
            $image = array();
        }

		if ( $singleBitacora->revisado_administracion == 'on' ) {
			

			//echo json_encode(auth()->user());
			if ( auth()->user()->hasRole(['editor', 'moderator', 'Super Admin']) ) {
				echo "si tiene permisos para modificar aunque este revisado por admon";
			} else {

				return back()->withErrors(['La bitácora ya fue revisada por administración; ya no es posible modificar información']);
					//->withInput($request->all());
			}
		}

		return view('layouts.bitacora-details.edit', compact('singleBitacora','causa','place', 'localidad', 'colonia', 'personalAtiende',
			'sucursalVelacion','sucursalCenizas','capilla','interplaza','parentesco', 'operativo','carroza',
			'proveedor','templo', 'capilla', 'panteon', 'cobrador', 'ataud', 'urna', 'timestamp_edit','medico','toldos','gestor','vehiculoGest','proveedor_driver','latino_driver','motocicleta','otrosDocumentos','centinela_driver','supervisor','factura','image','categorias',
			'is_factura','sucursalFactura'));
		
	}

	//public function addNewComment($bitacora, $comment)
	public function addNewComment(Request $request)
	{
		$comment = new Comments();
		$comment->bitacora = $request->input('bitacora');
		$comment->comentario = $request->input('comment');
		$comment->usuario = auth()->user()->name;
		$comment->fecha_captura = date('Y-m-d H:i:s');

		if ( $comment->save() ) {
			return response()->json(
				array(
					//'url' => public_path(),
					'success' => true,
					'message' => 'Se agregó el comentario correctamente',
					'result' => array(
									"comment" => $request->input('comment'),
									"usuario" => auth()->user()->name,
									"fecha" => $comment->fecha_captura,
									"imageSource" => "http://3.208.145.41/ebita-gdl/public/images/profile-picture.png"
								),
				),
				200
			);
		} else {
			return response()->json(
				array(
					//'url' => public_path(),
					'error' => true,
					'error_message' => 'No se agregó el comentario',
				),
				200
			);
		}
	}

	public function registerBSFAsPrinted(Request $request)
	{

		return;
		Log::channel('BSF_printed')->info('app.requests', ['request_name' => 'registerBSFAsPrinted', 'user' => auth()->user()->name, 'request' => $request->all()] );
		return;
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$arrayBitacora  = array(
			//'bitacora' => 'Número Bitacora',
			'finado' =>'Nombre de fallecido',
			'folioCertificado' => 'Folio de certificado',
			'contrato'=>'Número de contrato',
			'titularContrato'=>'Titular del contrato',
			//'agente'=>'Agente',
			//'clienteConfirma'=>'Cliente que confirma',
			//'telefonoCliente'=>'Teléfono del cliente'
		);		

		$rules = array(
						//'bitacora' => 'Unique:bitacora_details,bitacora|min:11',
						'finado' => 'required',
						'createDateBitacora' => 'required'
		 );

		$messages = array(
			'required' => 'El campo :attribute es requerido' ,
			'Unique' => 'El Número de empleado :attribute ya ha sido registrado',
			'min' => 'Mínimo 10 caracteres'
			 );
		$validator = Validator::make($request->all(),$rules,$messages);
		$validator->setAttributeNames($arrayBitacora);


		if($validator->fails()){
			
			$messages = $validator->messages();


			return back()
				->withErrors($messages)
				->withInput($request->all());

		}
		else {	

			// START
			// CHECK WHETHER $request->input('servicio') IS EQUAL TO "TERMINADA"
			// IF SO, CHECK THAT $request->input('tipoServicio') IS SET
			if( $request->input('servicio') == "TERMINADO" ) {
				if ( $request->input('tipoServicio') == null ) {
					return back()
					->withErrors(['Para terminar la bitácora se tiene haber agregado si el tipo de servicio si fue INHUMACIÓN, CREMACIÓN, TRASLADO u OTRO'])
					->withInput($request->all());
				}
			}
			// END






			

			$fieldToUpdate = DB::table('bitacora_details_being_updated')
            ->where('id', $id)
            ->where('timestamp', $request->input('timestamp_edit'))
            ->where('user', auth()->user()->name)
            ->first();

            /*echo json_encode($request->input('timestamp_edit'));
            echo "<br>";
            echo json_encode($fieldToUpdate);

            echo "<br>";
            echo "<br>";
            echo "<br>";*/

            //echo json_encode( array_diff_assoc( $request->all(), (array) $fieldToUpdate ) );

            //return;

			//Obtener los valores de los arreglos de contactos y direcciones

			/*$colonia = $_POST['colonia'];
			$localidad = $_POST['municipio'];
			$nombre = $_POST['name'];
			$telefono = $_POST['telefono'];
			$parentesco = $_POST['parentesco'];
			$calle =$_POST['calle'];*/
			$colonia = $request->input('colonia'); //$_POST['colonia'];
			$localidad = $request->input('municipio'); //$_POST['municipio'];
			$nombre = $request->input('name'); //$_POST['name'];
			$telefono = $request->input('telefono'); //$_POST['telefono'];
			$parentesco = $request->input('parentesco'); //$_POST['parentesco'];
			$calle = $request->input('calle'); //$_POST['calle'];
			$entre_calle = $request->input('entre_calles');
			//Variables para guardar los valores obtenidos del formulario
			$nombres=[];
			$telefonos=[];
			$parentescos=[];
			$calles=[];
			$colonias=[];
			$localidades=[];
			$entre_calles=[];
						//Campos de asignacion logistica
			$idOperativo =[];
			$movimiento=[];
			$tipo_operativo=[];
			$bitacoraAsiganda =[];

			//Agregar los valores a los arreglos 
			foreach ($calle as $val) {
				array_push($calles, $val);
			}
				
			foreach ($colonia as $val) {
				array_push($colonias, $val);
			}

			foreach ($localidad as $val) {
				array_push($localidades, $val);
			}
			foreach ($nombre as $val) {
				array_push($nombres, $val);
			}
				
			foreach ($telefono as $val) {
				array_push($telefonos, $val);
			}

			foreach ($parentesco as $val) {
				array_push($parentescos, $val);
			}

			foreach ($entre_calle as $val) {
				array_push($entre_calles, $val);
			}
			//echo json_encode(["Calles"=>$calles,"colonias"=>$colonias,"Localidad"=>$localidades,"Nombres"=>$nombres,"Telefonos"=>$telefonos,"Parentesco"=>$parentescos,"entre_calles"=>$entre_calles]);
			
			//$comentario_anterior = $request->input('observaciones'); //Input::get('observaciones');
			//$fecha_comentario = date("Y-m-d h:m:s");
			//$comentario = 
			$bitacora = BitacoraDetail::find($id);
			$bitacora->status_bitacora = $request->input('servicio'); //Input::get('finado');
			if ( $request->input('servicio') == 'TERMINADO' ) {
				$bitacora->fecha_terminada = date('Y-m-d H:i:s');
			}
			$bitacora->name_dead = $request->input('finado'); //Input::get('finado');
			//$bitacora->fecha_captura = $request->input('createDateBitacora'); //Input::get('createDateBitacora');
			//$bitacora->hora_captura = $request->input('createHourBitacora'); //Input::get('createHourBitacora');
			$bitacora->llamada = $request->input('llamada'); //Input::get('llamada');
			$bitacora->ataud = $request->input('ataud'); //Input::get('llamada');
			$bitacora->urna = $request->input('urna'); //Input::get('llamada');
			$bitacora->certifica = $request->input('certifica'); //Input::get('certifica');
			//$bitacora->visita_personal = $request->input('Visita'); //Input::get('visita');
			$bitacora->edad_finado = $request->input('edadFinado');
			$bitacora->persona_otorga_datos = $request->input('personaConfirma');
			$bitacora->folio_certificado = $request->input('folioCertificado'); //Input::get('folioCertificado');
			$bitacora->tipo_servicio = $request->input('tipoServicio'); //Input::get('tipoServicio');

			$causaFallecimientoTemp = $request->input('causaFallecimiento');
			if ( is_numeric( $causaFallecimientoTemp ) ) {
				$bitacora->id_causa = $request->input('causaFallecimiento'); //Input::get('causaFallecimiento');
			} else {
				$causaF = new causaFallecimiento();
				$causaF->name = $causaFallecimientoTemp;
				$causaF->save();
				$bitacora->id_causa = $causaF->id;
			}

			$bitacora->cobrador= $request->input('cobrador');
			$bitacora->lugar_fallece= $request->input('place'); //Input::get('place');
			$bitacora->no_contrato= $request->input('contrato'); //Input::get('contrato');
			$bitacora->promotor_nombre= $request->input('promotor_nombre'); //Input::get('contrato');
			$bitacora->name_titular= $request->input('titularContrato'); //Input::get('titularContrato');
			$bitacora->agente_captura= $request->input('agente'); //Input::get('agente');
			$bitacora->confirma_servicio= $request->input('servicioConfirmado'); //Input::get('servicioConfirmado');
			$bitacora->persona_confirma= $request->input('clienteConfirma'); //Input::get('clienteConfirma');
			$bitacora->telefono_cliente= $request->input('telefonoCliente'); //Input::get('telefonoCliente');
			$bitacora->fecha_confirma= $request->input('dateConfirma'); //Input::get('dateConfirma');
			$bitacora->hour_confirma= $request->input('hourConfirma'); //Input::get('hourConfirma');
			$bitacora->observaciones= $request->input('observaciones'); //Input::get('observaciones');
			$bitacora->id_atiende_servicio= $request->input('atiendeServicio'); //Input::get('atiendeServicio');
			$bitacora->id_suc_velacion= $request->input('sucursalVelacion'); //Input::get('sucursalVelacion');
			$bitacora->origen_servicio= $request->input('tipoServicioDetalle'); //Input::get('tipoServicioDetalle');
			$bitacora->tipo_capilla= $request->input('tipoCapilla'); //Input::get('tipoCapilla');
			$bitacora->interplaza = $request->input('interplaza'); //Input::get('interplaza');
			$bitacora->id_interplaza= $request->input('origenInterplaza'); //Input::get('origenInterplaza');
			$bitacora->personas_autorizadas= $request->input('personasAutorizadas'); //Input::get('personasAutorizadas');
			$bitacora->fecha_entrega_cenizas= $request->input('dateEntregaCenizas'); //Input::get('dateEntregaCenizas');
			$bitacora->id_sucursal_cenizas= $request->input('sucursalCenizas'); //Input::get('sucursalCenizas');
			$bitacora->seguro= $request->input('seguro'); //Input::get('seguro');
			$bitacora->fecha_fallecimiento= $request->input('dateDead'); //Input::get('dateDead');
			$bitacora->revisado_administracion= $request->input('revisado_administracion'); //Input::get('dateDead');
			$bitacora->totalServiciosAdicionales= $request->input('totalServiciosAdicionales'); //Input::get('dateDead');

			$bitacora->tipo_proceso_proveedor= $request->input('tipo_proceso_proveedor'); //Input::get('dateDead');

			
			$valuesForAdicionales = "";
			if ( $request->input('ataudCambio') != null && $request->input('ataudCambio') != "" ) {
				$valuesForAdicionales .= "Cambio de ataúd. ";
			}
			if ( $request->input('embalsamado') != null && $request->input('embalsamado') != "" ) {
				$valuesForAdicionales .= "Embalsamado. ";
			}
			if ( $request->input('cremacion') != null && $request->input('cremacion') != "" ) {
				$valuesForAdicionales .= "Cremación. ";
			}
			if ( $request->input('capillaDom') != null && $request->input('capillaDom') != "" ) {
				$valuesForAdicionales .= "Capilla a domicilio. ";
			}
			if ( $request->input('capillaRec') != null && $request->input('capillaRec') != "" ) {
				$valuesForAdicionales .= "Capilla en recinto. ";
			}
			if ( $request->input('cafeteria') != null && $request->input('cafeteria') != "" ) {
				$valuesForAdicionales .= "Cambio de ataúd. ";
			}
			if ( $request->input('traslado') != null && $request->input('traslado') != "" ) {
				$valuesForAdicionales .= "Traslado. ";
			}
			if ( $request->input('tramites') != null && $request->input('tramites') != "" ) {
				$valuesForAdicionales .= "Trámites. ";
			}
			if ( $request->input('camion') != null && $request->input('camion') != "" ) {
				$valuesForAdicionales .= "Camión. ";
			}
			if ( $request->input('certificado') != null && $request->input('certificado') != "" ) {
				$valuesForAdicionales .= "Certificado médico. ";
			}
			if ( $request->input('discos') != null && $request->input('discos') != "" ) {
				$valuesForAdicionales .= "Discos. ";
			}
			if ( $request->input('cantos') != null && $request->input('cantos') != "" ) {
				$valuesForAdicionales .= "Cantos. ";
			}

			//$bitacora->adicionales= $request->input('adicionales'); //Input::get('adicionales');
			$bitacora->adicionales= $valuesForAdicionales;

			/*$bitacora->documento_INE_finado= $request->input('documento_INE_finado') == "on" ? 1 : null;
			$bitacora->documento_acta_nacimiento_finado= $request->input('documento_acta_nacimiento_finado') == "on" ? 1 : null;
			$bitacora->documento_INE_familiar= $request->input('documento_INE_familiar') == "on" ? 1 : null;
			$bitacora->documento_acta_nacimiento_familiar= $request->input('documento_acta_nacimiento_familiar') == "on" ? 1 : null;
			$bitacora->documento_certificado_defuncion= $request->input('documento_certificado_defuncion') == "on" ? 1 : null;
			$bitacora->documento_titulo_propiedad_cementerio= $request->input('documento_titulo_propiedad_cementerio') == "on" ? 1 : null;
			$bitacora->documento_PERMISO_INHUMACION= $request->input('documento_PERMISO_INHUMACION') == "on" ? 1 : null;
			$bitacora->documento_PERMISO_CREMACION= $request->input('documento_PERMISO_CREMACION') == "on" ? 1 : null;
			$bitacora->documento_PERMISO_TRASLADO= $request->input('documento_PERMISO_TRASLADO') == "on" ? 1 : null;*/

			$bitacora->costo_paquete= $request->input('costoPaquete'); //Input::get('costoPaquete');
			$bitacora->saldo_PABS= $request->input('saldoPABS'); //Input::get('saldoPABS');
			$bitacora->costo_ataud= $request->input('ataudCambio'); //Input::get('ataudCambio');
			$bitacora->costo_embalsamado= $request->input('embalsamado'); //Input::get('embalsamado');
			$bitacora->costo_cremacion= $request->input('cremacion'); //Input::get('cremacion');
			$bitacora->costo_capilla_dom= $request->input('capillaDom'); //Input::get('capillaDom');
			$bitacora->costo_capilla_recinto= $request->input('capillaRec'); //Input::get('capillaRec');
			$bitacora->costo_cafeteria= $request->input('cafeteria'); //Input::get('cafeteria');
			$bitacora->costo_traslado= $request->input('traslado'); //Input::get('traslado');
			$bitacora->costo_tramites= $request->input('tramites'); //Input::get('tramites');
			$bitacora->costo_camion= $request->input('camion'); //Input::get('camion');
			$bitacora->costo_certificado= $request->input('certificado'); //Input::get('certificado');
			$bitacora->costo_discos= $request->input('discos');
			
			$bitacora->costo_cantos= $request->input('cantos');
			$bitacora->costo_capilla_elite= $request->input('capillaElite');
			$bitacora->cantidad_discos= $request->input('cantidadDiscos'); //Input::get('otros');

			//$bitacora->costo_otros= $request->input('otros'); //Input::get('otros');
			$bitacora->lugar_velacion= $request->input('lugarVelacion'); //Input::get('lugarVelacion');
			$bitacora->id_capilla= $request->input('nameCapilla'); //Input::get('nameCapilla');
			//$bitacora->fecha_velacion= $request->input('startDateVelacion'); //Input::get('startDateVelacion');
			//$bitacora->hora_velacion= $request->input('starHourVelacion'); //Input::get('starHourVelacion');

			//$bitacora->saldo_convenido= $request->input('saldoConvenido'); //Input::get('saldoConvenido');
			$saldoConvenidoTemp = str_replace(',','',$request->input('saldoConvenido'));
			$bitacora->saldo_convenido= $saldoConvenidoTemp; //Input::get('saldoConvenido');
			
			$bitacora->fecha_inicio_pagos= $request->input('startDatePagos'); //Input::get('startDatePagos');
			//Calcular fecha fin de pagos
			$bitacora->id_realiza_convenio = $request->input('realizaConvenio'); //Input::get('realizaConvenio');
			$bitacora->cantidad_pagos= $request->input('noPagos'); //Input::get('noPagos');
			$bitacora->forma_pago= $request->input('formaPago'); //Input::get('formaPago');

			$bitacora->id_operativo_recolecta1= $request->input('operativoRecolecta1'); //Input::get('operativoRecolecta1');
			$bitacora->id_operativo_recolecta2= $request->input('operativoRecolecta2'); //Input::get('operativoRecolecta2');
			$bitacora->id_carroza_recolecta= $request->input('carrozaRecolecta'); //Input::get('carrozaRecolecta');
			$bitacora->fecha_recoleccion= $request->input('startDateRecoleccion'); //Input::get('startDateRecoleccion');
			$bitacora->hora_recoleccion= $request->input('startHourRecoleccion'); //Input::get('startHourRecoleccion');
			$bitacora->fecha_termina_recoleccion = $request->input('endDateRecoleccion'); //Input::get('endDateRecoleccion');
			$bitacora->hora_fin_recoleccion= $request->input('endHourRecoleccion'); //Input::get('endHourRecoleccion');

			$bitacora->id_operativo_instala1= $request->input('operativoInstala1'); //Input::get('operativoInstala1');
			$bitacora->id_operativo_instala2= $request->input('operativoInstala2'); //Input::get('operativoInstala2');
			$bitacora->id_carroza_instala= $request->input('carrozaInstala'); //Input::get('carrozaInstala');
			$bitacora->fecha_instalacion= $request->input('startDateInstala'); //Input::get('startDateInstala');
			$bitacora->hora_instalacion= $request->input('startHourInstala'); //Input::get('startHourInstala');
			$bitacora->fecha_termina_instalacion= $request->input('endDateInstala'); //Input::get('endDateInstala');
			$bitacora->hora_fin_instalacion= $request->input('endHourInstala'); //Input::get('endHourInstala');

			$bitacora->id_operativo_cortejo1= $request->input('operativoCortejo1'); //Input::get('operativoCortejo1');
			$bitacora->id_operativo_cortejo2= $request->input('operativoCortejo2'); //Input::get('operativoCortejo2');
			$bitacora->id_carroza_cortejo= $request->input('carrozaCortejo'); //Input::get('carrozaCortejo');
			$bitacora->fecha_cortejo= $request->input('startDateCortejo'); //Input::get('startDateCortejo');
			$bitacora->hora_cortejo= $request->input('startHourCortejo'); //Input::get('startHourCortejo');
			$bitacora->fecha_termina_cortejo= $request->input('endDateCortejo'); //Input::get('endDateCortejo');
			$bitacora->hora_fin_cortejo= $request->input('endHourCortejo'); //Input::get('endHourCortejo');

			$bitacora->id_operativo_traslado1= $request->input('operativoTraslado1'); //Input::get('operativoCortejo1');
			$bitacora->id_operativo_traslado2= $request->input('operativoTraslado2'); //Input::get('operativoCortejo2');
			$bitacora->id_carroza_traslado= $request->input('carrozaTraslado'); //Input::get('carrozaCortejo');
			$bitacora->fecha_traslado= $request->input('startDateTraslado'); //Input::get('startDateCortejo');
			$bitacora->hora_traslado= $request->input('startHourTraslado'); //Input::get('startHourCortejo');
			$bitacora->fecha_termina_traslado= $request->input('endDateTraslado'); //Input::get('endDateCortejo');
			$bitacora->hora_fin_traslado= $request->input('endHourTraslado'); //Input::get('endHourCortejo');

			$bitacora->ropa_entregada= $request->input('entregaRopa'); //Input::get('entregaRopa');
			$bitacora->id_embalsamador = $request->input('proveedor'); //Input::get('proveedor');
			$bitacora->id_templo= $request->input('templo'); //Input::get('templo');
			$bitacora->hora_misa= $request->input('startDateMisa'); //Input::get('startDateMisa');
			$bitacora->fecha_misa= $request->input('fecha_misa'); //Input::get('startDateMisa');
			$bitacora->acta_defuncion= $request->input('actaDefuncion'); //Input::get('actaDefuncion');

			//Seccíón de gestoría
			$bitacora->id_gestor_acta= $request->input('gestorActa'); //Input::get('endHourCortejo');
			$bitacora->id_vehiculo_acta= $request->input('vehiculoActa'); //Input::get('entregaRopa');
			$bitacora->id_gestor_tramite_per = $request->input('gestorPermiso'); //Input::get('proveedor');
			$bitacora->id_vehiculo_tramite_per= $request->input('vehiculoPermiso'); //Input::get('templo');
			$bitacora->id_gestor_entrega_per= $request->input('gestorEntregaPer'); //Input::get('startDateMisa');
			$bitacora->id_vehiculo_entrega_per= $request->input('vehiculoEntregaPer'); //Input::get('actaDefuncion');

			//Sección centinelas
			$bitacora->id_centinela_recolecta  =$request->input('centinelaRecolecta');
			$bitacora->id_centinela_instala  =$request->input('centinelaInstala');
			$bitacora->id_centinela_cortejo  =$request->input('centinelaCortejo');
			$bitacora->id_centinela_traslado  =$request->input('centinelaTraslado');
			$bitacora->id_carroza_cent_recolecta  =$request->input('centVehiculoRecolecta');
			$bitacora->id_carroza_cent_instala  =$request->input('centVehiculoInstala');
			$bitacora->id_carroza_cent_cortejo  =$request->input('centVehiculoCortejo');
			$bitacora->id_carroza_cent_traslado=$request->input('centVehiculoTraslado');

			//Campos para fechas de cortejo camion
			$bitacora->fecha_inicio_camion = $request->input('startDateCamion');
			$bitacora->hora_inicio_camion  = $request->input('startHourCamion');
			//$bitacora->fecha_fin_camion = $request->input('endDateCamion');
			//$bitacora->hora_fin_camion = $request->input('endHourCamion');

			
			
			$panteonTemp = $request->input('panteon');
			if ( is_numeric( $panteonTemp ) ) {
				//$bitacora->id_causa = $request->input('causaFallecimiento'); //Input::get('causaFallecimiento');
				$bitacora->panteon= $request->input('panteon'); //Input::get('panteon');
			} else {
				$mPanteon = new Panteon();
				$mPanteon->name = $panteonTemp;
				$mPanteon->save();
				$bitacora->panteon = $mPanteon->id;
			}
			
			$bitacora->observaciones_servicio= $request->input('observacionesServicio'); //Input::get('panteon');
			$bitacora->medico_certifica= $request->input('medicoCertifica');//medicoCertifica

			$bitacora->toldos_sillas= $request->input('sillaToldos');//check box de sillas y toldos
			$bitacora->solicita_toldos= $request->input('solicitaToldos');//usuario que solciita toldos
			$bitacora->confirma_toldos= $request->input('confirmaToldos');//medicoCertifica
			$bitacora->hora_comfirma_ts= $request->input('horaConfirmaToldos');//medicoCertifica
			$bitacora->folio_toldos= $request->input('folioToldos');//medicoCertifica
			$bitacora->recibe_cenizas = $request->input('personaRecibeCen');
			$bitacora->recibe_acta = $request->input('personaRecibeActa');
			$bitacora->fecha_etrega_acta = $request->input('dateEntregaActa');
			$bitacora->fecha_entrega_suc_acta = $request->input('dateEntregaActaSucursal');
			$bitacora->fecha_entrega_suc_cen = $request->input('dateEntregaCenizasSucursal');
			$bitacora->personal_recibe_cen = $request->input('gestorCenizas');
			$bitacora->personal_recibe_act = $request->input('gestorActa1');
			$bitacora->observaciones_gest = $request->input('observacionesGestoria');
			$bitacora->observaciones_atn = $request->input('observacionesCenizas');
			$bitacora->obervaciones_convenio = $request->input('observacionesConvenio');
			$bitacora->toldos_externo = $request->input('toldosExterno');
			//$bitacora->fecha_fin_velacion = $request->input('endDateVelacion');
			//$bitacora->hora_fin_velacion = $request->input('endHourVelacion');
			//RECEPCION DE DOCUMENTOS
			$bitacora->doc_contrato= $request->input('docContrato');
			$bitacora->recibe_contrato= $request->input('recibeContrato');

			$bitacora->doc_titulo= $request->input('docTitulo');
			$bitacora->recibe_titulo= $request->input('recibeTitulo');

			$bitacora->doc_solicitud= $request->input('docSolicitud');
			$bitacora->recibe_solicitud= $request->input('recibeSolicitud');

			$bitacora->doc_responsiva= $request->input('docResponsiva');//check box de sillas y toldos
			$bitacora->recibe_responsiva= $request->input('recibeResponsiva');//usuario que solciita toldos

			$bitacora->sucursal_hace_convenio= $request->input('sucursal_hace_convenio');

			$bitacora->id_operativo_cortejo3= $request->input('id_operativo_cortejo3');
			$bitacora->id_camion_cortejo= $request->input('id_camion_cortejo');

			$bitacora->doc_entrega_disco= $request->input('docDisco');
			$bitacora->entrega_disco= $request->input('entregaDisco');

			$bitacora->ingreso_covid = $request->input('covid');



			//if ($bitacora->bitacora == "GDL30JUN001") {

			//---------------------------------------------------------------RECOLECCIÓN---------------------------------------------------------------------------------------------------------------------------------
			if($bitacora->isDirty('id_operativo_recolecta1') &&  $bitacora->id_operativo_recolecta1 != null && $bitacora->id_operativo_recolecta1 != "" ){
				$proveedor = $this->get_proveedor($request->input('operativoRecolecta1'));
						if($proveedor[0]>0){//significa que es proveedor----Asignar bitacora
							$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',1);
						}
						else{
							$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],1);
							array_push($idOperativo, $request->input('operativoRecolecta1'));
							array_push($movimiento, 'Recolección');
							array_push($tipo_operativo,'Operativo 1');
							array_push($bitacoraAsiganda,$bitacora->bitacora);
						}
					}

					if($bitacora->isDirty('id_operativo_recolecta2') &&  $bitacora->id_operativo_recolecta2 != null && $bitacora->id_operativo_recolecta2 != "" ){
						array_push($idOperativo, $request->input('operativoRecolecta2'));
						array_push($movimiento, 'Recolección');
						array_push($tipo_operativo,'Operativo 2');
						array_push($bitacoraAsiganda,$bitacora->bitacora);
					}

				//---------------------------------------------------------------INSTALACCIÓN---------------------------------------------------------------------------------------------------------------------------------

					if($bitacora->isDirty('id_operativo_instala1') &&  $bitacora->id_operativo_instala1 != null && $bitacora->id_operativo_instala1 != ""){
						$proveedor = $this->get_proveedor($request->input('operativoInstala1'));
					if($proveedor[0]>0){//significa que es proveedor----Asignar bitacora
							//echo "3 - ";
							//Log::channel('random_stuff')->info('app.requests', ['request_name' => '3'] );
						$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',2);
					}
					else{
						$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],2);
						array_push($idOperativo, $request->input('operativoInstala1'));
						array_push($movimiento, 'Instalación');
						array_push($tipo_operativo,'Operativo 1');
						array_push($bitacoraAsiganda,$bitacora->bitacora);
					}

				}

				if($bitacora->isDirty('id_operativo_instala2') &&  $bitacora->id_operativo_instala2 != null && $bitacora->id_operativo_instala2 != ""){
					array_push($idOperativo, $request->input('operativoInstala2'));
					array_push($movimiento, 'Instalación');
					array_push($tipo_operativo,'Operativo 2');
					array_push($bitacoraAsiganda,$bitacora->bitacora);

				} 

				//---------------------------------------------------------------CORTEJO---------------------------------------------------------------------------------------------------------------------------------
				if($bitacora->isDirty('id_operativo_cortejo1') &&  $bitacora->id_operativo_cortejo1 != null && $bitacora->id_operativo_cortejo1 != ""){
					$proveedor = $this->get_proveedor($request->input('operativoCortejo1'));
					if($proveedor[0]>0){
						$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',3);
					}
					else{
						$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],3);
						array_push($idOperativo, $request->input('operativoCortejo1'));
						array_push($movimiento, 'Cortejo');
						array_push($tipo_operativo,'Operativo 1');
						array_push($bitacoraAsiganda,$bitacora->bitacora);
					}
				}
				if($bitacora->isDirty('id_operativo_cortejo2') &&  $bitacora->id_operativo_cortejo2 != null && $bitacora->id_operativo_cortejo2 != ""){
					array_push($idOperativo, $request->input('operativoCortejo2'));
					array_push($movimiento, 'Cortejo');
					array_push($tipo_operativo,'Operativo 2');
					array_push($bitacoraAsiganda,$bitacora->bitacora);
				}

//---------------------------------------------------------------TRASLADO---------------------------------------------------------------------------------------------------------------------------------
				if($bitacora->isDirty('id_operativo_traslado1') &&  $bitacora->id_operativo_traslado1 != null && $bitacora->id_operativo_traslado1 != "" ){
					$proveedor = $this->get_proveedor($request->input('operativoTraslado1'));
					if($proveedor[0]>0){//significa que es proveedor----Asignar bitacora
						$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',4);

					}
					else{
						$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],4);
						array_push($idOperativo, $request->input('operativoTraslado1'));
						array_push($movimiento, 'Traslado');
						array_push($tipo_operativo,'Operativo 1');
						array_push($bitacoraAsiganda,$bitacora->bitacora);
					}
				}

				if($bitacora->isDirty('id_operativo_traslado2') &&  $bitacora->id_operativo_traslado2 != null && $bitacora->id_operativo_traslado2 != "" ){
					array_push($idOperativo, $request->input('id_operativo_traslado2'));
					array_push($movimiento, 'Traslado');
					array_push($tipo_operativo,'Operativo 2');
					array_push($bitacoraAsiganda,$bitacora->bitacora);
				}


					//---------------------------------------------------------------CORTEJO CAMION---------------------------------------------------------------------------------------------------------------------------------
				if($bitacora->isDirty('id_operativo_cortejo3') &&  $bitacora->id_operativo_cortejo3 != null && $bitacora->id_operativo_cortejo3 != ""){
					$proveedor = $this->get_proveedor($request->input('id_operativo_cortejo3'));
					if($proveedor[0]>0){//significa que es proveedor----Asignar bitacora
						$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',5);

					}
					else{
						$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],5);
						array_push($idOperativo, $request->input('id_operativo_cortejo3'));
						array_push($movimiento, 'Cortejo camion');
						array_push($tipo_operativo,'Operativo 1');
						array_push($bitacoraAsiganda,$bitacora->bitacora);

					}
				}



				//---------------------------------------------------------------CENTINELA RECOLECTA---------------------------------------------------------------------------------------------------------------------------------

				if($bitacora->isDirty('id_centinela_recolecta') &&  $bitacora->id_centinela_recolecta != null && $bitacora->id_centinela_recolecta != ""){
					$proveedor = $this->get_proveedor($request->input('centinelaRecolecta'));
					if($proveedor[0]>0){//significa que es proveedor----Asignar bitacora
						$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',6);

					}
					else{
						$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],6);
						array_push($idOperativo, $request->input('centinelaRecolecta'));
						array_push($movimiento, 'Centinela - Recolección');
						array_push($tipo_operativo,'Operativo 1');
						array_push($bitacoraAsiganda,$bitacora->bitacora);

					}
				}

				//---------------------------------------------------------------CENTINELA CORTEJO---------------------------------------------------------------------------------------------------------------------------------
				if($bitacora->isDirty('id_centinela_cortejo') &&  $bitacora->id_centinela_cortejo != null && $bitacora->id_centinela_cortejo != ""){
					$proveedor = $this->get_proveedor($request->input('centinelaCortejo'));
					if($proveedor[0]>0){//significa que es proveedor----Asignar bitacora
						$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',7);

					}
					else{
						$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],7);
						array_push($idOperativo, $request->input('centinelaCortejo'));
						array_push($movimiento, 'Centinela - Cortejo');
						array_push($tipo_operativo,'Operativo 1');
						array_push($bitacoraAsiganda,$bitacora->bitacora);

					}
				}


				//---------------------------------------------------------------CENTINELA INSTALA---------------------------------------------------------------------------------------------------------------------------------
				if($bitacora->isDirty('id_centinela_instala') &&  $bitacora->id_centinela_instala != null && $bitacora->id_centinela_instala != ""){
					$proveedor = $this->get_proveedor($request->input('centinelaInstala'));
					if($proveedor[0]>0){//significa que es proveedor----Asignar bitacora
						$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',8);

					}
					else{
						$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],8);
						array_push($idOperativo, $request->input('centinelaInstala'));
						array_push($movimiento, 'Centinela - Instalación');
						array_push($tipo_operativo,'operativo 1');
						array_push($bitacoraAsiganda,$bitacora->bitacora);

					}
				}

				//---------------------------------------------------------------CENTINELA TRASLADO---------------------------------------------------------------------------------------------------------------------------------
				if($bitacora->isDirty('id_centinela_traslado') &&  $bitacora->id_centinela_traslado != null && $bitacora->id_centinela_traslado != ""){
					$proveedor = $this->get_proveedor($request->input('centinelaTraslado'));
					if($proveedor[0]>0){//significa que es proveedor----Asignar bitacora
						$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',9);

					}
					else{
						//$this->store_bitacora_driver($bitacora->bitacora,$request->input('centinelaTraslado'),$proveedor[1],'',$request->input('centVehiculoTraslado'),9);
						$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],9);
						array_push($idOperativo, $request->input('centinelaTraslado'));
						array_push($movimiento, 'Centinela - Traslado');
						array_push($tipo_operativo,'operativo 1');
						array_push($bitacoraAsiganda,$bitacora->bitacora);

					}
				}

				$array_cambios = array('id_op' => $idOperativo,
					'movimiento' => $movimiento,
					'tipo_operativo' => $tipo_operativo,
					'bitacora' => $bitacoraAsiganda);

				if (count($array_cambios['id_op']) > 0) {
				//llamar el método 
					$this->getHistoryResources($array_cambios);
				}

			

			//}
			



			if($bitacora->isDirty()){
				/*echo "isDirty";
				if($bitacora->isDirty('acta_defuncion')){
				    echo "single isDirty acta_defuncion";
				}
				if($bitacora->isDirty('proveedor')){
				    echo "single isDirty proveedor";
				    echo " | ";
				    echo $bitacora->acta_defuncion;
				    echo " | ";
				    echo json_encode($bitacora);
				    echo " | ";
				} else {
					echo "not proveedor";
				}

				echo json_encode($bitacora);
				echo "<br>";
				echo json_encode($bitacora->getChanges());
				echo "<br>";
				*/
				/*echo json_encode($bitacora->getDirty());
				echo "<br>";*/
				/*return;*/
				/*echo json_encode($bitacora->getOriginal());
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo json_encode($bitacora->getOriginal('name_dead'));
				echo "<br>";
				echo "<br>";*/

				/*
				SAVE DATA CHANGES HISTORY
				*/
				//if($bitacora->isDirty()){

					//$bitacoraDetailDataChangesHistoryBoolean = false;

					$bitacoraDetailDataChangesHistory = new BitacoraDetailDataChangesHistory();
					$bitacoraDetailDataChangesHistory->bitacora = $bitacora->bitacora;
					$bitacoraDetailDataChangesHistory->id = $bitacora->id;
					$bitacoraDetailDataChangesHistory->id_user = auth()->user()->id;

					$bitacoraToModify = BitacoraDetail::find($id);

					//foreach ($bitacora->getDirty() as $key => $value) {
					foreach ($bitacora->getAttributes() as $key => $value) {
						//$bitacoraDetailDataChangesHistoryBoolean = true;
						//echo "| CHECK - " . $key . "-" . $value .  " |";
						/*if ( $bitacora->isDirty($key) ) {
							//echo "| isDirty |";
						} else {
							//echo "| NOT isDirty |";
						}*/

						if ( $key != "id" && $key != "bitacora" && $key != "id_user" && $key != "created_at" && $key != "updated_at" && $key != "fecha_captura" ) {

							if (  $value != $fieldToUpdate->$key ) {
								//echo "DIFFERENT VALUES = " . $fieldToUpdate->$key;
							

								//$bitacoraDetailDataChangesHistory[$key."_before"] = $bitacora->getOriginal($key);
								$bitacoraDetailDataChangesHistory[$key."_before"] = $fieldToUpdate->$key;
								$bitacoraDetailDataChangesHistory[$key."_after"] = $value;

								/*$bitacoraDetailDataChangesHistory[$key."_before"] = $bitacora->getOriginal($key) != null ? $bitacora->getOriginal($key) : "";
								$bitacoraDetailDataChangesHistory[$key."_after"] = $bitacora[$key] != null ? $bitacora[$key] : "";*/

								/*
								 UPDATE ONLY FIELDS MODIFIED
								*/
								//$bitacoraToModify[$key] = $bitacora[$key];
								 $bitacoraToModify[$key] = $value;
							}

						}

					}

					/*DB::table('bitacora_details_being_updated')
		            ->where('id', $id)
		            ->where('timestamp', $request->input('timestamp_edit'))
		            ->where('user', auth()->user()->name)
		            ->delete();*/
					//if ( $bitacoraDetailDataChangesHistoryBoolean ) {
						$bitacoraDetailDataChangesHistory->save();
					//}

					//return;


					/*
					UPDATE ONLY FIELDS MODIFIED
					*/
					//echo $bitacoraToModify->update($bitacora->getDirty());
					//return;

					$bitacoraToModify->save();

					//return;

					$id_bitacora = $bitacoraToModify->id;
					
					for ($i=0; $i <=3; $i++) { 
						$tipo =$i + 1;
						$address = Address::where('bitacora',$id_bitacora)->where('type',$tipo)->update([
							'calle'=> $calles[$i],
							'entre_calles'=> $entre_calles[$i],
							'colonia'=> $colonias[$i],
							'municipio' =>$localidades[$i]
						 ]);	
					}

				
					for ($i=0; $i <=4; $i++) { 
						$contact = Contactos::where('bitacora',$id_bitacora)->where('type',$i+1)->update([
							'name' => $nombres[$i],
							'telefono' => $telefonos[$i],
							'parentesco' => $parentescos[$i]
						]);
					
					}

					if ( $request->input('newComment') != null ) {
						$comment = new Comments();
						$comment->bitacora = $bitacoraToModify->bitacora;
						$comment->comentario = $request->input('newComment');
						$comment->usuario = auth()->user()->name;
						$comment->fecha_captura = date('Y-m-d H:i:s');

						$comment->save();
					}

					return redirect()->route('bitacora-details.show', $id_bitacora);
				//}

			}
			else{
					for ($i=0; $i <=3; $i++) { 
						$tipo =$i + 1;
						$address = Address::where('bitacora',$id)->where('type',$tipo)->update([
							'calle'=> $calles[$i],
							'entre_calles'=> $entre_calles[$i],
							'colonia'=> $colonias[$i],
							'municipio' =>$localidades[$i]
						 ]);	
					}

				
					for ($i=0; $i <=4; $i++) { 
						$contact = Contactos::where('bitacora',$id)->where('type',$i+1)->update([
							'name' => $nombres[$i],
							'telefono' => $telefonos[$i],
							'parentesco' => $parentescos[$i]
						]);
					
					}

					if ( $request->input('newComment') != null ) {
						$comment = new Comments();
						$comment->bitacora = $bitacora->bitacora;
						$comment->comentario = $request->input('newComment');
						$comment->usuario = auth()->user()->name;
						$comment->fecha_captura = date('Y-m-d H:i:s');

						$comment->save();
					}
					
					return redirect()->route('bitacora-details.show', $id);	
			}

			
			//echo json_encode("Valor de entre vcalles: ".$entre_calle);

			/*return;*/
			
			/*if($bitacora->save()){

				$id_bitacora = $bitacora->id;
			
				for ($i=0; $i <=2; $i++) { 
					$tipo =$i + 1;
					$address = Address::where('bitacora',$id_bitacora)->where('type',$tipo)->update([
						'calle'=> $calles[$i],
						'colonia'=> $colonias[$i],
						'municipio' =>$localidades[$i]
					 ]);	
				}

			
				for ($i=0; $i <=2; $i++) { 
					$contact = Contactos::where('bitacora',$id_bitacora)->where('type',$i+1)->update([
						'name' => $nombres[$i],
						'telefono' => $telefonos[$i],
						'parentesco' => $parentescos[$i]
					]);
				
				}

				if ( $request->input('newComment') != null ) {
					$comment = new Comments();
					$comment->bitacora = $bitacora->bitacora;
					$comment->comentario = $request->input('newComment');
					$comment->usuario = auth()->user()->name;
					$comment->fecha_captura = date('Y-m-d H:i:s');

					$comment->save();
				}

				return redirect()->route('bitacora-details.show', $id_bitacora);


			}*/
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//

		return;
		$affectedRows  = Personal::where('id', '=', $id)->update(array('status'=>'Inactivo'));
		return $affectedRows;

	}

	public function getColonia($id_municipio)
	{
		$div ='<option value=""></option>';

		if($id_municipio != "null"){
			$colonias = Colonia::where('municipio_id','=',$id_municipio)->orderBy('name')->get();
			//echo json_encode($colonias);


			foreach($colonias as $colonia){
	            $div .= ' <option value="'.$colonia->name.'">'.$colonia->name.'</option>';
	        }
		}
		
        return $div;
	}

	public function busqueda(Request $request)
	{
		

		if($request->get('query'))
		     {
			      $query = $request->get('query');
			      $data = BitacoraDetail::where('name_dead','LIKE',"%{$query}%")->get();	

			      $output = '<ul class="list-group" style="display:block; position:relative">';
			      	if($data->count()){
			      			foreach($data as $row)
						      {
							       $output .= '
							       <li class="list-group-item"><a href="#">'.$row->name_dead.'</a></li>';
						      }

						$output .= '</ul>';
			      		echo $output;
			      	}

			      	else{
			      		$output .= '<li class="list-group-item"><a href="#">NO SE ENCONTRARON RESULTADOS</a></li> </ul>';
			      		 echo $output;
			      	}

			      	
			     
			      	


		     }

		   
		   

    
    }
	




	public function getColonia1($id,$id_municipio)
	{
		$div ='<option value=""></option>';

		if($id_municipio != "null"){
			$colonias = Colonia::where('municipio_id','=',$id_municipio)->orderBy('name')->get();

			foreach($colonias as $colonia){
	            $div .= ' <option value="'.$colonia->name.'">'.$colonia->name.'</option>';
	        }
		}
		
        return $div;
	}

	public 	function getNewBitacora(){
		date_default_timezone_set('America/Mexico_City');
		$abrev ="";
		$pre_bitacora="";
		$anio = substr( date("Y"),2,2);
		$no_mes = date("n");
		//$no_mes = 6;
		//$anio = 30;
		$no_bitacora = "";
		$conf = AppConfig::find(1);

		switch ($no_mes) {
		    case 1:
		        $abrev="ENE";
		        break;
		    case 2:
		        $abrev ="FEB";
		        break;
		    case 3:
		        $abrev = "MAR";
		        break;
		    case 4:
		        $abrev = "ABR";
		        break;
		    case 5:
		        $abrev = "MAY";
		        break;
		    case 6:
		        $abrev = "JUN";
		        break;
		    case 7:
		        $abrev = "JUL";
		        break;
		    case 8:
		        $abrev = "AGO";
		        break;
		    case 9:
		        $abrev = "SEP";
		        break;
		    case 10:
		        $abrev = "OCT";
		        break;
		    case 11:
		        $abrev = "NOV";
		        break;
		    case 12:
		        $abrev = "DIC";
		        break;
			}

		$condicion =$conf->plaza.$anio.$abrev;

		if ( auth()->user()->name == 'PRUEBAS' ) {
			$condicion = 'GDL30JUN';
		}

		$bitacora = BitacoraDetail::where('bitacora','like',$condicion.'%')->orderByRaw('cast(substring(bitacora,9) as unsigned) desc')->first();

		if($bitacora != null){
			$pre_bitacora = substr($bitacora->bitacora, 8) + 1 ;

			if(strlen($pre_bitacora) < 3 ){
				$no_bitacora = str_pad($pre_bitacora, 3, "0", STR_PAD_LEFT); 
				echo $no_bitacora;
			}
			else{
				$no_bitacora = $pre_bitacora;
			}
		}
		else{
			$no_bitacora = $conf->default_bitacora;
		}
		

		$bitActual = $condicion.$no_bitacora;

		return $bitActual;
	}

		public function destroy_pay($id)
	{
		//

		
		$pago = Pagos::find($id);
		$pago->status = 'Inactivo';
		$pago->user_delete = auth()->user()->name;
		if ($pago->save()) {
			$msg = [
				        'message' => 'true',
				       ];
			return redirect()->route('bitacora-details.show', $pago->bitacora)->with($msg);
		}
		
	}

	public function getNextBitacora(Request $request, $id)
	{
		$bita = BitacoraDetail::find($id);
		$bit = $bita->bitacora;
		$serie_bitacora_ant = substr( $bit,0,8);
		$mes = substr($bit,5,3);
		$anio = substr($bit,3,2);
		$no_bitacora_ant = substr($bit,8,4);
		$next_no_bitacora =  str_pad($no_bitacora_ant + 1, 3, "0", STR_PAD_LEFT);
		$bit_busca = $serie_bitacora_ant.$next_no_bitacora;
		$bitacora_actual = BitacoraDetail::where('bitacora','=',$bit_busca)->first();
		$id_bitacora = $bitacora_actual;
		
			
		
		if($bitacora_actual != null)
		{
			
					return redirect()->route('bitacora-details.show', $bitacora_actual->id);
		}

		else{//buscar si hay cambio de mes
				switch ($mes) {
				    case "ENE":
				        $abrev="FEB";
				        break;
				    case "FEB":
				        $abrev ="MAR";
				        break;
				    case "MAR":
				        $abrev = "ABR";
				        break;
				    case "ABR":
				        $abrev = "MAY";
				        break;
				    case "MAY":
				        $abrev = "JUN";
				        break;
				    case "JUN":
				        $abrev = "JUL";
				        break;
				    case "JUL":
				        $abrev = "AGO";
				        break;
				    case "AGO":
				        $abrev = "SEP";
				        break;
				    case "SEP":
				        $abrev = "OCT";
				        break;
				    case "OCT":
				        $abrev = "NOV";
				        break;
				    case "NOV":
				        $abrev = "DIC";
				        break;
				    case "DIC":
				        $abrev = "ENE";
				        $anio = $anio + 1;
				        break;
					}
				$conf = AppConfig::find(1);
				$serie = $conf->plaza.$anio.$abrev.'001';
				$bitacora_next = BitacoraDetail::where('bitacora','=',$serie)->first();
				if ($bitacora_next != null) {
					return redirect()->route('bitacora-details.show', $bitacora_next->id);
				}
				//return redirect()->route('bitacora-details.show', $id);
				else{
					return redirect()->route('bitacora-details.show', $id);
				}
		}

	}

	   public function store_bitacora_supplier($bitacora,$supplierID,$supplierName,$supplierID2,$vehicle,$evento)
    {
        $supplierBitacora = new SupplierBitacora();
		$supplierBitacora->bitacora = $bitacora; //Input::get('bitacora');
        $supplierBitacora->supplier_id = $supplierID;
        $supplierBitacora->status = "Pendiente";
        if($supplierBitacora->save()){

            $this->sendPushNotification_proveedor( '', $bitacora, $supplierName,'',$evento);
        }
    }

    public function store_bitacora_driver($bitacora,$supplierID,$supplierName,$supplierID2,$vehicle,$evento)
    {
        $supplierBitacora = new SupplierBitacora();
		$supplierBitacora->bitacora = $bitacora; 
        $supplierBitacora->driver_id = $supplierID;
        $supplierBitacora->type = $evento;
        $supplierBitacora->driver_id2 = $supplierID2;
        $supplierBitacora->id_vehicle = $vehicle;
        $supplierBitacora->status = "Pendiente";
        if($supplierBitacora->save()){
			$this->sendPushNotification_proveedor('', $bitacora,"",$supplierName,$evento);
        }
    }

    public function get_proveedor($id){
        $driver = Driver::find($id);

        if($driver->tipo_empleado == "PROVEEDOR"){
            $proveedor = Supplier::select('id','name')->where('name','LIKE','%'.$driver->name.'%')->first();  
            $id_proveedor = $proveedor->id;
            $name = $proveedor->name;

        }
        else{
            $id_proveedor  = 0;
            $name = $driver->name;
        }
       
        return  array($id_proveedor,$name);

    }

    public function get_gestor($name){

            $proveedor = Driver::select('id','name')->where('name','LIKE','%'.$name.'%')->where('status','=','Activo')->first();  
            if ($proveedor != null) {
            	$id_proveedor = $proveedor->id;
            	$name = $proveedor->name;
            }
            else{
            	$id_proveedor = null;
            	$name = null;
            }
            

        return  array($id_proveedor,$name);

    }


 private function sendPushNotification_proveedor( $details = "", $bitacora = "", $supplier = "", $driver = "",$evento = "", $title = "BITACORA ASIGNADA", $message = "Se te asignó una bitácora para su servicio.", $topic = "", $isGeneral = false, $clickAction = "SPLASH_SCREEN" ) {

        $to = "";
        $error = false;
        $errorMessage = "";

        $token = "";
        $errorMessage = "";

        $message = $message . ". " . $details;

        if ( $isGeneral ) {

            $to = "/topics/all";

        } else if ( $topic != "" ) {

            $to = "/topics/" . $topic;

        } else if ( $supplier != ""  ) {

            $userToken = UserToken::where('usuario', '=', $supplier)->get();
            if ( count( $userToken ) > 0  ) {

                foreach ($userToken as $singleToken) {
                    $token = $singleToken->token;
                    $to = $token;

                    $notification = new Notification();
                    $notification->title = $bitacora . " - " . $title;
                    $notification->message = $message.$evento;
                    $notification->to = $to;
                    $notification->token = $token;
                    $notification->tema = $topic;
                    $notification->general = $isGeneral;
                    $notification->extra_data = json_encode( array( 'bitacora' => $bitacora ) );
                    $notification->click_action = json_encode( array( 'click_action' => $clickAction ) );;
                    $notification->error = $error;
                    $notification->error_message = $errorMessage;

                    if($notification->save()){

                        //echo "NOTIFICATION SAVED";

                        $config = AppConfig::get();


                        //echo json_encode($config);

                        $config = $config[0];

                         ////////Azael Jimenez 2021/02/11 /////////
                        //$token = 'cE9F37hEQce4ntLBAI7Rim:APA91bFNjIVmnXvjusPymheb22MRxJYK0H7i0L6B0Evnjq69aQNg7bT_dT87UbyI-_amDhpd0BPG15M84Z-rsnOdHRK-FFkXWqugueFTdS9T-tyu3H-i63a89p89fVHCuJboRuIq64E6';
                        $notification = [
                            'bitacora' => $bitacora, 
                            'title' => $bitacora . " - " . $title, 
                            'body' => $message, 
                            'icon' => $config->fcm_icon, 
                            'sound' => $config->fcm_sound,
                            'click_action' => $clickAction
                        ];

                        $extraNotificationData = [
                            "message" => $notification, 
                            "moredata" => $config->fcm_moredata
                        ];

                        $fcmNotification = [
                            'to' => $to, 
                            'notification' => $notification, 
                            'data' => $extraNotificationData
                        ];

                        $headers = [
                            'Authorization: key=' . $config->fcm_apiKey, 
                            'Content-Type: application/json'
                        ];

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $config->fcm_url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
                        $result = curl_exec($ch);
                        curl_close($ch);
                       
                        
                        //return;
                    }
                }
                //return;

            } else {
                $error = true;
                $errorMessage = "No se encontró el token de usuario";
            }

            //$to = "cE9F37hEQce4ntLBAI7Rim:APA91bFNjIVmnXvjusPymheb22MRxJYK0H7i0L6B0Evnjq69aQNg7bT_dT87UbyI-_amDhpd0BPG15M84Z-rsnOdHRK-FFkXWqugueFTdS9T-tyu3H-i63a89p89fVHCuJboRuIq64E6";
        }

        else if ( $driver != "" ) {

            $userToken = UserToken::where('usuario', '=',  $driver)->get();
            if ( count( $userToken ) > 0  ) {

                foreach ($userToken as $singleToken) {
                    $token = $singleToken->token;
                    $to = $token;

                    $notification = new Notification();
                    $notification->title = $bitacora . " - " . $title;
                    $notification->message = $message.$evento;
                    $notification->to = $to;
                    $notification->token = $token;
                    $notification->tema = $topic;
                    $notification->general = $isGeneral;
                    $notification->extra_data = json_encode( array( 'bitacora' => $bitacora ) );
                    $notification->click_action = json_encode( array( 'click_action' => $clickAction ) );;
                    $notification->error = $error;
                    $notification->error_message = $errorMessage;

                    if($notification->save()){

                        //echo "NOTIFICATION SAVED";

                        $config = AppConfig::get();
                        
                        $sql = "
                       SELECT
                                b.bitacora AS 'bitacora', IFNULL(c1.name, '') AS 'secondName',
                                 concat(dir.calle, ', ', ifnull(dir.entre_calles,''),', ',IFNULL(dir.colonia,''),', ',IFNULL(dir.municipio,'')) address,
                                IFNULL(c1.telefono,'') telefono,
                                ifnull(d1.name, '') as 'chofer',
                                ifnull(d2.name, '') as 'ayudante',
                                ifnull(v.name ,'') as 'vehiculo',
                                'Bunker' as 'salida',
                                '' as 'destino',
                                '' as 'destino_domicilio',
                                ''as 'destino_latitud',
                                '' as 'destino_longitud',
                                IFNULL(p.name,'') panteon,
                                b.tipo_servicio,
                                '' ataud,
                                IFNULL(b.hora_velacion, '') as 'inicio_velacion',
                                IFNULL(b.hora_cortejo, '') as 'inicio_cortejo',
                                IFNULL(b.id_templo, '') as 'templo',
                                ifnull(ba.type,'') type
                            FROM
                            bitacora_details b
                            inner join bitacoras_asignadas ba on b.bitacora = ba.bitacora
                            LEFT JOIN drivers d1 ON ba.driver_id = d1.id
                            LEFT JOIN drivers d2 ON ba.driver_id2= d2.id
                            LEFT JOIN vehicles v ON ba.id_vehicle = v.id
                            #LEFT JOIN places p ON b.id_place_destination = p.id
                            left join contactos c1 on c1.bitacora = b.id
                            left join address dir on dir.bitacora = b.id
                            left join panteon p on p.id = b.panteon
                            left join ataud a on a.id = b.ataud
                            where c1.type = 4 and dir.type = 3 and b.bitacora = '".$bitacora."' and ba.type = '".$evento."'
                            order by b.id desc
                            limit 1;
                    ";
                    //$bitacoraAsignada = DB::select($sql);

                        //echo json_encode($config);

                        $config = $config[0];

                        /*$valores_bitacora =[
                            'bitacora' => $bitacoraAsignada[0]->bitacora,
                            'secondName' => $bitacoraAsignada[0]->secondName,
                            'address' => $bitacoraAsignada[0]->address,
                            'telefono'=>$bitacoraAsignada[0]->telefono,
                            'chofer'=>$bitacoraAsignada[0]->chofer,
                            'ayudante'=>$bitacoraAsignada[0]->ayudante,
                            'vehiculo'=>$bitacoraAsignada[0]->vehiculo,
                            'salida'=>$bitacoraAsignada[0]->salida,
                            'destino'=>$bitacoraAsignada[0]->destino,
                            'destino_latitud'=>$bitacoraAsignada[0]->destino_latitud,
                            'destino_longitud'=>$bitacoraAsignada[0]->destino_longitud,
                            'panteon'=>$bitacoraAsignada[0]->panteon,
                            'tipo_servicio'=>$bitacoraAsignada[0]->tipo_servicio,
                            'ataud'=>$bitacoraAsignada[0]->ataud,
                            'inicio_velacion'=>$bitacoraAsignada[0]->inicio_velacion,
                            'inicio_cortejo'=>$bitacoraAsignada[0]->inicio_cortejo,
                            'templo'=>$bitacoraAsignada[0]->templo,
                            'type'=>$bitacoraAsignada[0]->type
                        ];*/
                         ////////Azael Jimenez 2021/02/11 /////////
                        //$token = 'cE9F37hEQce4ntLBAI7Rim:APA91bFNjIVmnXvjusPymheb22MRxJYK0H7i0L6B0Evnjq69aQNg7bT_dT87UbyI-_amDhpd0BPG15M84Z-rsnOdHRK-FFkXWqugueFTdS9T-tyu3H-i63a89p89fVHCuJboRuIq64E6';
                        $notification = [
                            'bitacora' => $bitacora, 
                            'title' => $bitacora . " - " . $title, 
                            'body' => $message, 
                            'icon' => $config->fcm_icon, 
                            'sound' => $config->fcm_sound,
                            'click_action' => $clickAction
                        ];

                        $extraNotificationData = [
                            "message" => $notification, 
                            "moredata" => $config->fcm_moredata
                        ];

                        $fcmNotification = [
                            'to' => $to, 
                            'notification' => $notification, 
                            'data' => $extraNotificationData
                        ];

                        $headers = [
                            'Authorization: key=' . $config->fcm_apiKey, 
                            'Content-Type: application/json'
                        ];

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $config->fcm_url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
                        $result = curl_exec($ch);
                        curl_close($ch);

                        //echo json_encode( $result );
                        
                        //return;
                    }
                }
                //return;

            } else {
                $error = true;
                $errorMessage = "No se encontró el token de usuario";
            }

            //$to = "cE9F37hEQce4ntLBAI7Rim:APA91bFNjIVmnXvjusPymheb22MRxJYK0H7i0L6B0Evnjq69aQNg7bT_dT87UbyI-_amDhpd0BPG15M84Z-rsnOdHRK-FFkXWqugueFTdS9T-tyu3H-i63a89p89fVHCuJboRuIq64E6";
        }

        

        $notification = new Notification();
        $notification->title = $bitacora . " - " . $title;
        $notification->message = $message;
        $notification->to = $to;
        $notification->token = $token;
        $notification->tema = $topic;
        $notification->general = $isGeneral;
        $notification->extra_data = json_encode( array( 'bitacora' => $bitacora ) );
        $notification->click_action = json_encode( array( 'click_action' => $clickAction ) );;
        $notification->error = $error;
        $notification->error_message = $errorMessage;

        if($notification->save()){

            //echo "NOTIFICATION SAVED";

            $config = AppConfig::get();


            //echo json_encode($config);

            $config = $config[0];

             ////////Azael Jimenez 2021/02/11 /////////
            //$token = 'cE9F37hEQce4ntLBAI7Rim:APA91bFNjIVmnXvjusPymheb22MRxJYK0H7i0L6B0Evnjq69aQNg7bT_dT87UbyI-_amDhpd0BPG15M84Z-rsnOdHRK-FFkXWqugueFTdS9T-tyu3H-i63a89p89fVHCuJboRuIq64E6';
            $notification = [
                'bitacora' => $bitacora, 
                'title' => $bitacora . " - " . $title, 
                'body' => $message, 
                'icon' => $config->fcm_icon, 
                'sound' => $config->fcm_sound,
                'click_action' => $clickAction
            ];

            $extraNotificationData = [
                "message" => $notification, 
                "moredata" => $config->fcm_moredata
            ];

            $fcmNotification = [
                'to' => $to, 
                'notification' => $notification, 
                'data' => $extraNotificationData
            ];

            $headers = [
                'Authorization: key=' . $config->fcm_apiKey, 
                'Content-Type: application/json'
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $config->fcm_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($ch);
            curl_close($ch);

            //echo json_encode( $result );
            
        }

        //return;

        
    }

    public function show_payments(Request $request)//Metdodo para obtener los pagos de la bitacora en base al id de la bitacora
    {
            $id_bit = $request->get('bitacora');
             $data = Pagos::where('bitacora','=',$id_bit)->where('status','=','Activo')->get();  
             //return response()->json(['errorseeee'=>$id_bit]); 

                  $output = '<table class="table table-hover" id="tabla_pagos2"><thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>Concepto</th>
                                    <th>Acciones</th>
                                 </tr>
                                </thead>
                                <tbody>';
                    if($data->count()){
                            foreach($data as $row)
                              {
                                $output.='<tr>';
                                $output.='<td>'.$row->id.'</td>';
                                $output.='<td>'.$row->fecha_pago.'</td>';
                                $output.='<td>'.$row->monto.'</td>';
                                $output.='<td>'.$row->Concepto->name.'</td>';
                                $output.='<td>';
                                $output.='<button type="button" class="btn btn-info open_modal" data-toggle="modal" data-target="#editPay" value='."$row->id".' ><i class="fa fa-edit"></i>Editar</button>';
                                $output.='<form method="" action="" style="display:inline-table">';
                                $output.='<button class="btn btn-danger esc_modal" type="button" data-toggle="tooltip" data-placement="bottom" value='."$row->id".' title="Eliminar bitácora"><i class="fa fa-remove"></i> Eliminar</button>';        
                                $output.= '</form></td></tr>';
                              }

                        $output .= '</tbody></table>';
                        $output .= '<a id="printConvenio1" class="btn btn-app" data-toggle="tooltip" data-placement="bottom" title="Imprimir CGS"><i class="fa fa-file-text"></i> Imprimir Convenio</a>';
                        echo $output;
                    }

                    else{
                        $output .= '<a id="printConveni1" class="btn btn-app" data-toggle="tooltip" data-placement="bottom" title="Imprimir CGS"><i class="fa fa-file-text"></i> Imprimir Convenio</a>';
                        $output .= '</tbody></table>';
                         echo $output;
                    }
}

public function destroy_payment(Request $request) // Método para eliminar pagos del convenio
    {
        //

        $id = $request->get('id');
        $bitacora = $request->get('bitacora');
        $pago = Pagos::find($id);
        $pago->status = 'Inactivo';
        $pago->user_delete = auth()->user()->name;
        $pago->save();

        $data = Pagos::where('bitacora','=',$bitacora)->where('status','=','Activo')->get();    

                  $output = '<table class="table table-hover" id="tabla_pagos2"><thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>Concepto</th>
                                    <th>Acciones</th>
                                 </tr>
                                </thead>
                                <tbody>';
                    if($data->count()){
                            foreach($data as $row)
                              {
                                $output.='<tr>';
                                $output.='<td>'.$row->id.'</td>';
                                $output.='<td>'.$row->fecha_pago.'</td>';
                                $output.='<td>'.$row->monto.'</td>';
                                $output.='<td>'.$row->Concepto->name.'</td>';
                                $output.='<td>';
                                $output.='<button type="button" class="btn btn-info open_modal" data-toggle="modal" data-target="#editPay" value='."$row->id".' ><i class="fa fa-edit"></i>Editar</button>';
                                $output.='<form method="" action="" style="display:inline-table">';
                                $output.='<button class="btn btn-danger esc_modal" type="button" data-toggle="tooltip" data-placement="bottom" value='."$row->id".'  title="Eliminar bitácora"><i class="fa fa-remove"></i> Eliminar</button>';        
                                $output.= '</form></td></tr>';
                              }

                        $output .= '</tbody></table>';
                        $output .= '<a id="printConvenio1" class="btn btn-app" data-toggle="tooltip" data-placement="bottom" title="Imprimir CGS"><i class="fa fa-file-text"></i> Imprimir Convenio</a>';
                        echo $output;
                    }

                    else{
                        $output .= '<a id="printConvenio1" class="btn btn-app" data-toggle="tooltip" data-placement="bottom" title="Imprimir CGS"><i class="fa fa-file-text"></i> Imprimir Convenio</a>';
                        $output .= '</tbody></table>';
                         echo $output;
                    }
        
    }

    public function edit_payment(Request $request)
    {
        
        $arrayPay = array('fecha' =>'Fecha de pago' ,
        'monto' =>  'Monto de pago',
        'concepto' => 'Concepto de pago');


        $rules = array('fecha' => 'required',
                        'monto' => 'required',
                        'concepto'=> 'required'
         );

        $messages = array(
            'required' => 'El campo :attribute es requerido' ,
            'Unique' => 'El Número de empleado :attribute ya ha sido registrado',
            'min' => 'Mínimo 10 caracteres'
             );


        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($arrayPay);

        if($validator->fails()){

            return response()->json(['errors'=>$validator->errors()]);
        }

            $id = $request->get('id');

            $pago = Pagos::find($id);
            $pago->fecha_pago = $request->get('fecha');
            $pago->monto = $request->get('monto');
            $pago->concepto_id  = $request->get('concepto');
            $pago->save();

            return response()->json(['success'=>$request->all()]);

    }

      public function store_payment(Request $request)
    {
        
        $arrayPay = array('fecha' =>'Fecha de pago' ,
        'monto' =>  'Monto de pago',
        'concepto' => 'Concepto de pago');


        $rules = array('fecha' => 'required',
                        'monto' => 'required',
                        'concepto'=> 'required'
         );

        $messages = array(
            'required' => 'El campo :attribute es requerido' ,
            'Unique' => 'El Número de empleado :attribute ya ha sido registrado',
            'min' => 'Mínimo 10 caracteres'
             );


        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($arrayPay);

        if($validator->fails()){

            return response()->json(['errors'=>$validator->errors()]);
        }

        
            $pago = new Pagos();
            $pago->bitacora = $request->get('bitacora');
            $pago->fecha_pago = $request->get('fecha');
            $pago->monto = $request->get('monto');
            $pago->concepto_id  = $request->get('concepto');
            $pago->user_create = auth()->user()->name;
            $pago->save();
            return response()->json(['success'=>$request->all()]);
             
}

public function getHistoryResources($campos){

	//return;

		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 12000);
		$startDate = date('Y-m-d'); 
		$endDate = date('Y-m-d');

		$events_first = DB::select("
			SELECT 
				    *
			FROM
			(SELECT 
			s.nombre_chofer,s.nombre_ayudante,s.nombre_vehiculo,s.tipo_movimiento,s.bitacora, s.evento, s.fecha, 'latinoamericana' as 'latino_proveedor'
			FROM
			salidas s
			INNER JOIN personal p ON p.name = s.usuario
							LEFT JOIN vehicles v on v.name = s.nombre_vehiculo
			WHERE
			s.created_at BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'
			AND s.evento IN ('Salida' , 'Terminada')
			AND 1 = IF(s.evento = 'Salida'
			AND id_lugar_destino = 0,
			2,
			1)
			AND p.profile_id IN ('servicios','Gestor')
			AND v.tipo_vehiculo in('CORTEJO/INSTALACION','INSTALACION/RECOLECCION')
			GROUP BY s.nombre_chofer,s.nombre_ayudante
			ORDER BY s.created_at) as dd 

			UNION ALL 
			SELECT 
				    *
			FROM
			( SELECT 
			s.nombre_chofer, s.nombre_ayudante, s.nombre_vehiculo, s.tipo_movimiento, s.bitacora, s.evento, s.fecha, 'proveedor' as 'latino_proveedor'
			FROM
			salidas s
			INNER JOIN supplier p ON p.name = s.usuario
			WHERE
			s.created_at BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'
			AND s.evento IN ('Salida' , 'Terminada')
			AND 1 = IF(evento = 'Salida'
			AND id_lugar_destino = 0,
			2,
			1)
			GROUP BY s.nombre_chofer , s.nombre_ayudante , nombre_vehiculo , s.created_at
			ORDER BY s.created_at) as d2");

		    $timestamp = time();
		    $attendance = array();
    		$data = array();
    if(count($events_first) > 0){
    	$attendance = $this->getAvailableDriversQuantity($startDate, $endDate, $timestamp);
    	Schema::create('events_vehicle_resources_'.$timestamp, function (Blueprint $table) {
		        $table->increments('id_table');
		        $table->string('latino_proveedor')->nullable();
		        $table->string('nombre_vehiculo')->nullable();
		        $table->string('nombre_lugar')->nullable();
		        $table->string('nombre_destino')->nullable();
		        $table->string('tipo_movimiento')->nullable();
		        $table->string('bitacora')->nullable();
		        $table->string('tipo')->nullable();
		        $table->string('nombre_chofer')->nullable();
		        $table->string('nombre_ayudante')->nullable();
		        $table->string('fecha_evento')->nullable();
		        $table->string('evento')->nullable();
		        $table->string('fecha_hour')->nullable();
		       

		        $table->index('latino_proveedor');
		        $table->index('nombre_lugar');
		        $table->index('nombre_destino');
		        $table->index('tipo_movimiento');
		        $table->index('bitacora');
		        $table->index('tipo');
		        $table->index('fecha_evento');
		        $table->index('evento');
		        $table->index('nombre_vehiculo');
		        $table->index('fecha_hour');

		    });
    	$data = array();
    	for ($i=0; $i < count($events_first) ; $i++) { 
    		$startDateQuery = $events_first[$i]->fecha;
				$endDateQuery = $events_first[$i]->fecha;

				$driverName = $events_first[$i]->nombre_chofer;
				$copilotName = $events_first[$i]->nombre_ayudante;

				$latino_proveedor = $events_first[$i]->latino_proveedor;

				$driverLabel = "Chofer";
				$copilotLabel = "Ayudante";
				$groupedRows  = "";
				if ( $driverName == $copilotName ) {
					$driverLabel = "Chofer y Ayudante";
					$copilotLabel = "Chofer y Ayudante";
					$groupedRows  = " group by nombre_chofer, nombre_ayudante, fecha_evento ";
				}

				DB::select("set @row_number = 0;");
				$sqlEventsDataVehicle = "SELECT * from (
				#;
					# CHOFER
				SELECT * FROM
				(
				select
				'$latino_proveedor' as 'latino_proveedor',
				salidas_eventos.*,
				hour(fecha_evento) as 'fecha_hour'
				From
				(
				select 
				nombre_vehiculo,
				nombre_lugar,
				nombre_destino,
				tipo_movimiento,
				bitacora,
				'$driverLabel' as 'tipo',
							nombre_chofer, nombre_ayudante, created_at as 'fecha_evento', evento #, salidas.*
							from salidas 
							where 
							created_at between '$startDateQuery 00:00:00' and '$endDateQuery 23:59:59'
							#and evento != 'Terminada'
							and evento in ( 'Salida', 'Terminada')
							and 1 = if (evento = 'Salida' and id_lugar_destino = 0, 2, 1)
							and nombre_chofer = '$driverName' 
							and nombre_ayudante  = '$copilotName'
							order by created_at asc
							#limit 10
							) as salidas_eventos

							) AS chofer
				    #;

							UNION ALL

					# AYUDANTE
							SELECT * FROM
							(
							select
							'$latino_proveedor' as 'latino_proveedor',
							salidas_eventos.*,
							hour(fecha_evento) as 'fecha_hour'
							From
							(
							select  
							nombre_vehiculo,
							nombre_lugar,
							nombre_destino,
							tipo_movimiento,
							bitacora,
							'$copilotLabel' as 'tipo',
							nombre_chofer, nombre_ayudante, created_at as 'fecha_evento', evento #, salidas.*
							from salidas 
							where 
							created_at between '$startDateQuery 00:00:00' and '$endDateQuery 23:59:59'
							#and evento != 'Terminada'
							and evento in ( 'Salida', 'Terminada')
							and 1 = if (evento = 'Salida' and id_lugar_destino = 0, 2, 1)
							and nombre_chofer  = '$driverName' 
							and nombre_ayudante  = '$copilotName' 
							order by created_at asc
							#limit 10
							) as salidas_eventos

							) as ayudante
							) as general_info
							".$groupedRows."
							";

							$EventsDataVehicle =DB::select($sqlEventsDataVehicle);

							if (count($EventsDataVehicle) ) {
								DB::table('events_vehicle_resources_'.$timestamp)->insert( json_decode( json_encode($EventsDataVehicle),true) );
								foreach ($EventsDataVehicle as  $value) {
									array_push($data, $value);
									# code...
								}
								# code...
							}
						}//FOR

		Schema::create('vehicles_date_hours_tmp_'.$timestamp, function (Blueprint $table) {
		        $table->increments('id_table');
		        $table->string('fecha')->nullable();
		        $table->integer('hora')->nullable();

		        $table->index('fecha');
		        $table->index('hora');
		    });
		
		$Variable1 = strtotime($startDate);
		$Variable2 = strtotime($endDate);

		for ($currentDate = $Variable1; $currentDate <= $Variable2; $currentDate += (86400)) {
			                                      
				$Store = date('Y-m-d', $currentDate);
				$store2 = $Store.' 00:00:00';
				$store3 = $Store.' 23:59:00';
				$array[] = $Store;
				/*echo $Store;
				echo "<br>";*/
				
				for ($m=0; $m < 24; $m++) { 
					DB::table('vehicles_date_hours_tmp_'.$timestamp)->insert( [ 'fecha' => $Store, 'hora' => $m ] );
				}
			}

			DB::select("insert into tmp_events_hour_vehicle(vehicle,name,first_event,last_event,event_type)
										SELECT 
										    t1.id,
										    t1.name,
										    IF(ev.created_at IS NULL,
										        '$startDate 00:00:00',
										        IF((SELECT 
										                    MIN(id)
										                FROM
										                    events_vehicle
										                WHERE
										                    vehicle = ev.vehicle) = ev.id,
										            '$startDate 00:00:00',
										            ev.created_at)) first_event,
										    (SELECT 
										            IF(ev.last_event IS NOT NULL,
										                    (SELECT 
										                            created_at
										                        FROM
										                            events_vehicle
										                        WHERE
										                            id = ev.last_event),
										                    '$endDate 23:59:59')
										        ) next_event,
										    CASE
										        WHEN ev.event_type IS NULL THEN IF(t1.status = 'Activo', 1, 2)
										        ELSE ev.event_type
										    END AS event_type
										FROM
										    vehicles t1
										        LEFT JOIN
										    events_vehicle ev ON t1.id = ev.vehicle
										  
										WHERE
										    t1.baja = 0 and t1.tipo_vehiculo in('CORTEJO/INSTALACION','INSTALACION/RECOLECCION')
										ORDER BY t1.name , event_type;");

			for ($i=0; $i <count($campos['id_op']) ; $i++) { 
				$bit= $campos['bitacora'][$i];
				$op= $campos['id_op'][$i];
				$mov= $campos['movimiento'][$i];
				$to= $campos['tipo_operativo'][$i];

				$dataGrouped = DB::SELECT(" insert into history_available_resources(bitacora,operativo,movimiento,tipo_chofer,fecha,hora,vehiculos_disponibles,personal_disponible)
								SELECT 
												'$bit' bitacora,
												'$op' operativo,
												'$mov' movimiento,
												'$to' empleado,
											    t2.fecha,
											    t2.hora,
											    #ifnull(cuenta_vehiculo.suma_cuenta_vehiculo,0) utilizados,
											    ifnull(disp.disponibles,0) - ifnull(t3.no_disponibles,0) - ifnull(cuenta_vehiculo.suma_cuenta_vehiculo,0) as 'disponibles',
											   	#ifnull(t3.no_disponibles,0) as no_disponibles,
											   	count(t1.usuario) as 'suma_disponibles'
											FROM
											vehicles_date_hours_tmp_".$timestamp." t2
											#left join tmp_events_vehicle s 
											#on t2.fecha = s.fecha and t2.hora = s.hora 
											LEFT JOIN 
											(SELECT 
												    eh.fecha, eh.hora, case  when eh.fecha = current_date and eh.hora > hour(current_timestamp()) then 0
		                                            else COUNT(DISTINCT ev.name) end as disponibles
												FROM
												    tmp_events_hour_vehicle ev
												        LEFT JOIN
												    vehicles_date_hours_tmp_".$timestamp." eh ON eh.fecha BETWEEN DATE(ev.first_event) AND DATE(ev.last_event)
												    where ev.event_type = 1
												GROUP BY eh.fecha , eh.hora
											) disp on disp.fecha = t2.fecha and disp.hora = t2.hora
											left join
												(
													#SUMA CUENTA VEHICULO GRUPADO POR TIPO_MOVIMIENTO
													select t1.*, sum(total) as 'suma_cuenta_vehiculo'
													from 
													(
													select
															fecha_evento, fecha_hour, count(distinct nombre_vehiculo) as 'total'
														from events_vehicle_resources_".$timestamp."
														group by date(fecha_evento), fecha_hour, nombre_vehiculo, tipo_movimiento
													) as t1
													group by date(fecha_evento), fecha_hour, total
													) as cuenta_vehiculo on t2.fecha = date(cuenta_vehiculo.fecha_evento) and t2.hora = cuenta_vehiculo.fecha_hour
											LEFT JOIN 
											(SELECT 
												    eh.fecha, eh.hora,case when eh.fecha = current_date and eh.hora > hour(current_timestamp()) then 0 
												    	else COUNT(DISTINCT ev.name) end as no_disponibles
												FROM
												    tmp_events_hour_vehicle ev
												        LEFT JOIN
												    vehicles_date_hours_tmp_".$timestamp." eh ON eh.fecha BETWEEN DATE(ev.first_event) AND DATE(ev.last_event)
												    where ev.event_type = 2
												GROUP BY eh.fecha , eh.hora
											) t3 on t3.fecha = t2.fecha and t3.hora = t2.hora
											left join
											(
												select a.*, h.horas_laborables from login_tmp_".$timestamp." a 
												left join horarios h on a.horario_seleccionado = h.horario
											) as t1 on
														( 
															(t1.horario_seleccionado in ('07:00 - 19:00 hrs', '08:00 - 19:00 hrs','09:00 - 19:00 hrs', '19:00 - 07:00 hrs', '19:00 - 09:00 hrs') and date(t1.Inicio) = t2.fecha )
								                            or
								                            (t1.horario_seleccionado in ('19:00 - 07:00 hrs', '19:00 - 09:00 hrs') and date(t1.Inicio) = DATE_ADD( t2.fecha, INTERVAL -1 DAY ) )
														)
								                        and 1 =
															(
															case
																when 
																(
																	case
																		when t1.horario_seleccionado in ('19:00 - 07:00 hrs') and date(t1.Inicio) = DATE_ADD( t2.fecha, INTERVAL -1 DAY ) then '|0|1|2|3|4|5|6|'
								                                        when t1.horario_seleccionado in ('19:00 - 09:00 hrs') and date(t1.Inicio) = DATE_ADD( t2.fecha, INTERVAL -1 DAY ) then '|0|1|2|3|4|5|6|7|8|'
																		when t1.horario_seleccionado in ('19:00 - 07:00 hrs', '19:00 - 09:00 hrs') and t2.fecha = date(t1.Inicio) then '|19|20|21|22|23|'
																		when t1.horario_seleccionado in ('07:00 - 19:00 hrs', '08:00 - 19:00 hrs','09:00 - 19:00 hrs') then t1.horas_laborables
																		else ''
																	end
																)
																like CONCAT('%|', t2.hora, '|%') then 1
																else 0
																end
															)


											   
											where t2.hora = hour(current_timestamp())
											GROUP BY t2.fecha , t2.hora;");	
			}
			

					}//IF
		Schema::dropIfExists('vehicles_date_hours_tmp_'.$timestamp);
		Schema::dropIfExists('events_vehicle_resources_'.$timestamp);
		Schema::dropIfExists('login_tmp_'.$timestamp);

}

	public function getAvailableDriversQuantity($startDate,$endDate,$timestamp){

		$personal = "";

		$personal = DB::select("SELECT l.user from personal p inner join login l on concat(p.name, ' ', p.first_last_name, ' ', p.second_last_name) = l.user where p.profile_id in ('SERVICIOS','GESTOR') group by l.user order by l.user asc;");

		if ( count($personal) > 0 ) {

			//$timestamp = time();

			// CREATES NEW TEMP TABLE TO STORE DATA
			Schema::create('login_tmp_'.$timestamp, function (Blueprint $table) {
		        $table->increments('id_table');
		        $table->string('row_number')->nullable()->default('');
		        $table->string('usuario')->nullable()->default('');
		        $table->string('id')->nullable()->default('');
		        $table->string('fecha')->nullable()->default('');
		        $table->string('Inicio')->nullable()->default('');
		        $table->string('entrada_geoFence')->nullable()->default('');
		        $table->string('Salida1')->nullable()->default('');
		        $table->string('Tiempo')->nullable()->default('');
		        $table->string('horario_seleccionado')->nullable()->default('');
		        $table->string('salida_geoFence')->nullable()->default('');

		        $table->index('usuario');
		        $table->index('fecha');
		        $table->index('Inicio');
		        $table->index('Salida1');
		        $table->index('horario_seleccionado');
		    });

			$data = array();

			for ($i=0; $i < count($personal) ; $i++) { 

				DB::select("set @row_number = 0;");

				//Query para obtener la asistencia del personal por fechas
				$sqlAsistencia = "
				SELECT
				*
				FROM (
					# TURNO DE NOCHE
					SELECT
						@row_number:=@row_number+1 AS row_number,
						t1.* 
					from
					(
						SELECT 
							log.user as 'usuario',
							log.id,
							DATE(log.fecha) fecha,
							e.entrada AS Inicio,
							e.entrada_geoFence,
							CASE
								WHEN s.salida > e.entrada THEN s.salida
								ELSE 
								(
									SELECT 
										MIN(lg.fecha)
									FROM
										login lg
									WHERE
										DATE(lg.fecha) = DATE_ADD( DATE( log.fecha ), INTERVAL 1 DAY )
										AND lg.user = log.user
										AND lg.type = 4
								)
							END as Salida1,
							CASE
								WHEN Salida < e.entrada THEN (
															SELECT 
																IFNULL( 
																	TIMEDIFF( 
																		ifnull( 
																			convert( Salida1, datetime ), 
																			now() 
																		), e.entrada 
																	), 
																'00:00:00' )
															)
								ELSE (
									SELECT 
										IFNULL(
											SEC_TO_TIME(
												TIMESTAMPDIFF(
													SECOND, e.entrada,Salida1 
												)
											), 
										'00:00:00')
									)
							END Tiempo,
							ifnull(e.horario_seleccionado,'Sin horario') as 'horario_seleccionado',
							s.salida_geoFence
						FROM login log
						left JOIN
						(
							select 
								ai.entrada, ai.usuario, a_inner.horario_seleccionado, a_inner.CurrentGeoFence as 'entrada_geoFence'
							from 
								login a_inner 
								inner join 
								(
									SELECT
										MIN(fecha) entrada, user usuario, horario_seleccionado
									FROM
										login l
									WHERE
										l.fecha BETWEEN '$startDate 00:00:00' and '$endDate 23:59:59'
										and l.user = '".$personal[$i]->user."'
										AND l.type in(3)
										and l.horario_seleccionado in ('07:00 - 19:00 hrs','08:00 - 19:00 hrs','09:00 - 19:00 hrs')
									GROUP BY 
										DATE(l.fecha) , l.user
								) as ai on a_inner.fecha = ai.entrada
						) AS e ON e.usuario = log.user and e.entrada = log.fecha
						left JOIN
						(
							select 
								bi.salida, bi.usuario, a_inner.horario_seleccionado, a_inner.CurrentGeoFence as 'salida_geoFence'
							from 
								login a_inner 
								inner join 
								(
									SELECT 
										MAX(fecha) salida, user usuario
									FROM
										login l
									WHERE
										l.fecha BETWEEN '$startDate 00:00:00' and '$endDate 23:59:59'
										and l.user = '".$personal[$i]->user."'
										AND l.type in(4)
										#and l.horario_seleccionado in ('07:00 - 19:00 hrs','08:00 - 19:00 hrs','09:00 - 19:00 hrs')
									GROUP BY 
									DATE(l.fecha) , l.user,l.type
								) as bi on a_inner.fecha = bi.salida
						) AS s ON s.usuario = log.user and date(s.salida) = date(log.fecha)
						WHERE
							log.fecha BETWEEN '$startDate 00:00:00' and '$endDate 23:59:59'
							AND log.fecha = e.entrada
							and log.user = '".$personal[$i]->user."'
							and log.horario_seleccionado in ('07:00 - 19:00 hrs','08:00 - 19:00 hrs','09:00 - 19:00 hrs')
						ORDER BY 
							log.user ASC , fecha ASC
					) as t1
					#where 
						#Salida1 is not null
					group by 
						fecha
					#ORDER BY 
						#fecha asc
						
					UNION ALL

					# TURNO DE DÍA
					SELECT
						@row_number:=@row_number+1 AS row_number,
						t1.* 
					from
					(
						SELECT 
							log.user as 'usuario',
							log.id,
							DATE(log.fecha) fecha,
							e.entrada AS Inicio,
				            e.entrada_geoFence,
							(
								SELECT 
									MIN(lg.fecha)
								FROM
									login lg
								WHERE
									DATE(lg.fecha) = DATE_ADD( DATE( log.fecha ), INTERVAL 1 DAY )
									AND lg.user = log.user
									AND lg.type = 4
							) as 'Salida1',
							(
								SELECT 
								IFNULL(
									SEC_TO_TIME(
										TIMESTAMPDIFF(
											SECOND, e.entrada,Salida1 
										)
									), 
								'00:00:00')
							) as 'Tiempo',
				            ifnull(e.horario_seleccionado,'Sin horario') as 'horario_seleccionado',
							'' AS salida_geoFence#s.salida_geoFence
						FROM login log
						inner JOIN
						(
							select 
								ai.entrada, ai.usuario, a_inner.horario_seleccionado, a_inner.CurrentGeoFence as 'entrada_geoFence'
							from 
								login a_inner 
								inner join 
								(
									SELECT
										MIN(fecha) entrada, user usuario, horario_seleccionado
									FROM
										login l
									WHERE
										l.fecha BETWEEN DATE_ADD( '$startDate 00:00:00', INTERVAL -1 DAY ) and '$endDate 23:59:59'
										and l.user = '".$personal[$i]->user."'
										AND l.type in(3)
										and l.horario_seleccionado in ('19:00 - 07:00 hrs','19:00 - 09:00 hrs')
									GROUP BY 
										DATE(l.fecha) , l.user
								) as ai on a_inner.fecha = ai.entrada
						) AS e ON e.usuario = log.user and e.entrada = log.fecha
						/*left JOIN
						(
							select 
								bi.salida, bi.usuario, a_inner.horario_seleccionado, a_inner.CurrentGeoFence as 'salida_geoFence'
							from 
								login a_inner 
								inner join 
								(
									SELECT 
										MIN(fecha) salida, user usuario
									FROM
										login l
									WHERE
										l.fecha BETWEEN '2021-06-01 00:00:00' and '2021-06-13 23:59:59'
										and l.user = 'asdasdasd'
										AND l.type in(4)
										#and l.horario_seleccionado in ('07:00 - 19:00 hrs','08:00 - 19:00 hrs','09:00 - 19:00 hrs')
									GROUP BY 
									DATE(l.fecha) , l.user,l.type
								) as bi on a_inner.fecha = bi.salida
						) AS s ON s.usuario = log.user and s.salida = log.fecha*/
						WHERE
							log.fecha BETWEEN DATE_ADD( '$startDate 00:00:00', INTERVAL -1 DAY ) and '$endDate 23:59:59'
							#AND log.fecha = e.entrada
							and type in (3,4)
							and log.user = '".$personal[$i]->user."'
							#and log.horario_seleccionado in ('07:00 - 19:00 hrs','08:00 - 19:00 hrs','09:00 - 19:00 hrs')
						ORDER BY 
							log.user ASC , fecha ASC
					) as t1
					#where 
						#Salida1 is not null
					group by 
						fecha
				) AS general
				ORDER BY 
					Inicio asc;
				";

				$asistencia = DB::select($sqlAsistencia);

				if ( count( $asistencia ) ) {

					DB::table('login_tmp_'.$timestamp)->insert( json_decode( json_encode($asistencia), true) );

					foreach ($asistencia as $value) {
						array_push($data,$value);
					}
				}
			}

			

			//Schema::dropIfExists('login_tmp_'.$timestamp);


		}

		return $data;

		//return view('layouts.reports.driverAssistance', compact( 'assistance' ));
	}

	public function store_esquela(Request $request){

		$id = $request->get('id');
		

		$fieldToUpdate = DB::table('bitacora_details_being_updated')
		->where('id', $id)
		->where('timestamp', $request->get('timestamp_edit'))
		->where('user', auth()->user()->name)
		->first();
		$bitacora = BitacoraDetail::find($id);
		$bitacora->status_esquela = $request->get('status_esquela'); 
		$bitacora->sucursal_esquelas = $request->get('sucursal_esquelas'); 
		$bitacora->recibe_esquelas = $request->get('recibe_esquelas'); 
		$bitacora->parentesco_rec_esquelas = $request->get('parentesco_rec_esquelas'); 
		$bitacora->supervisor_equelas = $request->get('supervisor_equelas'); 
		$bitacora->foto = $request->get('foto'); 
		$bitacora->cirio = $request->get('cirio');
		$bitacora->fecha_entrega_esquela = $request->get('fecha_entrega_esquela');
		if ( $request->get('comentEsquela') != null ) {
			$comment = new CommentsEsquela();
			$comment->bitacora = $bitacora->bitacora;
			$comment->comentario = $request->get('comentEsquela');
			$comment->usuario = auth()->user()->name;
			$comment->fecha_captura = date('Y-m-d H:i:s');

			$comment->save();
		}

		if($bitacora->isDirty()){
			$bitacoraDetailDataChangesHistory = new BitacoraDetailDataChangesHistory();
			$bitacoraDetailDataChangesHistory->bitacora = $bitacora->bitacora;
			$bitacoraDetailDataChangesHistory->id = $bitacora->id;
			$bitacoraDetailDataChangesHistory->id_user = auth()->user()->id;

			$bitacoraToModify = BitacoraDetail::find($id);
			

			foreach ($bitacora->getAttributes() as $key => $value) {

				if ( $key != "id" && $key != "bitacora" && $key != "id_user" && $key != "created_at" && $key != "updated_at" && $key != "fecha_captura" ) {

					if (  $value != $fieldToUpdate->$key ) {
						$bitacoraDetailDataChangesHistory[$key."_before"] = $fieldToUpdate->$key;
						$bitacoraDetailDataChangesHistory[$key."_after"] = $value;
						$bitacoraToModify[$key] = $value;
					}

				}

			}
			$bitacoraDetailDataChangesHistory->save();
			$bitacoraToModify->save();
			$id_bitacora = $bitacoraToModify->id;
			
			
			return response()->json(['success'=>$request->all()]);

		}

		else{
			return response()->json(['success'=>$request->all()]);
		}

	}

		public function getEstatusBitacora(Request $request){

		$id = $request->get('id');
		$bitacora = BitacoraDetail::find($id);
		$valores = array('PENDIENTE'=>'PENDIENTE', 'ACTIVA'=>'ACTIVA', 'TERMINADO'=>'TERMINADO', 'CANCELADO'=>'CANCELADO');
		$modalConcepto ="";
		$modalConcepto.= '<select class="form-control chosen-select"   data-placeholder="Selecciona..." id="servicio" name="servicio" >';

		foreach ($valores as $key => $val) {
			$modalConcepto.= '<option value="'.$val.'"';
			$modalConcepto.= ($val == $bitacora->status_bitacora)? 'selected':"" ;
			$modalConcepto.='>'.$val.'</option>';
		}
		$modalConcepto.= ' </select>';
		return $modalConcepto;
	}

	public function update_bitacora_estatus(Request $request, $id){


		$arrayBitacora  = array(
			'addCommentCancel' =>'Motivo Cancelación',
		);		

		$rules = array(
			'addCommentCancel' => 'required'
		);

		$messages = array(
			'required' => 'El campo :attribute es requerido' ,
			'Unique' => 'El Número de empleado :attribute ya ha sido registrado',
			'min' => 'Mínimo 10 caracteres'
		);
		$validator = Validator::make($request->all(),$rules,$messages);
		$validator->setAttributeNames($arrayBitacora);


		if($validator->fails()){
			
			$messages = $validator->messages();


			return back()
			->withErrors($messages)
			->withInput($request->all());

		}
		else {
			$fieldToUpdate = DB::table('bitacora_details_being_updated')
			->where('id', $id)
			->where('timestamp', $request->input('timestamp_edit2'))
			->where('user', auth()->user()->name)
			->first();
			$bitacora = BitacoraDetail::find($id);
			$bitacora->status_bitacora ="CANCELADO";
			
			if($request->input('addCommentCancel') != null ){
				$commentCancel = new Comments();
				$commentCancel->bitacora = $bitacora->bitacora;
				$commentCancel->comentario = $request->input('addCommentCancel');
				$commentCancel->usuario = "CANCELADO -"." ".auth()->user()->name;
				$commentCancel->fecha_captura = date('Y-m-d H:i:s'); 
				$commentCancel->save();
			}
			if($bitacora->isDirty()){
				$bitacoraDetailDataChangesHistory = new BitacoraDetailDataChangesHistory();
				$bitacoraDetailDataChangesHistory->bitacora = $bitacora->bitacora;
				$bitacoraDetailDataChangesHistory->id = $bitacora->id;
				$bitacoraDetailDataChangesHistory->id_user = auth()->user()->id;

				$bitacoraToModify = BitacoraDetail::find($id);


				foreach ($bitacora->getAttributes() as $key => $value) {

					if ( $key != "id" && $key != "bitacora" && $key != "id_user" && $key != "created_at" && $key != "updated_at" && $key != "fecha_captura" ) {

						if (  $value != $fieldToUpdate->$key ) {
							$bitacoraDetailDataChangesHistory[$key."_before"] = $fieldToUpdate->$key;
							$bitacoraDetailDataChangesHistory[$key."_after"] = $value;
							$bitacoraToModify[$key] = $value;
						}

					}

				}
				$bitacoraDetailDataChangesHistory->save();
				$bitacoraToModify->save();
				$id_bitacora = $bitacoraToModify->id;

				


			}
			return redirect()->route('bitacora-details.show', $id);	
		}
	}

	public function store_esquela2(Request $request,$id){


		$fieldToUpdate = DB::table('bitacora_details_being_updated')
		->where('id', $id)
		->where('timestamp', $request->input('timestamp_edit1'))
		->where('user', auth()->user()->name)
		->first();
		$bitacora = BitacoraDetail::find($id);
		$bitacora->status_esquela = $request->input('statusEsquela'); 
		$bitacora->sucursal_esquelas = $request->input('sucursalEsquelas'); 
		$bitacora->recibe_esquelas = $request->input('recibeEsquelas'); 
		$bitacora->parentesco_rec_esquelas = $request->input('parentescoEsquelas'); 
		$bitacora->supervisor_equelas = $request->input('supervisor'); 
		$bitacora->foto = $request->input('foto'); 
		$bitacora->cirio = $request->input('cirio');
		$bitacora->fecha_entrega_esquela = $request->input('createDateEsquela');

		if ( $request->input('newCommentEsquelas') != null ) {
			$comment = new CommentsEsquela();
			$comment->bitacora = $bitacora->bitacora;
			$comment->comentario = $request->input('newCommentEsquelas');
			$comment->usuario = auth()->user()->name;
			$comment->fecha_captura = date('Y-m-d H:i:s');

			$comment->save();
		}


		if($bitacora->isDirty()){
			$bitacoraDetailDataChangesHistory = new BitacoraDetailDataChangesHistory();
			$bitacoraDetailDataChangesHistory->bitacora = $bitacora->bitacora;
			$bitacoraDetailDataChangesHistory->id = $bitacora->id;
			$bitacoraDetailDataChangesHistory->id_user = auth()->user()->id;

			$bitacoraToModify = BitacoraDetail::find($id);


			foreach ($bitacora->getAttributes() as $key => $value) {

				if ( $key != "id" && $key != "bitacora" && $key != "id_user" && $key != "created_at" && $key != "updated_at" && $key != "fecha_captura" ) {

					if (  $value != $fieldToUpdate->$key ) {
						$bitacoraDetailDataChangesHistory[$key."_before"] = $fieldToUpdate->$key;
						$bitacoraDetailDataChangesHistory[$key."_after"] = $value;
						$bitacoraToModify[$key] = $value;
					}

				}

			}
			$bitacoraDetailDataChangesHistory->save();
			$bitacoraToModify->save();
			$id_bitacora = $bitacoraToModify->id;


			

		}

		return redirect()->route('bitacora-details.show', $id);	

	}

	public function update2(Request $request)
	{
		Log::channel('edit_bitacora')->info('app.requests', ['request_name' => 'update2', 'user' => auth()->user()->name, 'request' => $request->all()] );
		
		$id = $request->get('id');
		$arrayBitacora  = array(
			//'bitacora' => 'Número Bitacora',
			'finado' =>'Nombre de fallecido',
			'folioCertificado' => 'Folio de certificado',
			'contrato'=>'Número de contrato',
			'titularContrato'=>'Titular del contrato',
			//'agente'=>'Agente',
			//'clienteConfirma'=>'Cliente que confirma',
			//'telefonoCliente'=>'Teléfono del cliente'
		);		


		$rules = array(
						//'bitacora' => 'Unique:bitacora_details,bitacora|min:11',
						'finado' => 'required',
						'createDateBitacora' => 'required'
		 );

		$messages = array(
			'required' => 'El campo :attribute es requerido' ,
			'Unique' => 'El Número de empleado :attribute ya ha sido registrado',
			'min' => 'Mínimo 10 caracteres'
			 );
		$validator = Validator::make($request->all(),$rules,$messages);
		$validator->setAttributeNames($arrayBitacora);


		
			
			

			// START
			// CHECK WHETHER $request->get('servicio') IS EQUAL TO "TERMINADA"
			// IF SO, CHECK THAT $request->get('tipoServicio') IS SET
			if( $request->get('servicio') == "TERMINADO" ) {
				if ( $request->get('tipoServicio') == null ) {
					return back()
					->withErrors(['Para terminar la bitácora se tiene haber agregado si el tipo de servicio si fue INHUMACIÓN, CREMACIÓN, TRASLADO u OTRO'])
					->withInput($request->all());
				}
			}
			// END






			

			$fieldToUpdate = DB::table('bitacora_details_being_updated')
            ->where('id', $id)
            ->where('timestamp', $request->get('timestamp_edit'))
            ->where('user', auth()->user()->name)
            ->first();

			$colonia = $request->get('colonia'); //$_POST['colonia'];
			$localidad = $request->get('municipio'); //$_POST['municipio'];
			$nombre = $request->get('name'); //$_POST['name'];
			$telefono = $request->get('telefono'); //$_POST['telefono'];
			$parentesco = $request->get('parentesco'); //$_POST['parentesco'];
			$calle = $request->get('calle'); //$_POST['calle'];
			$entre_calle = $request->get('entre_calles');
			//Variables para guardar los valores obtenidos del formulario
			
			$nombres=[];
			$telefonos=[];
			$parentescos=[];
			$calles=[];
			$colonias=[];
			$localidades=[];
			$entre_calles=[];
			//Campos de asignacion logistica
			$idOperativo =[];
			$nameOperaticoC=[];
			$movimiento=[];
			$tipo_operativo=[];
			$bitacoraAsiganda =[];

			//campos logistica
			$idOperaticoC =[];
			$bitacoraC=[];
			$tipoOperaticoC=[];
			$movimientoC=[];

			array_push($colonias,$request->get('colonia'));
			array_push($colonias,$request->get('colonia2'));
			array_push($colonias,$request->get('colonia3'));
			array_push($colonias,$request->get('colonia4'));

			array_push($localidades,$request->get('municipio'));
			array_push($localidades,$request->get('municipio2'));
			array_push($localidades,$request->get('municipio3'));
			array_push($localidades,$request->get('municipio4'));

			array_push($nombres,$request->get('name1'));
			array_push($nombres,$request->get('name2'));
			array_push($nombres,$request->get('name3'));
			array_push($nombres,$request->get('name4'));
			array_push($nombres,$request->get('name5'));

			array_push($telefonos,$request->get('telefono1'));
			array_push($telefonos,$request->get('telefono2'));
			array_push($telefonos,$request->get('telefono3'));
			array_push($telefonos,$request->get('telefono4'));
			array_push($telefonos,$request->get('telefono5'));

			array_push($parentescos,$request->get('parentesco1'));
			array_push($parentescos,$request->get('parentesco2'));
			array_push($parentescos,$request->get('parentesco3'));
			array_push($parentescos,$request->get('parentesco4'));
			array_push($parentescos,$request->get('parentesco5'));

			array_push($calles,$request->get('calle1'));
			array_push($calles,$request->get('calle2'));
			array_push($calles,$request->get('calle3'));
			array_push($calles,$request->get('calle4'));

			array_push($entre_calles,$request->get('entre_calles1'));
			array_push($entre_calles,$request->get('entre_calles2'));
			array_push($entre_calles,$request->get('entre_calles3'));
			array_push($entre_calles,$request->get('entre_calles4'));

			
			
			//$comentario_anterior = $request->get('observaciones'); //Input::get('observaciones');
			//$fecha_comentario = date("Y-m-d h:m:s");
			//$comentario = 
			$bitacora = BitacoraDetail::find($id);
			$bitacora->status_bitacora = $request->get('servicio'); //Input::get('finado');
			if ( $request->get('servicio') == 'TERMINADO' ) {
				$bitacora->fecha_terminada = date('Y-m-d H:i:s');
			}
			$bitacora->name_dead = $request->get('finado'); //Input::get('finado');
			//$bitacora->fecha_captura = $request->get('createDateBitacora'); //Input::get('createDateBitacora');
			//$bitacora->hora_captura = $request->get('createHourBitacora'); //Input::get('createHourBitacora');
			$bitacora->llamada = $request->get('llamada'); //Input::get('llamada');
			$bitacora->ataud = $request->get('ataud'); //Input::get('llamada');
			$bitacora->urna = $request->get('urna'); //Input::get('llamada');
			$bitacora->certifica = $request->get('certifica'); //Input::get('certifica');
			//$bitacora->visita_personal = $request->get('Visita'); //Input::get('visita');
			$bitacora->edad_finado = $request->get('edadFinado');
			$bitacora->persona_otorga_datos = $request->get('personaConfirma');
			$bitacora->folio_certificado = $request->get('folioCertificado'); //Input::get('folioCertificado');
			$bitacora->tipo_servicio = $request->get('tipoServicio'); //Input::get('tipoServicio');

			$bitacora->tipo_proceso_proveedor= $request->get('tipo_proceso_proveedor'); //Input::get('dateDead');

			$causaFallecimientoTemp = $request->get('causaFallecimiento');
			if ( is_numeric( $causaFallecimientoTemp ) ) {
				$bitacora->id_causa = $request->get('causaFallecimiento'); //Input::get('causaFallecimiento');
			} else {
				$causaF = new causaFallecimiento();
				$causaF->name = $causaFallecimientoTemp;
				$causaF->save();
				$bitacora->id_causa = $causaF->id;
			}

			$bitacora->cobrador= $request->get('cobrador');
			$bitacora->lugar_fallece= $request->get('place'); //Input::get('place');
			$bitacora->no_contrato= $request->get('contrato'); //Input::get('contrato');
			$bitacora->promotor_nombre= $request->get('promotor_nombre'); //Input::get('contrato');
			$bitacora->name_titular= $request->get('titularContrato'); //Input::get('titularContrato');
			$bitacora->agente_captura= $request->get('agente'); //Input::get('agente');
			$bitacora->confirma_servicio= $request->get('servicioConfirmado'); //Input::get('servicioConfirmado');
			$bitacora->persona_confirma= $request->get('clienteConfirma'); //Input::get('clienteConfirma');
			$bitacora->telefono_cliente= $request->get('telefonoCliente'); //Input::get('telefonoCliente');
			$bitacora->fecha_confirma= $request->get('dateConfirma'); //Input::get('dateConfirma');
			$bitacora->hour_confirma= $request->get('hourConfirma'); //Input::get('hourConfirma');
			$bitacora->observaciones= $request->get('observaciones'); //Input::get('observaciones');
			$bitacora->id_atiende_servicio= $request->get('atiendeServicio'); //Input::get('atiendeServicio');
			$bitacora->id_suc_velacion= $request->get('sucursalVelacion'); //Input::get('sucursalVelacion');
			$bitacora->origen_servicio= $request->get('tipoServicioDetalle'); //Input::get('tipoServicioDetalle');
			$bitacora->tipo_capilla= $request->get('tipoCapilla'); //Input::get('tipoCapilla');
			$bitacora->interplaza = $request->get('interplaza'); //Input::get('interplaza');
			$bitacora->id_interplaza= $request->get('origenInterplaza'); //Input::get('origenInterplaza');
			$bitacora->personas_autorizadas= $request->get('personasAutorizadas'); //Input::get('personasAutorizadas');
			$bitacora->fecha_entrega_cenizas= $request->get('dateEntregaCenizas'); //Input::get('dateEntregaCenizas');
			$bitacora->id_sucursal_cenizas= $request->get('sucursalCenizas'); //Input::get('sucursalCenizas');
			$bitacora->seguro= $request->get('seguro'); //Input::get('seguro');
			$bitacora->fecha_fallecimiento= $request->get('dateDead'); //Input::get('dateDead');
			$bitacora->revisado_administracion= $request->get('revisado_administracion'); //Input::get('dateDead');
			$bitacora->totalServiciosAdicionales= $request->get('totalServiciosAdicionales'); //Input::get('dateDead');
			
			$valuesForAdicionales = "";
			if ( $request->get('ataudCambio') != null && $request->get('ataudCambio') != "" ) {
				$valuesForAdicionales .= "Cambio de ataúd. ";
			}
			if ( $request->get('embalsamado') != null && $request->get('embalsamado') != "" ) {
				$valuesForAdicionales .= "Embalsamado. ";
			}
			if ( $request->get('cremacion') != null && $request->get('cremacion') != "" ) {
				$valuesForAdicionales .= "Cremación. ";
			}
			if ( $request->get('capillaDom') != null && $request->get('capillaDom') != "" ) {
				$valuesForAdicionales .= "Capilla a domicilio. ";
			}
			if ( $request->get('capillaRec') != null && $request->get('capillaRec') != "" ) {
				$valuesForAdicionales .= "Capilla en recinto. ";
			}
			if ( $request->get('cafeteria') != null && $request->get('cafeteria') != "" ) {
				$valuesForAdicionales .= "Cambio de ataúd. ";
			}
			if ( $request->get('traslado') != null && $request->get('traslado') != "" ) {
				$valuesForAdicionales .= "Traslado. ";
			}
			if ( $request->get('tramites') != null && $request->get('tramites') != "" ) {
				$valuesForAdicionales .= "Trámites. ";
			}
			if ( $request->get('camion') != null && $request->get('camion') != "" ) {
				$valuesForAdicionales .= "Camión. ";
			}
			if ( $request->get('certificado') != null && $request->get('certificado') != "" ) {
				$valuesForAdicionales .= "Certificado médico. ";
			}
			if ( $request->get('discos') != null && $request->get('discos') != "" ) {
				$valuesForAdicionales .= "Discos. ";
			}
			if ( $request->get('cantos') != null && $request->get('cantos') != "" ) {
				$valuesForAdicionales .= "Cantos. ";
			}

			//$bitacora->adicionales= $request->get('adicionales'); //Input::get('adicionales');
			$bitacora->adicionales= $valuesForAdicionales;

			/*$bitacora->documento_INE_finado= $request->get('documento_INE_finado') == "on" ? 1 : null;
			$bitacora->documento_acta_nacimiento_finado= $request->get('documento_acta_nacimiento_finado') == "on" ? 1 : null;
			$bitacora->documento_INE_familiar= $request->get('documento_INE_familiar') == "on" ? 1 : null;
			$bitacora->documento_acta_nacimiento_familiar= $request->get('documento_acta_nacimiento_familiar') == "on" ? 1 : null;
			$bitacora->documento_certificado_defuncion= $request->get('documento_certificado_defuncion') == "on" ? 1 : null;
			$bitacora->documento_titulo_propiedad_cementerio= $request->get('documento_titulo_propiedad_cementerio') == "on" ? 1 : null;
			$bitacora->documento_PERMISO_INHUMACION= $request->get('documento_PERMISO_INHUMACION') == "on" ? 1 : null;
			$bitacora->documento_PERMISO_CREMACION= $request->get('documento_PERMISO_CREMACION') == "on" ? 1 : null;
			$bitacora->documento_PERMISO_TRASLADO= $request->get('documento_PERMISO_TRASLADO') == "on" ? 1 : null;*/

			$bitacora->costo_paquete= $request->get('costoPaquete'); //Input::get('costoPaquete');
			$bitacora->saldo_PABS= $request->get('saldoPABS'); //Input::get('saldoPABS');
			$bitacora->costo_ataud= $request->get('ataudCambio'); //Input::get('ataudCambio');
			$bitacora->costo_embalsamado= $request->get('embalsamado'); //Input::get('embalsamado');
			$bitacora->costo_cremacion= $request->get('cremacion'); //Input::get('cremacion');
			$bitacora->costo_capilla_dom= $request->get('capillaDom'); //Input::get('capillaDom');
			$bitacora->costo_capilla_recinto= $request->get('capillaRec'); //Input::get('capillaRec');
			$bitacora->costo_cafeteria= $request->get('cafeteria'); //Input::get('cafeteria');
			$bitacora->costo_traslado= $request->get('traslado'); //Input::get('traslado');
			$bitacora->costo_tramites= $request->get('tramites'); //Input::get('tramites');
			$bitacora->costo_camion= $request->get('camion'); //Input::get('camion');
			$bitacora->costo_certificado= $request->get('certificado'); //Input::get('certificado');
			$bitacora->costo_discos= $request->get('discos');
			
			$bitacora->costo_cantos= $request->get('cantos');
			$bitacora->costo_capilla_elite= $request->get('capillaElite');
			$bitacora->cantidad_discos= $request->get('cantidadDiscos'); //Input::get('otros');

			//$bitacora->costo_otros= $request->get('otros'); //Input::get('otros');
			$bitacora->lugar_velacion= $request->get('lugarVelacion'); //Input::get('lugarVelacion');
			$bitacora->id_capilla= $request->get('nameCapilla'); //Input::get('nameCapilla');
			//$bitacora->fecha_velacion= $request->get('startDateVelacion'); //Input::get('startDateVelacion');
			//$bitacora->hora_velacion= $request->get('starHourVelacion'); //Input::get('starHourVelacion');

			//$bitacora->saldo_convenido= $request->get('saldoConvenido'); //Input::get('saldoConvenido');
			$saldoConvenidoTemp = str_replace(',','',$request->get('saldoConvenido'));
			$bitacora->saldo_convenido= $saldoConvenidoTemp; //Input::get('saldoConvenido');
			
			$bitacora->fecha_inicio_pagos= $request->get('startDatePagos'); //Input::get('startDatePagos');
			//Calcular fecha fin de pagos
			$bitacora->id_realiza_convenio = $request->get('realizaConvenio'); //Input::get('realizaConvenio');
			$bitacora->cantidad_pagos= $request->get('noPagos'); //Input::get('noPagos');
			$bitacora->forma_pago= $request->get('formaPago'); //Input::get('formaPago');

			$bitacora->id_operativo_recolecta1= $request->get('operativoRecolecta1'); //Input::get('operativoRecolecta1');
			$bitacora->id_operativo_recolecta2= $request->get('operativoRecolecta2'); //Input::get('operativoRecolecta2');
			$bitacora->id_carroza_recolecta= $request->get('carrozaRecolecta'); //Input::get('carrozaRecolecta');
			$bitacora->fecha_recoleccion= $request->get('startDateRecoleccion'); //Input::get('startDateRecoleccion');
			$bitacora->hora_recoleccion= $request->get('startHourRecoleccion'); //Input::get('startHourRecoleccion');
			$bitacora->fecha_termina_recoleccion = $request->get('endDateRecoleccion'); //Input::get('endDateRecoleccion');
			$bitacora->hora_fin_recoleccion= $request->get('endHourRecoleccion'); //Input::get('endHourRecoleccion');

			$bitacora->id_operativo_instala1= $request->get('operativoInstala1'); //Input::get('operativoInstala1');
			$bitacora->id_operativo_instala2= $request->get('operativoInstala2'); //Input::get('operativoInstala2');
			$bitacora->id_carroza_instala= $request->get('carrozaInstala'); //Input::get('carrozaInstala');
			$bitacora->fecha_instalacion= $request->get('startDateInstala'); //Input::get('startDateInstala');
			$bitacora->hora_instalacion= $request->get('startHourInstala'); //Input::get('startHourInstala');
			$bitacora->fecha_termina_instalacion= $request->get('endDateInstala'); //Input::get('endDateInstala');
			$bitacora->hora_fin_instalacion= $request->get('endHourInstala'); //Input::get('endHourInstala');

			$bitacora->id_operativo_cortejo1= $request->get('operativoCortejo1'); //Input::get('operativoCortejo1');
			$bitacora->id_operativo_cortejo2= $request->get('operativoCortejo2'); //Input::get('operativoCortejo2');
			$bitacora->id_carroza_cortejo= $request->get('carrozaCortejo'); //Input::get('carrozaCortejo');
			$bitacora->fecha_cortejo= $request->get('startDateCortejo'); //Input::get('startDateCortejo');
			$bitacora->hora_cortejo= $request->get('startHourCortejo'); //Input::get('startHourCortejo');
			$bitacora->fecha_termina_cortejo= $request->get('endDateCortejo'); //Input::get('endDateCortejo');
			$bitacora->hora_fin_cortejo= $request->get('endHourCortejo'); //Input::get('endHourCortejo');

			$bitacora->id_operativo_traslado1= $request->get('operativoTraslado1'); //Input::get('operativoCortejo1');
			$bitacora->id_operativo_traslado2= $request->get('operativoTraslado2'); //Input::get('operativoCortejo2');
			$bitacora->id_carroza_traslado= $request->get('carrozaTraslado'); //Input::get('carrozaCortejo');
			$bitacora->fecha_traslado= $request->get('startDateTraslado'); //Input::get('startDateCortejo');
			$bitacora->hora_traslado= $request->get('startHourTraslado'); //Input::get('startHourCortejo');
			$bitacora->fecha_termina_traslado= $request->get('endDateTraslado'); //Input::get('endDateCortejo');
			$bitacora->hora_fin_traslado= $request->get('endHourTraslado'); //Input::get('endHourCortejo');

			$bitacora->ropa_entregada= $request->get('entregaRopa'); //Input::get('entregaRopa');
			$bitacora->id_embalsamador = $request->get('proveedor'); //Input::get('proveedor');
			$bitacora->id_templo= $request->get('templo'); //Input::get('templo');
			$bitacora->hora_misa= $request->get('startDateMisa'); //Input::get('startDateMisa');
			/*if ( $bitacora->bitacora == 'GDL30JUN001' ) {
				echo "asdasd-";
				echo $request->get('fecha_misa');
				echo "1";
				return;
			}*/
			$bitacora->fecha_misa= $request->get('fecha_misa'); //Input::get('startDateMisa');
			$bitacora->acta_defuncion= $request->get('actaDefuncion'); //Input::get('actaDefuncion');

			//Seccíón de gestoría
			$bitacora->id_gestor_acta= $request->get('gestorActa'); //Input::get('endHourCortejo');
			$bitacora->id_vehiculo_acta= $request->get('vehiculoActa'); //Input::get('entregaRopa');
			$bitacora->id_gestor_tramite_per = $request->get('gestorPermiso'); //Input::get('proveedor');
			$bitacora->id_vehiculo_tramite_per= $request->get('vehiculoPermiso'); //Input::get('templo');
			$bitacora->id_gestor_entrega_per= $request->get('gestorEntregaPer'); //Input::get('startDateMisa');
			$bitacora->id_vehiculo_entrega_per= $request->get('vehiculoEntregaPer'); //Input::get('actaDefuncion');

			//Sección centinelas
			$bitacora->id_centinela_recolecta  =$request->get('centinelaRecolecta');
			$bitacora->id_centinela_instala  =$request->get('centinelaInstala');
			$bitacora->id_centinela_cortejo  =$request->get('centinelaCortejo');
			$bitacora->id_centinela_traslado  =$request->get('centinelaTraslado');
			$bitacora->id_carroza_cent_recolecta  =$request->get('centVehiculoRecolecta');
			$bitacora->id_carroza_cent_instala  =$request->get('centVehiculoInstala');
			$bitacora->id_carroza_cent_cortejo  =$request->get('centVehiculoCortejo');
			$bitacora->id_carroza_cent_traslado=$request->get('centVehiculoTraslado');

			//Campos para fechas de cortejo camion
			$bitacora->fecha_inicio_camion = $request->get('startDateCamion');
			$bitacora->hora_inicio_camion  = $request->get('startHourCamion');
			//$bitacora->fecha_fin_camion = $request->get('endDateCamion');
			//$bitacora->hora_fin_camion = $request->get('endHourCamion');

			
			
			$panteonTemp = $request->get('panteon');
			if ( is_numeric( $panteonTemp ) ) {
				//$bitacora->id_causa = $request->get('causaFallecimiento'); //Input::get('causaFallecimiento');
				$bitacora->panteon= $request->get('panteon'); //Input::get('panteon');
			} else {
				$mPanteon = new Panteon();
				$mPanteon->name = $panteonTemp;
				$mPanteon->save();
				$bitacora->panteon = $mPanteon->id;
			}
			
			$bitacora->observaciones_servicio= $request->get('observacionesServicio'); //Input::get('panteon');
			$bitacora->medico_certifica= $request->get('medicoCertifica');//medicoCertifica

			$bitacora->toldos_sillas= $request->get('sillaToldos');//check box de sillas y toldos
			$bitacora->solicita_toldos= $request->get('solicitaToldos');//usuario que solciita toldos
			$bitacora->confirma_toldos= $request->get('confirmaToldos');//medicoCertifica
			$bitacora->hora_comfirma_ts= $request->get('horaConfirmaToldos');//medicoCertifica
			$bitacora->folio_toldos= $request->get('folioToldos');//medicoCertifica
			$bitacora->recibe_cenizas = $request->get('personaRecibeCen');
			$bitacora->recibe_acta = $request->get('personaRecibeActa');
			$bitacora->fecha_etrega_acta = $request->get('dateEntregaActa');
			$bitacora->fecha_entrega_suc_acta = $request->get('dateEntregaActaSucursal');
			$bitacora->fecha_entrega_suc_cen = $request->get('dateEntregaCenizasSucursal');
			$bitacora->personal_recibe_cen = $request->get('gestorCenizas');
			$bitacora->personal_recibe_act = $request->get('gestorActa1');
			$bitacora->observaciones_gest = $request->get('observacionesGestoria');
			$bitacora->observaciones_atn = $request->get('observacionesCenizas');
			$bitacora->obervaciones_convenio = $request->get('observacionesConvenio');
			$bitacora->toldos_externo = $request->get('toldosExterno');
			//$bitacora->fecha_fin_velacion = $request->get('endDateVelacion');
			//$bitacora->hora_fin_velacion = $request->get('endHourVelacion');
			//RECEPCION DE DOCUMENTOS
			$bitacora->doc_contrato= $request->get('docContrato');
			$bitacora->recibe_contrato= $request->get('recibeContrato');

			$bitacora->doc_titulo= $request->get('docTitulo');
			$bitacora->recibe_titulo= $request->get('recibeTitulo');

			$bitacora->doc_solicitud= $request->get('docSolicitud');
			$bitacora->recibe_solicitud= $request->get('recibeSolicitud');

			$bitacora->doc_responsiva= $request->get('docResponsiva');//check box de sillas y toldos
			$bitacora->recibe_responsiva= $request->get('recibeResponsiva');//usuario que solciita toldos

			$bitacora->sucursal_hace_convenio= $request->get('sucursal_hace_convenio');

			$bitacora->id_operativo_cortejo3= $request->get('id_operativo_cortejo3');
			$bitacora->id_camion_cortejo= $request->get('id_camion_cortejo');

			$bitacora->doc_entrega_disco= $request->get('docDisco');
			$bitacora->entrega_disco= $request->get('entregaDisco');

			$bitacora->ingreso_covid = $request->get('covid');

			


			//if ($bitacora->bitacora == "GDL30JUN001") {

			//---------------------------------------------------------------RECOLECCIÓN---------------------------------------------------------------------------------------------------------------------------------
			if($bitacora->isDirty('id_operativo_recolecta1') &&  $bitacora->id_operativo_recolecta1 != null && $bitacora->id_operativo_recolecta1 != "" ){
				$proveedor = $this->get_proveedor($request->get('operativoRecolecta1'));
						if($proveedor[0]>0){//significa que es proveedor----Asignar bitacora
							//$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',1);
							array_push($idOperaticoC,$proveedor[0]);
							array_push($nameOperaticoC,$proveedor[1]);
							array_push($bitacoraC,$bitacora->bitacora);
							array_push($movimientoC,1);
							array_push($tipoOperaticoC,'latino_proveedor');
						}
						else{
							//$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],1);
							array_push($idOperaticoC,$request->get('operativoRecolecta1'));
							array_push($nameOperaticoC,$proveedor[1]);
							array_push($bitacoraC,$bitacora->bitacora);
							array_push($movimientoC,1);
							array_push($tipoOperaticoC,'latino_driver');

							array_push($idOperativo, $request->get('operativoRecolecta1'));
							array_push($movimiento, 'Recolección');
							array_push($tipo_operativo,'Operativo 1');
							array_push($bitacoraAsiganda,$bitacora->bitacora);
						}
					}

					if($bitacora->isDirty('id_operativo_recolecta2') &&  $bitacora->id_operativo_recolecta2 != null && $bitacora->id_operativo_recolecta2 != "" ){

						array_push($idOperativo, $request->get('operativoRecolecta2'));
						array_push($movimiento, 'Recolección');
						array_push($tipo_operativo,'Operativo 2');
						array_push($bitacoraAsiganda,$bitacora->bitacora);
					}
			//---------------------------------------------------------------INSTALACCIÓN---------------------------------------------------------------------------------------------------------------------------------

					if($bitacora->isDirty('id_operativo_instala1') &&  $bitacora->id_operativo_instala1 != null && $bitacora->id_operativo_instala1 != ""){
						$proveedor = $this->get_proveedor($request->get('operativoInstala1'));
					if($proveedor[0]>0){//significa que es proveedor----Asignar bitacora
							//echo "3 - ";
							//Log::channel('random_stuff')->info('app.requests', ['request_name' => '3'] );
						//$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',2);
						array_push($idOperaticoC,$proveedor[0]);
						array_push($nameOperaticoC,$proveedor[1]);
						array_push($bitacoraC,$bitacora->bitacora);
						array_push($movimientoC,2);
						array_push($tipoOperaticoC,'latino_proveedor');
					}
					else{
						array_push($idOperaticoC,$request->get('operativoInstala1'));
						array_push($nameOperaticoC,$proveedor[1]);
						array_push($bitacoraC,$bitacora->bitacora);
						array_push($movimientoC,2);
						array_push($tipoOperaticoC,'latino_driver');
						//$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],2);
						array_push($idOperativo, $request->get('operativoInstala1'));
						array_push($movimiento, 'Instalación');
						array_push($tipo_operativo,'Operativo 1');
						array_push($bitacoraAsiganda,$bitacora->bitacora);
					}

				}

				if($bitacora->isDirty('id_operativo_instala2') &&  $bitacora->id_operativo_instala2 != null && $bitacora->id_operativo_instala2 != ""){
					array_push($idOperativo, $request->get('operativoInstala2'));
					array_push($movimiento, 'Instalación');
					array_push($tipo_operativo,'Operativo 2');
					array_push($bitacoraAsiganda,$bitacora->bitacora);

				} 

			//---------------------------------------------------------------CORTEJO---------------------------------------------------------------------------------------------------------------------------------
				if($bitacora->isDirty('id_operativo_cortejo1') &&  $bitacora->id_operativo_cortejo1 != null && $bitacora->id_operativo_cortejo1 != ""){
					$proveedor = $this->get_proveedor($request->get('operativoCortejo1'));
					if($proveedor[0]>0){
						//$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',3);
						array_push($idOperaticoC,$proveedor[0]);
						array_push($nameOperaticoC,$proveedor[1]);
						array_push($bitacoraC,$bitacora->bitacora);
						array_push($movimientoC,3);
						array_push($tipoOperaticoC,'latino_proveedor');
					}
					else{
						array_push($idOperaticoC,$request->get('operativoCortejo1'));
						array_push($nameOperaticoC,$proveedor[1]);
						array_push($bitacoraC,$bitacora->bitacora);
						array_push($movimientoC,3);
						array_push($tipoOperaticoC,'latino_driver');
						//$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],3);
						array_push($idOperativo, $request->get('operativoCortejo1'));
						array_push($movimiento, 'Cortejo');
						array_push($tipo_operativo,'Operativo 1');
						array_push($bitacoraAsiganda,$bitacora->bitacora);
					}
				}
				if($bitacora->isDirty('id_operativo_cortejo2') &&  $bitacora->id_operativo_cortejo2 != null && $bitacora->id_operativo_cortejo2 != ""){
					array_push($idOperativo, $request->get('operativoCortejo2'));
					array_push($movimiento, 'Cortejo');
					array_push($tipo_operativo,'Operativo 2');
					array_push($bitacoraAsiganda,$bitacora->bitacora);
				}
			//---------------------------------------------------------------TRASLADO---------------------------------------------------------------------------------------------------------------------------------
				if($bitacora->isDirty('id_operativo_traslado1') &&  $bitacora->id_operativo_traslado1 != null && $bitacora->id_operativo_traslado1 != "" ){
					$proveedor = $this->get_proveedor($request->get('operativoTraslado1'));
					if($proveedor[0]>0){//significa que es proveedor----Asignar bitacora
						//$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',4);
						array_push($idOperaticoC,$proveedor[0]);
						array_push($nameOperaticoC,$proveedor[1]);
						array_push($bitacoraC,$bitacora->bitacora);
						array_push($movimientoC,4);
						array_push($tipoOperaticoC,'latino_proveedor');

					}
					else{
						array_push($idOperaticoC,$request->get('operativoTraslado1'));
						array_push($nameOperaticoC,$proveedor[1]);
						array_push($bitacoraC,$bitacora->bitacora);
						array_push($movimientoC,4);
						array_push($tipoOperaticoC,'latino_driver');
						//$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],4);
						array_push($idOperativo, $request->get('operativoTraslado1'));
						array_push($movimiento, 'Traslado');
						array_push($tipo_operativo,'Operativo 1');
						array_push($bitacoraAsiganda,$bitacora->bitacora);
					}
				}

				if($bitacora->isDirty('id_operativo_traslado2') &&  $bitacora->id_operativo_traslado2 != null && $bitacora->id_operativo_traslado2 != "" ){
					array_push($idOperativo, $request->get('id_operativo_traslado2'));
					array_push($movimiento, 'Traslado');
					array_push($tipo_operativo,'Operativo 2');
					array_push($bitacoraAsiganda,$bitacora->bitacora);
				}
				//---------------------------------------------------------------CORTEJO CAMION---------------------------------------------------------------------------------------------------------------------------------
				if($bitacora->isDirty('id_operativo_cortejo3') &&  $bitacora->id_operativo_cortejo3 != null && $bitacora->id_operativo_cortejo3 != ""){
					$proveedor = $this->get_proveedor($request->get('id_operativo_cortejo3'));
					if($proveedor[0]>0){//significa que es proveedor----Asignar bitacora
						//$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',5);
						array_push($idOperaticoC,$proveedor[0]);
						array_push($nameOperaticoC,$proveedor[1]);
						array_push($bitacoraC,$bitacora->bitacora);
						array_push($movimientoC,5);
						array_push($tipoOperaticoC,'latino_proveedor');
					}
					else{
						array_push($idOperaticoC,$request->get('id_operativo_cortejo3'));
						array_push($nameOperaticoC,$proveedor[1]);
						array_push($bitacoraC,$bitacora->bitacora);
						array_push($movimientoC,5);
						array_push($tipoOperaticoC,'latino_driver');
						//$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],5);
						array_push($idOperativo, $request->get('id_operativo_cortejo3'));
						array_push($movimiento, 'Cortejo camion');
						array_push($tipo_operativo,'Operativo 1');
						array_push($bitacoraAsiganda,$bitacora->bitacora);

					}
				}
				
				
				//---------------------------------------------------------------CENTINELA RECOLECTA---------------------------------------------------------------------------------------------------------------------------------

				if($bitacora->isDirty('id_centinela_recolecta') &&  $bitacora->id_centinela_recolecta != null && $bitacora->id_centinela_recolecta != ""){
					$proveedor = $this->get_proveedor($request->get('centinelaRecolecta'));
					if($proveedor[0]>0){//significa que es proveedor----Asignar bitacora
						//$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',6);
						array_push($idOperaticoC,$proveedor[0]);
						array_push($nameOperaticoC,$proveedor[1]);
						array_push($bitacoraC,$bitacora->bitacora);
						array_push($movimientoC,6);
						array_push($tipoOperaticoC,'latino_proveedor');
					}
					else{
						array_push($idOperaticoC,$request->get('centinelaRecolecta'));
						array_push($nameOperaticoC,$proveedor[1]);
						array_push($bitacoraC,$bitacora->bitacora);
						array_push($movimientoC,6);
						array_push($tipoOperaticoC,'latino_driver');
						//$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],6);
						array_push($idOperativo, $request->get('centinelaRecolecta'));
						array_push($movimiento, 'Centinela - Recolección');
						array_push($tipo_operativo,'operativo 1');
						array_push($bitacoraAsiganda,$bitacora->bitacora);

					}
				}
				//---------------------------------------------------------------CENTINELA CORTEJO---------------------------------------------------------------------------------------------------------------------------------
				if($bitacora->isDirty('id_centinela_cortejo') &&  $bitacora->id_centinela_cortejo != null && $bitacora->id_centinela_cortejo != ""){
					$proveedor = $this->get_proveedor($request->get('centinelaCortejo'));
					if($proveedor[0]>0){//significa que es proveedor----Asignar bitacora
						//$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',7);
						array_push($idOperaticoC,$proveedor[0]);
						array_push($nameOperaticoC,$proveedor[1]);
						array_push($bitacoraC,$bitacora->bitacora);
						array_push($movimientoC,7);
						array_push($tipoOperaticoC,'latino_proveedor');
					}
					else{
						array_push($idOperaticoC,$request->get('centinelaCortejo'));
						array_push($nameOperaticoC,$proveedor[1]);
						array_push($bitacoraC,$bitacora->bitacora);
						array_push($movimientoC,7);
						array_push($tipoOperaticoC,'latino_driver');
						//$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],7);
						array_push($idOperativo, $request->get('centinelaCortejo'));
						array_push($movimiento, 'Centinela - Cortejo');
						array_push($tipo_operativo,'operativo 1');
						array_push($bitacoraAsiganda,$bitacora->bitacora);

					}
				}

				//---------------------------------------------------------------CENTINELA INSTALA---------------------------------------------------------------------------------------------------------------------------------
				if($bitacora->isDirty('id_centinela_instala') &&  $bitacora->id_centinela_instala != null && $bitacora->id_centinela_instala != ""){
					$proveedor = $this->get_proveedor($request->get('centinelaInstala'));
					if($proveedor[0]>0){//significa que es proveedor----Asignar bitacora
						//$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',8);
						array_push($idOperaticoC,$proveedor[0]);
						array_push($nameOperaticoC,$proveedor[1]);
						array_push($bitacoraC,$bitacora->bitacora);
						array_push($movimientoC,8);
						array_push($tipoOperaticoC,'latino_proveedor');
					}
					else{
						array_push($idOperaticoC,$request->get('centinelaInstala'));
						array_push($nameOperaticoC,$proveedor[1]);
						array_push($bitacoraC,$bitacora->bitacora);
						array_push($movimientoC,8);
						array_push($tipoOperaticoC,'latino_driver');
						//$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],8);
						array_push($idOperativo, $request->get('centinelaInstala'));
						array_push($movimiento, 'Centinela - Instalación');
						array_push($tipo_operativo,'operativo 1');
						array_push($bitacoraAsiganda,$bitacora->bitacora);

					}
				}

				//---------------------------------------------------------------CENTINELA TRASLADO---------------------------------------------------------------------------------------------------------------------------------
				if($bitacora->isDirty('id_centinela_traslado') &&  $bitacora->id_centinela_traslado != null && $bitacora->id_centinela_traslado != ""){
					$proveedor = $this->get_proveedor($request->get('centinelaTraslado'));
					if($proveedor[0]>0){//significa que es proveedor----Asignar bitacora
						//$this->store_bitacora_supplier($bitacora->bitacora,$proveedor[0],$proveedor[1],'','',9);
						array_push($idOperaticoC,$proveedor[0]);
						array_push($nameOperaticoC,$proveedor[1]);
						array_push($bitacoraC,$bitacora->bitacora);
						array_push($movimientoC,9);
						array_push($tipoOperaticoC,'latino_proveedor');
					}
					else{
						array_push($idOperaticoC,$request->get('centinelaTraslado'));
						array_push($nameOperaticoC,$proveedor[1]);
						array_push($bitacoraC,$bitacora->bitacora);
						array_push($movimientoC,9);
						array_push($tipoOperaticoC,'latino_driver');
						//$this->store_bitacora_driver($bitacora->bitacora,$request->get('centinelaTraslado'),$proveedor[1],'',$request->get('centVehiculoTraslado'),9);
						//$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],9);
						array_push($idOperativo, $request->get('centinelaTraslado'));
						array_push($movimiento, 'Centinela - Traslado');
						array_push($tipo_operativo,'operativo 1');
						array_push($bitacoraAsiganda,$bitacora->bitacora);

					}
				}

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
				if($bitacora->isDirty('id_gestor_acta') &&  $bitacora->id_gestor_acta != null && $bitacora->id_gestor_acta != "" && $request->get('gestorActa_name') != "SIN GESTOR" && 
					$request->get('gestorActa_name') != "OTRA FUNERARIA"){

					$proveedor = $this->get_gestor($request->get('gestorActa_name'));
				if ($proveedor != null) {
					array_push($idOperaticoC,$proveedor[0]);
					array_push($nameOperaticoC,$proveedor[1]);
					array_push($bitacoraC,$bitacora->bitacora);
					array_push($movimientoC,10);
					array_push($tipoOperaticoC,'latino_driver');
							//$this->store_bitacora_driver($bitacora->bitacora,$request->get('centinelaTraslado'),$proveedor[1],'',$request->get('centVehiculoTraslado'),9);
							//$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],9);
					array_push($idOperativo, $proveedor[0]);
					array_push($movimiento, 'Gestor - Acta');
					array_push($tipo_operativo,'operativo 1');
					array_push($bitacoraAsiganda,$bitacora->bitacora);
				}

			}

			if($bitacora->isDirty('id_gestor_tramite_per') &&  $bitacora->id_gestor_tramite_per != null && $bitacora->id_gestor_tramite_per != ""  && $request->get('gestorPermiso_name') != 
				"SIN GESTOR" && $request->get('gestorPermiso_name') != "OTRA FUNERARIA" ){

				$proveedor = $this->get_gestor($request->get('gestorPermiso_name'));
			if ($proveedor != null) {
				array_push($idOperaticoC,$proveedor[0]);
				array_push($nameOperaticoC,$proveedor[1]);
				array_push($bitacoraC,$bitacora->bitacora);
				array_push($movimientoC,10);
				array_push($tipoOperaticoC,'latino_driver');
							//$this->store_bitacora_driver($bitacora->bitacora,$request->get('centinelaTraslado'),$proveedor[1],'',$request->get('centVehiculoTraslado'),9);
							//$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],9);
				array_push($idOperativo, $proveedor[0]);
				array_push($movimiento, 'Gestor - Acta');
				array_push($tipo_operativo,'operativo 1');
				array_push($bitacoraAsiganda,$bitacora->bitacora);
			}

		}

		if($bitacora->isDirty('id_gestor_entrega_per') &&  $bitacora->id_gestor_entrega_per != null && $bitacora->id_gestor_entrega_per != "" && $request->get('gestorEntregaPer_name') != "SIN GESTOR" && $request->get('gestorEntregaPer_name') != "OTRA FUNERARIA" ){

			$proveedor = $this->get_gestor($request->get('gestorEntregaPer_name'));
		if ($proveedor != null) {
			array_push($idOperaticoC,$proveedor[0]);
			array_push($nameOperaticoC,$proveedor[1]);
			array_push($bitacoraC,$bitacora->bitacora);
			array_push($movimientoC,10);
			array_push($tipoOperaticoC,'latino_driver');
							//$this->store_bitacora_driver($bitacora->bitacora,$request->get('centinelaTraslado'),$proveedor[1],'',$request->get('centVehiculoTraslado'),9);
							//$this->sendPushNotification_proveedor('', $bitacora->bitacora,"",$proveedor[1],9);
			array_push($idOperativo, $proveedor[0]);
			array_push($movimiento, 'Gestor - Acta');
			array_push($tipo_operativo,'operativo 1');
			array_push($bitacoraAsiganda,$bitacora->bitacora);
		}

	}

					$array_cambios = array('id_op' => $idOperativo,
						'movimiento' => $movimiento,
						'tipo_operativo' => $tipo_operativo,
						'bitacora' => $bitacoraAsiganda);

					$array_cambios2 = array(
						'operativo' => $idOperaticoC,
						'nombre'	=> $nameOperaticoC,
						'bitacora' => $bitacoraC,
						'movimiento' => $movimientoC,
						'tipo_operatico' => $tipoOperaticoC);

			if (count($array_cambios['id_op']) > 0) {
				//llamar el método 
				//$this->getHistoryResources($array_cambios);
			}
			

			if($bitacora->isDirty()){


					$bitacoraDetailDataChangesHistory = new BitacoraDetailDataChangesHistory();
					$bitacoraDetailDataChangesHistory->bitacora = $bitacora->bitacora;
					$bitacoraDetailDataChangesHistory->id = $bitacora->id;
					$bitacoraDetailDataChangesHistory->id_user = auth()->user()->id;

					$bitacoraToModify = BitacoraDetail::find($id);

					foreach ($bitacora->getAttributes() as $key => $value) {


						if ( $key != "id" && $key != "bitacora" && $key != "id_user" && $key != "created_at" && $key != "updated_at" && $key != "fecha_captura" ) {

							if (  $value != $fieldToUpdate->$key ) {

								$bitacoraDetailDataChangesHistory[$key."_before"] = $fieldToUpdate->$key;
								$bitacoraDetailDataChangesHistory[$key."_after"] = $value;

								 $bitacoraToModify[$key] = $value;
							}

						}

					}

					$bitacoraDetailDataChangesHistory->save();
					$bitacoraToModify->save();

					$id_bitacora = $bitacoraToModify->id;
					
					for ($i=0; $i <=3; $i++) { 
						$tipo =$i + 1;
						$address = Address::where('bitacora',$id_bitacora)->where('type',$tipo)->update([
							'calle'=> $calles[$i],
							'entre_calles'=> $entre_calles[$i],
							'colonia'=> $colonias[$i],
							'municipio' =>$localidades[$i]
						 ]);	
					}

				
					for ($i=0; $i <=4; $i++) { 
						$contact = Contactos::where('bitacora',$id_bitacora)->where('type',$i+1)->update([
							'name' => $nombres[$i],
							'telefono' => $telefonos[$i],
							'parentesco' => $parentescos[$i]
						]);
					
					}

					if ( $request->get('newComment') != null ) {
						$comment = new Comments();
						$comment->bitacora = $bitacoraToModify->bitacora;
						$comment->comentario = $request->get('newComment');
						$comment->usuario = auth()->user()->name;
						$comment->fecha_captura = date('Y-m-d H:i:s');

						$comment->save();
					}

					return response()->json(['val1'=>$array_cambios,'val2'=>$array_cambios2]);

			}
			else{
					for ($i=0; $i <=3; $i++) { 
						$tipo =$i + 1;
						$address = Address::where('bitacora',$id)->where('type',$tipo)->update([
							'calle'=> $calles[$i],
							'entre_calles'=> $entre_calles[$i],
							'colonia'=> $colonias[$i],
							'municipio' =>$localidades[$i]
						 ]);	
					}

				
					for ($i=0; $i <=4; $i++) { 
						$contact = Contactos::where('bitacora',$id)->where('type',$i+1)->update([
							'name' => $nombres[$i],
							'telefono' => $telefonos[$i],
							'parentesco' => $parentescos[$i]
						]);
					
					}

					if ( $request->get('newComment') != null ) {
						$comment = new Comments();
						$comment->bitacora = $bitacora->bitacora;
						$comment->comentario = $request->get('newComment');
						$comment->usuario = auth()->user()->name;
						$comment->fecha_captura = date('Y-m-d H:i:s');

						$comment->save();
					}
					
					return response()->json(['val1'=>$array_cambios,'val2'=>$array_cambios2]);
			}	
	}

public function asignacion_historico(Request $request){

	//return;

	$historico_asignacion = $request->get('array1');
	$notificacion = $request->get('array2');

	if ($historico_asignacion != null) { //hay asiganacion de operativo
		$this->getHistoryResources($historico_asignacion);
		echo json_encode($historico_asignacion);
	}

	if ($notificacion != null) {
		for ($i=0; $i <count($notificacion['operativo']) ; $i++) { 
				$operativo_id= $notificacion['operativo'][$i];
				$operativo_nombre= $notificacion['nombre'][$i];
				$bitacora= $notificacion['bitacora'][$i];
				$movimiento = $notificacion['movimiento'][$i];
				$tipo_operativo = $notificacion['tipo_operatico'][$i];

			if ($tipo_operativo == "latino_proveedor") {
				$this->store_bitacora_supplier($bitacora,$operativo_id,$operativo_nombre,'','',$movimiento);
			}

			if ($tipo_operativo == "latino_driver") {
				$this->sendPushNotification_proveedor('', $bitacora,"",$operativo_nombre,$movimiento);
			}

			echo json_encode($notificacion);

		}

	} 

}

public function update_crate_invoce(Request $request,$id)
{
	$singleBitacora = BitacoraDetail::find($id);
    $calc =  Invoices::where('bitacora_invoice','=',$singleBitacora->id)->get();
    $estatus_carta ="";
    $estatus_factura = "";

	if (count($calc) > 0 ) {//Existe registro de factura
		$factura = Invoices::find($calc[0]["id"]);  


	}else{//No exis registro indesrtamos registro

		$registro = Invoices::create(['bitacora_invoice' => $id]);

		$factura = Invoices::find($registro->id); 
	}
	//echo json_encode($factura);

		$fieldToUpdate = DB::table('bitacora_invoice_beign_updated') // no existe registros create
	                ->where('bitacora_invoice', $id)
	                ->where('timestamp_invoice', $request->input('timestamp_factura') )
	                ->where('user_invoice', auth()->user()->name )
	                ->first();
	     echo json_encode($fieldToUpdate);


	     $proceso = "";
	    if ($request->input('requiereFactura') == 'on' and  $request->input('requiereCarta') == 'on') {
	    	$proceso = 3;
	    	$factura->atiendo_solcitud = $factura->atiendo_solcitud != null ? $factura->atiendo_solcitud :  auth()->user()->name  ;
	    	$factura->atiendo_solcitud_carta = $factura->atiendo_solcitud_carta != null ? $factura->atiendo_solcitud_carta :  auth()->user()->name  ;
	    	$estatus_factura = $request->input('correcionFactura') == "on"   && $factura->is_correccion != 1 ? "CORRECIÓN" :  ($request->input('statusFactura') != '' ? $request->input('statusFactura') : "PENDIENTE" );
    		$estatus_carta = $request->input('estatusCarta') != '' ? $request->input('estatusCarta') : "PENDIENTE" ;



	    }else if($request->input('requiereFactura') == 'on' and  $request->input('requiereCarta') != 'on'){
	    	$proceso = 1;
	    	$factura->atiendo_solcitud = $factura->atiendo_solcitud != null ? $factura->atiendo_solcitud :  auth()->user()->name  ;
	    	$estatus_factura = $request->input('correcionFactura') == "on" && $factura->is_correccion != 1 ? "CORRECIÓN" :  ($request->input('statusFactura') != '' ? $request->input('statusFactura') : "PENDIENTE" );
	    }else if($request->input('requiereFactura') != 'on' and  $request->input('requiereCarta') == 'on') {
	    	$proceso = 2;
	    	$factura->atiendo_solcitud_carta = $factura->atiendo_solcitud_carta != null ? $factura->atiendo_solcitud_carta :  auth()->user()->name  ;
	    	$estatus_carta = $request->input('estatusCarta') != '' ? $request->input('estatusCarta') : "PENDIENTE" ;
	    }



	                $factura->bitacora = $id;
	                $factura->check_saldo = $request->input('saldoPendiente');
	                $factura->check_documentacion = $request->input('documentacionCompleta');
	                $factura->sucursal_solicitud = $request->input('sucursalSolicitud');
	                $factura->persona_solicita_fac= $request->input('solicitaFacturaCliente');
	                $factura->finado = $request->input('finado');
	                $factura->date_dead = $request->input('dateDead');
	                $factura->telefono_solicitante = $request->input('telefonoCliente');
	                $factura->celular_solicitante = $request->input('celular');
	                $factura->RFC = $request->input('rfcCliente');
	                $factura->email = $request->input('emailCliente');
	                $factura->calle = $request->input('calleCliente');
	                $factura->numero = $request->input('calleNumero');
	                $factura->no_interior = $request->input('numeroInterior');
	                $factura->municipio = $request->input('municipioCliente');
	                $factura->colonia = $request->input('coloniaCliente');
	                $factura->codigo_postal = $request->input('cpCliente');
	                $factura->estado = $request->input('estado');
	                $factura->monto_factura = $request->input('montoFactura');
	                $factura->forma_pago_invoice = $request->input('formaPagoFactura');
	                $factura->regimen_fiscal = $request->input('regimenFiscal');
	                $factura->CFDI = $request->input('cfdiFactura');
	                $factura->check_entrega = $request->input('entregaFactura') == ''  ? $factura->check_entrega : $request->input('entregaFactura') ;
	                $factura->personal_entrega = $request->input('personalFacturaEntrega');
	                $factura->persona_recibe = $request->input('perosnaRecibeFactura');
	                $factura->fecha_entrega = $request->input('dateEntregaFactura');
	                $factura->sucursal_carta = $request->input('sucursalSolicitudCarta');
	                $factura->persona_solicita_car = $request->input('solicitaCarta');//Cliente que solicita carta desglose
	                $factura->telefono_solicitante_carta = $request->input('telefonoClienteCarta');
	                $factura->celular_solicitante_carta = $request->input('celularCarta');
	                $factura->check_entrega_carta = $request->input('entregaCarta');
	                $factura->personal_entrega_carta = $request->input('personalCartaEntrega');
	                $factura->personal_recibe_carta = $request->input('personaRecibeCarta');
	                $factura->fecha_entrega_carta = $request->input('dateEntregaCarta');
	                $factura->check_factura = $request->input('requiereFactura');
	                $factura->check_carta = $request->input('requiereCarta');
	                $factura->proceso = $proceso;
	                $factura->status_factura = $estatus_factura;
	                $factura->status_carta =  $estatus_carta;
	                $factura->check_correcion = $request->input('correcionFactura');
	                $factura->is_correccion = $request->input('correcionFactura') == "on" ? 1 : 0;


	                if ($factura->isDirty()) {

	                	$invoiceDataChangesHistory = new InvoiceDataChangesHistory();
						$invoiceDataChangesHistory->bitacora_invoice = $factura->bitacora;
						$invoiceDataChangesHistory->id = $factura->id;
						$invoiceDataChangesHistory->id_user_invoice = auth()->user()->id;

						$invoiceToModify = Invoices::find($factura->id);

						foreach ($factura->getAttributes() as $key => $value) {


							if ( $key != "id" && $key != "bitacora" && $key != "id_user" && $key != "created_at" && $key != "updated_at" && $key != "fecha_captura" && $key != "is_correccion") {

								if (  $value != $fieldToUpdate->$key ) {

									
									
									$invoiceDataChangesHistory[$key."_before"] = $fieldToUpdate->$key;
									$invoiceDataChangesHistory[$key."_after"] = $value;


									 $invoiceToModify[$key] = $value;
								}


							}

						}

						 $invoiceDataChangesHistory->save();
						 $invoiceToModify["is_correccion"] = $request->input('correcionFactura') == "on" ? 1 : 0;
						 $invoiceToModify->save();
	                }
	            $id2 = "9|".$id;
	 
	 return redirect()->route('bitacora-details.show', $id2);

}

public function getInvoiceData($id)
{
	$data = Invoices::find($id);

	return response()->json(['success'=>$data]);

}


}
