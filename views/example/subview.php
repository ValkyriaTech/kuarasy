<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Kûarasy v<?= KUARASY_VERSION ?></title>

    <link rel="stylesheet" href="<?= SITE_URL ?>/_assets/css/main.css">
  </head>
  <body>
    <section id="kuarasy">
        <div class="decoration">
          <div class="lines">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
          </div>
          <div class="lines">
            <div class="small"></div>
            <div class="small"></div>
            <div class="small"></div>
            <div class="small"></div>
          </div>
        </div>
        <div class="container">
          <h2>Kûarasy</h2>
          <h4><small>v</small><?= KUARASY_VERSION ?></h4>
          <p>
            This is a <b>subview</b>. It's located in <code>/views/example/subview.php</code>. <br>
            You can access a <b>subview</b> specifying the filename: <a href="<?= SITE_URL ?>/example/subview/"><?= SITE_URL ?>/example/<u>subview</u>/</a>
          </p>
          <a class="btn" href="<?= SITE_URL ?>/example/">
            Back
          </a>
        </div>
      </section>
  </body>
</html>
