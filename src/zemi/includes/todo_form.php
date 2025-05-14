  <h2>やることリスト</h2>
  <button type="button" onclick="addTodoRow()">＋ 行を追加</button>
  <table id="todo-table">
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
        <select name="todos_status[<?= $i ?>]">
          <option value="">選択なし</option>
          <option value="完了">完了</option>
          <option value="進行中">進行中</option>
          <option value="未着手">未着手</option>
        </select>
      </td>
      <td style="white-space: nowrap;">
        <select name="todos_month[<?= $i ?>]" style="width: 60px; display: inline-block;">
          <?php for ($m = 1; $m <= 12; $m++): ?>
            <option value="<?= $m ?>"><?= $m ?></option>
          <?php endfor; ?>
        </select>
        <select name="todos_day[<?= $i ?>]" style="width: 60px; display: inline-block;">
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
