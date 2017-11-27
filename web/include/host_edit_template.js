$(document).ready(function(){
    $.ajaxSetup({async: false});
    
    $("#op-warn").dialog({
        autoOpen: false,
        height: 150,
        width: 200,
        modal: true,
        buttons: {
            "返回": function() {
                $(this).dialog( "close" );
            }
        }
    });
    
    
    $("#add_gt_x").click(
        function() {
            $("#available-template-list").dialog({
                autoOpen: true,
                dialogClass: "graph_template_id_dialog",
                height: 300,
                width: 550,
                position: getPosition("available-template-list", 300),
                title: '关键字(空格分隔)：',
                modal: true,
                buttons: {
                    "保存": function() {
                        $("input[name=graph_template_id]:checked").each(
                            function() {
                                $.post('host.php',
                                       {action: 'save',
                                        id: $("#id").val(),
                                        add_gt_x: 'OK',
                                        graph_template_id: $(this).val(),
                                        ajax: 'YES'
                                       }
                                      );
                            }
                        );
                        
                        $("#host-edit-template").load('host.php?action=host_template&ajax=yes&id=' + $('#id').val());
                        $(this).dialog( "close" );
                    },
                    "返回": function() {
                        $(this).dialog( "close" );
                    }
                },
                open: function() {
                    buildSearchBox('graph_template_id');
                },
                close: function() {
                    $('input[name=graph_template_id]').attr('checked', false);
                }
            });       
            
        }
    );
    
    function buildSearchBox(idField) {
        if($('#' + idField + '_search').length == 0) {
            $('.' + idField + '_dialog .ui-dialog-titlebar').after('<input type="text" id="' + idField + '_search" maxlength="255" style="position:absolute;top:7px;left:130px;">');
            
            $('#' + idField + '_search').keyup(function() {
                filterOptions(idField + "_wrapper", $(this).val());
            });
        } else {
            $('#' + idField + '_search').val('');
            filterOptions(idField + "_wrapper", "");
        }

    }
    
    function filterOptions(controlName, keyword) {
        $('.' + controlName).each(function() {
            var re = new RegExp($.trim(keyword).replace(" ", ".*"), "i");
            
            if(keyword == "" || ($(this).attr('title').search(re) >= 0)) {
                $(this).show();
                $("input", this).show();
            } else {
                $(this).hide();
                $("input", this).hide();
            }
            
        });
        //alert(keyword);
    }
    
    $("#remove_gt_x").click(
        function() {
            if($("input[name=graph_template_select]:checked").length == 0) {
                $("#op-warn").html("<p>请选择要删除的记录。</p>");
                $("#op-warn").dialog("option", "position", getPosition("op-warn", 150));
                $("#op-warn").dialog("open");
            } else {
                $("#template-delete-confirm").html("是否删除所选模板？");
                $("#template-delete-confirm").dialog({
                    autoOpen: true,
                    height: 150,
                    width: 200,
                    position: getPosition("template-delete-confirm", 150),
                    modal: true,
                    buttons: {
                        "删除": function() {
                            delete_template();
                            $(this).dialog( "close" );
                        },
                        "返回": function() {
                            $(this).dialog( "close" );
                        }
                    }
                });
            }
        }
    );
    
    $("#add_t_graph").click(
        function() {
            if($(".nograph input[name=graph_template_select]:checked").length == 0) {
                $("#op-warn").html("<p>请选择要添加图形的模板。</p>");
                $("#op-warn").dialog("option", "position", getPosition("op-warn", 150));
                $("#op-warn").dialog("open");
            } else {
                var d = {cg_g: 0};
                
                $(".nograph input[name=graph_template_select]:checked").each(
                    function() {
                        d['cg_' + $(this).val()] = 'on';
                    }
                );
                        
                add_host_graph('template', d, {});
            }

        }
    );
    
    $("#remove_t_graph").click(
        function() {
            if($(".graphed input[name=graph_template_select]:checked").length == 0) {
                $("#op-warn").html("<p>请选择要删除图形的模板。</p>");
                $("#op-warn").dialog("option", "position", getPosition("op-warn", 150));
                $("#op-warn").dialog("open");
            } else {
                $("#template-delete-confirm").html("是否删除所选图形？");
                $("#template-delete-confirm").dialog({
                    autoOpen: true,
                    height: 150,
                    width: 200,
                    position: getPosition("template-delete-confirm", 150),
                    modal: true,
                    buttons: {
                        "删除": function() {
                            var d = {'type': 'template', 'graph_template_id': ''};
                            
                            $(".graphed input[name=graph_template_select]:checked").each(
                                function() {
                                    d.graph_template_id = d.graph_template_id + ',' + $(this).val();
                                }
                            );
                                    
                            remove_host_graph(d);
                            $(this).dialog( "close" );
                        },
                        "返回": function() {
                            $(this).dialog( "close" );
                        }
                    }
                });
            }
        }
    );    
    
    $("#add_dq_x").click(
        function() {
            $("#available-query-list").load('host.php?action=load_available_query&id=' + $('#id').val());
            $("#available-query-list").dialog({
                autoOpen: true,
                dialogClass: "snmp_query_id_dialog",
                height: 300,
                width: 550,
                position: getPosition("available-query-list", 300),
                title: '关键字(空格分隔)：',
                modal: true,
                buttons: {
                    "保存": function() {
                        $("input[name=snmp_query_id]:checked").each(
                            function() {
                                $.post('host.php',
                                       {action: 'save',
                                        id: $("#id").val(),
                                        add_dq_x: 'OK',
                                        snmp_query_id: $(this).val(),
                                        reindex_method: $("#reindex_method_" + $(this).val()).val(),
                                        ajax: 'YES'
                                       }
                                      );
                            }
                        );
                        
                        reload_snmp_list();
                        $(this).dialog( "close" );
                    },
                    "返回": function() {
                        $(this).dialog( "close" );
                    }
                },
                open: function() {
                    buildSearchBox('snmp_query_id');
                },
                close: function() {
                    $('input[name=snmp_query_id]').attr('checked', false);
                }
            });
        }
    );
    
    $("#remove_dq_x").click(
        function() {
            if($("input[name=graph_query_select]:checked").length == 0) {
                $("#op-warn").html("<p>请选择要删除的记录。</p>");
                $("#op-warn").dialog("option", "position", getPosition("op-warn", 150));
                $("#op-warn").dialog("open");
            } else {
                $("#query-delete-confirm").dialog({
                    autoOpen: true,
                    height: 150,
                    width: 200,
                    position: getPosition("query-delete-confirm", 150),
                    modal: true,
                    buttons: {
                        "删除": function() {
                            $("input[name=graph_query_select]:checked").each(
                                function() {
                                    $.get('host.php',
                                           {action: 'query_remove',
                                            host_id: $("#id").val(),
                                            id: $(this).val(),
                                            ajax: 'YES'
                                           }
                                          );
                                    
                                    //
                                }
                            );
                            
                            reload_snmp_list();
                            $(this).dialog( "close" );
                        },
                        "返回": function() {
                            $(this).dialog( "close" );
                        }
                    }
                });
            }
        }
    );        
    
    attach_query_action();
    
    
    
    
    
    function reload_snmp_list() {
        $("#host-edit-query").load('host.php?action=host_query&ajax=yes&id=' + $('#id').val());
        attach_query_action();
    }
    
    function attach_query_action() {
        $("input.toggle-query-button").click(
            function() {
                var cid = $(this).attr("id");
                $("#query-detail-wrapper").load("graphs_new.php?graph_type=" + cid + "&host_id=" + $("#id").val() + "&ajax=1",
                                                function() {
                                                    //alert(initDqDeps.length);
                                                    dq_update_deps(initDqDeps[0][0], initDqDeps[0][1]);
                                                    dq_update_selection_indicators();
                                                });
                $("#query-detail-wrapper").dialog({
                    autoOpen: true,
                    dialogClass: "query_detail_id_dialog",
                    height: 400,
                    width: 800,
                    position: getPosition("query-detail-wrapper", 400),
                    title: '关键字(空格分隔)：',
                    modal: true,
                    buttons: {
                        "确认": function() {
                            var d = {};
                            var gid = $("#sgg_" + cid).val();
                            var needCreate = false;
                            
                            d["sgg_" + cid] = gid;
                            
                            $("form[name=chk2] input:checked").each(function() {
                                var prefix = "sg_" + cid + "_";
                                var pureName = $(this).attr('name').substr(prefix.length);
                                
                                if($.inArray(pureName, created_graphs[gid]) == -1) {
                                    d[$(this).attr('name')] = "on";
                                    needCreate = true;
                                }

                            });
                            
                            var del = {'type': 'snmp',
                                       snmp_query_id: cid, 
                                       snmp_query_graph_id: gid,
                                       snmp_index: ''};
                            $("form[name=chk2] input[type=checkbox]").not(':checked').each(function() {
                                var prefix = "sg_" + cid + "_";
                                var pureName = $(this).attr('name').substr(prefix.length);
                                
                                if($.inArray(pureName, created_graphs[gid]) != -1) {
                                    del.snmp_index = del.snmp_index + ',' + pureName;
                                }

                            });
                            
                            
                            $(this).dialog( "close" );
                            if(needCreate) {
                                add_host_graph('snmp', d, del);
                            } else if(del.snmp_index != '') {
                                remove_host_graph(del);
                            }
                        },
                        "返回": function() {
                            $(this).dialog( "close" );
                        }
                    },
                    open: function() {
                        buildSearchBox('query_detail_id');
                    }
                });
            }
        );        
    }

    function delete_template() {
        $("input[name=graph_template_select]:checked").each(
            function() {
                $.get('host.php',
                       {action: 'gt_remove',
                        host_id: $("#id").val(),
                        id: $(this).val(),
                        ajax: 'YES'
                       }
                      );
                
                //
            }
        );
        
        $("#host-edit-template").load('host.php?action=host_template&ajax=yes&id=' + $('#id').val());
    }
        
    function add_host_graph(gType, gData, gDel) {
        var options = 
               {action: 'save',
                host_id: $("#id").val(),
                host_template_id: $("#_host_template_id").val(),
                save_component_graph: 1,
                ajax: 'YES'
               };
        
        $.extend(true, options, gData);

        $.post('graphs_new.php',
                options,
                function (data) {
                    if(data != 'OK') {
                        $("#dialog-wrapper").html(data);
                        
                        $("#dialog-wrapper").dialog({
                            autoOpen: true,
                            height: 300,
                            width: 500,
                            position: getPosition("dialog-wrapper", 300),
                            modal: true,
                            buttons: {
                                "确认": function() {
                                    $("#dialog-wrapper form").ajaxSubmit({data: {ajax: 'yes'}});
                                    if(gType == 'template') {
                                        $("#host-edit-template").load('host.php?action=host_template&ajax=yes&id=' + $('#id').val());
                                    }
                                    $(this).dialog( "close" );
                                    if(gDel.snmp_index) {
                                        remove_host_graph(gDel);
                                    }
                                },
                                "返回": function() {
                                    $(this).dialog( "close" );
                                }
                            }
                        });
                    } else {
                        if(gType == 'template') {
                            $("#host-edit-template").load('host.php?action=host_template&ajax=yes&id=' + $('#id').val());
                        }
                        if(gDel.snmp_index) {
                            remove_host_graph(gDel);
                        }
                    }
                }
              );
                              

        
    }
    
    function remove_host_graph(gData) {
        var options = 
               {action: 'fetch_and_delete',
                host_id: $("#id").val(),
                ajax: 'YES'
               };
        
        $.extend(true, options, gData);
        
        $.post('graphs.php',
                options,
                function (data) {
                    if(data != 'OK') {
                        $("#dialog-wrapper").html(data);
                        
                        $("#dialog-wrapper").dialog({
                            autoOpen: true,
                            height: 300,
                            width: 500,
                            position: getPosition("dialog-wrapper", 300),
                            modal: true,
                            buttons: {
                                "确认": function() {
                                    $("#delete-confirm-form").ajaxSubmit({data: {ajax: 'yes'}});
                                    if(options.type == 'template') {
                                        $("#host-edit-template").load('host.php?action=host_template&ajax=yes&id=' + $('#id').val());
                                    }
                                    $(this).dialog( "close" );
                                },
                                "返回": function() {
                                    $(this).dialog( "close" );
                                }
                            }
                        });
                    }
                }
              );
                              

        
    }
    
    //$("body").keyup(function(event){
    //    if(event.which == 81) {
    //        var scrTop = $(top.document).find("html").scrollTop();
    //        console.log("top html scrollTop: " + scrTop);
    //   }
    //});
    
    function getPosition(id, height) {
        //console.log("--->");
        
        var scrTop = $(top.document).find("html").scrollTop();
        var cliHeight = $(top.document).find("html").attr("clientHeight");
        var frm1 = $(top.document).find("iframe#main").offset();
        var frm2 = $(top.document).find("iframe#main").contents().find("iframe#frame_content").offset();
        var dHeight = height; //$('#' + id).closest('.ui-dialog').height();
        var pTop = scrTop -frm1.top - frm2.top + (cliHeight - dHeight) / 2;
        
        //$('#' + id).closest('.ui-dialog').css("top", pTop + "px");
        
        //console.log("--->");
        //console.log("   top html scrollTop: " + scrTop);
        //console.log("   frm1 offset top: " + frm1.top);
        //console.log("   frm1 offset left: " + frm1.left);
        //console.log("   frm2 offset top: " + frm2.top);
        //console.log("   frm2 offset left: " + frm2.left);
        //console.log("   client Height: " + cliHeight);
        //console.log("   dHeight: " + dHeight);
        //console.log("   pTop: " + pTop);
        
        return ["center", pTop];
        
    }
    
});
