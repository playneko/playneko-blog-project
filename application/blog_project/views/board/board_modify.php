<?
    $boardData = $dataInfo[0];
?>
<main role="main" class="container">
    <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
        <img class="mr-3" src="<?=CONST_ASSETS_DIR?>images/logo_top.png" alt="" width="55">
        <div class="lh-100">
            <h6 class="mb-0 text-white lh-100">게시물 수정</h6>
            <small>게시물 수정 합니다.</small>
        </div>
    </div>

    <div class="my-3 p-3 bg-white rounded shadow-sm">
    <form class="contact-form js-from_board" name="from_data" id="from_data">
    <input type="hidden" name="board_no" value="<?=$boardData['no']?>">
    <input type="hidden" name="mode" value="add">
        <h6 class="border-bottom border-gray pb-2 mb-0">게시물 수정</h6>
        <div class="media text-muted pt-3">
            <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <div class="row">
                    <div class="col-3">카테고리</div>
                    <div class="col-9">
                        <input class="form-control" type="text" name="board_category" placeholder="카테고리(,구분)" value="<?=$boardData['board_category']?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="media text-muted pt-3">
            <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <div class="row">
                    <div class="col-3">태그</div>
                    <div class="col-9">
                        <input class="form-control" type="text" name="board_tag" placeholder="태그(,구분)" value="<?=$boardData['board_tag']?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="media text-muted pt-3">
            <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <div class="row">
                    <div class="col-3">썸네일</div>
                    <div class="col-9">
                        <input class="form-control" type="text" name="board_thumnail" placeholder="썸네일 URL" value="<?=$boardData['board_thumnail']?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="media text-muted pt-3">
            <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <div class="row">
                    <div class="col-3">제목</div>
                    <div class="col-9">
                        <input class="form-control" type="text" name="board_title" placeholder="제목" value="<?=$boardData['board_title']?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="media text-muted pt-3">
            <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <div class="row">
                    <div class="col-3">간략 내용</div>
                    <div class="col-9">
                        <textarea class="form-control span5" name="board_comment" placeholder="간략 내용" style="height: 150px;"><?=$boardData['board_comment']?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="media text-muted pt-3">
            <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <div class="row">
                    <div class="col-3">상세 내용</div>
                    <div class="col-9">
                        <textarea class="form-control span5" name="board_article" placeholder="상세 내용" style="height: 600px;"><?=$boardData['board_article']?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="media text-muted pt-3">
            <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <div class="row">
                    <div class="col-3">날짜</div>
                    <div class="col-9">
                        <input class="form-control" type="text" name="board_date" placeholder="날짜(0000-00-00 00:00:00)" value="<?=$boardData['board_date']?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="media text-muted pt-3">
            <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <div class="row">
                    <div class="col-3">마크다운 작성법</div>
                    <div class="col-9">
                        <div style="padding-top:5px;">내용은 마크다운 방식으로 작성을 합니다.</div>
                        <div style="padding-top:10px;">
                            <strong>※ 큰제목: 문서 제목</strong>
                            <div style="background: #eeeeee;padding: 10px;">
                            This is an H1<br>
                            =============
                            </div>
                        </div>
                        <div style="padding-top:10px;">
                            <strong>※ 작은제목: 문서 부제목</strong>
                            <div style="background: #eeeeee;padding: 10px;">
                            This is an H2<br>
                            -------------
                            </div>
                        </div>
                        <div style="padding-top:10px;">
                            <strong>※ 글머리: 1~6까지만 지원</strong>
                            <div style="background: #eeeeee;padding: 10px;">
                            # This is a H1<br>
                            ## This is a H2<br>
                            ### This is a H3<br>
                            #### This is a H4<br>
                            ##### This is a H5<br>
                            ###### This is a H6
                            </div>
                        </div>
                        <div style="padding-top:10px;">
                            <strong>※ BlockQuote</strong><br>
                            이메일에서 사용하는 > 블럭인용문자를 이용한다.
                            <div style="background: #eeeeee;padding: 10px;">
                            > This is a first blockqute.<br>
                            >	> This is a second blockqute.<br>
                            >	>	> This is a third blockqute.
                            </div>
                        </div>
                        <div style="padding-top:10px;">
                            <strong>※ 순서있는 목록(번호)</strong><br>
                            순서있는 목록은 숫자와 점을 사용한다.
                            <div style="background: #eeeeee;padding: 10px;">
                            1. 첫번째<br>
                            2. 두번째<br>
                            3. 세번째
                            </div>
                        </div>
                        <div style="padding-top:10px;">
                            <strong>※ 순서없는 목록(글머리 기호: *, +, - 지원)</strong>
                            <div style="background: #eeeeee;padding: 10px;">
                            * 빨강<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;* 녹색<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* 파랑<br>
                            + 빨강<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;+ 녹색<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ 파랑<br>
                            - 빨강<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;- 녹색<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- 파랑<br>
                            </div>
                        </div>
                        <div style="padding-top:10px;">
                            <strong>※ 코드블럭</strong><br>
                            코드블럭코드("```")
                            <div style="background: #eeeeee;padding: 10px;">
                            ``` js(언어별 확장자)<br>
                            public class BootSpringBootApplication {<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;public static void main(String[] args) {<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;System.out.println("Hello, Honeymon");<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;}<br>
                            }<br>
                            ```
                            </div>
                        </div>
                        <div style="padding-top:10px;">
                            <strong>※ 수평선</strong><br>
                            아래 줄은 모두 수평선을 만든다. 마크다운 문서를 미리보기로 출력할 때 페이지 나누기 용도로 많이 사용한다.
                            <div style="background: #eeeeee;padding: 10px;">
                            * * *<br>
                            ***<br>
                            *****<br>
                            - - -<br>
                            ---------------------------------------
                            </div>
                        </div>
                        <div style="padding-top:10px;">
                            <strong>※ 링크</strong><br>
                            외부링크
                            <div style="background: #eeeeee;padding: 10px;">
                            사용문법: [Title](link)<br>
                            적용예: [Google](https://google.com, "google link")
                            </div>
                            자동연결
                            <div style="background: #eeeeee;padding: 10px;">
                            일반적인 URL 혹은 이메일주소인 경우 적절한 형식으로 링크를 형성한다.<br>
                            * 외부링크: <span><</span>http://example.com/<span>></span><br>
                            * 이메일링크: <span><</span>address@example.com<span>></span>
                            </div>
                        </div>
                        <div style="padding-top:10px;">
                            <strong>※ 강조</strong>
                            <div style="background: #eeeeee;padding: 10px;">
                            *single asterisks* ※ 기울임<br>
                            _single underscores_ ※ 기울임<br>
                            **double asterisks** ※ 강조<br>
                            __double underscores__ ※ 강조<br>
                            ~~cancelline~~ ※ 취소선
                            </div>
                        </div>
                        <div style="padding-top:10px;">
                            <strong>※ 이미지</strong>
                            <div style="background: #eeeeee;padding: 10px;">
                            ![Alt text](/path/to/img.jpg)<br>
                            ![Alt text](/path/to/img.jpg "Optional title")
                            </div>
                        </div>
                        <div style="padding-top:10px;">
                            <strong>※ 줄바꿈</strong><br>
                            3칸 이상 띄어쓰기( )를 하면 줄이 바뀐다.
                            <div style="background: #eeeeee;padding: 10px;">
                            * 줄 바꿈을 하기 위해서는 문장 마지막에서 3칸이상을 띄어쓰기해야 한다.___\\ 띄어쓰기
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <small class="d-block text-right mt-3">
            <button class="btn btn-secondary js-submit-board" type="button"
                data-format-target="<?=CONST_DEFAULT_DIR?>project/board/write/modify"
                data-target-return="<?=CONST_DEFAULT_DIR?>project/board"><i class="fa fa-check-circle"></i> 저장</button>
            <button class="btn btn-danger js-submit-board" type="button"
                data-format-target="<?=CONST_DEFAULT_DIR?>project/board/write/delete"
                data-target-return="<?=CONST_DEFAULT_DIR?>project/board"><i class="fa fa-times-circle"></i> 삭제</button>
        </small>
    </form>
    </div>
</main>