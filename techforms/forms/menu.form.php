<div id="page">
    <form method="post" name="form" id="menuTechRelatorio" action="#" onsubmit="return false;">
        <table class="tab_cadre_fixe">
            <tbody>
                <tr>
                    <th colspan="2" class="">Técnico</th>
                </tr>
                <tr class="tab_bg_1">
                    <td class="center">
                        <select name="idtech" required>
                            <option value="">-----</option>
                            <?php foreach(getTech() as $tech): ?>
                                <?php if(isValidProfile()): ?>
                                    <option value="<?= $tech['users_id_tech'] ?>"><?= $tech['completename']?></option>	
                                <?php endif;?>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="tab_cadre">
            <tbody>
                <tr class="tab_bg_2">
                    <td><img src="http://www.ambientelivre.com.br/suporte/glpi/pics/calendar.png" alt="..." title="..."> Data inicial</td>
                    <td>
                        <div class="no-wrap">
                            <input type="text" size="10" name="_date1" value="<?= date('Y-m-01', strtotime('-1 month')) ?>" class="hasDatepicker">
                        </div>
                    </td>
                    <td rowspan="2" class="center"><input type="submit" class="submit" name="submit" value="Mostrar relatório"></td>
                </tr>
                <tr class="tab_bg_2">
                    <td><img src="http://www.ambientelivre.com.br/suporte/glpi/pics/calendar.png" alt="..." title="..."> Data final</td>
                    <td>
                        <div class="no-wrap">
                            <input type="text" size="10" name="_date2" value="<?= date('Y-m-31', strtotime('-1 month')); ?>" class="hasDatepicker">
                        </div>
                    </td>
                </tr>
                <tr class="tab_bg_2" align="center">
                    <td colspan="3"><input type="checkbox" name="garantia"> Trazer relatório com garantia</td>
                </tr>
                <tr class="tab_bg_2" align="center">
                    <td colspan="3"><input type="checkbox" name="projeto"> Trazer relatório com projeto</td>
                </tr>
            </tbody>
        </table>
    </form>
    <hr>
    <div id="report_tech"></div>
</div>
