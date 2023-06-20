
// primera_entrada : variable control que permite ACTIVAR todas las graficas
// hasta que se OPRIME el boton Mostrar por primera vez

if (primera_entrada == 1){
    $('#contenido').css('display','none');
}else{
    $('#contenido').css('display','flex');
}



//Grafica 1-2: semi-circulo=======================================================
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
        paper_bgcolor: $('#tarjeta_mitad').css('background-color'),
        font:{size:10, color:'000000'}
    };

    Plotly.newPlot(contenedor, data1, layout1);
}


//grafica 3: Linea de tiempo indicador por region========================================
/*
    necesita 2 parametros:
    contenedor(string): 'id' del elemento donse se va hacer la grafica
    datos(object): los datos para graficar {'fecha':'valor'}
*/
function grafica_linea(contenedor, datos){
    let grafica_1 = $('#'+contenedor);
    var data3 = [
        {
            x: Object.keys(datos),
            y: Object.values(datos),            
            type: 'scatter',
            line: {shape: 'spline', dash: 'dot', width:3}
        }
    ];
    var layout3 = {
        width: grafica_1.width() , 
        height:grafica_1.height(),
        margin:{t:0, b:15, l:20, r:0},
        paper_bgcolor:"transparent", //color fondo layout
        font:{size:10, color:'000000'},
        plot_bgcolor:"rgba(255, 255, 255, 0.4)" //Color del fondo de la grafica

    }
    console.log(grafica_1.height());
Plotly.newPlot(contenedor, data3, layout3);
}



//grafica 4: top barras -> indicador por municipio=============================
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
        hoverlabel:{namelength:0, align:"rigth"},
        marker: {
            color: '#0a2535',
            opacity: 0.9,
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
        paper_bgcolor:"rgba(0, 0, 0, 0)", //color fondo layout
        font:{size:10, color:'000000'},
        plot_bgcolor:"rgba(255, 255, 255, 0,5)"//Color del fondo de la grafica
    };

Plotly.newPlot(contenedor, data4, layout4);
}



/*
    Cambia los textos del dashboard
    nd: nombre departamento
    ni: nombre indicador
    f: fecha
    ff : factor --> indica el numero de personas en el que se aplica el valor del indicador "20 de cada 'factor' personas"
*/

function cambiar_nombres(nd, ni, f, ff){

    $('#titulo_tabla_1').text(nd);
    $('#titulo_indicador').html('<h6> '+ ni + '</h6>');
    $('#tarjeta_mitad').html('<strong>año: ' + f + '</strong> <br> <strong>factor: ' + ff + '</strong>');
    $('.titulo_graf_linea').text(nd);
    $('.titulo_muni_barras').text('Top 10 municipios : '+nd);
    $('.titulo_ips_barras').text('Top 10 ips: '+nd);
    $('#titulo_tabla_2').text(nd);
    $('#titulo_tabla_3').text(nd);
}

/*
    Cambia los textos del las tablas de informacion
    no recibe argumentos
*/

function informacion_tarjetas(){

    let muni_menor = JSON.parse(datos_muni_menor);
    let muni_mayor = JSON.parse(datos_muni_mayor);

    let ips_menor = JSON.parse(datos_ips_menor);
    let ips_mayor = JSON.parse(datos_ips_mayor);


    $('#codigo_departamento').text(id_departamento);
    $('#poblacion_departamento').text(poblacion_dep);

    $('#nombre_muni_mayor').text(muni_mayor.municipio);
    $('#valor_muni_mayor').text(muni_mayor.valor);

    $('#nombre_muni_menor').text(muni_menor.municipio);
    $('#valor_muni_menor').text(muni_menor.valor);


    $('#nombre_ips_mayor').text(ips_mayor.ips);
    $('#valor_ips_mayor').text(ips_mayor.valor);

    $('#nombre_ips_menor').text(ips_menor.ips);
    $('#valor_ips_menor').text(ips_menor.valor);

    $('#cant_municipios').text(JSON.parse(cant_muni).cant_mun);
    $('#cant_ips').text(JSON.parse(cant_ips).cant_ips);

}



// Crear el MAPA DINAMICO==================================================================

/*  
    Esta funcion se encarga de organizar los datos para luego dibujar el mapa
    Recibe 2 parametro:
    data_json(object): Todos los datos traido del archivo json
    datos_grafico_mapa(object): Los datos traidos de mysql

    returna un objeto:{'data':datos_mapa_json,
                        'locations':datos_locations,
                        'z':datos_z};
*/

let id_departamento_2 = (id_departamento.length > 1) ? id_departamento : '0'+id_departamento ; // Si el codigo de departamento es de 1 digito, se le agrega un '0' al principio para que concida con el codigo del archivo json

function config_datos_mapa(data_json, datos_grafico_mapa) {
    datos_mapa_json = data_json;

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



// Se encarga el mapa por medio de plotly
/*
    Recibe un parametro:
    datos(object): recibe los datos ya configurados para crearl el mapa
                    {'data':datos_mapa_json,
                    'locations':datos_locations,
                    'z':datos_z};
*/
function dibujar_mapa(datos){
    let map = $('#mapa');

    var data = [{
        type: "choroplethmapbox", 
        locations: datos['locations'], 
        z: datos['z'],
        geojson: datos['data'],
        zauto: true, 
        colorbar: {y: 0, yanchor: "bottom", ticklabelposition:"inside"}
        }];

    var layout = {
        mapbox: {style: "outdoors", center: {lon: -74.3, lat: 4.5}, zoom: 4}, 
        width: map.width(),
        height: map.height(), 
        margin: {t: 0, b: 0, l:0, r:0}};

    var config = {mapboxAccessToken: "pk.eyJ1IjoiZWR3MjM0LSIsImEiOiJjbGl3MHh3dmswY2tyM2hsbXNubmg5YjQwIn0.ZS9jomCXDX3yRCCfEtic7g"};

    Plotly.newPlot('mapa', data, layout, config);
}


//LLama los datos de los JSON y la funciones : config_datos_mapa() y dibujar_mapa()
function crear_mapa(){
    $.ajax({
        url: 'source/jsons_municipios/'+id_departamento_2+'.json',
        type:  "POST",
        dataType: 'json',
        success: function(data) {
            let datos_crear_mapa = config_datos_mapa(data, datos_grafico_mapa);
            dibujar_mapa(datos_crear_mapa);                                       // Llama a la funcion dibujar_mapa
        },
        error: function(){
            alert('Error en el envio:');
        }
    });
}

//============================================================================================

$(document).ready(()=>{

    cambiar_nombres(nombre_departamento,nombre_indicador, fecha, factor_ind);

    indicador_semi_circulo('tarjeta_1','Indicador país', datos_indicador_pais);
    indicador_semi_circulo('tarjeta_2','Indicador depto', datos_indicador_depart);
    
    grafica_linea('grafica_linea' ,datos_grafica_linea);
    
    top_barras('muni_barras_top', datos_barras_muni);
    top_barras('ips_barras_top', datos_barras_ips);
    crear_mapa();

    informacion_tarjetas();

});


