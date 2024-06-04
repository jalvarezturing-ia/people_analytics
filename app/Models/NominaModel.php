<?php


namespace App\Models;

use CodeIgniter\Model;

class NominaModel extends Model
{

    public function periodos()
    {
        $query = $this->db->query("SELECT periodo, mes, pagada, COUNT(*) 
        as colaboradores,
                c1.nombre AS nombre_f1,
            c2.nombre AS nombre_f2,
            c3.nombre AS nombre_f3,
            c4.nombre AS nombre_f4,
            pago_nomina.fecha_inicio_quincena, 
            pago_nomina.fecha_fin_quincena 
            FROM pago_nomina
            LEFT JOIN 
            colaboradores c1 ON c1.id = pago_nomina.f1
        LEFT JOIN 
            colaboradores c2 ON c2.id = pago_nomina.f2
        LEFT JOIN 
            colaboradores c3 ON c3.id = pago_nomina.f3
        LEFT JOIN 
            colaboradores c4 ON c4.id = pago_nomina.f4
            
                GROUP BY periodo, mes, pago_nomina.pagada, pago_nomina.fecha_inicio_quincena, pago_nomina.fecha_fin_quincena
                ORDER BY periodo DESC, FIELD(mes, 'dicembre', 'noviembre', 'octubre', 'septiembre', 'agosto', 'julio', 'junio', 'mayo', 'abril', 'marzo', 'febrero', 'enero'),
                pago_nomina.fecha_inicio_quincena DESC");

        return $query->getResult();
    }

    public function nominas()
    {
        $query = $this->db->query('SELECT colaboradores.nombre, nominas.* 
        FROM nominas 
        INNER JOIN colaboradores ON colaboradores.id = nominas.id_usuario');

        return $query->getResult();
    }

    public function periods($period, $mes, $estado, $inicio, $fin)
    {
    

        $query = $this->db->query('SELECT nominas.nombre_banco, pago_nomina.periodo, pago_nomina.mes, pago_nomina.pagada, 
        COUNT(*) AS cantidad_registros 
        FROM nominas 
        INNER JOIN pago_nomina ON pago_nomina.id_nomina = nominas.id 
        WHERE pago_nomina.periodo = ?
        AND pago_nomina.mes = ?
        AND pago_nomina.pagada = ?
        AND pago_nomina.fecha_inicio_quincena = ?
        AND pago_nomina.fecha_fin_quincena = ?
        GROUP BY nominas.nombre_banco, pago_nomina.pagada, pago_nomina.fecha_inicio_quincena, pago_nomina.fecha_fin_quincena;',
            [$period, $mes, $estado,  $inicio, $fin]
        );

        return $query->getResult();
    }

    public function getAllColabs()
    {
        $query = $this->db->query('SELECT colaboradores.id, colaboradores.nombre, colaboradores.correo, 
        colaboradores.apellido_paterno,colaboradores.apellido_materno, datos_personales.fecha_ingreso 
        FROM colaboradores 
        LEFT JOIN nominas 
        ON nominas.id_usuario = colaboradores.id 
        LEFT JOIN datos_personales 
        ON datos_personales.id_usuario = colaboradores.id 
        WHERE nominas.id 
        IS NULL AND colaboradores.nombre != "turing-ia" 
        AND colaboradores.nombre 
        NOT LIKE "%Noe Alejandro%"
        AND colaboradores.nombre NOT LIKE "%Jessica%"');

        return $query->getResult();
    }

    public function saveNomina($id_usuario, $nombre_banco, $numero_cuenta, $clabe_interbancaria, $pago_mensual_base, $pago_quincenal, $sueldo_diario)
    {

        $query = $this->db->query(
            "INSERT INTO nominas (id_usuario, nombre_banco, numero_cuenta, clabe_interbancaria, pago_mensual_base, pago_quincenal, sueldo_diario)
            VALUES ('$id_usuario', '$nombre_banco', '$numero_cuenta', '$clabe_interbancaria', '$pago_mensual_base', '$pago_quincenal', '$sueldo_diario')"
        );

        //return $query->getResult();
        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getNominas()
    {
        $query = $this->db->query('SELECT DISTINCT nominas.id_usuario, nominas.id as id_nomina, colaboradores.nombre, 
         colaboradores.apellido_paterno,colaboradores.apellido_materno, 
         datos_personales.fecha_ingreso, nominas.pago_mensual_base 
        FROM nominas INNER JOIN colaboradores on colaboradores.id = nominas.id_usuario 
        LEFT JOIN pago_nomina ON pago_nomina.id_nomina = nominas.id 
        INNER JOIN datos_personales ON datos_personales.id_usuario = colaboradores.id
        /*WHERE pago_nomina.id IS NULL*/
        AND datos_personales.fecha_egreso = "0"');

        return $query->getResult();

    }

    public function saveperiod($idNomina, $periodo, $mes, $fechaInicioQuincena, $fechaFinQuincena, $diasTrabajados, $sueldoFinal, $pagada, $firmada)
    {

        $query = $this->db->query(
            "INSERT INTO pago_nomina (id_nomina, periodo, mes, fecha_inicio_quincena, fecha_fin_quincena, dias_trabajados, sueldo_final, pagada, firmado)
            VALUES ('$idNomina', '$periodo', '$mes', '$fechaInicioQuincena', '$fechaFinQuincena', '$diasTrabajados', '$sueldoFinal', '$pagada' , '$firmada')"
        );

        //return $query->getResult();
        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }

    public function getPeriods($periodo, $mes, $nombre_banco, $estado, $inicio, $fin)
    {
        $query = $this->db->query('SELECT 
        pago_nomina.id as id_periodo,  
        nominas.id as id_nomina, 
        colaboradores.nombre, 
        colaboradores.apellido_paterno, 
        colaboradores.apellido_materno, 
        areas.descripcion, 
        areas.puesto, 
        nominas.nombre_banco, 
        nominas.clabe_interbancaria, 
        nominas.pago_mensual_base, 
        nominas.pago_quincenal, 
        nominas.sueldo_diario, 
        pago_nomina.fecha_inicio_quincena, 
        pago_nomina.fecha_fin_quincena,
        pago_nomina.dias_trabajados, 
        pago_nomina.sueldo_final,
        pagos_extras.home_office,
        pagos_extras.pago_dia_extra,
        pagos_extras.pago_bono_extra,
        pagos_extras.comision_extra,
        SUM(pago_nomina.sueldo_final + IFNULL(pagos_extras.home_office, 0) 
        + IFNULL(pagos_extras.pago_dia_extra, 0) 
        + IFNULL(pagos_extras.pago_bono_extra, 0) 
        + IFNULL(pagos_extras.comision_extra, 0)) 
        AS sueldo_final_total,
        SUM( nominas.pago_quincenal
        + IFNULL(pagos_extras.home_office, 0)/2
        /*+ IFNULL(pagos_extras.pago_dia_extra, 0) / 2  -- Divide entre dos
        + IFNULL(pagos_extras.pago_bono_extra, 0) / 2  -- Divide entre dos
        + IFNULL(pagos_extras.comision_extra, 0) / 2  -- Divide entre dos*/
        + IFNULL(pagos_extras.pago_dia_extra, 0)
        + IFNULL(pagos_extras.pago_bono_extra, 0) 
        + IFNULL(pagos_extras.comision_extra, 0)
        ) AS sueldo_quincenal_total
        FROM nominas 
        INNER JOIN colaboradores ON colaboradores.id = nominas.id_usuario 
        INNER JOIN pago_nomina ON pago_nomina.id_nomina = nominas.id 
        INNER JOIN areas ON areas.id_usuario = colaboradores.id 
        LEFT JOIN pagos_extras ON pagos_extras.id_nomina = nominas.id
        WHERE pago_nomina.periodo = ? 
        AND pago_nomina.mes = ?
        AND nominas.nombre_banco = ?
        AND pago_nomina.pagada = ?
        AND pago_nomina.fecha_inicio_quincena = ?
        AND pago_nomina.fecha_fin_quincena = ?
        GROUP BY 
        pago_nomina.id, nominas.id, colaboradores.nombre, areas.descripcion, areas.puesto, nominas.nombre_banco, nominas.clabe_interbancaria, nominas.pago_mensual_base, nominas.pago_quincenal, nominas.sueldo_diario, pago_nomina.fecha_fin_quincena, pago_nomina.dias_trabajados',
            [$periodo, $mes, $nombre_banco, $estado, $inicio, $fin]
        );



        return $query->getResult();
    }

    public function deletePeriod($id_periodo)
    {

        $query = $this->db->query(
            'DELETE FROM pago_nomina WHERE pago_nomina.id = ? LIMIT 1',
            [$id_periodo]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function saveExtras($id_nomina, $home_office, $dias_extras, $pago_dia_extra, $bono_extra, $pago_bono_extra, $comision_extra)
    {


        $query = $this->db->query(
            "INSERT INTO pagos_extras (id_nomina, home_office, dias_extras, pago_dia_extra, bono_extra, pago_bono_extra, comision_extra)
            VALUES ('$id_nomina', '$home_office', '$dias_extras', '$pago_dia_extra', '$bono_extra', '$pago_bono_extra', '$comision_extra')"
        );

        //return $query->getResult();
        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getdataarchive($periodo, $mes, $estado, $inicio, $fin)
    {

        $query = $this->db->query('SELECT 
        colaboradores.nombre, 
        colaboradores.apellido_paterno,
        colaboradores.apellido_materno,
        nominas.nombre_banco, 
        nominas.numero_cuenta,
        SUM(pago_nomina.sueldo_final + IFNULL(pagos_extras.home_office, 0) 
                + IFNULL(pagos_extras.pago_dia_extra, 0) 
                + IFNULL(pagos_extras.pago_bono_extra, 0) 
                + IFNULL(pagos_extras.comision_extra, 0)) 
                AS sueldo_final_total,
                SUM( nominas.pago_quincenal
                + IFNULL(pagos_extras.home_office, 0)/2
                + IFNULL(pagos_extras.pago_dia_extra, 0) / 2  -- Divide entre dos
                + IFNULL(pagos_extras.pago_bono_extra, 0) / 2  -- Divide entre dos
                + IFNULL(pagos_extras.comision_extra, 0) / 2  -- Divide entre dos
                ) AS sueldo_quincenal_total
                FROM nominas 
                INNER JOIN colaboradores ON colaboradores.id = nominas.id_usuario
                LEFT JOIN pago_nomina ON pago_nomina.id_nomina = nominas.id 
                LEFT JOIN pagos_extras ON pagos_extras.id_nomina = nominas.id
                WHERE pago_nomina.periodo = ?
                AND pago_nomina.mes = ?
                AND pago_nomina.pagada = ?
                AND pago_nomina.fecha_inicio_quincena = ?
                AND pago_nomina.fecha_fin_quincena = ?
                 GROUP BY 
                pago_nomina.id, nominas.id, colaboradores.nombre, 
        nominas.nombre_banco, 
        nominas.numero_cuenta
        ORDER BY 
        CASE WHEN nominas.nombre_banco = "Santander" THEN 1 ELSE 2 END,  -- Pone Santander primero
            colaboradores.apellido_paterno ASC;',
            [$periodo, $mes, $estado, $inicio, $fin]
        );



        return $query->getResult();

    }

    public function setpagados($pagado, $periodo, $mes, $inicio, $fin)
    {
        $query = $this->db->query(
            'UPDATE pago_nomina SET pagada = ? WHERE periodo = ? AND mes = ? AND fecha_inicio_quincena = ? AND fecha_fin_quincena = ?',
            [$pagado, $periodo, $mes, $inicio, $fin]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }

    public function getFiniquito()
    {
        $query = $this->db->query('SELECT
            colaboradores.id as id_usuario,
            nominas.id as id_nomina,
            colaboradores.nombre,
            colaboradores.apellido_paterno,
            colaboradores.apellido_materno,
            datos_personales.fecha_ingreso,
            datos_personales.fecha_egreso,
            DATEDIFF(datos_personales.fecha_egreso, datos_personales.fecha_ingreso) AS diferencia_dias,
            nominas.pago_mensual_base,
            nominas.sueldo_diario,
            SUM(
            nominas.pago_mensual_base +
            IFNULL(pagos_extras.home_office, 0) +
            IFNULL(pagos_extras.pago_dia_extra, 0) +
            IFNULL(pagos_extras.pago_bono_extra, 0) +
            IFNULL(pagos_extras.comision_extra, 0)
                ) AS sueldo_final_total
            FROM
                colaboradores
            LEFT JOIN
                datos_personales ON colaboradores.id = datos_personales.id_usuario
            LEFT JOIN
                nominas ON colaboradores.id = nominas.id_usuario
            LEFT JOIN 
                pago_nomina ON nominas.id = pago_nomina.id_nomina
            LEFT JOIN 
                pagos_extras ON nominas.id = pagos_extras.id_nomina
            LEFT JOIN 
            	finiquito_liquidacion ON finiquito_liquidacion.id_nomina = nominas.id
            WHERE
                datos_personales.fecha_egreso != 0
            AND 
            	finiquito_liquidacion.id IS NULL
            GROUP BY
                colaboradores.id,
                colaboradores.nombre,
                datos_personales.fecha_ingreso,
                datos_personales.fecha_egreso,
                nominas.pago_mensual_base,
                nominas.sueldo_diario');

        return $query->getResult();
    }

    public function setFiniquito($id_nomina, $total_finiquito, $f_egreso,   $t_aguinaldo, $t_vacaciones, $total_pv, $t_sp,$vacaciones,$total, $proporcional,$legal,$dias_laborados,$aguinaldo,$factor) 
    {

        $query = $this->db->query(
            "INSERT INTO finiquito_liquidacion (id_nomina, monto_finiquito, fecha_finiquito, t_aguinaldo, t_vacaciones, total_pv, t_sp, dias_vacaciones, total_factor, proporcional, legal, dias_laborados, dias_aguinaldo, numero_factor ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [$id_nomina,$total_finiquito,$f_egreso,$t_aguinaldo,$t_vacaciones,$total_pv, $t_sp, $vacaciones,$total, $proporcional,$legal,$dias_laborados, $aguinaldo,$factor
            ]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getPagados()
    {
        $query = $this->db->query('SELECT
        colaboradores.id as id_usuario,
        nominas.id as id_nomina,
        colaboradores.nombre,
        colaboradores.apellido_paterno,
        colaboradores.apellido_materno,
        datos_personales.fecha_ingreso,
        datos_personales.fecha_egreso,
        nominas.pago_mensual_base,
        nominas.sueldo_diario,
        finiquito_liquidacion.monto_finiquito, 
        finiquito_liquidacion.fecha_finiquito,
        SUM(
        nominas.pago_mensual_base +
        IFNULL(pagos_extras.home_office, 0) +
        IFNULL(pagos_extras.pago_dia_extra, 0) +
        IFNULL(pagos_extras.pago_bono_extra, 0) +
        IFNULL(pagos_extras.comision_extra, 0)
            ) AS sueldo_final_total
        FROM
            colaboradores
        LEFT JOIN
            datos_personales ON colaboradores.id = datos_personales.id_usuario
        LEFT JOIN
            nominas ON colaboradores.id = nominas.id_usuario
        LEFT JOIN 
            pago_nomina ON nominas.id = pago_nomina.id_nomina
        LEFT JOIN 
            pagos_extras ON nominas.id = pagos_extras.id_nomina
        INNER JOIN 
            finiquito_liquidacion ON finiquito_liquidacion.id_nomina = nominas.id
        WHERE
            datos_personales.fecha_egreso != 0
        GROUP BY
            colaboradores.id,
            colaboradores.nombre,
            datos_personales.fecha_ingreso,
            datos_personales.fecha_egreso,
            nominas.pago_mensual_base,
            nominas.sueldo_diario');

        return $query->getResult();
    }

    public function getDetailsFiniquito($id_usuario, $id_nomina)
    {

        $query = $this->db->query('SELECT
        colaboradores.id as id_usuario,
        nominas.id as id_nomina,
        colaboradores.nombre,
        colaboradores.apellido_paterno,
        colaboradores.apellido_materno,
        datos_personales.fecha_ingreso,
        datos_personales.fecha_egreso,
        nominas.pago_mensual_base,
        nominas.sueldo_diario,
        finiquito_liquidacion.*,
        SUM(
        nominas.pago_mensual_base +
        IFNULL(pagos_extras.home_office, 0) +
        IFNULL(pagos_extras.pago_dia_extra, 0) +
        IFNULL(pagos_extras.pago_bono_extra, 0) +
        IFNULL(pagos_extras.comision_extra, 0)
            ) AS sueldo_final_total,
        DATEDIFF(datos_personales.fecha_egreso, datos_personales.fecha_ingreso) AS diferencia_dias
        FROM
            colaboradores
        LEFT JOIN
            datos_personales ON colaboradores.id = datos_personales.id_usuario
        LEFT JOIN
            nominas ON colaboradores.id = nominas.id_usuario
        LEFT JOIN 
            pago_nomina ON nominas.id = pago_nomina.id_nomina
        LEFT JOIN 
            pagos_extras ON nominas.id = pagos_extras.id_nomina
        INNER JOIN 
            finiquito_liquidacion ON finiquito_liquidacion.id_nomina = nominas.id
        WHERE
            datos_personales.fecha_egreso != 0
        AND 
        	colaboradores.id = ?
        AND 
        	nominas.id = ?
        GROUP BY
            colaboradores.id,
            colaboradores.nombre,
            datos_personales.fecha_ingreso,
            datos_personales.fecha_egreso,
            nominas.pago_mensual_base,
            nominas.sueldo_diario',
            [$id_usuario, $id_nomina]
        );



        return $query->getResult();

    }

    public function deleteseverance($id_nomina)
    {

        $query = $this->db->query(
            'DELETE FROM finiquito_liquidacion WHERE id_nomina = ? LIMIT 1',
            [$id_nomina]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }


    public function deletePago($periodo, $mes, $fecha_inic, $fecha_fin)
    {

        $query = $this->db->query(
            'DELETE FROM pago_nomina WHERE periodo = ? AND mes = ? AND fecha_inicio_quincena = ? AND fecha_fin_quincena = ?',
            [$periodo, $mes, $fecha_inic, $fecha_fin]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getPeriodsColab($id_usuario)
    {
        $query = $this->db->query('SELECT 
        pago_nomina.id as id_periodo,  
        nominas.id as id_nomina, 
        colaboradores.nombre, 
        colaboradores.apellido_paterno, 
        colaboradores.apellido_materno, 
        nominas.nombre_banco, 
        nominas.clabe_interbancaria, 
        nominas.pago_mensual_base, 
        nominas.pago_quincenal, 
        nominas.sueldo_diario, 
        pago_nomina.fecha_inicio_quincena, 
        pago_nomina.fecha_fin_quincena,

        pago_nomina.dias_trabajados, 
        pago_nomina.sueldo_final,
        pago_nomina.firmado,
        pagos_extras.home_office,
        pagos_extras.pago_dia_extra,
        pagos_extras.pago_bono_extra,
        pagos_extras.comision_extra,
        SUM(pago_nomina.sueldo_final + IFNULL(pagos_extras.home_office, 0) 
        + IFNULL(pagos_extras.pago_dia_extra, 0) 
        + IFNULL(pagos_extras.pago_bono_extra, 0) 
        + IFNULL(pagos_extras.comision_extra, 0)) 
        AS sueldo_final_total,
        SUM( nominas.pago_quincenal
        + IFNULL(pagos_extras.home_office, 0)/2
        + IFNULL(pagos_extras.pago_dia_extra, 0) / 2  -- Divide entre dos
        + IFNULL(pagos_extras.pago_bono_extra, 0) / 2  -- Divide entre dos
        + IFNULL(pagos_extras.comision_extra, 0) / 2  -- Divide entre dos
        ) AS sueldo_quincenal_total
        FROM nominas 
        INNER JOIN colaboradores ON colaboradores.id = nominas.id_usuario 
        INNER JOIN pago_nomina ON pago_nomina.id_nomina = nominas.id 
        INNER JOIN areas ON areas.id_usuario = colaboradores.id 
        LEFT JOIN pagos_extras ON pagos_extras.id_nomina = nominas.id
        WHERE colaboradores.id = ?
        AND (pago_nomina.f1 != 0 AND pago_nomina.f2 != 0 AND pago_nomina.f3 != 0 AND pago_nomina.f4 != 0)
        GROUP BY 
        pago_nomina.id, nominas.id, colaboradores.nombre, areas.descripcion, areas.puesto, nominas.nombre_banco, nominas.clabe_interbancaria,  nominas.pago_mensual_base, nominas.pago_quincenal, nominas.sueldo_diario, pago_nomina.fecha_inicio_quincena, pago_nomina.fecha_fin_quincena, pago_nomina.dias_trabajados
        ORDER BY  pago_nomina.fecha_inicio_quincena DESC',
            [$id_usuario]
        );



        return $query->getResult();
    }

    public function saveFirma($firmado, $id_periodo)
    {

        $query = $this->db->query(
            "UPDATE pago_nomina SET firmado = ? WHERE id = ?",
            [$firmado, $id_periodo]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getRecibos()
    {

        $query = $this->db->query('SELECT 
        pago_nomina.id as id_periodo,  
        nominas.id as id_nomina, 
        colaboradores.nombre, 
        colaboradores.apellido_paterno, 
        colaboradores.apellido_materno, 
        nominas.nombre_banco, 
        nominas.clabe_interbancaria, 
        nominas.pago_mensual_base, 
        nominas.pago_quincenal, 
        nominas.sueldo_diario, 
        pago_nomina.fecha_inicio_quincena, 
        pago_nomina.fecha_fin_quincena,
        pago_nomina.dias_trabajados, 
        pago_nomina.sueldo_final,
        pago_nomina.firmado,
        pagos_extras.home_office,
        pagos_extras.pago_dia_extra,
        pagos_extras.pago_bono_extra,
        pagos_extras.comision_extra,
        SUM(pago_nomina.sueldo_final + IFNULL(pagos_extras.home_office, 0) 
        + IFNULL(pagos_extras.pago_dia_extra, 0) 
        + IFNULL(pagos_extras.pago_bono_extra, 0) 
        + IFNULL(pagos_extras.comision_extra, 0)) 
        AS sueldo_final_total,
        SUM( nominas.pago_quincenal
        + IFNULL(pagos_extras.home_office, 0)/2
        + IFNULL(pagos_extras.pago_dia_extra, 0) / 2  -- Divide entre dos
        + IFNULL(pagos_extras.pago_bono_extra, 0) / 2  -- Divide entre dos
        + IFNULL(pagos_extras.comision_extra, 0) / 2  -- Divide entre dos
        ) AS sueldo_quincenal_total
        FROM nominas 
        INNER JOIN colaboradores ON colaboradores.id = nominas.id_usuario 
        INNER JOIN pago_nomina ON pago_nomina.id_nomina = nominas.id 
        INNER JOIN areas ON areas.id_usuario = colaboradores.id 
        LEFT JOIN pagos_extras ON pagos_extras.id_nomina = nominas.id
        WHERE pago_nomina.firmado = "SI"
        GROUP BY 
        pago_nomina.id, nominas.id, colaboradores.nombre, areas.descripcion, areas.puesto, nominas.nombre_banco, nominas.clabe_interbancaria, nominas.pago_mensual_base, nominas.pago_quincenal, nominas.sueldo_diario, pago_nomina.fecha_inicio_quincena, pago_nomina.fecha_fin_quincena,  pago_nomina.dias_trabajados
          ORDER BY  pago_nomina.fecha_inicio_quincena DESC');

        return $query->getResult();

    }

    public function getReciboColab($id_periodo)
    {
        $query = $this->db->query('SELECT 
        pago_nomina.id as id_periodo,  
        nominas.id as id_nomina, 
        colaboradores.nombre, 
        colaboradores.apellido_paterno, 
        colaboradores.apellido_materno, 
        nominas.nombre_banco, 
        areas.descripcion,
        nominas.clabe_interbancaria, 
        nominas.pago_mensual_base, 
        nominas.pago_quincenal, 
        nominas.sueldo_diario, 
        pago_nomina.fecha_inicio_quincena, 
        pago_nomina.fecha_fin_quincena,
        pago_nomina.dias_trabajados, 
        pago_nomina.sueldo_final,
        pago_nomina.firmado,
        pagos_extras.home_office,
        pagos_extras.pago_dia_extra,
        pagos_extras.pago_bono_extra,
        pagos_extras.comision_extra,
        SUM(pago_nomina.sueldo_final + IFNULL(pagos_extras.home_office, 0) 
        + IFNULL(pagos_extras.pago_dia_extra, 0) 
        + IFNULL(pagos_extras.pago_bono_extra, 0) 
        + IFNULL(pagos_extras.comision_extra, 0)) 
        AS sueldo_final_total,
        SUM( nominas.pago_quincenal
        + IFNULL(pagos_extras.home_office, 0)/2
        + IFNULL(pagos_extras.pago_dia_extra, 0) / 2  -- Divide entre dos
        + IFNULL(pagos_extras.pago_bono_extra, 0) / 2  -- Divide entre dos
        + IFNULL(pagos_extras.comision_extra, 0) / 2  -- Divide entre dos
        ) AS sueldo_quincenal_total
        FROM nominas 
        INNER JOIN colaboradores ON colaboradores.id = nominas.id_usuario 
        INNER JOIN pago_nomina ON pago_nomina.id_nomina = nominas.id 
        INNER JOIN areas ON areas.id_usuario = colaboradores.id 
        LEFT JOIN pagos_extras ON pagos_extras.id_nomina = nominas.id
        WHERE pago_nomina.id = ?
        GROUP BY 
        pago_nomina.id, nominas.id, colaboradores.nombre, areas.descripcion, areas.puesto, nominas.nombre_banco, nominas.clabe_interbancaria, nominas.pago_mensual_base, nominas.pago_quincenal, nominas.sueldo_diario, pago_nomina.fecha_inicio_quincena, pago_nomina.fecha_fin_quincena, pago_nomina.dias_trabajados
        ORDER BY  pago_nomina.fecha_inicio_quincena DESC;',
            [$id_periodo]
        );



        return $query->getResult();
    }
    public function getName($user_id)
    {
        $query = $this->db->query(
            'SELECT nombre, apellido_paterno, apellido_materno FROM colaboradores WHERE id = ?',
            [$user_id]
        );



        return $query->getResult();
    }

    public function f1($user_id, $periodo, $mes, $inicio, $fin) // LIC JESSI
    {

        $query = $this->db->query('UPDATE pago_nomina 
        SET pago_nomina.f1 = ? WHERE pago_nomina.periodo = ? AND pago_nomina.mes = ? AND pago_nomina.fecha_inicio_quincena = ?
        AND pago_nomina.fecha_fin_quincena = ?',
            [$user_id, $periodo, $mes, $inicio, $fin]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function f2($user_id, $periodo, $mes, $fecha_inic, $fecha_fin) //ADMIN LUIS
    {

        $query = $this->db->query('UPDATE pago_nomina 
        SET pago_nomina.f2 = ? WHERE pago_nomina.periodo = ? AND pago_nomina.mes = ? AND pago_nomina.fecha_inicio_quincena = ?
        AND pago_nomina.fecha_fin_quincena = ?',
            [$user_id, $periodo, $mes, $fecha_inic, $fecha_fin]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }



    }
    
    public function f3($user_id, $periodo, $mes, $fecha_inic, $fecha_fin) // CP MAY
    {

        $query = $this->db->query('UPDATE pago_nomina 
        SET pago_nomina.f3 = ? WHERE pago_nomina.periodo = ? AND pago_nomina.mes = ? AND pago_nomina.fecha_inicio_quincena = ?
        AND pago_nomina.fecha_fin_quincena = ?',
            [$user_id, $periodo, $mes, $fecha_inic, $fecha_fin]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }



    }

    public function f4($user_id, $periodo, $mes, $fecha_inic, $fecha_fin) //ING ALEJANDRO
    {

        $query = $this->db->query('UPDATE pago_nomina 
        SET pago_nomina.f4 = ? WHERE pago_nomina.periodo = ? AND pago_nomina.mes = ? AND pago_nomina.fecha_inicio_quincena = ?
        AND pago_nomina.fecha_fin_quincena = ?',
            [$user_id, $periodo, $mes, $fecha_inic, $fecha_fin]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }



    }

    public function updateNomina($fecha_inicio, $fecha_fin, $trabajados, $sueldo_base, $home_office, $p_dia_extra, $bon_extra, $com_extra, $id_periodo)
    {

        $query = $this->db->query('UPDATE pago_nomina 
              LEFT JOIN pagos_extras ON pagos_extras.id_nomina = pago_nomina.id_nomina
              SET pago_nomina.fecha_inicio_quincena = ?, pago_nomina.fecha_fin_quincena = ?, pago_nomina.dias_trabajados = ?, pago_nomina.sueldo_final = ?,
              pagos_extras.home_office = ?,  pagos_extras.pago_dia_extra = ?,  pagos_extras.pago_bono_extra = ?,  pagos_extras.comision_extra = ?
              WHERE pago_nomina.id = ?',
            [$fecha_inicio, $fecha_fin, $trabajados, $sueldo_base, $home_office, $p_dia_extra, $bon_extra, $com_extra, $id_periodo]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }


    }

}