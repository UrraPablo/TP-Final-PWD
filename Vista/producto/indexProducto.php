<?php 
    include_once "../estructura/headPrivado.php";
?>
<head>
    <meta charset="UTF-8">
    <title>Lista Productos</title>
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/color.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/demo/demo.css">
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
</head>
<body style="margin:0; padding:0">
    <h1>Lista de Todos los Productos</h1>
    
    <table id="dg" title="My Users" class="easyui-datagrid" style="width:1200px;height:400px"
            url="accion/list_producto.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="idproducto" width="20">Id</th>
                <th field="pronombre" width="70">Nombre</th>
                <th field="prodetalle" width="70">Detalle</th>
                <th field="procantstock" width="50">Stock</th>
                <th field="precio" width="50">Precio</th>
                <th field="imagen" width="80">Imagen</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevoProducto()">Nuevo Producto</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editarProducto()">Editar Producto</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Dar de baja Producto</a>
    </div>
    
    <div id="dlg_nuevo" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-boton'">
        <form id="fm_nuevo" method="post" novalidate style="margin:0;padding:20px 50px">
            <h4>Informacion de Producto</h4>
            
  
                <input name="idproducto" class="easyui-textbox" value="0" type="hidden">
            
            <div style="margin-bottom:10px">
                <input name="pronombre" class="easyui-textbox" required="true" label="Nombre:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="prodetalle" class="easyui-textbox" required="true" label="Detalle:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="procantstock" class="easyui-textbox" required="true" label="Stock:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="precio" class="easyui-textbox" required="true" label="Precio:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="imagen" class="easyui-textbox" required="true" label="Imagen:" style="width:100%">
            </div>
            
        </form>
    </div>
    <div id="dlg_edit" class="easyui-dialog" style="width:500px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm_edit" method="post" novalidate style="margin:0;padding:20px 50px">
            <h4>Informacion del Producto</h4>
            <div style="margin-bottom:10px">
                <input name="idproducto" class="easyui-textbox" required="true" label="I.D:" readonly style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="pronombre" class="easyui-textbox" required="true" label="Nombre:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="prodetalle" class="easyui-textbox" required="true" label="Detalle:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="procantstock" class="easyui-textbox" required="true" label="stock:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="precio" class="easyui-textbox" required="true" label="Precio:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="imagen" class="easyui-textbox" required="true" label="Imagen:" style="width:100%">
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveProductoEdit()" style="width:90px">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_edit').dialog('close')" style="width:90px">Cancelar</a>
    </div>
    <div id="dlg-boton">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveProductoNuevo()" style="width:90px">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_nuevo').dialog('close')" style="width:90px">Cancelar</a>
    </div>
    <script type="text/javascript">
        var url;
        function nuevoProducto(){
            $('#dlg_nuevo').dialog('open').dialog('center').dialog('setTitle','Producto Nuevo');
            $('#fm_nuevo').form('clear');
            url = 'accion/alta_producto.php';
        }
        function editarProducto(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg_edit').dialog('open').dialog('center').dialog('setTitle','Editar Producto');
                $('#fm_edit').form('load',row);
                url = 'accion/editar_producto.php?id='+row.id;
            }
        }
        function saveProductoNuevo(){
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
        function saveProductoEdit(){
            $('#fm_edit').form('submit',{
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
                        $('#dlg_edit').dialog('close');        // close the dialog
                        $('#dg').datagrid('reload');    // reload the user data
                    }
                }
            });
        }
        function destroyUser(){
                var row = $('#dg').datagrid('getSelected');
                if (row){
                    $.messager.confirm('Confirm','Seguro que desea eliminar el producto?', function(r){
                        if (r){
                            $.post('accion/eliminar_producto.php?idproducto='+row.idproducto,{idproducto:row.id},
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
