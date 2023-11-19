require([
    "esri/Map",
    "esri/views/MapView",
    "esri/layers/GraphicsLayer",
    "esri/layers/FeatureLayer",
    "esri/Graphic",
    "esri/widgets/FeatureTable",
    "esri/widgets/Sketch",
    "esri/geometry/SpatialReference",
    "esri/geometry/support/webMercatorUtils",
    "esri/widgets/Locate",
    "esri/core/reactiveUtils",
    "esri/widgets/Popup",
    "esri/PopupTemplate",
    "esri/popup/content/CustomContent"
  ], (Map, MapView,GraphicsLayer,FeatureLayer,Graphic,FeatureTable,Sketch,spatialReference,webMercatorUtils,Locate,reactiveUtils,Popup,PopupTemplate,CustomContent) => {
    const graphicsLayer = new GraphicsLayer();
    const form = document.getElementById("form-insert");
    var idd ;
    var iddsaubenh;
    var hinhanhsaubenh;
  const map = new Map({
  basemap: "dark-gray-vector",
  layers: graphicsLayer,
  });

  const view = new MapView({
  container: "viewDiv",
  map: map,
  zoom: 12,
  popup: new Popup({
    dockEnabled: true,
    dockOptions: {
      // Disables the dock button from the popup
      buttonEnabled: false,
      // Ignore the default sizes that trigger responsive docking
      breakpoint: false
    },
    visibleElements: {
      closeButton: false
    }
  }),
  center: [106.084167,10.368333]
  });
  const locateBtn = new Locate({
    view: view
  });

  // Add the locate widget to the top left corner of the view
  view.ui.add(locateBtn, {
    position: "top-left"
  });
  const chinhsuavung = {
    title: "Chỉnh sửa",
    id: "Chinhsuavung",
    image: "/icon/edit.jpg"
  };
  const xoavung = {
    title: "Xóa Vùng",
    id: "xoavung",
    image: "/icon/delete.png"
  };
  const template = {          
    title: "Feature Info {mavua}",
    content: [
      {
        type: "fields",
        fieldInfos: [
          {
            fieldName: "objectid",
            label: "Mã vựa"
          },
          {
            fieldName: "dientich",
            label: "Diện tích"
          },
        ]
      }
    ],
    actions: [chinhsuavung]  
        };
        
  const featureLayer = new FeatureLayer({
    url: "https://localhost:6443/arcgis/rest/services/CamSon/FeatureServer/4",
    popupTemplate: template
  });
  const canuoc = new FeatureLayer({
    url: "https://localhost:6443/arcgis/rest/services/CamSon/FeatureServer/3",
    popupTemplate: template
  });
  const tinh = new FeatureLayer({
    url: "https://localhost:6443/arcgis/rest/services/CamSon/FeatureServer/2",
    popupTemplate: template
  });
  const huyen = new FeatureLayer({
    url: "https://localhost:6443/arcgis/rest/services/CamSon/FeatureServer/1",
    popupTemplate: template
  });
  const xa = new FeatureLayer({
    url: "https://localhost:6443/arcgis/rest/services/CamSon/FeatureServer/0",
    popupTemplate: template
  });

  map.add(featureLayer);

 
form.addEventListener('change', (event) => {
  const layerName = event.target.name;
  const isChecked = event.target.checked;

  switch (layerName) {
    case 'featureLayer':
      featureLayer.visible = isChecked;
      break;
    case 'canuoc':
      canuoc.visible = isChecked;
      break;
    case 'tinh':
      tinh.visible = isChecked;
      break;
    case 'huyen':
      huyen.visible = isChecked;
      break;
    case 'xa':
      xa.visible = isChecked;
      break;
  }
});


  const point = {
    type: "point", // autocasts as new Point()
    longitude: -49.97,
    latitude: 41.73
  };
  // Create a symbol for drawing the point
  const markerSymbol = {
    type: "simple-marker", // autocasts as new SimpleMarkerSymbol()
    color: [226, 119, 40],
    outline: {
      // autocasts as new SimpleLineSymbol()
      color: [255, 255, 255],
      width: 2
    }
  };
  // Create a graphic and add the geometry and symbol to it
  const pointGraphic = new Graphic({
    geometry: point,
    symbol: markerSymbol
  });
  var cactoadohinhhoc = [[1,2],[3,4]];
  
  const polyline = {
    type: "polyline", // autocasts as new Polyline()
    paths: cactoadohinhhoc,
  };
  // Create a symbol for drawing the line
  const lineSymbol = {
    type: "simple-line", // autocasts as SimpleLineSymbol()
    color: [226, 119, 40],
    width: 4
  };
  // Create an object for storing attributes related to the line
  const lineAtt = {
    Name: "Keystone Pipeline",
    Owner: "TransCanada",
    Length: "3,456 km"
  };

  const polylineGraphic = new Graphic({
    geometry: polyline,
    symbol: lineSymbol,
    attributes: lineAtt,
    popupTemplate: {
      // autocasts as new PopupTemplate()
      title: "{Name}",
      content: [
        {
          type: "fields",
          fieldInfos: [
            {
              fieldName: "Name"
            },
            {
              fieldName: "Owner"
            },
            {
              fieldName: "Length"
            }
          ]
        }
      ],
      actions: [chinhsuavung]
    }
  });
  const fillSymbol = {
    type: "simple-fill", // autocasts as new SimpleFillSymbol()
    color: [227, 139, 79, 0.8],
    outline: {
      // autocasts as new SimpleLineSymbol()
      color: [255, 255, 255],
      width: 1
    }
  };

  

  var popupTemplate = new PopupTemplate({
    title: "Tọa độ Polygon",
    content: [{
      type: "media",
      mediaInfos: [{
        "title": "image",
        "caption": "",
        "type": "image",
        "value": {
          "sourceURL": "",
        }
      }],
    
    }],
   
    actions: [chinhsuavung]
  });
  
  var graphic;
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
var polygonsGraphics = []; // Mảng toàn cục để lưu trữ các đối tượng Graphic
var bool;
for (const element of polygons) {

  var polygon = {
    type: "polygon", // autocasts as new Polygon()
    rings: element,
  };
  var polygonGraphic1 = new Graphic({ 
    geometry: polygon, 
    symbol: fillSymbol,
    popupTemplate: popupTemplate,
    attributes: {
      source: 0 // Đánh dấu đối tượng này là polygonGraphic1
  }
  });
  view.graphics.add(polygonGraphic1);
  polygonsGraphics.push(polygonGraphic1); // Thêm đối tượng Graphic vào mảng
}

for (const element of polygonssaubenh) {
  
  var polygonssb = {
    type: "polygon", // autocasts as new Polygon()
    rings: element,
  };
  const fillSymbol2 = {
    type: "simple-fill", // autocasts as new SimpleFillSymbol()
    color: [100, 30, 80, 0.8],
    outline: {
      // autocasts as new SimpleLineSymbol()
      color: [255, 255, 255],
      width: 1
    }
  };
  var polygonGraphic2 = new Graphic({
    geometry: polygonssb, 
    symbol: fillSymbol2,
    popupTemplate: popupTemplate,
    attributes: {
      source: 1 // Đánh dấu đối tượng này là polygonGraphic2
  }
  });
  view.graphics.add(polygonGraphic2);
  polygonsGraphics.push(polygonGraphic2); // Thêm đối tượng Graphic vào mảng
}
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
  reactiveUtils.on(
    () => view.popup,
    "trigger-action",
    (event) => {
      // Execute the measureThis() function if the measure-this action is clicked
      if (event.action.id === "Chinhsuavung") {
        if(graphic.attributes.source == 0)
        {
        window.location.href = "/vungtrong/update/"+idd;
        }
        else if(graphic.attributes.source == 1)
        {
          window.location.href = "/saubenh/update/"+iddsaubenh;
        }
      }
      if(event.action.id === "xoavung")
      {
        var confirmation = confirm("Bạn có chắc chắn muốn xóa vùng này?");

    if (confirmation) {
        if(graphic.attributes.source == 0)
        {
        window.location.href = "/vungtrong/"+idd;
        }
        else if(graphic.attributes.source == 1)
        {
          window.location.href = "/saubenh/delete/"+iddsaubenh;
        }
      }
    }
    }
  );
  // Add the graphics to the view's graphics layer
  view.graphics.addMany([pointGraphic, polylineGraphic]);

  const featureTable = new FeatureTable({
    view: view, // make sure to pass in view in order for selection to work
    layer: featureLayer,
    tableTemplate: {
      // autocasts to TableTemplate
      columnTemplates: [
        // takes an array of GroupColumnTemplate and FieldColumnTemplate
        {
          // autocasts to FieldColumnTemplate
          type: "field",
          fieldName: "OBJECTID",
          label: "State",
          direction: "asc"
        },
        {
          type: "field",
          fieldName: "maxa",
          label: "Private school percentage"
        },
        {
          type: "field",
          fieldName: "shape",
          label: "Public school percentage"
        }
      ]
    },
    container: tableDiv
  });

view.when(() => {
const appContainer = document.getElementById("appContainer");
const tableContainer = document.getElementById("tableContainer");
const tableDiv = document.getElementById("tableDiv");
const sketch = new Sketch({
layer: graphicsLayer,
view: view,
// graphic will be selected as soon as it is created
creationMode: "update"
});
view.when(() => {     
sketch.on("create", (event) => {  
var wgs84 = new spatialReference({
wkid: 4326  
});
var coords;
if (event.state === "complete") {
if (event.graphic.geometry.type === "polygon") {
coords = webMercatorUtils.project(event.graphic.geometry, wgs84);
document.getElementById("shape").innerHTML = JSON.stringify(coords.rings);
document.getElementById("shapesaubenh").innerHTML = JSON.stringify(coords.rings);
document.getElementById("paths").innerHTML="";
opendialogButton.style.display = "block";
} else if (event.graphic.geometry.type === "polyline") {
coords = webMercatorUtils.project(event.graphic.geometry, wgs84);
document.getElementById("paths").innerHTML = JSON.stringify(coords.paths);
document.getElementById("shape").innerHTML = "";
opendialogButton.style.display = "block";
}
}
});
});

view.ui.add(sketch, "top-right"); 
});



var laytoado;
view.on("click", function(event){
view.hitTest(event).then(function(response){
  if (response.results.length) {
    var filteredResults = response.results.filter(function(result){
      return polygonsGraphics.includes(result.graphic); // Kiểm tra xem đối tượng Graphic có trong mảng hay không
    });

    if (filteredResults.length > 0) {
       graphic = filteredResults[0].graphic;

if(graphic){
  var truong=graphic.attributes;
laytoado=JSON.stringify(graphic.geometry.rings);
var trimmedA = laytoado.slice(1, -1);
document.getElementById("paths").innerHTML = trimmedA;
if(graphic.attributes.source == 0){
  $.ajax({
    url: '/getid',
    type: 'get',
    data: {shapes: trimmedA},
    success: function(response) {
    
    idd = response.idvungtrong;
     truong.idvungtrong = response.idvungtrong;
     truong.dientichtrong = response.dientichtrong;
     truong.giongcay = response.giongcay;
     truong.giaidoansinhtruong = response.giaidoansinhtruong;
     truong.tenvungtrong = response.tenvungtrong;
     truong.loaidat = response.loaidat;
     truong.tuoicay = response.tuoicay;
     var popupTemplate = new PopupTemplate({
      title: "Tọa độ Polygon",
      content: [
       
        {
          type: "fields",
          fieldInfos: [
            {
              fieldName:  "idvungtrong",
              label: "Tên sâu bệnh",
              visible: true,
              
            },
              {
                  fieldName:  "dientichtrong",
                  label: "Mô tả",
                  visible: true
              },
              
              {
                fieldName:  "giongcay",
                label: "Thời gian phát hiện",
                visible: true
              },
              {
                fieldName:  "giaidoansinhtruong",
                label: "Phương pháp",
                visible: true
              },
              {
                fieldName:  "tenvungtrong",
                label: "Mô tả",
                visible: true
            },
            
            {
              fieldName:  "loaidat",
              label: "Thời gian phát hiện",
              visible: true
            },
            {
              fieldName:  "tuoicay",
              label: "Phương pháp",
              visible: true
            },
              
          ]
      }                      
    ],             
      actions: [chinhsuavung,xoavung],
  });
  graphic.popupTemplate = popupTemplate;

  // Hiển thị popup
  view.popup.open({
      features: [graphic],
      location: event.mapPoint
  });
    }
    });
}
else if(graphic.attributes.source == 1){
  $.ajax({
    url: '/getidsaubenh',
    type: 'get',
    data: {shapesaubenh: trimmedA},
    success: function(response) {
      
        iddsaubenh = response.idsaubenh;
        var images;
        if(response.hinhanh.length === 0)
        {
          response.hinhanh = ["null.jpg"];
          images = response.hinhanh.map(function(hinh) {
            return "/images/" + hinh;
      });
        }
        else
        {
         images = response.hinhanh.map(function(hinh) {
            return "/images/" + hinh;
        });}
        var mediaInfos = images.map(function(image) {
            return {
                "title": "Hình ảnh",
                "caption": "",
                "type": "image",
                "value": {
                    "sourceURL": image,
                }
            };
        }); 
       
       truong.tensaubenh = response.tensaubenh;
       truong.mota = response.mota;
     
       truong.thoigianphathien = response.thoigianphathien;
       truong.phuongphap =response.phuongphap;

        var popupTemplate = new PopupTemplate({
            title: "Tọa độ Polygon",
            content: [
              {
                type: "media",
                mediaInfos: mediaInfos,
              },
              {
                type: "fields",
                fieldInfos: [
                  {
                    fieldName:  "tensaubenh",
                    label: "Tên sâu bệnh",
                    visible: true,
                    
                  },
                    {
                        fieldName:  "mota",
                        label: "Mô tả",
                        visible: true
                    },
                    
                    {
                      fieldName:  "thoigianphathien",
                      label: "Thời gian phát hiện",
                      visible: true
                    },
                    {
                      fieldName:  "phuongphap",
                      label: "Phương pháp",
                      visible: true
                    },
                    
                ]
            }                      
          ],             
            actions: [chinhsuavung,xoavung],
        });
        graphic.popupTemplate = popupTemplate;

        // Hiển thị popup
        view.popup.open({
            features: [graphic],
            location: event.mapPoint
        });
    }
});

    
}
}
}
}
});
});
  view.ui.add(document.getElementById("mainDiv"), "top-right");
  const tableContainer = document.getElementById("tableContainer");
          const checkboxEle = document.getElementById("checkboxId");
          const labelText = document.getElementById("labelText");
          // Listen for when toggle is changed, call toggleFeatureTable function
          checkboxEle.onchange = () => {
            toggleFeatureTable();
          };
          function toggleFeatureTable() {
            // Check if the table is displayed, if so, toggle off. If not, display.
            if (!checkboxEle.checked) {
              appContainer.removeChild(tableContainer);
              labelText.innerHTML = "Hiện thông tin";
            } else {
              appContainer.appendChild(tableContainer);
              labelText.innerHTML = "Ẩn thông tin";
            }
          }
          
          graphicsLayer.on("click", (event) => {
            // Get the clicked graphic
            const clickedGraphic = event.graphic;
          
            // Check if the clicked graphic is a polygon
            if (clickedGraphic.geometry.type === "polygon") {
              // Get the coordinates of the polygon
              const coordinates = clickedGraphic.geometry.rings[0];
          
              // Update the input field with the coordinates
              console.log(JSON.stringify(coordinates));
            }
          });
          view.popup.set("dockOptions", {
            breakpoint: false,
            buttonEnabled: false,
            position: "bottom-left"
          });
          
        
         
  });
