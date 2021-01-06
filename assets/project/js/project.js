var project = project || {};

;(function(global, $, undefined) {
    'use strict';

    var blogProject = global || {};

    $('.js-submit-login').on('click', function() {
        var url = $('.form-login').attr('data-input-text');

        blogProject.init = project.util.json(url, $('.form-login').serialize())
        .then(function (res) {
            if(res.result == "OK") {
                $(location).attr('href', "?/project");
            } else {
                alert(res.message);
            }
        })
        .then(function (res) {
        });
    });

    $('.js-submit-logout').on('click', function() {
        var url = $(this).attr('data-input-text');

        blogProject.init = project.util.json(url, {})
        .then(function (res) {
            $(location).attr('href', "?/project/login");
        })
        .then(function (res) {
        });
    });
    
    $('.js-modal_input').on('click', function() {
        var modal = $(this).attr('data-modal-target');
        var data = $(this).attr('data-input-text');

        $('.js-form_' + modal).val(data);
    });
    
    $('.js-submit_modal_save').on('click', function() {
        var url = $(this).attr('data-format-target');
        var returnUrl = $(this).attr('data-target-return');

        blogProject.init = project.util.json(url, $('.js-from_modal').serialize())
        .then(function (res) {
            if(res.result == "OK") {
                $(location).attr('href', returnUrl);
            } else {
                alert(res.message);
            }
        });
    });

    $('.js-link-href').on('click', function() {
        var url = $(this).attr('data-input-href');
        $(location).attr('href', url);
    });
    
    $('.js-submit-board').on('click', function() {
        var url = $(this).attr('data-format-target');
        var returnUrl = $(this).attr('data-target-return');

        blogProject.init = project.util.json(url, $('.js-from_board').serialize())
        .then(function (res) {
            if(res.result == "OK") {
                $(location).attr('href', returnUrl);
            } else {
                alert(res.message);
            }
        });
    });

}(this, jQuery));
