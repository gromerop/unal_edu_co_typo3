require(["jquery"], function($) {

    let layoutObj = JSON.parse(layout);

    let countRow     = 0;
    let countColum   = 0;
    let countContent = 0;
    let limitColumns = 12;
    let tempCntRow   = 0;
    let tempCntCol   = 0;
    let tempCntCnt   = 0;
    let completeTpl  = new Object();

    let $contenedor       = $("#contenedor");
    let selectTplContents = $('#tplContents');
    let selectTplCntTpls  = $('#tplCntTpls');

    function renderLayout(layoutObj, $container) {
        
        for (const k in layoutObj) {
            let kArr = k.split('_');
            if(kArr[0] == 'r')
            {
                let customClass = layoutObj[k].customClass;
                let columns     = layoutObj[k].columns;
                    
                addRow($container, kArr[1], customClass);
                if(parseInt(kArr[1])>tempCntRow){
                    tempCntRow = parseInt(kArr[1]);
                }

                if(Object.keys(columns).length>0){
                    for (const kk in columns) {
                        let kkArr = kk.split('_');
                        if(kkArr[0] == 'c')
                        {
                            let customClass = columns[kk].customClass;
                            let rows        = columns[kk].rows;
                            let contents    = columns[kk].contents;
                            addColumn($('#'+k), kkArr[1], customClass);
                            if(parseInt(kkArr[1]) > tempCntCol){
                                tempCntCol = parseInt(kkArr[1]);
                            }
                            calcColumnsTpl($('#'+k).find('.columnsContent').first());

                            if(Object.keys(contents).length>0){
                                for (const cc in contents) {
                                    let ccArr = cc.split('_');
                                    if(ccArr[0] == 'cnt')
                                    {
                                        let customClass = contents[cc].customClass;
                                        let cntId       = contents[cc].content;
                                        let tplId       = contents[cc].template;
                                        addContent($('#'+kk), ccArr[1], customClass, cntId, tplId);
                                        if(parseInt(ccArr[1])>tempCntCnt){
                                            tempCntCnt = parseInt(ccArr[1]);
                                        }
                                    }
                                }
                            }

                            if(Object.keys(rows).length>0){
                                renderLayout(rows, $('#'+kk))
                            }

                        }
                    }
                }
            }

        }

    }

    function loadSelectContens() {
        $('.template-class').each(function(index) {
            let value = $.trim($(this).attr('data-id'));
            if(value != ''){
                $(this).find('option[value="'+value+'"]').attr('selected', 'selected');
            }
        });
        $('.content-class').each(function(index) {
            let value = $.trim($(this).attr('data-id'));
            if(value != ''){
                $(this).find('option[value="'+value+'"]').attr('selected', 'selected');
            }
        });
    }
    
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
      
    function setDataFromClass(cssClass, keyElem) {
        $(cssClass).each(function(index) {
            let value = $.trim($(this).val());
            if(value != ''){
                let parentKey =  $(this).attr('data-target');
                let pathToElem = findPathsToKey({ obj: completeTpl, key: parentKey}).join("");
                eval("completeTpl."+pathToElem+"."+keyElem+" = value");
            }
        });
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

    function addRow($container, numRow, customClss){
        countRow++;
        if(typeof numRow !== 'undefined'){
            countRow = numRow;
        }
        
        customClss = (typeof customClss !== 'undefined') ?  customClss : '';

        let tplRow = `<div class="row">
            <div class="tplRow col-sm-12">
                <div id="r_${countRow}" class="panel panel-default">
                    <div class="panel-heading">
                        <div class="form-group panel-title">
                            <div class="panel-controls">
                                <button type="button" data-target="#r_${countRow}" class="btn btn-danger badge pull-right delete"><i class="fa fa-times"></i> Eliminar</button>
                            </div>
                            <label for="inputRC_${countRow}">Fila</label>
                            <input type="text" data-target="r_${countRow}" class="form-control custom-class" id="inputRC_${countRow}" value="${customClss}" placeholder="Clase personalizada">
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
            completeTpl[`r_${countRow}`] = { customClass:customClss, columns:{} };
        }else{
            let pathToElem = findPathsToKey({ obj: completeTpl, key: parentKey}).join("");
            eval("completeTpl."+pathToElem+".rows['r_"+countRow+"'] = { customClass:'"+customClss+"', columns:{} }");
        }

        $('#cargando').hide();
    }

    function addColumn($container, numColumn, customClss){
        countColum++;
        if(typeof numColumn !== 'undefined'){
            countColum = numColumn;
        }
        
        customClss = (typeof customClss !== 'undefined') ?  customClss : '';

        let tplColumn = `
            <div class="tplColumn col-sm-12">
                <div id="c_${countColum}" class="panel panel-default">
                    <div class="panel-heading">
                        <div class="form-group panel-title">
                            <div class="panel-controls">
                                <button type="button" data-target="#c_${countColum}" class="btn btn-danger badge pull-right delete-column"><i class="fa fa-times"></i> Eliminar</button>
                            </div>
                            <label for="inputCC_${countColum}">Columna</label>
                            <input type="text" data-target="c_${countColum}" class="form-control custom-class" id="inputCC_${countColum}" value="${customClss}" placeholder="Clase personalizada">
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 controls">
                                <button type="button" data-target="#c_${countColum}" class="btn btn-success badge add-row"><i class="fa fa-plus"></i> Fila</button>
                                <button type="button" data-target="#c_${countColum}" class="btn btn-primary badge add-content"><i class="fa fa-plus"></i> Contenido</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>`;
        $container.find('.panel-body').first().children('.columnsContent').append($(tplColumn));

        let parentKey = $container.attr('id');
        let pathToElem = findPathsToKey({ obj: completeTpl, key: parentKey}).join("");
        eval("completeTpl."+pathToElem+".columns['c_"+countColum+"'] = { customClass:'"+customClss+"', rows:{}, contents:{} }");
    }
    function addContent($container, numContent, customClss, contentId, templateId,){
        countContent++;
        if(typeof numContent !== 'undefined'){
            countContent = numContent;
        }
        customClss = (typeof customClss !== 'undefined') ?  customClss : '';
        contentId  = (typeof contentId !== 'undefined') ?  contentId : '';
        templateId = (typeof templateId !== 'undefined') ?  templateId : '';

        let tplContent = `<div class="row">
            <div class="tplContent col-sm-12">
                <div id="cnt_${countContent}" class="panel panel-default">
                    <div class="panel-heading">
                        <div class="form-group panel-title">
                            <div class="panel-controls">
                                <button type="button" data-target="#cnt_${countContent}" class="btn btn-danger badge pull-right delete"><i class="fa fa-times"></i> Eliminar</button>
                            </div>
                            <label for="inputCnt_${countContent}">Contenido</label>
                            <input type="text" data-target="cnt_${countContent}" class="form-control custom-class" id="inputCnt_${countContent}" value="${customClss}" placeholder="Clase personalizada">
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="selectTpl_${countContent}">Plantilla del contenido</label>
                            <select data-id="${templateId}" data-target="cnt_${countContent}" id="selectTpl_${countContent}" class="form-control template-class">
                                ${selectTplCntTpls.html()}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="selectCnt_${countContent}">Listado de noticias</label>
                            <select data-id="${contentId}" data-target="cnt_${countContent}" id="selectCnt_${countContent}" class="form-control content-class">
                                ${selectTplContents.html()}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

        $container.find('.panel-body').first().append($(tplContent));

        let parentKey = $container.attr('id');
        let pathToElem = findPathsToKey({ obj: completeTpl, key: parentKey}).join("");
        eval("completeTpl."+pathToElem+".contents['cnt_"+countContent+"'] = { customClass:'"+customClss+"', content:'"+contentId+"', template:'"+templateId+"'}");

        $('#cargando').hide();
    }

    function prepareCompleteTpl() {
        let tplName = $.trim($('#tplName').val());
        if(tplName != ''){
            
            // @cssClass, @keyElem
            setDataFromClass('.custom-class', 'customClass');
            setDataFromClass('.template-class', 'template');
            setDataFromClass('.content-class', 'content');

            if(Object.keys(completeTpl).length > 0)
            {
                let allContent = new Object();
                
                allContent['uid']     = $('#uid').val();
                allContent['tplName'] = tplName;
                allContent['tpl']     = completeTpl;

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
        let target = $(this).attr("data-target");
        addContent($(target));
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

    function init() {
        $('#cargando').show();

        renderLayout(layoutObj, $contenedor);

        if(tempCntRow>0){
            countRow = tempCntRow;
        }
        if(tempCntCol>0){
            countColum = tempCntCol;
        }
        if(tempCntCnt>0){
            countContent = tempCntCnt;
        }

        loadSelectContens();

        $('#cargando').hide();
    }

    init();

});