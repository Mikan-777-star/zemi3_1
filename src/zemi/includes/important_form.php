<div class="right">
  <h2>大事なことリスト</h2>
  <button type="button" onclick="addImportantRow()">＋ 行を追加</button>
  <table id="important-table">
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
