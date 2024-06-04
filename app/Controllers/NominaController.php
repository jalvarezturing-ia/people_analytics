<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\NominaModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsm;


class NominaController extends BaseController
{
    public function periodos()
    {

        $nominaModel = new NominaModel();
        $periodos = $nominaModel->periodos();

        $data = ['periodos' => $periodos];

        //print_r ($data);

        return view("comercial/administracionGeneral/nomina/periodos", $data);

    }

    public function board($periodo = null, $mes = null, $estado = null, $inicio = null, $fin = null )
    {

        $period = trim($periodo);
        $mes = trim($mes);
        $estado = trim($estado);
        $inicio = trim($inicio);
        $fin = trim($fin);



        $nominaModel = new NominaModel();
        $periodo = $nominaModel->periods($period, $mes, $estado, $inicio, $fin);
        $data = ['periodo' => $periodo, 'año' => $period, 'mes' => $mes, 'estado' =>$estado, 'inicio' => $inicio, 'fin' => $fin];

        return view('comercial/administracionGeneral/nomina/nomina', $data);


    }

    public function newboard()
    {

        $nominaModel = new NominaModel();
        $colabs = $nominaModel->getAllColabs();

        $data = ['colabs' => $colabs];
        /*echo "<pre>";
        print_r($colabs);
        echo "</pre>";*/

        return view('comercial/administracionGeneral/nomina/nuevaNomina', $data);

    }

    public function saveNomina()
    {

        $session = session();
        $id_usuario = $this->request->getPost('id_usuario');
        $nombre_banco = $this->request->getPost('nombre_banco');
        $numero_cuenta = $this->request->getPost('numero_cuenta');
        $clabe_interbancaria = $this->request->getPost('clabe_interbancaria');
        $fecha_inicio_colab = $this->request->getPost('fecha_inicio_colab');
        $pago_mensual_base = $this->request->getPost('pago_mensual_base');
        $pago_quincenal = $this->request->getPost('pago_quincenal');
        $sueldo_diario = $this->request->getPost('sueldo_diario');

        $nominaModel = new NominaModel();
        $insert = $nominaModel->saveNomina($id_usuario, $nombre_banco, $numero_cuenta, $clabe_interbancaria, $pago_mensual_base, $pago_quincenal, $sueldo_diario);

        if ($insert) {
            $mensaje = "Nómina generada con éxito, continue con los siguientes pasos.";
            $session->setFlashdata('sucess_message', $mensaje);
            return redirect()->to(base_url('home/newboard'));

        } else {

            $mensaje = "Algo salió mal, intente de nuevo más tarde.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url('home/newboard'));
        }

    }

    public function newperiod()
    {
        $nominaModel = new NominaModel();
        $data = $nominaModel->getNominas();



        $nomina = ['nomina' => $data];
        return view("comercial/administracionGeneral/nomina/nuevoPeriodo", $nomina);
    }

    public function saveperiod()
    {
        $session = session();
        $idUsuario = $this->request->getPost('id_usuario');
        $idNomina = $this->request->getPost('id_nomina');
        $fechaInicioColab = $this->request->getPost('fecha_inicio_colab');
        $pagoMensualBase = $this->request->getPost('pago_mensual_base');
        $periodo = $this->request->getPost('periodo');
        $mes = $this->request->getPost('mes');
        $fechaInicioQuincena = $this->request->getPost('fecha_inicio_quincena');
        $fechaPrimerQuincena = $this->request->getPost('fecha_primer_quincena');
        $fechaFinQuincena = $this->request->getPost('fecha_fin_quincena');
        $siNoQuincena = $this->request->getPost('si_no_quincena');
        $diasTrabajados = $this->request->getPost('dias_trabajados');
        $sueldoFinal = $this->request->getPost('sueldo_final');
        $pagada = "NO";
        $firmada = "NO";

        $nominaModel = new nominaModel();
        $save = $nominaModel->saveperiod($idNomina, $periodo, $mes, $fechaInicioQuincena, $fechaFinQuincena, $diasTrabajados, $sueldoFinal, $pagada, $firmada);

        if ($save) {

            $mensaje = "Periodo generado con éxito.";
            $session->setFlashdata('sucess_message', $mensaje);
            return redirect()->to(base_url('home/newperiod'));

        } else {

            $mensaje = "Algo salió mal, intente de nuevo más tarde.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url('home/newperiod'));
        }
    }

    public function periods($periodo = null, $mes = null, $nombre_banco = null, $estado = null, $inicio = null, $fin = null)
    {

        $session = session();
        $nominaModel = new nominaModel();
        $periods = $nominaModel->getPeriods($periodo, $mes, $nombre_banco, $estado, $inicio, $fin);
        $data = ['periodos' => $periods, 'año' => $periodo, 'mes' => $mes, 'nombreB' => $nombre_banco, 'estado' => $estado, 'inicio'=>$inicio, 'fin'=> $fin];

        /*echo "<pre>";
        print_r($data);
        echo "</pre>";*/
        //exit();

        return view('comercial/administracionGeneral/nomina/vistaPeriodos', $data);

    }

    public function delete($id_periodo)
    {
        $session = session();
        $nominaModel = new NominaModel();
        $delete = $nominaModel->deletePeriod($id_periodo);

        if ($delete) {
            $mensaje = "Periodo elimnado con éxito.";
            $session->setFlashdata('sucess_message', $mensaje);
            return redirect()->to(base_url('home/newperiod'));

        } else {

        }

    }

    public function saveExtras()
    {


        $session = session();
        $periodo = $this->request->getPost('periodo');
        $mes = $this->request->getPost('mes');
        $nombre_b = $this->request->getPost('nombre_b');
        $id_nomina = $this->request->getPost('id_nomina');
        $home_office = $this->request->getPost('home_office');
        $dias_extras = $this->request->getPost('dias_extras');
        $pago_dia_extra = $this->request->getPost('pago_dia_extra');
        $bono_extra = $this->request->getPost('bono_extra');
        $pago_bono_extra = $this->request->getPost('pago_bono_extra');
        $comision_extra = $this->request->getPost('comision_extra');
        $estado = $this->request->getPost('estado');
        $inicio = $this->request->getPost('inicio');
        $fin = $this->request->getPost('fin');

        $nominaModel = new NominaModel();
        $extras = $nominaModel->saveExtras($id_nomina, $home_office, $dias_extras, $pago_dia_extra, $bono_extra, $pago_bono_extra, $comision_extra);

        if ($extras) {

            $mensaje = "Bonos generados con éxito.";
            $session->setFlashdata('sucess_message', $mensaje);
            return redirect()->to(base_url("home/periods/$periodo/$mes/$nombre_b/$estado/$inicio/$fin"));

        } else {

            $mensaje = "Algo salio mal.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/periods/$periodo/$mes/$nombre_b/$estado/$inicio/$fin"));

        }



    }

    public function archive($periodo = null, $mes = null, $estado = null, $inicio = null, $fin = null)
    {

        $data = ['periodo' => $periodo, 'mes' => $mes, 'estado' => $estado, 'inicio'=>$inicio, 'fin'=> $fin];
        return view("comercial/administracionGeneral/nomina/excel", $data);

    }

    public function process()
    {
        $session = session();
        $periodo = $this->request->getPost('periodo');
        $mes = $this->request->getPost('mes');
        $estado = $this->request->getPost('estado');
        $inicio = $this->request->getPost('inicio');
        $fin = $this->request->getPost('fin');
        $nombre_doc = $_FILES['documento']['name'];
        $tipo = $_FILES['documento']['type'];
        $tamano = $_FILES['documento']['size'];
        $pagado = "SI";

        $ruta_archivo = WRITEPATH . 'uploads/';

        move_uploaded_file($_FILES['documento']['tmp_name'], $ruta_archivo . $nombre_doc);
        $excelFilePath = $ruta_archivo . $nombre_doc;

        $nominaModel = new NominaModel();
        $archive = $nominaModel->getdataarchive($periodo, $mes, $estado, $inicio, $fin);
        $nominaModel->setpagados($pagado, $periodo, $mes, $inicio, $fin);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        //$lastRow = $sheet->getHighestDataRow() + 1;

        $sheet->setCellValue('B5', 'NUMERO EMPLEADO');
        $sheet->getColumnDimension('B')->setWidth(25);

        $sheet->setCellValue('C5', 'APELLIDO PATERNO DEL EMPLEADO');
        $sheet->getColumnDimension('C')->setWidth(40);

        $sheet->setCellValue('D5', 'APELLIDO MATERNO DEL EMPLEADO');
        $sheet->getColumnDimension('D')->setWidth(40);

        $sheet->setCellValue('E5', 'NOMBRE DEL EMPLEADO');
        $sheet->getColumnDimension('E')->setWidth(30);

        $sheet->setCellValue('F5', 'CUENTA');
        $sheet->getColumnDimension('F')->setWidth(30);

        $sheet->setCellValue('G5', 'IMPORTE');
        $sheet->getColumnDimension('G')->setWidth(25);

        $sheet->setCellValue('H5', 'ID_CONCEPTO');
        $sheet->getColumnDimension('H')->setWidth(35);

        $sheet->setCellValue('I5', 'NOMBRE DEL BANCO');
        $sheet->getColumnDimension('I')->setWidth(35);



        $numero = 1; // Comenzar contador desde aqui 
        foreach ($archive as $key) {


            $nombre = strtoupper($key->nombre);
            $nombre_sin_acentos = strtoupper(iconv('UTF-8', 'ASCII//IGNORE//TRANSLIT', $nombre));

            $ap = strtoupper($key->apellido_paterno);
            $ap_sin_acentos = strtoupper(iconv('UTF-8', 'ASCII//IGNORE//TRANSLIT', $ap));

            $am = strtoupper($key->apellido_materno);
            $am_sin_acentos = strtoupper(iconv('UTF-8', 'ASCII//IGNORE//TRANSLIT', $am));

            $nombre_sin_acentos = str_replace(["'", '"'], '', $nombre_sin_acentos);
            $ap_sin_acentos = str_replace(["'", '"'], '', $ap_sin_acentos);
            $am_sin_acentos = str_replace(["'", '"'], '', $am_sin_acentos);

            $motivo = "08 OTROS PAGOS POR TRANSFERENCIA";

            //echo $numero;

            $sheet->setCellValue('B' . (5 + $numero), $numero); // Insertar el número del contador
            $sheet->setCellValue('C' . (5 + $numero), $ap_sin_acentos);
            $sheet->setCellValue('D' . (5 + $numero), $am_sin_acentos);
            $sheet->setCellValue('E' . (5 + $numero), $nombre_sin_acentos);
            $sheet->setCellValue('F' . (5 + $numero), $key->numero_cuenta);
            $sheet->setCellValue('G' . (5 + $numero), $key->sueldo_quincenal_total);
            $sheet->setCellValue('H' . (5 + $numero), $motivo);
            $sheet->setCellValue('I' . (5 + $numero), strtoupper($key->nombre_banco));

            $columnasCentradas = ['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];

            foreach ($columnasCentradas as $columna) {
                $sheet->getStyle($columna . (5 + $numero))->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            }

            $numero++;


        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($excelFilePath);

        // Descargar el archivo o realizar cualquier otra acción necesaria
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombre_doc . '"');
        header('Cache-Control: max-age=0');
        header('Content-Type: text/html; charset=utf-8');


        //$writer->save('php://output');
        readfile($excelFilePath);
        exit();

    }

    public function terminations()
    {
        $nominaModel = new NominaModel();
        $finiquito = $nominaModel->getFiniquito();
        $pagados = $nominaModel->getPagados();

        $data = ['datoFin' => $finiquito, 'pagados' => $pagados];

        /*echo "<pre>";
        print_r($data);
        echo "</pre>";*/
        //exit();

        return view("comercial/administracionGeneral/nomina/finiquitos", $data);

    }

    public function savefiniquito()
    {

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();*/
        $session = session();
        $id_nomina = $this->request->getPost('id_nomina');
        $total_finiquito = $this->request->getPost('total_finiquito');
        $f_egreso = $this->request->getPost('f_egreso');

        $id_usuario = $this->request->getPost('id_usuario');
        $antiguedad = $this->request->getPost('antiguedad');
        $f_ingreso = $this->request->getPost('f_ingreso');
        $pago_mensual = $this->request->getPost('pago_mensual');
        $sueldo_diario = $this->request->getPost('sueldo_diario');
        $aguinaldo = $this->request->getPost('aguinaldo');
        $vacaciones = $this->request->getPost('vacaciones');
        $total = $this->request->getPost('total');
        $dias = $this->request->getPost('dias');
        $proporcional = $this->request->getPost('proporcional');
        $antiguedad1 = $this->request->getPost('antiguedad1');
        $total_vacaciones = $this->request->getPost('total_vacaciones');
        $legal = $this->request->getPost('legal');
        $pv = $this->request->getPost('pv');
        $total_pv = $this->request->getPost('total_pv');
        $sueldo_diario2 = $this->request->getPost('sueldo_diario2');
        $total_sp = $this->request->getPost('total_sp');
        $antiguedad2 = $this->request->getPost('antiguedad2');
        $factor = $this->request->getPost('factor');
        $factor1 = $this->request->getPost('factor1');
        $sd = $this->request->getPost('sd');
        $ap = $this->request->getPost('ap');
        $t_aguinaldo = $this->request->getPost('t_aguinaldo');
        $t_vacaciones = $this->request->getPost('t_vacaciones');
        $t_sp = $this->request->getPost('t_sp');
        $dias_laborados = $this->request->getPost('dias_laborados');


        $nominaModel = new NominaModel();

        $finiquito = $nominaModel->setFiniquito(
            $id_nomina,
            $total_finiquito,
            $f_egreso,
            $t_aguinaldo,
            $t_vacaciones,
            $total_pv,
            $t_sp,
            $vacaciones,
            $total,
            $proporcional,
            $legal,
            $dias_laborados,
            $aguinaldo,
            $factor
        );

        if ($finiquito) {
            $mensaje = "Finiquito generado con éxito.";
            $session->setFlashdata('sucess_message', $mensaje);
            return redirect()->to(base_url("home/nomina/terminations"));

        } else {

            $mensaje = "Algo salio mal.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/nomina/terminations"));

        }

    }

    public function severance($id_usuario = NULL, $id_nomina = NULL)
    {
        $session = session();
        $nominaModel = new NominaModel();

        $finiquito = $nominaModel->getDetailsFiniquito($id_usuario, $id_nomina);

        $data = ['finiquito' => $finiquito];

        /*echo "<pre>";
        print_r($data);
        echo "</pre>";*/
        return view("comercial/administracionGeneral/nomina/detalleFiniquito", $data);
    }

    public function deleteseverance($id_nomina = NULL)
    {
        $session = session();
        $nominaModel = new NominaModel();
        $delete = $nominaModel->deleteseverance($id_nomina);

        if ($delete) {
            $mensaje = "Finiquito eliminado con éxito.";
            $session->setFlashdata('sucess_message', $mensaje);
            return redirect()->to(base_url("home/nomina/terminations"));

        } else {

            $mensaje = "Algo salio mal.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/nomina/terminations"));

        }


    }

    public function deletePeriodo($periodo = null, $mes = null, $fecha_inic = null, $fecha_fin = null)
    {

        $session = session();
        $periodo = trim($periodo);
        $mes = trim($mes);

        $nominaModel = new NominaModel();
        $detete = $nominaModel->deletePago($periodo, $mes, $fecha_inic, $fecha_fin);

        if ($detete) {
            $mensaje = "Finiquito eliminado con éxito.";
            $session->setFlashdata('sucess_message', $mensaje);
            return redirect()->to(base_url("home/nomina"));

        } else {

            $mensaje = "Algo salio mal.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/nomina"));

        }

    }

    public function overtimes()
    {
        $session = session();
        $user_id = $session->get('user_id');
        $nominaModel = new NominaModel();

        $nomina = $nominaModel->getPeriodsColab($user_id);

        /*echo "<pre>";
        print_r($nomina);
        echo "</pre>";*/

        $data = ['periodos' => $nomina];

        return view("colaboradores/nomina/nomina", $data);

    }

    public function saveFirma()
    {

        $session = session();
        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/
        //exit();
        $user_id = $session->get('user_id');
        $id_periodo = $this->request->getPost('id_periodo');
        $firma = $this->request->getPost('firma');
        $nombre = $this->request->getPost('nombre');
        $firmado = "SI";
        $nominaModel = new NominaModel();


        $name = $nominaModel->getName($user_id);

        $data = $name[0];
        $n = $data->nombre;
        $ap = $data->apellido_paterno;
        $am = $data->apellido_materno;
        $nc = strtoupper($n . " " . $ap . " " . $am);

        if ($nombre != $nc) {

            $mensaje = "INTRODUCE TU NOMBRE COMPLETO SIN MAYUSCULAS Y SIN ACENTOS EJEM: Nombre1 Nombre2 Apellido1 Apellido2.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/index/receipt/$id_periodo"));
        } else {
            $nominaModel->saveFirma($firmado, $id_periodo);

            $mensaje = "DOCUMENTO FIRMADO CON ÉXITO.";
            $session->setFlashdata('sucess_message', $mensaje);
            return redirect()->to(base_url("home/index/receipt/$id_periodo"));

        }

    }

    public function receipts()
    {

        $nominaModel = new NominaModel();

        $nomina = $nominaModel->getRecibos();

        $data = ['periodos' => $nomina];

        return view("comercial/administracionGeneral/nomina/colaborators/firmados", $data);

    }
    public function receiptss()
    {

        $nominaModel = new NominaModel();

        $nomina = $nominaModel->getRecibos();

        $data = ['periodos' => $nomina];

        return view("direccion/nomina/firmados", $data);

    }

    public function receipt($id_periodo = NULL)
    {

        $session = session();

        $nominaModel = new NominaModel();
        $nomina = $nominaModel->getReciboColab($id_periodo);
        $data = ['finiquito' => $nomina, 'periodo' => $id_periodo];

        return view("colaboradores/nomina/recibo", $data);


        /*echo "<pre>";
        print_r($nomina);
        echo "</pre>";*/


    }
    public function guardarCambios()
    {


        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();*/

        $session = session();
        $id_periodo = $this->request->getPost('id_periodo');
        $año = $this->request->getPost('año');
        $mes = $this->request->getPost('mes');
        $n_banco = $this->request->getPost('n_banco');
        $sueldo_base = $this->request->getPost('sueldo_base');
        $monto_quincena = $this->request->getPost('monto_quincena');
        $fecha_inicio = $this->request->getPost('fecha_inicio');
        $fecha_fin = $this->request->getPost('fecha_fin');
        $trabajados = $this->request->getPost('trabajados');
        $estado = $this->request->getPost('estado');
        $inicio = $this->request->getPost('inicio');
        $fin = $this->request->getPost('fin');
        //
        $home_office = $this->request->getPost('home_office');
        $p_dia_extra = $this->request->getPost('p_dia_extra');
        $bon_extra = $this->request->getPost('bon_extra');
        $com_extra = $this->request->getPost('com_extra');


        $nominaModel = new NominaModel();
        $update = $nominaModel->updateNomina($fecha_inicio, $fecha_fin, $trabajados, $sueldo_base, $home_office, $p_dia_extra, $bon_extra, $com_extra, $id_periodo);

        if ($update){

            $mensaje = "Periodo editado con éxito.";
            $session->setFlashdata('sucess_message', $mensaje);
            return redirect()->to(base_url("home/periods/$año/$mes/$n_banco/$estado/$inicio/$fin"));
        } else {

            $mensaje = "Algo salió mal.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/periods/$año/$mes/$n_banco/$estado/$inicio/$fin"));

        }


        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();*/
    }
    public function receiptt($id_periodo = NULL)
    {

        $session = session();

        $nominaModel = new NominaModel();
        $nomina = $nominaModel->getReciboColab($id_periodo);
        $data = ['finiquito' => $nomina, 'periodo' => $id_periodo];

        return view("comercial/administracionGeneral/nomina/recibo", $data);


        /*echo "<pre>";
        print_r($nomina);
        echo "</pre>";*/
    }

    //aprobar nomina de ADMIN
    public function aprov($periodo = null, $mes = null, $nombre_banco = null, $estado = null, $fecha_inic = null, $fecha_fin = null)
    {

        $session = session();
        $user_id = $session->get('user_id');
        $nominaModel = new nominaModel();
        $firma = $nominaModel->f2($user_id, $periodo, $mes, $fecha_inic, $fecha_fin);

        if ($firma) {

            $mensaje = "Procesado y firmado con éxito.";
            $session->setFlashdata('sucess_message', $mensaje);
            return redirect()->to(base_url("home/periods/$periodo/$mes/$nombre_banco/$estado/$fecha_inic/$fecha_fin"));

        } else {

            $mensaje = "Algo salio mal.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/periods/$periodo/$mes/$nombre_banco/$estado/$fecha_inic/$fecha_fin"));

        }

    
        
    }

    //Ing-Lic
    public function history()
    {


        $nominaModel = new NominaModel();
        $periodos = $nominaModel->periodos();

        $data = ['periodos' => $periodos];

        return view("direccion/nomina/periodos", $data);

    }

    public function signature($periodo = null, $mes = null, $estado = null, $fecha_inic = null, $fecha_fin = null)
    {

        $period = trim($periodo);
        $mes = trim($mes);

        $nominaModel = new NominaModel();
        $periodo = $nominaModel->periods($period, $mes, $estado, $fecha_inic, $fecha_fin);
        $data = ['periodo' => $periodo, 'año' => $period, 'mes' => $mes, 'estado' =>$estado, 'inicio' => $fecha_inic, 'fin' => $fecha_fin];

        return view("direccion/nomina/nomina", $data);

    }

    public function banks($periodo = null, $mes = null, $nombre_banco = null, $estado = null, $inicio = null, $fin = null)
    {

        $session = session();
        $nominaModel = new nominaModel();
        $periods = $nominaModel->getPeriods($periodo, $mes, $nombre_banco, $estado, $inicio, $fin);
        $data = ['periodos' => $periods, 'año' => $periodo, 'mes' => $mes, 'nombreB' => $nombre_banco, 'estado' => $estado, 'inicio'=>$inicio, 'fin'=>$fin];
        return view('direccion/nomina/firma', $data);

    }

    //aprobar nomina de Ing-Lic
    public function admit($periodo = null, $mes = null, $nombre_banco = null, $estado = null, $inicio = null, $fin = null)
    {

        $session = session();
        $user_id = $session->get('user_id');
        $nominaModel = new nominaModel();

        if($user_id == '5'){
        $firma = $nominaModel->f4($user_id, $periodo, $mes, $inicio, $fin);
        if ($firma) {

            $mensaje = "Procesado y firmado con éxito.";
            $session->setFlashdata('sucess_message', $mensaje);
            return redirect()->to(base_url("home/banks/$periodo/$mes/$nombre_banco/$estado/$inicio/$fin"));

        } else {

            $mensaje = "Algo salio mal.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/banks/$periodo/$mes/$nombre_banco/$estado/$inicio/$fin"));

        }

        } elseif($user_id == '6'){
            $firma = $nominaModel->f1($user_id, $periodo, $mes, $inicio, $fin);

            if ($firma) {

                $mensaje = "Procesado y firmado con éxito.";
                $session->setFlashdata('sucess_message', $mensaje);
                return redirect()->to(base_url("home/banks/$periodo/$mes/$nombre_banco/$estado/$inicio/$fin"));
    
            } else {
    
                $mensaje = "Algo salio mal.";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/banks/$periodo/$mes/$nombre_banco/$estado/$inicio/$fin"));
    
            }
        }

        

    
        
    }

    public function capital()
    {

        $nominaModel = new NominaModel();
        $periodos = $nominaModel->periodos();
        $data = ['periodos' => $periodos];
        return view("comercial/capitalHumanoGeneral/nomina/periodos", $data);


    }

    public function accept($periodo = null, $mes = null, $estado = null, $fecha_inic = null, $fecha_fin = null)
    {

        $period = trim($periodo);
        $mes = trim($mes);

        $nominaModel = new NominaModel();
        $periodo = $nominaModel->periods($period, $mes, $estado, $fecha_inic, $fecha_fin);
        $data = ['periodo' => $periodo, 'año' => $period, 'mes' => $mes, 'estado' =>$estado, 'inicio' => $fecha_inic, 'fin' => $fecha_fin];

        return view("comercial/capitalHumanoGeneral/nomina/nomina", $data);

    }

    public function data($periodo = null, $mes = null, $nombre_banco = null, $estado = null, $fecha_inic = null, $fecha_fin = null)
    {

        $nominaModel = new nominaModel();
        $periods = $nominaModel->getPeriods($periodo, $mes, $nombre_banco, $estado, $fecha_inic, $fecha_fin);
        $data = ['periodos' => $periods, 'año' => $periodo, 'estado'=>$estado, 'mes' => $mes, 'nombreB' => $nombre_banco,  'inicio'=>$fecha_inic, 'fin'=>$fecha_fin];
        return view('comercial/capitalHumanoGeneral/nomina/firma', $data);

    }

    //aprobar nomina de RH
    public function access($periodo = null, $mes = null, $nombre_banco = null, $estado = null, $fecha_inic = null, $fecha_fin = null)
    {

        $session = session();
        $user_id = $session->get('user_id');
        $nominaModel = new nominaModel();
        $firma = $nominaModel->f3($user_id, $periodo, $mes, $fecha_inic, $fecha_fin);

        if ($firma) {

            $mensaje = "Procesado y firmado con éxito.";
            $session->setFlashdata('sucess_message', $mensaje);
            return redirect()->to(base_url("home/data/$periodo/$mes/$nombre_banco/$estado/$fecha_inic/$fecha_fin"));

        } else {

            $mensaje = "Algo salio mal.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/data/$periodo/$mes/$nombre_banco/$estado/$fecha_inic/$fecha_fin"));

        }

    
        
    }

}