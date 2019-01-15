    <!doctype html>
    <html lang="ru">
    <head>
        <?php
        $website_title = 'nepogoda.by';
        require 'blocks/head.php';
        ?>
    </head>
    <body>
    <?php require 'blocks/header.php'; ?>

    <main class="container content mt-5 container-main">
        <div class="row">
            <div class="col-md-12 mb-3 ">
                <div class="card mx-auto border-0 text-center" style="width: 16rem;">
                    <img src="img/error_256_x_256.png" class="card-img-top" alt="ошибка 404">
                    <div class="card-body">
                        <h5 class="card-title">Такой страницы не существует!</h5>
                        <p class="card-text">Пожалуйста, вернитесь на главную страницу :)</p>
                        <a href="/" class="btn btn-primary">На главную!</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </body>
    </html>