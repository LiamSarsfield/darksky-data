<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" charset="utf-8">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
            crossorigin="anonymous"></script>
    <script src="/assets/javascript/libraries/jQuery-Validation-Engine/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script src="/assets/javascript/libraries/jQuery-Validation-Engine/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="/assets/javascript/libraries/jQuery-Validation-Engine/css/validationEngine.jquery.css" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" type="text/css"/>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" type="text/css"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <?php foreach ($scripts ?? [] as $script) {
        echo "<script src='{$script}'></script>";
    } ?>
    <?php foreach ($stylesheets ?? [] as $stylesheet) {
        echo link_tag($stylesheet);
    } ?>

    <script src="/assets/javascript/javascript.js" type="text/javascript" charset="utf-8"></script>
    <title><?= $title ?? 'Darksky Data' ?></title>
</head>
<body>
<header class="mb-2">
    <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container col-sm-8 d-flex justify-content-between">
            <a href="#" class="navbar-brand d-flex align-items-center">
                <svg class="bi bi-archive" width="1em" height="1em" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M4 7v7.5c0 .864.642 1.5 1.357 1.5h9.286c.715 0 1.357-.636 1.357-1.5V7h1v7.5c0 1.345-1.021 2.5-2.357 2.5H5.357C4.021 17 3 15.845 3 14.5V7h1z"
                          clip-rule="evenodd"></path>
                    <path fill-rule="evenodd"
                          d="M7.5 9.5A.5.5 0 018 9h4a.5.5 0 010 1H8a.5.5 0 01-.5-.5zM17 4H3v2h14V4zM3 3a1 1 0 00-1 1v2a1 1 0 001 1h14a1 1 0 001-1V4a1 1 0 00-1-1H3z"
                          clip-rule="evenodd"></path>
                </svg>
                <strong class="px-2">Darksky data</strong>
            </a>
            <a class="btn btn-primary" href="<?= (isset($this->session->userdata['user_info']['id'])) ? '/admin/logout' : '/login' ?> ">
                <?= (isset($this->session->userdata['user_info']['id'])) ? 'Logout' : 'Login' ?></a>
        </div>
    </div>
</header>
