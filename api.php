<?php

function cidade($cidade)
{
   
    //Gerar o token api.openweathermap.org
    $url = 'https://api.openweathermap.org/data/2.5/weather?id=' . $cidade . '&lang=pt_br&units=metric&APPID=seutoket';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    return json_decode(curl_exec($ch));
}
// $temp_pnz = cidade('Petrolina');

// print_r($temp_pnz);

//Código das cidades tirados do arquivo json que possui na documentação
$petrolina = 3392242;
$juazeiro = 3397154;
$lagoagrande = 3396675;
$stmboavista = 3389462;
$casanova = 3402621;
$sobradinho = 3447473;

//Criado um array de cidade que será percorrido no for
$cidades = array(
    $petrolina, $juazeiro, $lagoagrande, $stmboavista, $casanova, $sobradinho
);

?>

<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">

        <?php

        //Loop nas cidades listadas
        foreach ($cidades as $key_cid => $cid) {

            //Função que chama o link para buscar os dados da API
            $temp = cidade($cid);

            //Detalhes do tempo está dentro de outra Array
            foreach ($temp->main as $key_temp => $value) {
                if ($key_temp == 'temp') $media = round($value);
                // if ($key_temp == 'temp_max') $max = round($value);
                // if ($key_temp == 'temp_min') $min = round($value);
                // if ($key_temp == 'pressure') $pressao = round($value);
                if ($key_temp == 'humidity') $umidade = round($value);
            }

            //O icone e a descrição que representa o status do tempo está dentro de outra Array
            foreach ($temp->weather as $value) {
                foreach ($value as $key_dtl => $val) {
                    if ($key_dtl == 'description') $descricao = $val;
                    if ($key_dtl == 'icon') $icon = $val;
                }
            }

            //vento está dentro de outra Array
            foreach ($temp->wind as $jey_vnt => $value) {
                if ($jey_vnt == 'speed') $vento = round($value);
            }

        ?>

            <!-- Se for a primeira cidade do loop fica como ativo no carosel -->
            <div class="carousel-item <?php echo $key_cid === 0 ? 'active' : '' ?>">

                <div class="text-center temp-api">
                    <!-- Nome da Cidade -->
                    <h5 class="text-uppercase mb-0"><?php echo $temp->name; ?></h5>

                    <div class="row d-flex align-items-center justify-content-center">
                        <div class="col-4">
                            <img src="http://openweathermap.org/img/w/<?php echo $icon ?>.png" alt="Clima" width="100">
                        </div>

                        <div class="col-3">
                            <h2 class="mb-0"><?php echo $media; ?><sup>&#8451;</sup></h2>
                        </div>

                        <div class="col-5">
                            <p class="text-left mb-0">
                                <!-- <b>Max: </b> <?php //echo $max; 
                                                    ?> <br>
                                <b>Min: </b> <?php //echo $min; 
                                                ?> <br> -->
                                <b>Umidade: </b> <?php echo $umidade; ?>% <br>
                                <b>Vento: </b> <?php echo $vento * 3.6 ?>Km/h <br>
                                <b class="text-capitalize"><?php echo $descricao; ?></b>
                            </p>
                        </div>
                    </div><!-- row -->

                </div><!-- text-center -->

            </div><!-- fim carousel-item -->

        <?php } ?>

    </div><!-- fim carouselExampleSlidesOnly -->
</div><!-- fim carousel-inner -->