<?
    $projectData = $projectInfo['project'];
    $headerIgnoreArr = unserialize(CONST_HEADER_IGNORE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="Dashboard">
<meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
<title>Blog Project</title>

<script src="<?=CONST_ASSETS_DIR?>js/jquery-3.3.1.min.js"></script>
<script src="<?=CONST_ASSETS_DIR?>js/jquery-migrate-3.0.1.min.js"></script>
<script src="<?=CONST_ASSETS_DIR?>js/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="<?=CONST_ASSETS_DIR?>/fontawesome-free-5.10.1-web/css/all.css">
<link href="<?=CONST_ASSETS_DIR?>font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="<?=CONST_ASSETS_DIR?>css/offcanvas.css" rel="stylesheet">
<link href="<?=CONST_ASSETS_DIR?>css/style.css" rel="stylesheet">

</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
    <a class="navbar-brand mr-auto mr-lg-0" href="#"><?=$projectData['project_title']?> 프로젝트</a>
</nav>

<div class="nav-scroller bg-white shadow-sm nav_scroller">
    <nav class="nav nav-underline nav_scroller">
        <a class="nav-link<? if (!empty($page) && $page == "board") { ?> active<? } ?>" href="<?=CONST_DEFAULT_DIR?>project/board">게시판</a>
    </nav>
</div>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar nav-underline">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?=CONST_DEFAULT_DIR?>project/board">
                            <span class="fa fa-desktop"></span>
                            게시물
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
