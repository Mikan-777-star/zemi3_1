<?php
include 'db.php';
$date = $_GET['date'] ?? date('Y-m-d');
$user_id = 1;

// スケジュール取得
$stmt = $pdo->prepare("SELECT * FROM schedules WHERE user_id = ?");
$stmt->execute([$user_id]);
$schedules = $stmt->fetchAll(PDO::FETCH_UNIQUE | PDO::FETCH_ASSOC);

// メモ取得
$stmt = $pdo->prepare("SELECT * FROM memos WHERE user_id = ? ");
$stmt->execute([$user_id]);
$memo = $stmt->fetchColumn() ?? '';

// ↓ 後でDB化する場合用に仮変数（配列で編集対応）
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
        <div id="important-list">
          <?php for ($i = 0; $i < count($important); $i++): ?>
            <div class="important-item">
              <input type="checkbox" name="important_done[<?= $i ?>]">
              <input type="text" name="important[<?= $i ?>]" value="<?= htmlspecialchars($important[$i]) ?>">
              <button type="button" onclick="removeItem(this)">削除</button>
            </div>
          <?php endfor; ?>
        </div>
        <button type="button" onclick="addImportant()">＋追加</button>

        <h2>一日のやることリスト</h2>
        <div id="todo-list">
          <?php for ($i = 0; $i < count($todos); $i++): ?>
            <div class="todo-item">
              <input type="checkbox" name="todos_done[<?= $i ?>]">
              <input type="text" name="todos[<?= $i ?>]" value="<?= htmlspecialchars($todos[$i]) ?>">
              <button type="button" onclick="removeItem(this)">削除</button>
            </div>
          <?php endfor; ?>
        </div>
        <button type="button" onclick="addTodo()">＋追加</button>

        <h2>メモ</h2>
        <textarea name="memo" rows="5"><?= htmlspecialchars($memo) ?></textarea>

        <div style="margin-top: 20px;">
          <button type="submit">保存</button>
        </div>
      </div>
    </form>

    <script>
      //document.addEventListener('DOMContentLoaded',()=>{
        addTodo()
      })
      function removeItem(button) {
        button.parentElement.remove();
      }

      function addImportant() {
        const container = document.getElementById("important-list");
        const index = container.children.length;
        const div = document.createElement("div");
        div.className = "important-item";
        div.innerHTML = `
          <input type="checkbox" name="important_done[${index}]">
          <input type="text" name="important[${index}]" placeholder="入力してください">
          <button type="button" onclick="removeItem(this)">削除</button>
        `;
        container.appendChild(div);
      }

      function addTodo() {
        const container = document.getElementById("todo-list");
        const index = container.children.length;
        const div = document.createElement("div");
        div.className = "todo-item";
        div.innerHTML = `
          <input type="checkbox" name="todos_done[${index}]">
          <input type="text" name="todos[${index}]" placeholder="入力してください">
          <button type="button" onclick="removeItem(this)">削除</button>
        `;
        container.appendChild(div);
      }
    </script>
  </body>

</html>