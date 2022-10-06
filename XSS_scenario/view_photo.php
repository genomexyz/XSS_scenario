<?php
$db = new SQLite3('/var/www/html/XSS_scenario/scenario.db');
$results = $db->query('SELECT title,caption,loc FROM photo');
?>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<div class="container grid grid-cols-3 gap-2 mx-auto">

<?php
while ($row = $results->fetchArray()) {
    $title = $row[0];
    $caption = $row[1];
    $loc = $row[2];
?>
<div class="w-full rounded">
    <p><?php echo $title; ?></p>
    <img src="upload/<?php echo $loc; ?>"
        alt="image">
    <p><?php echo $caption; ?></p>
</div>
<?php
}
?>

</div>
