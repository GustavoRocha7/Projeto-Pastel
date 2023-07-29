<?php
    echo '
    <div class="table-responsive">
        <table class="table table-bordered table-striped" style="float: right;">
            <tr style="background-color: #d3d3d3;">
                <td class="text-center">Quantidade</td>
                <td class="text-center">Produto</td>
                <td class="text-center">Valor</td>
            </tr>';

    if (isset($_SESSION['produtos'])) {
        foreach ($_SESSION['produtos'] as $pro) { 
            echo '<tr>
                    <td class="text-center align-middle">'.$pro->quant.'</td>
                    <td class="text-left align-middle">'.$pro->nome.'</td>
                    <td class="text-center align-middle">R$'.$pro->valor.'</td>
                  </tr>';
        }
    }

    echo '</table>
        </div>';
    $total = 0;
    if (isset($_SESSION['produtos'])) {
        foreach ($_SESSION['produtos'] as $pro) {
            $total += floatval(str_replace('R$', '', $pro->valor));
        }
    }
?>
