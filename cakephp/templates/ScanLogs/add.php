<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ScanLog $scanLog
 * @var \Cake\Collection\CollectionInterface|string[] $devices
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Scan Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="scanLogs form content">
            <?= $this->Form->create($scanLog) ?>
            <fieldset>
                <legend><?= __('Add Scan Log') ?></legend>
                <?php
                    echo $this->Form->control('idm');
                    echo $this->Form->control('device_id', ['options' => $devices]);
                    echo $this->Form->control('scanned_at');
                    echo $this->Form->control('processed');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
