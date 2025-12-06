<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/footer.css">
    <!-- Inclusion conditionnelle de la feuille de style spécifique à chaque page -->
    <?php
    if (isset($_GET['page'])) {
        $page = htmlspecialchars($_GET['page']);
        $cssFile = "css/pages/$page.css";
        if (file_exists($cssFile)) {
            echo '<link rel="stylesheet" href="' . $cssFile . '">';
        }
    }
    ?>
    <script src="js/modernizr-custom.js"></script>
    <script src="js/menu.js"></script>
    <link rel="shortcut icon" type="image/png" href="iconsite.png">
    <title>Wetground.be</title>
</head>