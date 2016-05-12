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
                $url = parse_url(getenv('DATABASE_URL'));
                print_r($url);
                $connection = new mysqli($url['host'], $url['user'], $url['pass'], null, $url['port']);
                if ($connection->connect_errno) {
                    printf("Connect failed: %s\n", $connection->connect_error);
                } else {
                    echo "Connection OK.<br>";
                    /* check if server is alive */
                    if (!$connection->ping()) {
                        printf ("Error: %s\n", $connection->error);
                    } else {
                        $dbname = substr($url['path'], 1);
                        if (!$connection->select_db($dbname)) {
                            echo "Database not found";
                        } else {
                            echo "OK";
                        }
                    }
                }
                $connection->close();
                ?>
            </dd>
        </dl>
    </body>
</html>