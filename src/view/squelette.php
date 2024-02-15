<!DOCTYPE html>
<html lang="fr">
<head>
  <title><?php  echo $title; ?></title>
  <meta name="author" content="favier211">
  <link rel="stylesheet" href="src/view/style.css">
</head>
<body>
  <header>
    <h1>Site</h1>
  </header>  
  <main>
    <nav>
      <?php echo $nav; ?>
    </nav>
    <?php  echo $feedback;?>
    <?php  echo $content; ?>
  </main>
  <footer>
    <?php echo $footer; ?>
  </footer>
</body>
</html>
