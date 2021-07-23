<?php $massege = $this->messenger->getMessages("permission");?>
<?php if($massege !== null):?>
    <p class="message t<?= $massege[1] ?>"><?= $massege[0] ?><a href="" class="closeBtn"><i class="fa fa-times"></i></a></p>
<?php endif;?>
<div class="container">
    <a href="/Permissions/add" class="button"><i class="fa fa-plus"></i> <?= $text_new_item ?></a>
    <table class="data">
        <thead>
        <tr>
            <th><?= $text_table_permission ?></th>
            <th><?= $text_table_control ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if(false !== $privileges): foreach ($privileges as $privilege): ?>
            <tr>
                <td><?= $privilege->PrivilegeTitle ?></td>
                <td>
                    <a href="/Permissions/edit/<?= $privilege->PrivilegeId ?>"><i class="fa fa-edit"></i></a>
                    <a href="/Permissions/delete/<?= $privilege->PrivilegeId ?>" onclick="if(!confirm('<?= $text_table_control_delete_confirm ?>')) return false;"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>