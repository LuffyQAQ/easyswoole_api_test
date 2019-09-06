/**

 @Name：selected
 @Author：eValor
 @Site：http://www.evalor.cn
 @License：APACHE-2.0

 */

layui.define(['form', 'admin'], function (exports) {
    var $ = layui.$,
        form = layui.form,
        admin = layui.admin;
    var selected = {
        loadSelect: function (selector, reqOptions, idName, textName, value, formFilter, callback) {
            var select = $(selector);
            select.find('option').remove();
            reqOptions.success = reqOptions.success || function (res) {
                var runInsert = function () {
                    $.each(res.result, function (index, item) {
                        if (value && item[idName] == value) {
                            select.append('<option value="' + item[idName] + '" selected>' + item[textName] + '</option>')
                        } else {
                            select.append('<option value="' + item[idName] + '">' + item[textName] + '</option>')
                        }
                    });
                };
                if (typeof callback === 'function') {
                    callback(res, select, runInsert)
                } else {
                    runInsert();
                }
                form.render('select', formFilter);
            };
            admin.req(reqOptions)
        }
    };
    exports('selected', selected)
});