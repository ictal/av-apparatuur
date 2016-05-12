<!doctype html>
<html>
    <head>
        <title>AV Apparatuur</title>
    </head>
    <body>
        <h2>Systems check</h2>
        <dl>
            <dt>HTML</dt>
            <dd>OK</dd>
            <dt>Javascript</dt>
            <dd>
                <script type="application/javascript">document.write("OK");</script>
            </dd>
            <dt>PHP</dt>
            <dd><?php echo "OK"; ?></dd>
            <dt>Mysql</dt>
            <dd>
                <?php
                    $connection = new mysqli(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'));
                    if($connection) {
                        if($connection->select_db(getenv('DB_NAME'))) {
                            echo "No DB";
                        }
                        echo $connection->ping() ? "OK" : $connection->error;
                    } else {
                        echo "No Connection";
                    }
                ?>
            </dd>
        </dl>
    </body>
</html>