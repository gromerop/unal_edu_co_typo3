$(document).ready(function () {
    var sedesInfo = [], coor = [];
    var otherInfo = [], otherCoor = [];
    try {
        var northEast = L.latLng(30.039337,-62.190256);
        var southWest = L.latLng(-5.779292, -90.967448);
        var bounds = L.latLngBounds(southWest, northEast);
        var map = L.map('mapid', {
            maxBounds: bounds,
            minZoom: 5,
            maxZoom: 5
        });
        map.createPane('labels');
        map.getPane('labels').style.zIndex = 650;
        map.getPane('labels').style.pointerEvents = 'none';
        var cartodbAttribution = '&copy; <a href="//www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="//carto.com/attribution">CARTO</a>';
        //var Stamen_Watercolor = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/watercolor/{z}/{x}/{y}.{ext}', {
        //    subdomains: 'abcd',
        //    minZoom: 1,
        //    maxZoom: 16,
        //    ext: 'jpg'
        //}).addTo(map);
        var positron = L.tileLayer('//{s}.basemaps.cartocdn.com/rastertiles/voyager_nolabels/{z}/{x}/{y}.png', {
        attribution: cartodbAttribution
        }).addTo(map);
//        var positronLabels = L.tileLayer('//{s}.basemaps.cartocdn.com/light_only_labels/{z}/{x}/{y}.png', {
//        attribution: cartodbAttribution,
//        pane: 'labels'
//        }).addTo(map);
        //var Esri_WorldImagery = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        //attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
        //}).addTo(map);
        var colombia_coor = `[
			[-75.28584,-0.119722],
			[-74.77237,-0.207917],
			[-74.37611,-0.568056],
			[-74.2407,-1.012917],
			[-73.5557,-1.375278],
			[-73.50751,-1.748333],
			[-73.13278,-1.849167],
			[-73.11529,-2.32875],
			[-72.88196,-2.506389],
			[-72.22751,-2.498889],
			[-71.6932,-2.147917],
			[-71.36168,-2.346945],
			[-70.85896,-2.225347],
			[-70.56445,-2.493333],
			[-70.29539,-2.501281],
			[-70.0675,-2.755556],
			[-70.72417,-3.779723],
			[-70.32306,-3.799167],
			[-69.95692,-4.236874],
			[-69.37855,-1.337917],
			[-69.60654,-0.519861],
			[-70.05806,-0.1575],
			[-70.04473,0.585],
			[-69.45928,0.736597],
			[-69.12782,0.644028],
			[-69.26487,1.033889],
			[-69.84222,1.072222],
			[-69.8461,1.710455],
			[-68.15306,1.724167],
			[-68.1964,1.9775],
			[-67.91473,1.745278],
			[-67.42258,2.142847],
			[-67.07118,1.620407],
			[-67.07529,1.1725],
			[-66.87045,1.220932],
			[-67.1925,2.3925],
			[-67.83307,2.876667],
			[-67.29285,3.396041],
			[-67.63515,3.797639],
			[-67.85876,4.56125],
			[-67.84863,5.306519],
			[-67.41398,5.995538],
			[-67.45445,6.193055],
			[-67.83118,6.307569],
			[-68.6384,6.135485],
			[-69.0564,6.21611],
			[-69.24174,6.084096],
			[-69.42946,6.11861],
			[-70.11917,6.975833],
			[-70.71973,7.098055],
			[-71.18126,6.963472],
			[-71.99236,7.01625],
			[-72.15472,7.325277],
			[-72.47244,7.497985],
			[-72.33667,8.151943],
			[-72.77972,9.080276],
			[-73.01,9.302012],
			[-73.37807,9.171389],
			[-72.49126,11.12278],
			[-72.20935,11.25],
			[-71.96848,11.66625],
			[-71.32472,11.85305],
			[-71.11418,12.04889],
			[-71.22084,12.30208],
			[-71.69084,12.4593],
			[-71.93779,12.16278],
			[-72.15792,12.24111],
			[-72.25862,11.88917],
			[-73.28445,11.29556],
			[-74.15501,11.33139],
			[-74.395,10.74215],
			[-74.59174,10.87764],
			[-74.29223,10.99903],
			[-74.86081,11.12549],
			[-75.50404,10.55014],
			[-75.63432,9.448194],
			[-76.08974,9.335833],
			[-76.31751,8.93861],
			[-76.92834,8.568333],
			[-76.77383,8.411249],
			[-76.75792,7.919166],
			[-76.92389,7.936041],
			[-76.83411,8.129096],
			[-77.36667,8.674999],
			[-77.46858,8.4717],
			[-77.21556,7.937222],
			[-77.57744,7.52618],
			[-77.74403,7.719999],
			[-77.88972,7.228889],
			[-77.34042,6.567361],
			[-77.48889,6.185347],
			[-77.24084,5.758194],
			[-77.53223,5.518888],
			[-77.34778,5.240555],
			[-77.38244,4.342152],
			[-77.2423,4.260902],
			[-77.43445,4.031388],
			[-77.36626,3.925972],
			[-77.18723,4.060277],
			[-77.26542,3.840139],
			[-77.03271,3.918402],
			[-77.78111,2.756389],
			[-77.74542,2.610416],
			[-78.56529,2.429166],
			[-78.68687,2.193472],
			[-78.5875,1.767153],
			[-78.84494,1.836528],
			[-79.05029,1.631805],
			[-78.80972,1.437778],
			[-78.10001,0.915972],
			[-77.67834,0.837222],
			[-77.37946,0.384722],
			[-76.54515,0.219167],
			[-76.24306,0.395556],
			[-75.28584,-0.119722]
		]`;
        country = jQuery.parseJSON('{"type": "Feature", "properties": {"name": "Colombia" },"geometry": {"type": "Polygon","coordinates": [' + colombia_coor + ']}}');
        function polystyle(feature) {
            return {
                fillColor: '#A0C860',
                weight: 2,
                opacity: 0.5,
                color: '#C1974B', //Outline color
                fillOpacity: 0.4
            };
        }
        var LeafIcon = L.Icon.extend({
            options: {
                iconSize: [20, 28],
                shadowSize: [20, 28],
                iconAnchor: [15, 20],
                shadowAnchor: [10, 20],
                popupAnchor: [-4, -20]
            }
        });
        var sedesIcon = new LeafIcon({
            iconUrl: './archivos/imagenes-home/marker-icon.png',
            shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png'
        })
        var LeafIcon = L.Icon.extend({
            options: {
                iconSize: [22, 22],
                shadowSize: [22, 22],
                iconAnchor: [15, 20],
                shadowAnchor: [10, 20],
                popupAnchor: [-4, -20]
            }
        });
        var otherIcon = new LeafIcon({
            iconUrl: './archivos/imagenes-home/alfiler.png',
            shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png'
        })
        geojson = L.geoJson(country, {style: polystyle}).addTo(map);
        map.setView({lat: 3.6230276517351068, lng: -72.79226765629087}, 5);
        for (let index = 0; index < $('#c346 p').length; index++) {
            sedesInfo.push($('#c346 p').eq(index).text().split('|'));
        }
        for (let index = 0; index < $('#c764 p').length; index++) {
            otherInfo.push($('#c764 p').eq(index).text().split('|'));
        }
        sedesInfo.forEach(sede => {
            coor = sede[1].split(',');
            L.marker([coor[0], coor[1]], {icon: sedesIcon})
                    .addTo(map)
                    .bindTooltip(sede[0], {
                        permanent: false,
                        direction: 'right'})
                    .bindPopup(
                            '<center><b>' + sede[0] + '</b><center/>'
                            + sede[2] + '</br>' +
                            '<b>Dirección:</b>' + sede[3] + '</br>' +
                            '<b>Teléfono:</b>' + sede[4] + '</br>' +
                            '<b>Email:</b>' + sede[5] + '</br>' +
                            '<b>Horario de atención:</b>' + sede[6] + '</br>' +
                            '<a target="_blank" href="' + sede[7].replace(/\s/g, '') + '">Ir al sitio</a>');
        });
        otherInfo.forEach(sede => {
            otherCoor = sede[1].split(',');
            L.marker([otherCoor[0], otherCoor[1]], {icon: otherIcon})
                    .addTo(map)
                    .bindTooltip(sede[0], {
                        permanent: false,
                        direction: 'right'})
                    .bindPopup(
                            '<center><b>' + sede[0] + '</b><center/>'
                            + sede[2] + '</br>' +
                            '<b>Dirección:</b>' + sede[3] + '</br>' +
                            '<b>Teléfono:</b>' + sede[4] + '</br>' +
                            '<b>Email:</b>' + sede[5] + '</br>')
        });
        $('#c346').remove();
        $('#c764').remove();
    } catch (error) {
    }
});
