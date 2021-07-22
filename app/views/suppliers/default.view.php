<?php $massege = $this->messenger->getMessages("Suppliers");?>
<?php if($massege !== null):?>
    <p class="message t<?= $massege[1] ?>"><?= $massege[0] ?><a href="" class="closeBtn"><i class="fa fa-times"></i></a></p>
<?php endif;?>
<div class="container">
    <a href="/suppliers/add" class="button"><i class="fa fa-plus"></i> <?= $text_new_item ?></a>
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
        <?php if(false !== $suppliers): foreach ($suppliers as $supplier): ?>
            <tr>
                <td><?= $supplier->Name ?></td>
                <td><?= $supplier->Email ?></td>
                <td><?= $supplier->PhoneNumber ?></td>
                <td>
                    <a href="/suppliers/edit/<?= $supplier->SupplierId ?>"><i class="fa fa-edit"></i></a>
                    <a href="/suppliers/delete/<?= $supplier->SupplierId ?>" onclick="if(!confirm('<?= $text_table_control_delete_confirm ?>')) return false;"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>