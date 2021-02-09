function flexGridAddElements(containerClass, elementClass, addElementClass) {
    count();

    $(window).resize(function() {
        count();
    });

    function count() {
        $('.' + containerClass).each(function(index, containerr) {
            var container = $(containerr);
            var element = $('.' + elementClass + ':not(.'+addElementClass+')');
            var addElement = $('<div class="'+elementClass+' ' + addElementClass + '">');
            var containerWidth = container.outerWidth();
            var elementWidth = element.eq(0).outerWidth();
            var elementsInRow = parseInt(containerWidth / elementWidth);

            if (elementsInRow >= 2) {
                var allElementCount = container.find(element).length;
                var addElements = container.find('.'+addElementClass);
                var imax = (elementsInRow - (allElementCount % elementsInRow));

                if (imax != elementsInRow) {
                    for (var i = 0; i < imax; i++) {
                        if (container.find('.'+addElementClass).get(i) === undefined) {
                            container.append(addElement.clone());
                        }
                    }
                }
            } else {
                container.find('.'+addElementClass).remove();
            }
        });
    }
}
