<?php
$id = $_GET['id'];
$acao = $_GET['acao'];
$tp = $_GET['tp'];
$id_cliente		= $_GET['id_cliente'];

include '../../config/mysql.php';
include '../../config/funcoes.php';
include '../../config/check.php';

$modulo 	= 'faturas';
$tabela 	= 'faturas';
$atributos 	= 'id_cliente='.$id_cliente;


$vencimento		= data_brasil_eua($_GET['vencimento']);
$id_servico1	= $_GET['id_servico1'];
$id_servico2	= $_GET['id_servico2'];
$id_servico3	= $_GET['id_servico3'];
$id_servico4	= $_GET['id_servico4'];
$id_servico5	= $_GET['id_servico5'];
$valor1			= vfloat($_GET['valor1']);
$valor2			= vfloat($_GET['valor2']);
$valor3			= vfloat($_GET['valor3']);
$valor4			= vfloat($_GET['valor4']);
$valor5			= vfloat($_GET['valor5']);
$obs			= $_GET['obs'];
$data			= data_hora();

if ($acao == 'adicionar')
{
	$insert = mysql_query("INSERT into $tabela (id_cliente, vencimento, id_servico1, id_servico2, id_servico3, id_servico4, id_servico5, valor1, valor2, valor3, valor4, valor5, obs, data, id_admin) VALUES ('$id_cliente', '$vencimento', '$id_servico1', '$id_servico2', '$id_servico3', '$id_servico4', '$id_servico5', '$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$obs', '$data', '$id_admin')") or die(mysql_error());

	echo '<script>fecharpopup(); '.$modulo.'(\'?'.$atributos.'\'); </script>';
	exit;
}
else if ($acao == 'editar')
{
	
	mysql_query("UPDATE $tabela SET id_cliente='$id_cliente', vencimento='$vencimento', id_servico1='$id_servico1', id_servico2='$id_servico2', id_servico3='$id_servico3', id_servico4='$id_servico4', id_servico5='$id_servico5', valor1='$valor1', valor2='$valor2', valor3='$valor3', valor4='$valor4', valor5='$valor5', obs='$obs' WHERE id='$id'");
	echo '<script>fecharpopup(); '.$modulo.'(\'?'.$atributos.'\'); </script>';
	exit;
}
	
$result = mysql_query("SELECT * FROM $tabela WHERE id='$id'");

$n = mysql_fetch_array($result);

$id				= $n['id'];
if ($id_cliente == '') { $id_cliente = $n['id_cliente']; }
if ($tp == 'copia') {
	echo $vencimento = data_eua_brasil(date('Y-m-d', strtotime("+1 month", strtotime($n['vencimento']))));
	//echo $vencimento = data_eua_brasil(date($n['vencimento'], strtotime("+1 months")));
}
else
{
	$vencimento		= data_eua_brasil($n['vencimento']);
}
$id_servico1	= $n['id_servico1'];
$id_servico2	= $n['id_servico2'];
$id_servico3	= $n['id_servico3'];
$id_servico4	= $n['id_servico4'];
$id_servico5	= $n['id_servico5'];
$valor1			= moeda($n['valor1']);
$valor2			= moeda($n['valor2']);
$valor3			= moeda($n['valor3']);
$valor4			= moeda($n['valor4']);
$valor5			= moeda($n['valor5']);
$obs			= utf8_encode($n['obs']); 

if ($id_cliente != '')
{
	$tpcli = 'edit';
}
else
{
	$tpcli = $tp;
}
?>
<script> mascaras(); calendario('vencimento'); </script>
<div class="row-fluid">
    <span class="span10">Cliente:<br />
    <?php echo select2($tpcli,'clientes','id_cliente','fantasia','obrigatorio',$id_cliente.'\' AND status=\'1','WHERE status=1'); ?>
    </span>
    <span class="span2"><span id="tfantasia">Vencimento</span>:<br />
    <input name="vencimento" type="text" class="obrigatorio masc_data span12" id="vencimento" value="<?php echo $vencimento; ?>" size="50" maxlength="100" required="required">
    </span>
</div>
<div class="row-fluid">
    <span class=" span7">Serviço:<br />
    <?php echo select($tp,'tiposervicos','id_servico1','nome','obrigatorio',$id_servico1); ?>
    </span>
    <span class=" span3">Valor:<br />
    <input name="valor1" type="text" class="obrigatorio masc_preco span12" id="valor1" value="<?php echo $valor1; ?>" size="30" required="required" />
    </span>
    <span class=" span1"><br />
    <button class="btn btn-success" onclick="ocultar('#bts1','.servico2');" id="bts1" style=" <?php if ($id_servico2 != 0) { echo 'display:none;' ; } ?>">+1</button>
    </span>
    <span class=" span1"><br />
    </span>
</div>
<div class="row-fluid servico2" style=" <?php if ($id_servico2 == 0) { echo 'display:none;' ; } ?>">
    <span class=" span7">Serviço:<br />
    <?php echo select($tp,'tiposervicos','id_servico2','nome','',$id_servico2); ?>
    </span>
    <span class=" span3">Valor:<br />
    <input name="valor2" type="text" class=" masc_preco span12" id="valor2" value="<?php echo $valor2; ?>" size="30" required="required" />
    </span>
    <span class=" span1"><br />
    <button class="btn btn-success" onclick="ocultar('#bts2','.servico3');" id="bts2" style=" <?php if ($id_servico3 != 0) { echo 'display:none;' ; } ?>">+1</button>
    </span>
    <span class=" span1"><br />
    <button class="btn btn-danger" onclick="ocultar('.servico2','#bts1'); $('#id_servico2').val(''); $('#valor2').val('');" id="bt1">-1</button>
    </span>
</div>
<div class="row-fluid servico3" style=" <?php if ($id_servico3 == 0) { echo 'display:none;' ; } ?>">
    <span class=" span7">Serviço:<br />
    <?php echo select($tp,'tiposervicos','id_servico3','nome','',$id_servico3); ?>
    </span>
    <span class=" span3">Valor:<br />
    <input name="valor3" type="text" class=" masc_preco span12" id="valor3" value="<?php echo $valor3; ?>" size="30" required="required" />
    </span>
    <span class=" span1"><br />
    <button class="btn btn-success" onclick="ocultar('#bts3','.servico4');" id="bts3" style=" <?php if ($id_servico4 != 0) { echo 'display:none;' ; } ?>">+1</button>
    </span>
    <span class=" span1"><br />
    <button class="btn btn-danger" onclick="ocultar('.servico3','#bts2'); $('#id_servico3').val(''); $('#valor3').val('');" id="bt2">-1</button>
    </span>
</div>
<div class="row-fluid servico4" style=" <?php if ($id_servico4 == 0) { echo 'display:none;' ; } ?>">
    <span class=" span7">Serviço:<br />
    <?php echo select($tp,'tiposervicos','id_servico4','nome','',$id_servico4); ?>
    </span>
    <span class=" span3">Valor:<br />
    <input name="valor4" type="text" class=" masc_preco span12" id="valor4" value="<?php echo $valor4; ?>" size="30" required="required" />
    </span>
    <span class=" span1"><br />
    <button class="btn btn-success" onclick="ocultar('#bts4','.servico5');" id="bts4" style=" <?php if ($id_servico5 != 0) { echo 'display:none;' ; } ?>">+1</button>
    </span>
    <span class=" span1"><br />
    <button class="btn btn-danger" onclick="ocultar('.servico4','#bts3'); $('#id_servico4').val(''); $('#valor4').val('');" id="bt3">-1</button>
    </span>
</div>
<div class="row-fluid servico5" style=" <?php if ($id_servico5 == 0) { echo 'display:none;' ; } ?>">
    <span class=" span7">Serviço:<br />
    <?php echo select($tp,'tiposervicos','id_servico5','nome','',$id_servico5); ?>
    </span>
    <span class=" span3">Valor:<br />
    <input name="valor5" type="text" class=" masc_preco span12" id="valor5" value="<?php echo $valor5; ?>" size="30" required="required" />
    </span>
    <span class=" span1"><br />
    </span>
    <span class=" span1"><br />
    <button class="btn btn-danger" onclick="ocultar('.servico5','#bts4'); $('#id_servico5').val(''); $('#valor5').val('');" id="bt4">-1</button>
    </span>
</div>
<div class="row-fluid">
  <span class="span12">Observações:<br />
  <textarea name="obs" cols="30" rows="2" class="span12" id="obs"><?php echo $obs; ?></textarea>
  </span>
</div>

<?php if ($tp != 'ver') { ?>
<div class="row-fluid">
    <center>
        <button class="btn btn-primary" onclick="form<?php echo $modulo; ?>('<?php
        if ($tp == 'edit')
        {
            echo $id.'\',\'editar';
        }
        else if ($tp == 'add' || $tp == 'copia')
        {
            echo '0\',\'adicionar';
        }
        ?>');" >Salvar</button>
    </center>
</div>
<?php } ?>

