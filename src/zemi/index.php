<?php
include 'db.php';
$date = $_GET['date'] ?? date('Y-m-d');
$user_id = 1;

// スケジュール取得
$stmt = $pdo->prepare("SELECT * FROM schedules WHERE user_id = ?");
$stmt->execute([$user_id]);
$schedules = $stmt->fetchAll(PDO::FETCH_UNIQUE | PDO::FETCH_ASSOC);

// メモ取得
$stmt = $pdo->prepare("SELECT * FROM memos WHERE user_id = ?");
$stmt->execute([$user_id]);
$memo = $stmt->fetchColumn() ?? '';

// 仮データ（DB未実装用）
$important = [''];
$todos = [''];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ToDoリスト</title>
  <style>
    body {
      font-family: sans-serif;
      margin: 0;
    }
    form {
      display: flex;
      height: 100vh;
    }
    .left, .right {
      padding: 20px;
      box-sizing: border-box;
      overflow-y: auto;
    }
    .left {
      flex: 1;
      border-right: 1px solid #ccc;
    }
    .right {
      flex: 1;
    }
    input[type="text"] {
      width: 90%;
      margin-bottom: 5px;
    }
    textarea {
      width: 95%;
    }
    h2 {
      margin-top: 25px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <form method="POST" action="save.php">
    <input type="hidden" name="date" value="<?= htmlspecialchars($date) ?>">

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

    <div class="right">
      <h2>大事なことリスト</h2>
      <button type="button" onclick="addImportantRow()">＋ 行を追加</button>
      <table id="important-table" border="1" cellpadding="5" cellspacing="0">
        <tr>
          <th>完了</th>
          <th>内容</th>
          <th>タグ</th>
          <th></th>
        </tr>
        <?php for ($i = 0; $i < count($important); $i++): ?>
          <tr>
            <td><input type="checkbox" name="important_done[<?= $i ?>]"></td>
            <td><input type="text" name="important[<?= $i ?>]" value="<?= htmlspecialchars($important[$i] ?? '') ?>"></td>
            <td><input type="text" name="important_tag[<?= $i ?>]"></td>
            <td><button type="button" onclick="removeRow(this)">削除</button></td>
          </tr>
        <?php endfor; ?>
      </table>

      <h2>やることリスト</h2>
      <button type="button" onclick="addTodoRow()">＋ 行を追加</button>
      <table id="todo-table" border="1" cellpadding="5" cellspacing="0">
        <tr>
          <th>完了</th>
          <th>内容</th>
          <th>状態</th>
          <th>締切（月/日）</th>
          <th>コメント</th>
          <th></th>
        </tr>
        <?php for ($i = 0; $i < count($todos); $i++): ?>
          <tr>
            <td><input type="checkbox" name="todos_done[<?= $i ?>]"></td>
            <td><input type="text" name="todos[<?= $i ?>]" value="<?= htmlspecialchars($todos[$i] ?? '') ?>"></td>
            <td>
              <select name="todos_status[<?= $i ?>]" class="status-select">
                <option value="">選択なし</option>
                <option value="完了">完了</option>
                <option value="進行中">進行中</option>
                <option value="未着手">未着手</option>
              </select>
            </td>
            <td style="white-space: nowrap;">
              <select name="todos_month[<?= $i ?>]" style="width: 60px;">
                <?php for ($m = 1; $m <= 12; $m++): ?>
                  <option value="<?= $m ?>"><?= $m ?></option>
                <?php endfor; ?>
              </select>
              /
              <select name="todos_day[<?= $i ?>]" style="width: 60px;">
                <?php for ($d = 1; $d <= 31; $d++): ?>
                  <option value="<?= $d ?>"><?= $d ?></option>
                <?php endfor; ?>
              </select>
            </td>
            <td><input type="text" name="todos_comment[<?= $i ?>]" style="width: 100%;"></td>
            <td><button type="button" onclick="removeRow(this)">削除</button></td>
          </tr>
        <?php endfor; ?>
      </table>

      <h2>メモ</h2>
      <textarea name="memo" rows="5"><?= htmlspecialchars($memo) ?></textarea>

      <div style="margin-top: 20px;">
        <button type="submit">保存</button>
      </div>
    </div>
  </form>

  <!-- JavaScript -->
  <script>
    let importantIndex = <?= count($important) ?>;
    let todoIndex = <?= count($todos) ?>;

    function addImportantRow() {
      const table = document.getElementById("important-table");
      const row = table.insertRow(-1);
      row.innerHTML = `
        <td><input type="checkbox" name="important_done[${importantIndex}]"></td>
        <td><input type="text" name="important[${importantIndex}]"></td>
        <td><input type="text" name="important_tag[${importantIndex}]"></td>
        <td><button type="button" onclick="removeRow(this)">削除</button></td>
      `;
      importantIndex++;
    }

    function addTodoRow() {
      const table = document.getElementById("todo-table");
      const row = table.insertRow(-1);

      let monthOptions = '', dayOptions = '';
      for (let m = 1; m <= 12; m++) {
        monthOptions += `<option value="${m}">${m}</option>`;
      }
      for (let d = 1; d <= 31; d++) {
        dayOptions += `<option value="${d}">${d}</option>`;
      }

      row.innerHTML = `
        <td><input type="checkbox" name="todos_done[${todoIndex}]"></td>
        <td><input type="text" name="todos[${todoIndex}]"></td>
        <td>
          <select name="todos_status[${todoIndex}]" class="status-select">
            <option value="">選択なし</option>
            <option value="完了">完了</option>
            <option value="進行中">進行中</option>
            <option value="未着手">未着手</option>
          </select>
        </td>
        <td style="white-space: nowrap;">
          <select name="todos_month[${todoIndex}]" style="width: 60px;">${monthOptions}</select> /
          <select name="todos_day[${todoIndex}]" style="width: 60px;">${dayOptions}</select>
        </td>
        <td><input type="text" name="todos_comment[${todoIndex}]" style="width: 100%;"></td>
        <td><button type="button" onclick="removeRow(this)">削除</button></td>
      `;
      todoIndex++;
    }

    function removeRow(button) {
      const row = button.closest("tr");
      row.remove();
    }
  </script>
</body>
</html>
