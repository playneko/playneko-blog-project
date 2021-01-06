var project = project || {};

;(function(global, $, undefined) {
    'use strict';

    var util = global || {};

    util.json = function(url, param) {
		var defer = $.Deferred();

		$.ajax({
			url: url,
			type: "post",
			dataType: 'json',
            data: param
		}).done(function(data){
			defer.resolve(data);
		}).fail(function(data){
			defer.reject();
		});
		
		return defer.promise();
    }

    util.jsonp = function(url, param) {
		var defer = $.Deferred();

		$.ajax({
			url: url,
			type: "post",
			dataType: 'jsonp',
          data: param
		}).done(function(data){
			defer.resolve(data);
		}).fail(function(data){
			defer.reject();
		});
		
		return defer.promise();
    }

    project.util = util;

}(this, jQuery));
