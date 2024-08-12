<?php 
    include_once "../estructura/headPrivado.php";
   // var_dump($objSession->getRol()[0]);
?>
<head>
    <meta charset="UTF-8">
    <title>Lista de Roles</title>
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/color.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/demo/demo.css">
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
</head>
<body style="margin:0; padding:0">
    <h1>Lista de Todos los Roless</h1>
    <h4>ver la forma de hacer un borrado logico con los roles </h4>
    
    <table id="dg" title="Roles" class="easyui-datagrid" style="width:700px;height:450px"
            url="accion/list_rol.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="idrol" width="20">Id</th>
                <th field="rodescripcion" width="50">Descripción</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo Rol</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar Rol</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Dar de baja Rol</a>
        
    </div>
    
    <div id="dlg_nuevo" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-boton'">
        <form id="fm_nuevo" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Informacion del Rol</h3>
            
                <input name="idrol" class="easyui-textbox" value="0" type="hidden">
            
            <div style="margin-bottom:10px">
              <label for="rodescripcion">Descripcion:</label>
                <input name="rodescripcion" class="easyui-textbox" required="true" style="width:100%">
            </div>
            
        </form>
    </div>
    <div id="dlg_edit" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm_edit" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Informacion del Rol</h3>
            <div style="margin-bottom:10px">
                <input name="idrol" class="easyui-textbox" required="true" label="I.D:" readonly style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="rodescripcion" class="easyui-textbox" required="true" label="Rol:" style="width:100%">
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUserEdit()" style="width:90px">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_edit').dialog('close')" style="width:90px">Cancel</a>
    </div>
    <div id="dlg-boton">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUserNuevo()" style="width:90px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_nuevo').dialog('close')" style="width:90px">Cancel</a>
    </div>
    <script type="text/javascript">
        var url;
        function newUser(){
            $('#dlg_nuevo').dialog('open').dialog('center').dialog('setTitle','New Rol');
            $('#fm_nuevo').form('clear');
            url = 'accion/alta_rol.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg_edit').dialog('open').dialog('center').dialog('setTitle','Edit User');
                $('#fm_edit').form('load',row);
                url = 'accion/editar_rol.php?id='+row.id;
            }
        }
        function saveUserNuevo(){
            $('#fm_nuevo').form('submit',{
                url: url,
                iframe: false,
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#dlg_nuevo').dialog('close');        // close the dialog
                        $('#dg').datagrid('reload');    // reload the user data
                    }
                }
            });
        }
        function saveUserEdit(){
            $('#fm_edit').form('submit',{
                url: url,
                iframe: false,
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success: function(result){
                    console.log(result);
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#dlg_edit').dialog('close');        // close the dialog
                        $('#dg').datagrid('reload');    // reload the user data
                    }
                }
            });
        }
        function destroyUser(){
                var row = $('#dg').datagrid('getSelected');
                if (row){
                    $.messager.confirm('Confirm','Seguro que desea eliminar el rol?', function(r){
                        if (r){
                            $.post('accion/eliminar_rol.php?idrol='+row.idrol,{idrol:row.id},
                               function(result){ 
                                    JSON.parse(result);
                                    console.log(result);
                                   	 if(result.bajaUR!=='ok'){ 
                                    $('#dg').datagrid('reload');    // reload the  data
                                 } else {
                                     $.messager.show({    // show error message
                                         title: 'Error',
                                         msg: 'Hubo un problema con la baja del rol'
                                   });
                                 }
                            });// , json
                        }
                    });
                }
            }
            function habilitarUser(){
                var row = $('#dg').datagrid('getSelected');
                if (row){
                    $.messager.confirm('Confirm','Seguro que desea habilitar al usuario?', function(r){
                        if (r){
                            $.post('accion/habilitar_rol.php?idrol='+row.idrol,{idrol:row.id},
                               function(result){ 
                                 if (result.respuesta){
                                   	 
                                    $('#dg').datagrid('reload');    // reload the  data
                                } else {
                                    $.messager.show({    // show error message
                                        title: 'Error',
                                        msg: result.errorMsg
                                  });
                                }
                            },'json');
                        }
                    });
                }
            }            
    </script>
</body>
<?php
include_once "../estructura/footer.php";
?>