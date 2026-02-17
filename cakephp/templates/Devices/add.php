<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Device $device
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Devices'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="devices form content">
            <?= $this->Form->create($device) ?>
            <fieldset>
                <legend><?= __('Add Device') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('device_id');
                    echo $this->Form->control('device_name');
                    echo $this->Form->control('location');
                    echo $this->Form->control('active_flag');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
