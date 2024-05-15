function init(){
    var myMap = new ymaps.Map("map", {
        center: [47.475322, 40.093581],
        zoom: 16
    });

    //for (var i = 0, l = groups.length; i < l; i++) {
    //    createMenuGroup(groups[i]);
    //}

	var placemark = new ymaps.Placemark([47.475322, 40.093581], {
		balloonContentBody: 'kycjujc',
		hintContent: 'Нажми на маркер'
	});

	myMap.geoObjects.add(placemark);

}
		
ymaps.ready(init);
