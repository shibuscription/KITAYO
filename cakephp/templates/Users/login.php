<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div style="max-width:420px;margin:40px auto;padding:20px;border:1px solid #ddd;border-radius:10px;">
    <h1 style="margin:0 0 16px 0;">ログイン</h1>

    <?= $this->Flash->render() ?>

    <?= $this->Form->create() ?>
        <fieldset>
            <div style="margin-bottom:12px;">
                <?= $this->Form->control('username', [
                    'label' => 'ユーザー名',
                    'required' => true,
                    'autofocus' => true,
                ]) ?>
            </div>

            <div style="margin-bottom:12px;">
                <?= $this->Form->control('password', [
                    'label' => 'パスワード',
                    'required' => true,
                ]) ?>
            </div>
        </fieldset>

        <div style="display:flex;gap:10px;align-items:center;">
            <?= $this->Form->button('ログイン', ['style' => 'padding:10px 16px;']) ?>
        </div>
    <?= $this->Form->end() ?>
</div>
