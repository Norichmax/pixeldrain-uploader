<!DOCTYPE html>
<html>
<head>
    <title>PHP File Upload</title>
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
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Dosya Yükleme</h1>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            $file_name = $_FILES['file']['name'];
            $tmp_file_path = $_FILES['file']['tmp_name'];

            $post_data = array(
                'name' => $file_name,
                'anonymous' => true,
                'file' => new CURLFile($tmp_file_path)
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://pixeldrain.com/api/file");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            curl_close($ch);

            $api_response = json_decode($response, true);

            if ($api_response && isset($api_response['id'])) {
                echo '<div class="result alert alert-success text-center">';
                echo "Dosya başarıyla yüklendi. Dosya URL'si: <a href='https://pixeldrain.com/u/" . $api_response['id'] . "' target='_blank'>https://pixeldrain.com/u/" . $api_response['id'] . "</a>";
                echo '</div>';
            } else {
                echo '<div class="result alert alert-danger text-center">';
                echo "Dosya yükleme başarısız oldu.";
                echo '</div>';
            }
        }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file">Dosya Seçin:</label>
                <input type="file" id="file" name="file" required class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary">Yükle</button>
        </form>

        <form action="remote.php" method="post">
            <button type="submit" class="btn btn-secondary mt-3">Uzaktan Dosya Yükle</button>
        </form>
    </div>
</body>
</html>
