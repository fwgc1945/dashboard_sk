<!DOCTYPE html>
<html lang="ja">

<?php
// $course_id = $_GET['course_id'];
// echo $course_id;
$detected_node = 'R3A-0000000031C7F85D';

$dsn = 'mysql:host=localhost;dbname=fwgc1945_densin;charset=utf8';
$user = 'root';
$password = '';

try {
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $stmt = $db->prepare("select distinct detected_node from skeed_oz where sensors_value <> '' order by detected_node, time");
    // $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
    $stmt->execute();
    $data2 = array();
    $count = $stmt->rowCount();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data2[] = $row;
    }
} catch (PDOException $e) {
    die('エラー:' . $e->getMesssage());
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ダッシュボード</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"
        crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- アイコン -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>

    <!-- cssファイルの設定 -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">ユーザー名</a>
        <input class="form-control form-control-dark w-100" type="text" placeholder="検索" aria-label="検索">
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="#">サインアウト</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <span data-feather="home"></span>
                                ダッシュボード <span class="sr-only">(現位置)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file"></span>
                                棒グラフ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="shopping-cart"></span>
                                折れ線グラフ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="users"></span>
                                円グラフ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="bar-chart-2"></span>
                                ドーナツ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="layers"></span>
                                レーダー
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>データ集計</span>
                        <a class="d-flex align-items-center text-muted" href="#">
                            <span data-feather="plus-circle"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                前月
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                前年
                            </a>
                        </li>
                    </ul>
                </div>
            </nav> -->

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">node</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">

                        <div class="btn-group mr-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">　活動タグ MAP　</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">　活動タグ 一覧　</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">　センサー MAP　</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">　センサー 一覧　</button>
                        </div>

                        <!-- <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <span data-feather="calendar"></span>
                            今週
                        </button> -->
                    </div>
                </div>

                <div class="row">

                    <ul>
                        <!-- <h3>node</h3>
                        <?php
                        foreach ($data2 as $row) {
                            echo '<li>' . $row['detected_node'] . '</li>';
                        }
                        ?> -->
                    </ul>                    

                    <div id="map" class="map col-sm-10">
                              
                    <div class="col-sm-9">
                        <canvas id="myChart1" height="110"></canvas>
                    </div>
                    <div class="col-sm-9">
                        <canvas id="myChart2" height="40"></canvas>
                    </div>
                    <div class="col-sm-9">
                        <div id="myslider1"></div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <hr>

    <div class="container">
        <footer>
            <p>
                &copy; 2019 DENSIN
            </p>
        </footer>
    </div>

    <script>
        let labels = [];
        <?php
        try {
            $db = new PDO($dsn, $user, $password);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $stmt = $db->prepare("select * from skeed_oz where sensors_value <> '' and detected_node = :detected_node order by detected_node, time");
            $stmt->bindParam(':detected_node', $detected_node, PDO::PARAM_INT);
            $stmt->execute();
            $data1 = array();
            $count = $stmt->rowCount();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data1[] = $row;
            }
        } catch (PDOException $e) {
            die('エラー:' . $e->getMesssage());
        }

        foreach ($data1 as $row) {
            echo "labels.push('" . $row['time'] . "');";
        }
        ?>

        // グラフ(左)のラベル
        const label1 = '101-9001:水位計1';
        // グラフ(右)のラベル
        const label2 = '101-9002:水位計2';

        // グラフのデータ
        let data1 = [];
        let data2 = [];

        <?php
        foreach ($data1 as $row) {
            echo "data1.push('" . hexdec($row['sensors_value']) . "');";
        }
        foreach ($data1 as $row) {
            echo "data2.push('" . hexdec($row['sensors_value']) * 0.9 . "');";
        }
        ?>
    </script>

    <script src="js/srChart1.js"></script>

    <script>
        feather.replace()
    </script>

    <script src="js/mapCode.js"></script>

</body>

</html>