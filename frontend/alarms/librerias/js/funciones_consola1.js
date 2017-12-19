function formulario(id,nom)
{
    document.getElementById('title_modal').innerHTML = nom;
    document.getElementById('title_modal').className = 'glyphicon glyphicon-edit';
    obtenerXHR('?actionID=formulario&servicio=' + id,'modal-body','modal-body');
}
function cargaConf()
{
    clientes = document.getElementById('l_clientes').value.split(",");
    for (i in clientes)
    {
        document.getElementById('cfg_'+clientes[i]).style.display = 'none';
    }

    document.getElementById('cfg_'+document.getElementById('cliente_conf').value).style.display = 'block';
}
function iniciarMonitoreo()
{
    location.href = "?monitorear";
}
function validarServicio()
{
    $.ajax({
        url:'servicios.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        data: ({actionID: 'validarServicio',nombre:$('#n_servicio').val()}),
        error:function(objeto, quepaso, otroobj){alert('Error');},
        success: function(data){
            if(data.val=='FALSE'){
                alert('Error al validar Servicio');
                return false;
            }
            if(data.ok == 1)
            {
                document.getElementById('crearServicio').style.display = 'block';
            }
            else
            {
                alert("El servicio ya existe");
            }
        }
    });
}
function guardarServicio()
{
    $.ajax({
        url:'servicios.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        data: ({actionID: 'guardarServicio',nombre:$('#n_servicio').val()}),
        error:function(objeto, quepaso, otroobj){alert('Error');},
        success: function(data){
            if(data.val=='FALSE'){
                alert('Error al guardar servicio');
                return false;
            }
            document.getElementById('id_servicio').value = data.id;
            document.getElementById('crearServicio').style.display = 'none';
            document.getElementById('defines').style.display = 'block';
            document.getElementById('nuevo').style.display = 'block';
        }
    });
}
function guardarParametro(item)
{
    if(document.getElementById('guardar_'+item).checked)
    {
        if($('#tipo_'+item).val() != '' && $('#nombre_'+item).val() != '' && $('#desc_'+item).val() != '')
        {
            $.ajax({
                url:'servicios.php',
                type: 'POST',
                cache: false,
                dataType: 'json',
                data: ({actionID: 'guardarParametro',tipo:$('#tipo_'+item).val(),nombre:$('#nombre_'+item).val(),desc:$('#desc_'+item).val(),servicio:$('#id_servicio').val()}),
                error:function(objeto, quepaso, otroobj){alert('Error');},
                success: function(data){
                    if(data.val=='FALSE'){
                        alert('Error al guardar parametro');
                        return false;
                    }
                    document.getElementById('guardado_'+item).innerHTML = 'Guardado';
                }
            });
        }
        else
        {
            alert("Complete los campos");
        }
    }
}
function nuevoItem()
{
    item = document.getElementById('item').value;
    item++;
    document.getElementById('item').value = item;
    var row = document.createElement('tr');
    var col = document.createElement('td');
    col.innerHTML = "<select id='tipo_" + item + "' name='tipo_" + item + "'><option value = ''>Seleccione una opcion</option><option value='text'>Text</option><option value='password'>Password</option></select>";
    row.appendChild(col);
    col = document.createElement('td');
    col.innerHTML = "<input name='nombre_" + item + "' id='nombre_" + item + "' type='text'>";
    row.appendChild(col);
    col = document.createElement('td');
    col.innerHTML = "<input name='desc_" + item + "' id='desc_" + item + "' type='text'>";
    row.appendChild(col);
    col = document.createElement('td');
    col.id = "guardado_"+item;
    col.innerHTML = "<input type='checkbox' id='guardar_"+item+"' value='1' onchange = 'guardarParametro("+item+")'>";
    row.appendChild(col);
    document.getElementById('params').appendChild(row);
    row.id = item;
}
function traeParametros()
{
    limpiaParametros();
    $('#id_servicio').val($('#n_servicio').val());
    $.ajax({
        url:'servicios.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        data: ({actionID: 'traeParametros',servicio:$('#n_servicio').val()}),
        error:function(objeto, quepaso, otroobj){alert('Error');},
        success: function(data){
            if(data.val=='FALSE'){
                alert('Error al traer parametros');
                return false;
            }
            if(data.define)
            {
                document.getElementById('defines').style.display = 'block';
                document.getElementById('nuevo').style.display = 'block';
                for (i in data.define)
                {
                    var row = document.createElement('tr');
                    var col = document.createElement('td');
                    text = (data.define[i].tipo == 'text')?"selected":"";
                    pass = (data.define[i].tipo == 'password')?"selected":"";
                    col.innerHTML = "<select id='tipog_" + i + "' name='tipog_" + i + "'><option value='text' " + text +" >Text</option><option value='password' " + pass +" >Password</option></select>";
                    row.appendChild(col);
                    col = document.createElement('td');
                    col.innerHTML = "<input name='nombreg_" + i + "' id='nombreg_" + i + "' type='text' value = '" + data.define[i].param + "'>";
                    row.appendChild(col);
                    col = document.createElement('td');
                    col.innerHTML = "<input name='descg_" + i + "' id='descg_" + i + "' type='text'  value = '" + data.define[i].desc + "'>";
                    row.appendChild(col);
                    col = document.createElement('td');
                    col.id = "guardadog_"+i;
                    col.innerHTML = "<input type='checkbox' id='guardarg_"+i+"' value='1' onchange = 'actualizarParametro("+i+")'>";
                    row.appendChild(col);
                    document.getElementById('params').appendChild(row);
                    row.id = item;
                }
            }
        }
    });
}
function limpiaParametros()
{
    lista = document.getElementById('params').children;
    for(var j=0;j<lista.length;j++)
    {
        if(lista[j].id != '')
        {
            document.getElementById('params').removeChild(lista[j]);
            j--;
        }
    }
}
function actualizarParametro(id)
{
    if(document.getElementById('guardarg_'+id).checked)
    {
        if($('#tipog_'+id).val() != '' && $('#nombreg_'+id).val() != '' && $('#descg_'+id).val() != '')
        {
            $.ajax({
                url:'servicios.php',
                type: 'POST',
                cache: false,
                dataType: 'json',
                data: ({actionID: 'actualizarParametro',id_param:id,tipo:$('#tipog_'+id).val(),nombre:$('#nombreg_'+id).val(),desc:$('#descg_'+id).val()}),
                error:function(objeto, quepaso, otroobj){alert('Error');},
                success: function(data){
                    if(data.val=='FALSE'){
                        alert('Error al actualizar parametro');
                        return false;
                    }
                    document.getElementById('guardadog_'+id).innerHTML = 'Actualizado';
                }
            });
        }
    }
}
function validaNum(e,especial)
{
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true; //Tecla de retroceso (para poder borrar)
    if (tecla==48) return true;
    if (tecla==49) return true;
    if (tecla==50) return true;
    if (tecla==51) return true;
    if (tecla==52) return true;
    if (tecla==53) return true;
    if (tecla==54) return true;
    if (tecla==55) return true;
    if (tecla==56) return true;
    if (tecla==57) return true;
    if(especial)
    {
        if (tecla==42) return true;
    }
    patron = /1/; //ver nota
    te = String.fromCharCode(tecla);
    return patron.test(te);
}
function ValidaRangos(id)
{
    cont = 0;
    if(document.getElementById(id).value.length >= 4 && document.getElementById(id).value.length <= 13)
    {
        num = document.getElementById(id).value;
        inf = 1000;
        sup = 9999;

        if(num.length > 4)
        {
            if(document.getElementById(id).value.slice(0,3) != '*03')
            {
                alert("Numero no valido");
                document.getElementById(id).value = '';
                return;
            }
            num = document.getElementById(id).value.slice(3, document.getElementById(id).value.length);
            inf = 3000000000;
            sup = 3500019999;

        }

        if(num > sup || num < inf)
        {
            alert("El numero no cumple con el rango esperado");
            document.getElementById(id).value = '';
            return;
        }
    }
    else
    {
        alert("El numero no cumple con la cantidad de digitos");
    }
}
function udpTurnos(campos)
{
    valores = campos.split(',');
    var conca = '';
    var sep = '';
    for (var i=0; i < valores.length; i++)
    {
        conca += sep + valores[i] + '!' + $('#campo_'+valores[i]).val();
        sep = '/';
    }
    $.ajax({
        url:'turnos.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        data: ({actionID:'udpTurnos',conca:conca}),
        error:function(objeto, quepaso, otroobj){alert('Error');},
        success: function(data){
            if(data.val=='FALSE'){
                alert('Error al actualizar los turnos');
                return false;
            }
            alert('Datos actualizados correctamente');
        }
    });
}
function abrirOpcion(pagina)
{
    obtenerXHR(pagina,'contenido','contenido');
}
function validarCliente()
{
    $.ajax({
        url:'cliente.html.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        data: ({actionID: 'validarCliente',nombre:$('#n_cliente').val()}),
        error:function(objeto, quepaso, otroobj){alert('Error');},
        success: function(data){
            if(data.val=='FALSE'){
                alert('Error al validar Cliente');
                return false;
            }
            if(data.ok == 1)
            {
                document.getElementById('crearCliente').disabled = false;
            }
            else
            {
                alert("El cliente ya existe");
            }
        }
    });
}
function guardarCliente()
{
    informe = ($('#n_informe').prop('checked'))?1:0;
    $.ajax({
        url:'cliente.html.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        data: ({actionID: 'obtenerToken',nombre:$('#n_cliente').val()}),
        error:function(objeto, quepaso, otroobj){alert('Error');},
        success: function(data){
            if(data.val=='FALSE'){
                alert('Error al obtener Token');
                return false;
            }
            $.ajax({
                url:'cliente.html.php',
                type: 'POST',
                cache: false,
                dataType: 'json',
                data: ({actionID: 'guardarCliente',nombre:$('#n_cliente').val(),token:data.info,informe:informe}),
                error:function(objeto, quepaso, otroobj){alert('Error');},
                success: function(data){
                    if(data.val=='FALSE'){
                        alert('Error al guardar Cliente');
                        return false;
                    }
                    alert("Cliente Guardado");
                    abrirOpcion('cliente.html.php');
                }
            });
        }
    });
}
function hab_edicion(id)
{
    document.getElementById('edit_' + id).style.display = 'none';
    document.getElementById('vis_' + id).style.display = 'none';
    document.getElementById('nom_' + id).style.display = 'block';
}
function validarDup(id)
{
    $.ajax({
        url:'cliente.html.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        data: ({actionID: 'validarDup',nombre:document.getElementById('nom_' + id).value,id:id}),
        error:function(objeto, quepaso, otroobj){alert('Error');},
        success: function(data){
            if(data.val=='FALSE'){
                alert('Error al actualizar Cliente');
                return false;
            }
            if(data.ok)
                document.getElementById('upd_' + id).style.display = 'block';
            else
                alert("No pueden haber duplicados");
        }
    });
}
function upd_cliente(id)
{
    valor = document.getElementById('nom_' + id).value;
    informe = ($('#inf_'+id).prop('checked'))?1:0;
    $.ajax({
        url:'cliente.html.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        data: ({actionID: 'obtenerToken',nombre:valor}),
        error:function(objeto, quepaso, otroobj){alert('Error');},
        success: function(data){
            if(data.val=='FALSE'){
                alert('Error al obtener Token');
                return false;
            }
            $.ajax({
                url:'cliente.html.php',
                type: 'POST',
                cache: false,
                dataType: 'json',
                data: ({actionID: 'upd_cliente',nombre:valor,token:data.info,id:id,informe:informe}),
                error:function(objeto, quepaso, otroobj){alert('Error');},
                success: function(data){
                    if(data.val=='FALSE'){
                        alert('Error al actualizar Cliente');
                        return false;
                    }
                    alert("Cliente Actualizado");
                    abrirOpcion('cliente.html.php?actionID=listar');
                }
            });
        }
    });
}
function validarUsuario()
{
    if($('#n_login').val() != '' && $('#n_contrasena').val() != '' && $('#n_nombre').val() != '' && $('#n_correo').val() != '' && $('#n_perfil').val() != '' && $('#n_cliente').val() != '')
    {
        $.ajax({
            url:'usuarios.php',
            type: 'POST',
            cache: false,
            dataType: 'json',
            data: ({actionID: 'validarLogin',nombre:$('#n_login').val()}),
            error:function(objeto, quepaso, otroobj){alert('Error');},
            success: function(data){
                if(data.val=='FALSE'){
                    alert('Error al validar Login');
                    return false;
                }
                if(data.ok == 1)
                {
                    $.ajax({
                        url:'usuarios.php',
                        type: 'POST',
                        cache: false,
                        dataType: 'json',
                        data: ({actionID: 'guardarUsuario',login:$('#n_login').val(),contrasena:$('#n_contrasena').val(),nombre:$('#n_nombre').val(),correo:$('#n_correo').val(),perfil:$('#n_perfil').val(),cliente:$('#n_cliente').val()}),
                        error:function(objeto, quepaso, otroobj){alert('Error');},
                        success: function(data){
                            if(data.val=='FALSE'){
                                alert('Error al guardar Usuario');
                                return false;
                            }
                            alert("Usuario Guardado");
                            abrirOpcion('usuarios.php');
                        }
                    });
                }
                else
                {
                    alert("El login existe");
                }
            }
        });
    }
    else
    {
        alert("Debe diligenciar completo los items");
    }
}
function cargarUsuario()
{
    if($('#n_nombre').val() != '')
    {
        $.ajax({
            url:'usuarios.php',
            type: 'POST',
            cache: false,
            dataType: 'json',
            data: ({actionID: 'traeUsuario',usuario:$('#n_nombre').val()}),
            error:function(objeto, quepaso, otroobj){alert('Error');},
            success: function(data){
                if(data.val=='FALSE'){
                    alert('Error al traer información del Usuario');
                    return false;
                }

                $('#n_login').val(data.info.login);
                $('#n_contrasena').val(data.info.contrasena);
                $('#n_correo').val(data.info.correo);
                $('#n_perfil').val(data.info.perfil);
                $('#n_cliente').val(data.info.empresa);
            }
        });
    }
}
function actualizarUsuario()
{
    if($('#n_login').val() != '' && $('#n_contrasena').val() != '' && $('#n_nombre').val() != '' && $('#n_correo').val() != '' && $('#n_perfil').val() != '' && $('#n_cliente').val() != '')
    {
        $.ajax({
            url:'usuarios.php',
            type: 'POST',
            cache: false,
            dataType: 'json',
            data: ({actionID: 'updUsuario',contrasena:$('#n_contrasena').val(),usuario:$('#n_nombre').val(),correo:$('#n_correo').val(),perfil:$('#n_perfil').val(),cliente:$('#n_cliente').val()}),
            error:function(objeto, quepaso, otroobj){alert('Error');},
            success: function(data){
                if(data.val=='FALSE'){
                    alert('Error al actualizar Usuario');
                    return false;
                }
                alert("Usuario Actualizado");
                abrirOpcion('usuarios.php');
            }
        });
    }
    else
    {
        alert("Debe diligenciar completo los items");
    }
}
function integrarSpark()
{
    window.location = 'https://api.ciscospark.com/v1/authorize?client_id=C14b8fdc411b38ea02bd0c19bd760f5517456953f2f8275bbb8afcec97e48cbda&response_type=code&redirect_uri=http%3A%2F%2Falarms.infomediaservice.com%2Falarms%2Finicio.php&scope=spark%3Amessages_write%20spark%3Arooms_read%20spark%3Akms&state=set_state_here';
}