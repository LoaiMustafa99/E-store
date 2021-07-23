<?php $massege = $this->messenger->getMessages("ProductList");?>
<?php if($massege !== null):?>
    <p class="message t<?= $massege[1] ?>"><?= $massege[0] ?><a href="" class="closeBtn"><i class="fa fa-times"></i></a></p>
<?php endif;?>
<div class="container">
    <a href="/productlist/add" class="button"><i class="fa fa-plus"></i> <?= $text_new_item ?></a>
    <table class="data">
        <thead>
        <tr>
            <th><?= $text_table_name ?></th>
            <th><?= $text_table_category ?></th>
            <th><?= $text_table_buy_price ?></th>
            <th><?= $text_table_sell_price ?></th>
            <th><?= $text_table_quantity ?></th>
            <th><?= $text_table_control ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if(false !== $products): foreach ($products as $product): ?>
            <tr>
                <td><?= $product->Name ?></td>
                <td><?= $product->categoryName ?></td>
                <td><?= $product->BuyPrice ?> <?= $text_currency ?></td>
                <td><?= $product->SellPrice ?> <?= $text_currency ?></td>
                <td><?= $product->Quantity ?></td>
                <td>
                    <a href="/productlist/edit/<?= $product->ProductId ?>"><i class="fa fa-edit"></i></a>
                    <a href="/productlist/delete/<?= $product->ProductId ?>" onclick="if(!confirm('<?= $text_table_control_delete_confirm ?>')) return false;"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>