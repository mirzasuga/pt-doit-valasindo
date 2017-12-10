var loader = $(".overlay");
var overlay = "<div id='overlay'></div>";
var defaultContainer = "body";
var _token = $('input[name="csrf-token"]').attr('content');
function FormValas(p) {
    this.container = $(p.container);
    this.action = p.action;
    this.data = null,
    this.loadForm = function() {
        var load = new LoadElement({
            method : 'GET',
            url: this.action,
            container: this.container
        });
        return load.do();
    }
}
function LoadElement(p) {
    this.do = function() {
        $.ajax({
            method: p.method,
            url : p.url,
            data: p.data,
            beforeSend:function() {
                loader.show();
                console.log(p.container);
            },
            success:function(data) {
                loader.hide();
                p.container.html('');
                p.container.html(data);
            },
            error:function(xhr) {
                loader.hide();
                console.log(xhr.message);
            },
        });
    }
}

function storeData(p) {
    this._storedData = [];
    this._onStored = false;
    var container = (p.container == undefined) ? defaultContainer : p.container;
    this.do = function() {
        var stored = this._storedData;
        $.ajax({
            url : p.storeurl,
            method: 'POST',
            data: p.data,
            beforeSend:function() {
                this._onStored = true;
                loader.show();
            },
            success:function(res) {
                this._onStored = false;
                loader.hide();
                stored.push(res);
            },
            error : function(res) {
                loader.hide();
                alert(res.responseText);
            }
        });
    };
    this.getStoredData = function() {
        return this._storedData;
    };
}


$(document).ready(function() {
/**
 * Form Entry Valas
 */
$('#frmEntryValas').find("#prefix").on('keyup', function(e) {
    e.preventDefault();
    var newval = $(this).val();
    newval = newval.toUpperCase();
    $(this).val(newval);
});



});