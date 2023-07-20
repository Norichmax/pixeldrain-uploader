

<!DOCTYPE html>
<html>
<head>
    <title>Dosya Yükleme</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 500px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .result {
            margin-top: 20px;
            font-size: 18px;
            text-align: center; /* Bildirimi merkezlemek için */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Dosya Yükleme</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="url">Dosya URL'si:</label>
                <input type="text" id="url" name="url" required class="form-control">
            </div>

            <div class="form-group">
                <label for="file_name">Dosya Adı:</label>
                <input type="text" id="file_name" name="file_name" required class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Yükle</button>
        </form>

        <?php
            // github/seferilgun
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['url'];
    $file_name = $_POST['file_name'];

    // github/seferilgun
    $file_extension = pathinfo($url, PATHINFO_EXTENSION);

    // github/seferilgun
    $random_file_name = uniqid() . '.' . $file_extension;

    // github/seferilgun
    $file = file_get_contents($url);

    // github/seferilgun
    $post_data = array(
        'name' => $random_file_name,
        'anonymous' => true,
        'file' => new CURLFile($url)
    );

    // github/seferilgun
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://pixeldrain.com/api/file");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    // github/seferilgun
    $api_response = json_decode($response, true);
            if ($api_response && isset($api_response['id'])) {
                echo '<div class="result alert alert-success">';
                echo "Dosya başarıyla yüklendi. Dosya URL'si: <a href='https://pixeldrain.com/u/" . $api_response['id'] . "' target='_blank'>https://pixeldrain.com/u/" . $api_response['id'] . "</a>";
                echo '</div>';
            } else {
                echo '<div class="result alert alert-danger">';
                echo "Dosya yükleme başarısız oldu.";
                echo '</div>';
            }
        }
        ?>
    </div>
</body>
</html>
