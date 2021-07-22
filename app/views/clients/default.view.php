<?php $massege = $this->messenger->getMessages("Clients");?>
<?php if($massege !== null):?>
    <p class="message t<?= $massege[1] ?>"><?= $massege[0] ?><a href="" class="closeBtn"><i class="fa fa-times"></i></a></p>
<?php endif;?>
<div class="container">
    <a href="/clients/add" class="button"><i class="fa fa-plus"></i> <?= $text_new_item ?></a>
    <table class="data">
        <thead>
        <tr>
            <th><?= $text_table_name ?></th>
            <th><?= $text_table_email ?></th>
            <th><?= $text_table_phone_number ?></th>
            <th><?= $text_table_control ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if(false !== $clients): foreach ($clients as $client): ?>
            <tr>
                <td><?= $client->Name ?></td>
                <td><?= $client->Email ?></td>
                <td><?= $client->PhoneNumber ?></td>
                <td>
                    <a href="/clients/edit/<?= $client->ClientId ?>"><i class="fa fa-edit"></i></a>
                    <a href="/clients/delete/<?= $client->ClientId ?>" onclick="if(!confirm('<?= $text_table_control_delete_confirm ?>')) return false;"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>