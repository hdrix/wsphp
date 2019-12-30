<?php
include_once('database/database.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$database = new Database();

//$database->get_rows("SELECT * from ws limit 1;");

//$url         = "https://www.banguat.gob.gt/variables/ws/TipoCambio.asmx?wsdl";

//$url = "http://www.banguat.gob.gt/variables/ws/TipoCambio.asmx?wsdl";

$url = "http://www.banguat.gob.gt/variables/ws/TipoCambio.asmx?wsdl";
/*$client     = new SoapClient($url, array("trace" => 1, "exception" => 0)); */

$client = new SoapClient($url);

$response= $client->TipoCambioDia();
/*echo '<pre>';
var_dump($response->TipoCambioDiaResult->CambioDolar->VarDolar);
echo '</pre>';*/







//echo $response->TipoCambioDiaResult->CambioDolar->VarDolar->fecha;

$params = (object)[];
$params->fechainit = "29/12/2019";

$response2 = $client->TipoCambioFechaInicial($params);

$arr = $response2->TipoCambioFechaInicialResult->Vars->Var;
foreach ($arr as $key ) {
  $arr_date       =   explode('/',$key->fecha);
  $date =  date("Y-m-d", strtotime($arr_date[0]."-".$arr_date[1]."-".$arr_date[2]));

  if($database->exist("select fecha from tipocambio where fecha = '".$date."'; ")){
    continue;
  }
  $database->exec_query("insert ignore into tipocambio values (".$key->moneda.",'".$date."',".$key->venta.",".$key->compra.");");
  
}








/*$respuestaSaludar = $client->__soapCall('TipoCambioDia', array());
  echo '<pre>';
    var_dump($respuestaSaludar);
      echo '</pre>';
    echo $respuestaSaludar-;
  */
/*echo $client->sdl;
var_dump($client);*/
//$client->method("TipoCambioDia")
//var_dump($client->__getFunctions());

/*
$client = new SoapClient("https://svn.apache.org/repos/asf/airavata/sandbox/xbaya-web/test/Calculator.wsdl");*/


//working
/*
$url = "http://www.banguat.gob.gt/variables/ws/TipoCambio.asmx?wsdl";
$client = new SoapClient($url);
  $respuestaSaludar = $client->__soapCall('TipoCambioDia', array());
    print_r($respuestaSaludar);
*/

 $datos = $database->get_rows("select moneda, fecha, venta, compra from tipocambio order by fecha desc;");
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">  



   <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> 

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- DATATABLES -->

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>



    <style type="text/css" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"></style>
    <style type="text/css" src="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"></style>
    <!-- DATATABLES -->
    <title>Hello, world!</title>
  </head>
  <body>


<div class="container">












<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Moneda</th>
                <th>Fecha</th>
                <th>Venta</th>
                <th>Compra</th>

            </tr>
        </thead>
        <tbody>

            <?php

          
              foreach ($datos as $key ) {

                $signo = $key->moneda == 2? "$.":"Q.";
                $date_loop = date("d/m/Y", strtotime($key->fecha));
                echo "<tr> ".
                "<td> ".$signo."</td>".
                "<td> ".$date_loop."</td>".
                "<td> ".$key->venta."</td>".
                "<td> ".$key->compra."</td>".
                "</tr>";
              }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Moneda</th>
                <th>Fecha</th>
                <th>Venta</th>
                <th>Compra</th>
            </tr>
        </tfoot>
    </table>
























</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
   

    <script type="text/javascript">
      $(function(){
        $("#example").DataTable();
      });
      

    </script>
  </body>
</html>


