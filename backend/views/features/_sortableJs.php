<?php
$script = <<< JS
    $('.container-fv').each(function(index, element) {
        var fvIndex = [];
        var sortable = $(element);
         
        sortable.sortable({
            items: '.fv-item',
            placeholder: "ui-state-highlight",
            axis: 'y',
            update: function () {
                var hasNewElements = false;
                var ids = [];
                var i = 0;
                
                $('.fv-item').each(function (indexFv, elementFv) {                    
                    if (ids.indexOf($(elementFv).data('id')) == -1) {
                        ids[i] = $(elementFv).data('id');
                    } else {
                        hasNewElements = true;
                    }
                        
                    i++;
                });
                
                if (hasNewElements) {
                    alert('Сначала нужно сохранить');
                } else {
                    $('.fv-item', sortable).each(function (indexFv, elementFv) {
                        fvIndex[indexFv] = $(elementFv).data('id');
                    });
                    
                    $.ajax({
                        'url': '/admin/sort/fv-update',
                        'type': 'post',
                        'data': "items="+JSON.stringify(fvIndex),
                        'success': function () {
                            console.log('Сортировка прошла успешно');
                        },
                        'error': function (request, status, error) {
                            alert('Ошибка сортировки');
                        }
                    });
                }
            },
        }).disableSelection();
    });
    
    $('.container-images').each(function(index, element) {
        var fvIndex = [];
        var sortable = $(element);
         
        sortable.sortable({
            items: '.images-item',
            placeholder: "ui-state-highlight",
            axis: 'y',
            update: function () {
                var hasNewElements = false;
                var ids = [];
                var i = 0;
                
                $('.images-item').each(function (indexFv, elementFv) {                    
                    if (ids.indexOf($(elementFv).data('id')) == -1) {
                        ids[i] = $(elementFv).data('id');
                    } else {
                        hasNewElements = true;
                    }
                        
                    i++;
                });
                
                if (hasNewElements) {
                    alert('Сначала нужно сохранить');
                } else {
                    $('.images-item', sortable).each(function (indexFv, elementFv) {
                        fvIndex[indexFv] = $(elementFv).data('id');
                    });
                    
                    $.ajax({
                        'url': '/admin/sort/image-update',
                        'type': 'post',
                        'data': "items="+JSON.stringify(fvIndex),
                        'success': function () {
                            console.log('Сортировка прошла успешно');
                        },
                        'error': function (request, status, error) {
                            alert('Ошибка сортировки');
                        }
                    });
                }
            },
        }).disableSelection();
    });
JS;
$css = '.ui-state-highlight {background-color: #000 !important;}';
$this->registerJs($script);
$this->registerCss($css);
?>