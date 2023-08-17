var map = L.map('map').setView([10.420288, 106.296844], 10);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);



var checkbox = document.getElementById("choosepoint");
checkbox.addEventListener("change", function() {
    if (checkbox.checked) {
        onMapClick();
    } else {
        removeOnMapClick();
    }
});

var a = false;
var b = ",";
var polyline;

function onMapClick() {
    if (map) {
            map.on('click', handleMapClick);
    }
}

function removeOnMapClick() {
    if (map) {
        map.off('click', handleMapClick);
        a = false;
        document.getElementById('shapeInput').value = '';
        if (polyline) {
            map.removeLayer(polyline);
            polyline = null;
        }
    }
}

var shapeinf = "";

function handleMapClick(event) {
    var polylinePoints = [];
    if (!polyline) {
        polyline = L.polyline(polylinePoints, {
            color: 'red'
        }).addTo(map);
    }
    map.off('click', handleMapClick);
    map.on('click', function(event) {
        if (checkbox.checked) {
            var latlng = event.latlng;
            if (a == true) {
                shapeinf += b + "[" + latlng.lat + "," + latlng.lng + "]";
            } else {
                shapeinf += "[" + latlng.lat + "," + latlng.lng + "]";
                a = true;
            }
            document.getElementById('shapeInput').value = "[" + shapeinf + "]";
            polylinePoints.push(latlng);
            polyline.setLatLngs(polylinePoints);
        }
    });
}

var xaGeojsonLayer = null;
var maXa = document.getElementById('maxa');
var tenXa = document.getElementById('tenxa');
fetch('/Geojson/xa.geojson')
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        xaGeojsonLayer = L.geoJSON(data, {
            onEachFeature: function(feature, layer) {
                layer.on('click', function() {
                      
                });
            }
        });
        xaGeojsonLayer.addTo(map);
    });


    document.getElementById("back").addEventListener("click", function() {
    window.location.href = "/location";
});

document.getElementById("myButton").addEventListener("click", function(){ 
    document.getElementById("myForm").submit(); 
});


