require(["jquery"], function($) {

    //Seleccionamos en el menu la opcion: Generador de plantillas de contenido
    $('.docheader-funcmenu select option:eq(1)').attr('selected', 'selected');

    let countRow     = 0;
    let countColum   = 0;
    let countContent = 0;
    let limitColumns = 12;
    let completeTpl  = new Object();
    
    function findPathsToKey(options) {
        let results = [];
      
        (function findKey({
          key,
          obj,
          pathToKey,
        }) {
          const oldPath = `${pathToKey ? pathToKey + "." : ""}`;
          if (obj.hasOwnProperty(key)) {
            results.push(`${oldPath}${key}`);
            return;
          }
      
          if (obj !== null && typeof obj === "object" && !Array.isArray(obj)) {
            for (const k in obj) {
              if (obj.hasOwnProperty(k)) {
                if (Array.isArray(obj[k])) {
                  for (let j = 0; j < obj[k].length; j++) {
                    findKey({
                      obj: obj[k][j],
                      key,
                      pathToKey: `${oldPath}${k}[${j}]`,
                    });
                  }
                }
      
                if (obj[k] !== null && typeof obj[k] === "object") {
                  findKey({
                    obj: obj[k],
                    key,
                    pathToKey: `${oldPath}${k}`,
                  });
                }
              }
            }
          }
        })(options);
      
        return results;
    }

    function deleteObjElement($container) {
        let parentKey = $container.attr('id');
        let pathToElem = findPathsToKey({ obj: completeTpl, key: parentKey}).join("");
        eval("delete completeTpl."+pathToElem);
        $('#cargando').hide();
    }
      

    function calcColumnsTpl($container){
        let elemColums   = $container.children('.tplColumn');
        let countColumns = elemColums.length;
        if(countColumns > 0)
        {
            let numByColum = Math.floor(limitColumns / countColumns);
            elemColums.each(function(index){
                $( this ).attr('class','tplColumn col-sm-'+numByColum);
            })
        }

        $('#cargando').hide();
    }

    function addRow($container){
        countRow++;
        let tplRow = `<div class="row">
            <div class="tplRow col-sm-12">
                <div id="r_${countRow}" class="panel panel-default">
                    <div class="panel-heading">
                        <div class="form-group panel-title">
                            <div class="panel-controls">
                                <button type="button" data-target="#r_${countRow}" class="btn btn-danger badge pull-right delete"><i class="fa fa-times"></i> Eliminar</button>
                            </div>
                            <label for="inputRC_${countRow}">Fila</label>
                            <input type="text" data-target="r_${countRow}" class="form-control custom-class" id="inputRC_${countRow}" placeholder="Clase personalizada">
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 controls">
                                <button data-target="#r_${countRow}" type="button" class="btn btn-success badge add-column"><i class="fa fa-plus"></i> Columna</button>
                            </div>
                        </div>
                        <div class="row columnsContent">
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
        
        $container.find('.panel-body').first().append($(tplRow));

        let parentKey = $container.attr('id');
        if(parentKey == 'contenedor')
        {
            completeTpl[`r_${countRow}`] = { customClass:'', columns:{} };
        }else{
            let pathToElem = findPathsToKey({ obj: completeTpl, key: parentKey}).join("");
            eval("completeTpl."+pathToElem+".rows['r_"+countRow+"'] = { customClass:'', columns:{} }");
        }

        $('#cargando').hide();
    }

    function addColumn($container){
        countColum++;
        let tplColumn = `
            <div class="tplColumn col-sm-12">
                <div id="c_${countColum}" class="panel panel-default">
                    <div class="panel-heading">
                        <div class="form-group panel-title">
                            <div class="panel-controls">
                                <button type="button" data-target="#c_${countColum}" class="btn btn-danger badge pull-right delete-column"><i class="fa fa-times"></i> Eliminar</button>
                            </div>
                            <label for="inputCC_${countColum}">Columna</label>
                            <input type="text" data-target="c_${countColum}" class="form-control custom-class" id="inputCC_${countColum}" placeholder="Clase personalizada">
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 controls">
                                <button type="button" data-target="#c_${countColum}" class="btn btn-success badge add-row"><i class="fa fa-plus"></i> Fila</button>
                                <button type="button" data-content="title" data-target="#c_${countColum}" class="btn btn-success badge add-content"><i class="fa fa-plus"></i> T&iacute;tulo</button>
                                <button type="button" data-content="teaser" data-target="#c_${countColum}" class="btn btn-warning badge add-content"><i class="fa fa-plus"></i> Teaser</button>
                                <button type="button" data-content="media" data-target="#c_${countColum}" class="btn btn-primary badge add-content"><i class="fa fa-plus"></i> Multimedia</button>
                                <button type="button" data-content="fecha" data-target="#c_${countColum}" class="btn btn-info badge add-content"><i class="fa fa-plus"></i> Fecha</button>
                                <button type="button" data-content="logo" data-target="#c_${countColum}" class="btn btn-default badge add-content"><i class="fa fa-plus"></i> Logo</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>`;
        $container.find('.panel-body').first().children('.columnsContent').append($(tplColumn));

        let parentKey = $container.attr('id');
        let pathToElem = findPathsToKey({ obj: completeTpl, key: parentKey}).join("");
        eval("completeTpl."+pathToElem+".columns['c_"+countColum+"'] = { customClass:'', rows:{}, media:{}, title:{}, teaser:{}, fecha:{}, logo:{} }");
    }
    function addContent($container, contenido){
        countContent++;
        contenido = (typeof contenido !== 'undefined') ?  contenido : 'title';
        contenidoTxt = 'T&iacute;tulo';

        switch (contenido) {
            case 'media':
                contenidoTxt = 'Multimedia';
                break;
            case 'teaser':
                contenidoTxt = 'Teaser';
                break;
            case 'fecha':
                contenidoTxt = 'Fecha';
                break;
            case 'logo':
                contenidoTxt = 'Logo';
                break;
            default:
                contenidoTxt = 'T&iacute;tulo';
                break;
        }

        let tplContent = `<div class="row">
            <div class="tplContent col-sm-12">
                <div id="cnt_${countContent}" class="panel panel-default">
                    <div class="panel-heading">
                        <div class="form-group panel-title">
                            <div class="panel-controls">
                                <button type="button" data-target="#cnt_${countContent}" class="btn btn-danger badge pull-right delete"><i class="fa fa-times"></i> Eliminar</button>
                            </div>
                            <label for="inputCnt_${countContent}">${contenidoTxt}</label>
                            <input type="text" data-target="cnt_${countContent}" class="form-control custom-class" id="inputCnt_${countContent}" placeholder="Clase personalizada">
                        </div>
                    </div>
                    <!--
                    <div class="panel-body">
                       ...
                    </div>
                    -->
                </div>
            </div>
        </div>`;

        $container.find('.panel-body').first().append($(tplContent));

        let parentKey = $container.attr('id');
        let pathToElem = findPathsToKey({ obj: completeTpl, key: parentKey}).join("");
        eval("completeTpl."+pathToElem+"."+contenido+"['cnt_"+countContent+"'] = { customClass:''}");

        $('#cargando').hide();
    }

    function prepareCompleteTpl() {
        let tplName = $.trim($('#tplName').val());
        if(tplName != ''){
            $('.custom-class').each(function(index) {
                let value = $.trim($(this).val());
                if(value != ''){
                    let parentKey =  $(this).attr('data-target');
                    let pathToElem = findPathsToKey({ obj: completeTpl, key: parentKey}).join("");
                    eval("completeTpl."+pathToElem+".customClass = value");
                }
            });

            if(Object.keys(completeTpl).length > 0)
            {
                let allContent  = new Object();

                allContent['isContent'] = 1;
                allContent['tplName']   = tplName;
                allContent['tpl']       = completeTpl;

                let url = $('#tplForm').attr('action');
                $.ajax({
                    url: url,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        "tx_unalconvergencemodule_web_unalconvergencemoduleunalcvgtplbuilder[data]":JSON.stringify(allContent)
                    },
                    beforeSend:function(){
                        $('#cargando').show();
                    },
                    success: function (data) {
                        if(data.status){
                            window.location.href = $('#btn-home').attr('href')
                        }else{
                            alert(data.message);
                        }
                        $('#cargando').hide();
                    },
                    error: function(request, status, error) {
                        alert("Ocurrió un error, por favor intente más tarde");
                        $('#cargando').hide();
                    }
                });
                
            }else{
                $('#cargando').hide();
                alert("Debe crear una plantilla.")
            }

        }else{
            $('#cargando').hide();
            alert("Debe asignarle un nombre a la plantilla.")
        }
    }

    $(document).on("click", ".add-row", function(){
        $('#cargando').show();
        let target = $(this).attr("data-target");
        addRow($(target));
    });

    $(document).on("click", ".add-column", function(){
        $('#cargando').show();
        let target = $(this).attr("data-target");
        let elemColums   = $(target).find('.columnsContent').first().children('.tplColumn');
        let countColumns = elemColums.length;
        if(countColumns < limitColumns)
        {
            addColumn($(target));
            calcColumnsTpl($(target).find('.columnsContent').first());
        }else{
            $('#cargando').hide();
            alert("No se permiten más de "+limitColumns+" columnas.")
        }
    });
    $(document).on("click", ".add-content", function(){
        $('#cargando').show();
        let target  = $(this).attr("data-target");
        let content = $(this).attr("data-content");
        addContent($(target), content);
    });

    $(document).on("click", ".delete", function(){
        $('#cargando').show();
        let target = $(this).attr("data-target");
        deleteObjElement($(target));
        $(target).parent().parent().remove();
    });
    
    $(document).on("click", ".delete-column", function(){
        $('#cargando').show();
        let target = $(this).attr("data-target");
        let parentTarget = $(target).parent().parent();
        deleteObjElement($(target));
        $(target).parent().remove();
        calcColumnsTpl(parentTarget);
    });


    $('#saveTpl').click(function(e) {
        $('#cargando').show();
        prepareCompleteTpl();
    });



});