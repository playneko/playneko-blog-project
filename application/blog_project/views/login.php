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
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!--external css-->
<link href="<?=CONST_ASSETS_DIR?>font-awesome/css/font-awesome.css" rel="stylesheet" />
    
<!-- Custom styles for this template -->
<link href="<?=CONST_ASSETS_DIR?>css/login.css" rel="stylesheet">
<link href="<?=CONST_ASSETS_DIR?>css/style-responsive.css" rel="stylesheet">

</head>
<body>

<div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="projectModalScrollableTitle">프로젝트 생성</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="contact-form js-from_modal" name="from_modal" id="from_modal">
                    <div class="form-group">
                        <label for="user_id" class="col-form-label">사용자 ID:</label>
                        <input type="text" class="form-control" id="user_id" name="user_id" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="user_pw" class="col-form-label">사용자 비밀번호:</label>
                        <input type="password" class="form-control" id="user_pw" name="user_pw">
                    </div>
                    <div class="form-group">
                        <label for="user_email" class="col-form-label">사용자 이메일:</label>
                        <input type="text" class="form-control" id="user_email" name="user_email">
                    </div>
                    <div class="form-group">
                        <label for="project_title" class="col-form-label">프로젝트명:</label>
                        <input type="text" class="form-control" id="project_title" name="project_title">
                    </div>
                    <div class="form-group">
                        <label for="project_description" class="col-form-label">상세설명:</label>
                        <textarea class="form-control" id="project_description" name="project_description"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary js-submit_modal_save"
                    data-format-target="<?=CONST_DEFAULT_DIR?>project/register"
                    data-target-return="<?=CONST_DEFAULT_DIR?>project/login">Save</button>
            </div>
        </div>
    </div>
</div>

<div id="login-page">
    <div class="container">
        <form class="form-login" action="" method="post" data-input-text="<?=CONST_DEFAULT_DIR?>project/logincheck">
            <h2 class="form-login-heading">sign in now</h2>
            <div class="login-wrap">
                <input type="text" name="login_id" class="form-control" placeholder="User ID" autofocus>
                <br>
                <input type="password" name="login_pw" class="form-control" placeholder="Password">
                <br>
                <button class="btn btn-theme btn-block js-submit-login" type="button"><i class="fa fa-lock"></i> 로그인</button>
                <button class="btn btn-theme btn-block" type="button" data-toggle="modal" data-target="#projectModal"><i class="fa fa-sitemap"></i> 프로젝트 생성</button>
            </div>
        </form>
    </div>
</div>
<script src="<?=CONST_ASSETS_DIR?>js/util.js"></script>
<script src="<?=CONST_ASSETS_DIR?>js/project.js"></script>

</body>
</html>