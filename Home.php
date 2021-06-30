<?php session_start();
?>
<html>
<head>
    <title>Benvenuto nella home</title>
</head>
<body>

</body>
<h3>Benvenuto nella home, <?php $_SESSION['nomesessione'] . " " . $_SESSION['cognomesessione'] ?></h3>
<form action="inserimentocorsi.php" method="post">
    <select name=prefissi id="prefissi">
        <?php while ($row = pg_fetch_row($result)) { ?>
            <option><?php echo $row[0]; ?></option>
            <?php /*endwhile; */?>
        <?php } ?>
    </select>
</html>