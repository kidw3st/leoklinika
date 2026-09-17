$(function () {
    $('#jstree').on("move_node.jstree", function (e, data) {
        var $current = $('#' + data.node.id);
        var $newParent = $('#' + data.parent);
        var type = '';

        if (data.position == 0) {
            type = 'inside';
        } else {
            $newParent = $newParent.children('ul').children('li').eq(data.position - 1);
            type = 'after';
        }

        $.ajax({
            method: "GET",
            url: "",
            data: { type: type, pid: $newParent.attr('data-id'), id: data.node.data.id }
        });
    }).jstree({
        "core" : {
            "animation" : 0,
            "check_callback" : true,
            "themes" : { "stripes" : true }
        },
        "types" : {
            "#" : {
                "max_children" : 1,
                "max_depth" : 6,
                "valid_children" : ["root"]
            },
            "default" : {
                "valid_children" : ["default"]
            },
        },
        "contextmenu":{
            "items": function($node) {
                return {
                    goToElement: {
                        "label" : "Редактировать",
                        "action" : function(obj) {
                            location.href = obj.reference.parent().attr('data-url');
                        }
                    }
                };
            }
        },
        "plugins" : [
            "contextmenu", "dnd", "search",
            "state", "types", "wholerow"
        ]
    });
});