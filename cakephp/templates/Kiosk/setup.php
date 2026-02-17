<h1>端末セットアップ</h1>

<?= $this->Flash->render() ?>

<?= $this->Form->create() ?>
  <div style="max-width:520px;">
    <label>使用する端末</label>
    <select name="device_id" required style="width:100%;padding:10px;">
      <?php foreach ($devices as $d): ?>
        <option value="<?= h($d->device_id) ?>">
          <?= h($d->device_id) ?> <?= $d->device_name ? ' - ' . h($d->device_name) : '' ?> <?= $d->location ? ' (' . h($d->location) . ')' : '' ?>
        </option>
      <?php endforeach; ?>
    </select>

    <div style="margin-top:16px;">
      <button type="submit" style="padding:10px 16px;">この端末として開始</button>
    </div>
  </div>
<?= $this->Form->end() ?>
