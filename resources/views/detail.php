<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 5/12/16
 * Time: 3:39 PM
 */
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: "Microsoft YaHei", sans-serif;
            text-align: center;
        }
        h1 {
            font-family: Arial, sans-serif;
        }
        button {
            float: right;
        }
    </style>
</head>
<body>
    <h1>Detail View</h1>
    <p>创建人: <?= $item['creator'] ?></p>
    <p>现已加入: <?= implode(',', $item['member'])?></p>
    <p>出发地点: <?= $item['from'] ?></p>
    <p>目的地: <?= $item['to'] ?></p>
    <p>期望人数: <?= $item['expected_number'] ?></p>
    <p>
        <?php if ($item['status'] === 1): ?>
            Full
        <?php else: ?>
            Not Full
        <?php endif; ?>
    </p>
    <p>
        <a href="/index.php/market">返回</a>
    </p>

</body>
</html>
