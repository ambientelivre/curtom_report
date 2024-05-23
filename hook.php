<?php
function plugin_customreport_install() {
    // Caminho do arquivo
    $file = GLPI_ROOT . "/inc/html.class.php";

    // Linha a ser inserida
    $comando = '      echo Html::script($CFG_GLPI["root_doc"]."/plugins/customreport/customRelatorio.js");';
    $novaLinha = "$comando\n";

    // Linha após a qual a nova linha será inserida
    $linhaAlvo = "      // PLugins jquery";

    // Lê o conteúdo do arquivo em um array de linhas
    $linhas = file($file);

    // Verifica se a modificação já foi feita
    foreach ($linhas as $linha) {
        if (strpos($linha, $comando) !== false) {
            // Modificação já feita, saia da função
            return true;
        }
    }

    // Encontra a posição da linha alvo e insere a nova linha após ela
    for ($i = 0; $i < count($linhas); $i++) {
        if (strpos($linhas[$i], $linhaAlvo) !== false) {
            array_splice($linhas, $i + 1, 0, $novaLinha);
            break;
        }
    }

    // Escreve o conteúdo modificado de volta ao arquivo
    file_put_contents($file, implode('', $linhas));
    return true;
}

function plugin_customreport_uninstall() {
    // Caminho do arquivo
    $file = GLPI_ROOT . "/inc/html.class.php";

    // Linha a ser removida
    $comando = '      echo Html::script($CFG_GLPI["root_doc"]."/plugins/customreport/customRelatorio.js");';

    // Lê o conteúdo do arquivo em um array de linhas
    $linhas = file($file);
    
    // Encontra e remove a linha desejada
    foreach ($linhas as $i => $linha) {
        if (strpos($linha, $comando) !== false) {
            unset($linhas[$i]);
            break;
        }
    }
    
    // Escreve o conteúdo modificado de volta ao arquivo
    file_put_contents($file, implode('', $linhas));
    return true;
}
?>

