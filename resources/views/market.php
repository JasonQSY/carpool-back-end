<?php
/**
 * Created by PhpStorm.
 * User: JasonQSY
 * Date: 5/12/16
 * Time: 2:53 PM
 */
?>
<!DOCTYPE html>
<html>
<head>
    <!-- 响应式
     ~ <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
     -->
    <style>
        body {
            font-family: "Microsoft YaHei", sans-serif;
            text-align: center;
        }
        #global-nav {
            background-color: #31b0d5;
            margin: 0;
            padding: 0;
            height: 100%;
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
    <div id="global-nav">
        <div id="title">
            <h1>Taxi Sharing Market</h1>
        </div>
    </div>

    <h2>现在可以进行的交易</h2>
        <p>创建人, 出发地点, 目的地</p>
        <?php foreach ($list as $i => $item): ?>
            <p>
                <?= $item['creator'] ?>,
                <?= $item['from'] ?>,
                <?= $item['to'] ?>
                <a href= <?= "/index.php/detail/$i" ?> >查看详细信息</a>
            </p>
        <?php endforeach; ?>

    <script>

    </script>
</body>
</html>
