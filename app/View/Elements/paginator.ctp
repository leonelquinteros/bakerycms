<div class="paginator">
    <?php
    if($this->Paginator->hasPrev())
    {
        echo $this->Paginator->prev('« ' . __d('cms','Previous') . ' ', null, null, array('class' => 'disabled'));
    }
    
    echo $this->Paginator->numbers(array('separator' => ''));
    
    if($this->Paginator->hasNext())
    {
        echo $this->Paginator->next(__d('cms','Next') . ' »', null, null, array('class' => 'disabled'));
    }
    ?>
</div>