<div class="left">
  <h2>タイムスケジュール（<?= htmlspecialchars($date) ?>）</h2>
  <?php for ($hour = 6; $hour <= 22; $hour++): 
    $time = sprintf("%02d:00", $hour);
    $task = $schedules[$time]['task'] ?? '';
  ?>
    <div>
      <?= $time ?> - <input type="text" name="task[<?= $time ?>]" value="<?= htmlspecialchars($task) ?>">
    </div>
  <?php endfor; ?>
</div>
