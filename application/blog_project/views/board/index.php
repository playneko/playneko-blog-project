<main role="main" class="container">
    <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
        <img class="mr-3" src="<?=CONST_ASSETS_DIR?>images/logo_top.png" alt="" width="55">
        <div class="lh-100">
            <h6 class="mb-0 text-white lh-100">게시물</h6>
            <small>게시물을 등록/수정 합니다.</small>
        </div>
    </div>

    <div class="my-3 p-3 bg-white rounded shadow-sm">
        <h6 class="border-bottom border-gray pb-2 mb-0">게시물 관리</h6>
        <div class="media text-muted pt-3">
            <table class="table table-striped small">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" width="5%">썸네일</th>
                    <th scope="col" width="55%">제목</th>
                    <th scope="col" width="12%">날짜</th>
                </tr>
            </thead>
            <tbody>
            <?
                if(!empty($dataList)) {
                    foreach ($dataList as $value) {
            ?>
                        <tr>
                            <th scope="row"><?=$value['no']?></th>
                            <td class="js-link-href" data-input-href="<?=CONST_DEFAULT_DIR?>project/board/modify/<?=$value['no']?>">
                                <img src="<?=$value['board_thumnail']?>" width="100">
                            </td>
                            <td><?=$value['board_title']?></td>
                            <td class="text-align_center"><?=$value['board_date']?></td>
                        </tr>
            <?
                    }
                }
            ?>
            </tbody>
            </table>
        </div>
        <small class="d-block text-right">
            <button class="btn btn-secondary js-link-href" type="button" data-input-href="<?=CONST_DEFAULT_DIR?>project/board/add"><i class="fa fa-plus-circle"></i> 추가</button>
        </small>
    </div>
</main>