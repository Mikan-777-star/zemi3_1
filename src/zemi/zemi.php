<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>1日のスケジュール管理</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .section-title {
      font-weight: bold;
      margin-bottom: 5px;
    }
    .box {
      border: 2px solid red;
      padding: 10px;
      margin-bottom: 10px;
      height: 100%;
    }
    .time-table {
      height: 100%;
      overflow-y: auto;
    }
    .time-slot {
      border-bottom: 1px solid #ddd;
      padding: 5px 0;
    }
  </style>
</head>
<body class="p-4">

  <div class="container">
    <h1 class="mb-4">1日のスケジュール管理</h1>
    <div class="row">

      <!-- 時間ごとの予定 -->
      <div class="col-md-4">
        <div class="box time-table">
          <div class="section-title">時間毎の予定</div>
          <div>
            <!-- 5:00〜翌1:00までの時間 -->
            <?php
            for ($hour = 5; $hour <= 24; $hour++) {
              echo "<div class='time-slot'>" . ($hour % 24) . ":00</div>";
            }
            ?>
          </div>
        </div>
      </div>

      <!-- 中央：大事なこと + ToDo -->
      <div class="col-md-4">
        <div class="box">
          <div class="section-title">大事なこと</div>
          <ul class="list-unstyled">
            <li><input type="text" class="form-control mb-1"></li>
            <li><input type="text" class="form-control mb-1"></li>
          </ul>
        </div>
        <div class="box">
          <div class="section-title">1日のやる事</div>
          <ul class="list-unstyled">
            <li><input type="checkbox" class="form-check-input me-2"> <input type="text" class="form-control d-inline w-75"></li>
            <li class="mt-2"><input type="checkbox" class="form-check-input me-2"> <input type="text" class="form-control d-inline w-75"></li>
          </ul>
        </div>
      </div>

      <!-- 右下：メモ -->
      <div class="col-md-4">
        <div class="box" style="height: 100%;">
          <div class="section-title">メモ</div>
          <textarea class="form-control" rows="12"></textarea>
        </div>
      </div>

    </div>
  </div>

</body>
</html>