<style>
    .tab_bg_2,td {
        word-wrap: break-word;
        max-width: 300px;
    }
</style>
<table border="0" class="tab_cadrehov">
    <thead>
        <tr>
            <th>Ticket</th>
            <th>Técnico</th>
            <th>Sumário</th>
            <th>Descrição</th>
            <th>Tipo</th>
            <th>Hora de inicio - fim | Data</th>
            <th>Duração</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tasks = getTechTasks($data) as $task): ?>
        <tr class="tab_bg_2" align="center">
            <td valign="top"><a target="_blank" href="ticket.form.php?id=<?= $task['tickets_id'] ?>">#<?= $task['tickets_id'] ?></a></td>
            <td valign="top"><?= $task['tech'] ?></td>
            <td valign="top"><?= $task['sumario'] ?></td>
            <td valign="top"><div><?= $task['descricao'] ?></div></td>
            <td valign="top"><?= $task['categoria'] ?></td>
            <td valign="top"><?= $task['horainicio'] ?> - <?= $task['horafim'] ?><br><?= $task['data'] ?></td>
            <td valign="top"><?= $task['duracao'] ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <th colspan="1"><input type="submit" class="submit" id="imprimir_tech" value="Imprimir"></th>
            <th colspan="7" style="text-align:right;">Total: <?= getTotalHoras($tasks)['total'] ?> <?php if($data['garantia']): ?>| Total com exceção de garantia: <?= getTotalHoras($tasks)['semgarantia'] ?><?php endif; ?></th>
        </tr>
    </tbody>
</table>
