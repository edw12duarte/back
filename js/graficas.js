
//Grafica 1-2: semi-circulo
/*
    Necesita 3 parametros
    contenedor(string): id del contenedor de la grafica
    titulo(string): el titulo de la grafica
    valor (string): numero que mostrara la grafica (debe ser un numero)
*/
function indicador_semi_circulo(contenedor, titulo, valor){ 
    let tarjeta = $('#'+contenedor);
    var data1 = [
        {
            domain: { x: [0, 1], y: [0, 1] },
            value: valor,
            title: { text: titulo , font:{size:15} },
            type: "indicator",
            mode: "gauge+number",
            delta: { reference: 50 },
            gauge: { axis: { range: [0, 100] } }
        }
    ];

    var layout1 = { 
        width: tarjeta.width(), 
        height: tarjeta.height(),
        margin:{t:50, b:5, l:0, r:0},
        paper_bgcolor:"#C2BFBF",
        font:{size:10, color:'000000'}
    };

    Plotly.newPlot(contenedor, data1, layout1);
}


//grafica 3: Linea de tiempo indicador por region
/*
    necesita 2 parametros:
    contenedor(string): 'id' del elemento donse se va hacer la grafica
    datos(object): los datos para graficar {'fecha':'valor'}
*/
function grafica_linea(contenedor,datos){
    let grafica_1 = $('#'+contenedor);
    var data3 = [
        {
            x: Object.keys(datos),
            y: Object.values(datos),            
            type: 'scatter',
            line: {shape: 'spline', dash: 'dot'}
        }
    ];
    var layout3 = {
        width: grafica_1.width() , 
        height: grafica_1.height(),
        margin:{t:0, b:15, l:20, r:0},
        paper_bgcolor:"#C2BFBF",
        font:{size:10, color:'000000'},
        plot_bgcolor:"#C2BFBF"

    }
Plotly.newPlot(contenedor, data3, layout3);
}



//grafica 4: top barras -> indicador por municipio
/*
    necesita 2 parametros:
    contenedor (string): 'id' del elemento donse se va hacer la grafica
    datos(object): los datos para graficar {'municipio/ips':'valor'}
*/
function top_barras(contenedor ,datos){
    let contenedor_barras = $('#'+ contenedor);
    var yValue = Object.keys(datos);
    var xValue = Object.values(datos);

    var trace1 = {
        x: xValue,
        y: yValue,
        type: 'bar',
        orientation: 'h',
        text: yValue.map(String),
        textposition: 'outside',
        hovertemplate: '%{y} <br> %{x}',
        marker: {
            color: '#0a2535',
            opacity: 0.6,
            line: {
                color: '#000000',
                width: 1.5
                }
        }
    };

    var data4 = [trace1];

    var layout4 = {
        barmode: 'stack',
        width: contenedor_barras.width() , 
        height: contenedor_barras.height(),
        margin:{t:10, b:20, l:1, r:10},
        paper_bgcolor:"#C2BFBF",
        font:{size:10, color:'000000'},
        plot_bgcolor:"#C2BFBF"
    };

Plotly.newPlot(contenedor, data4, layout4);
}



/*
    Cambia los textos del dashboard
    nd: nombre departamento
    ni: nombre indicador
    f: factor
*/
function cambiar_nombres(nd, ni, f){

    $('#titulo_tabla_1').text(nd);
    $('#titulo_indicador').text(' '+ni+': '+f+' ');
    $('.titulo_graf_linea').text(nd);
    $('.titulo_muni_barras').text('Top 10 municipios : '+nd);
    $('.titulo_ips_barras').text('Top 10 ips: '+nd);
    $('#titulo_tabla_2').text(nd);
    $('#titulo_tabla_3').text(nd);
    //console.log(nd);
    //console.log(ni);
    //console.log(f);
}


$(document).ready(()=>{
    cambiar_nombres(nombre_departamento,nombre_indicador, fecha);

    indicador_semi_circulo('tarjeta_1','Indicador país', datos_indicador_pais);
    indicador_semi_circulo('tarjeta_2','Indicador departamento', datos_indicador_depart);
    
    grafica_linea('grafica1' ,datos_grafica_linea);
    
    top_barras('muni_barras_top', datos_barras_muni);
    top_barras('ips_barras_top', datos_barras_ips);
});

//==================================================================

// Convierte el formato de 'id_departamento' traido de mysql,
// para compararlo con 'id' del archivo 'municipios_2.json'

function datos_para_mapa(data_json, datos_grafico_mapa) {

    id_departamento = (id_departamento.length > 1) ? id_departamento: '0'+id_departamento ;
    datos_mapa_json = data_json;//[id_departamento];

    datos_locations= [];
    datos_z=[];

    for(let x of datos_mapa_json.features){
        datos_locations.push(x['properties']['MPIO_CNMBR']);

        if (x['properties']['DPTOMPIO'] in datos_grafico_mapa){
            datos_z.push(datos_grafico_mapa[x['properties']['DPTOMPIO']]);
        }else{
            datos_z.push(0);
        }
    }
    return {'data':datos_mapa_json,
            'locations':datos_locations,
            'z':datos_z};
}


function crear_mapa(datos){
    let map = $('#mapa');

    var data = [{
        type: "choroplethmapbox", 
        locations: datos['locations'], 
        z: datos['z'],
        geojson: datos['data'],
        zauto: true, 
        colorbar: {y: 0, yanchor: "bottom", title: {text: "Colombia", side: "right"}}
        }];

    var layout = {
        mapbox: {style: "outdoors", center: {lon: -74.3, lat: 4.5}, zoom: 4.5}, 
        width: map.width(),
        height: map.height(), 
        margin: {t: 0, b: 0, l:0, r:0}};

    var config = {mapboxAccessToken: "pk.eyJ1IjoiZWR3MjM0LSIsImEiOiJjbGl3MHh3dmswY2tyM2hsbXNubmg5YjQwIn0.ZS9jomCXDX3yRCCfEtic7g"};

    Plotly.newPlot('mapa', data, layout, config);
}


$(document).ready(()=>{

    $.ajax({
        url: 'source/jsons_municipios/'+id_departamento+'.json',//'source/municipios_2_id.json',
        type:  "POST",
        dataType: 'json',
        success: function(data) {
            let datos_crear_mapa = datos_para_mapa(data, datos_grafico_mapa);
            crear_mapa(datos_crear_mapa);  // Llama a la funcion crear_mapa
        },
        error: function(){
            alert('Error en el envio:');
        }
    });
});




