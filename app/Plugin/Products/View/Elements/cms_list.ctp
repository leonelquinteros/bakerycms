<?php
foreach($products as $product)
{
    ?>
    <tr>
        <td><?php echo Sanitize::html($product['ProductsProduct']['name']); ?></td>
        <td><?php echo $product['ProductsProduct']['url']; ?></td>
        <td>
            <?php
            if(!empty($product['Category']))
            {
                echo Sanitize::html($product['Category']['name']);
            }
            ?>
        </td>
        <td>
            <a href="<?php echo $this->Html->url('/bakery'); ?>/products/edit/<?php echo $product['ProductsProduct']['id']; ?>" title="<?php echo __d('cms', 'Edit'); ?>">
                <img src="<?php echo $this->Html->url('/img'); ?>/bakery/icons/application_edit.png" alt="<?php echo __d('cms', 'Edit'); ?>" />
            </a>
            &nbsp;&nbsp;&nbsp;
            <a href="<?php echo $this->Html->url('/bakery'); ?>/products/delete/<?php echo $product['ProductsProduct']['id']; ?>" title="<?php echo __d('cms', 'Delete'); ?>" onclick="return confirm('<?php echo __d('cms', "Are you sure you want to delete this product?"); ?>');">
                <img src="<?php echo $this->Html->url('/img'); ?>/bakery/icons/delete.png" alt="<?php echo __d('cms', 'Delete'); ?>" />
            </a>
        </td>
    </tr>
    <?php
}
?>
