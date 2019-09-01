<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once 'functions.php';

$apiUrl = 'http://www.diripatent.org/patents_search/psearch.php';
$searchEngine = $_POST['searchEngine'];
$searchText = $_POST['searchText'];

if (isset($searchEngine) && isset($searchText)) {
    $params = array(
        't' => $searchEngine,
        'q' => $searchText
    );

    $result = callApi($apiUrl, $params);
    $jsonResult = json_decode($result, true);
}

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body style="padding: 50px 150px">
    <img src="logo_diri.png"><br><br>
    <h1>SEARCH PATENT SYSTEM</h1>
    <h2>เครื่องมือและทรัพยากรในการค้นหาสิทธิบัตร</h2>
    <br>

    <form method="post">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="radioGoogle" name="searchEngine" value="google">
            <label class="form-check-label" for="radioGoogle">Google</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="radioDip" name="searchEngine" value="dip">
            <label class="form-check-label" for="radioDip">DiP</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="radioWipo" name="searchEngine" value="wipo">
            <label class="form-check-label" for="radioWipo">WIPO</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="radioLens" name="searchEngine" value="lens">
            <label class="form-check-label" for="radioLens">Lens.org</label>
        </div>

        <br><br>

        <div class="form-group">
            <label>กรุณาระบุข้อความหรือประโยค</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="searchText" value="<?= isset($searchText) ? $searchText : '' ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">ค้นหา</button>
                </div>
            </div>
        </div>

        <!-- <button type="submit" class="btn btn-primary">ค้นหา</button> -->
    </form>

    <br><br>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>เลขที่คำขอ</th>
                <th>ชื่อสิ่งประดิษฐ์/การออกแบบ</th>
                <th>ผู้ขอจดสิทธิบัตร</th>
                <th>ผู้ประดิษฐ์/ออกแบบ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($jsonResult)) {
                foreach ($jsonResult as $patent) {
                    ?>
                    <tr>
                        <td>
                            <a target="_blank" href="<?= 'https://patents.google.com/patent/' . $patent['publication_number'] ?>">
                                <?= $patent['publication_number'] ?>
                            </a>
                        </td>
                        <td><?= $patent['title'] ?></td>
                        <td><?= $patent['assignee'] ?></td>
                        <td><?= $patent['inventor'] ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>