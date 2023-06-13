
//Grafica 1-2: semi-circulo
/*Necesita 3 parametros
    contenedor: id del contenedor de la grafica
    titulo: string con el titulo de la grafica
    valor : numero que mostrara la grafica
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

function grafica_linea(datos, nombre_departamento){
    let grafica_1 = $('#grafica1');
    var data3 = [
        {
            x: Object.keys(datos),
            y: Object.values(datos),            
            type: 'scatter',
            line: {shape: 'spline', dash: 'dot'}
        }
    ];
    var layout3 = {
        title:{text: nombre_departamento, font:{size:'25', family:'Lexend Deca', color:'000000', weight:'bold'}},
        width: grafica_1.width() , 
        height: grafica_1.height(),
        margin:{t:40, b:15, l:20, r:10},
        paper_bgcolor:"#C2BFBF",
        font:{size:10, color:'000000'},
        plot_bgcolor:"#C2BFBF"

    }
    console.log(data3);
Plotly.newPlot('grafica1', data3, layout3);
}



//grafica 4: top barras -> indicador por municipio

function top_municipios(dm, titulo){
    let barras_muni = $('#muni_barras_top');
    var yValue = Object.values(dm);
    var xValue = Object.keys(dm);

    var trace1 = {
        x: xValue,
        y: yValue,
        type: 'bar',
        orientation: 'h',
        text: yValue.map(String),
        textposition: 'auto',
        hoverinfo: true,
        marker: {
            color: 'rgb(158,202,225)',
            opacity: 0.6,
            line: {
                color: 'rgb(8,48,107)',
                width: 1.5
                }
        }
    };

    var data4 = [trace1];

    var layout4 = {
        title:{text: titulo, font:{size:'25', family:'Lexend Deca', color:'000000', weight:'bold'}},
        barmode: 'stack',
        width: barras_muni.width() , 
        height: barras_muni.height(),
        margin:{t:40, b:20, l:1, r:10},
        paper_bgcolor:"#C2BFBF",
        font:{size:10, color:'000000'},
        plot_bgcolor:"#C2BFBF"
    };

Plotly.newPlot('muni_barras_top', data4, layout4);
}



//grafica 5: top barras -> indicador por ips

function top_ips(){
    let barras_ips = $('#ips_barras_top');
    var yValue_2 = ['Edwin', 'Armando', 'Duarte', 'Segura'];
    var xValue_2 = [200, 140, 213, 70];

    var trace2 = {
        x: xValue_2,
        y: yValue_2,
        type: 'bar',
        orientation: 'h',
        text: yValue_2.map(String),
        textposition: 'auto',
        hoverinfo: true,
        marker: {
            color: 'rgb(158,202,225)',
            opacity: 0.6,
            line: {
                color: 'rgb(8,48,107)',
                width: 1.5
                }
        }
    };

    var data5 = [trace2];

    var layout5 = {
        title:{text:'Top ips', font:{size:'25', family:'Lexend Deca', color:'000000', weight:'bold'}},
        barmode: 'group',
        width: barras_ips.width() , 
        height: barras_ips.height(),
        margin:{t:40, b:20, l:1, r:10},
        paper_bgcolor:"#C2BFBF",
        font:{size:10, color:'000000'},
        plot_bgcolor:"#C2BFBF"
    };

Plotly.newPlot('ips_barras_top', data5, layout5);
}

/*
    Cambia los textos del dashboard
    nd: nombre departamento
    ni: nombre indicador
    f: factor
*/
function cambiar_nombres(nd, ni, f){

    $('#titulo_tabla_1').text(nd);
    $('#titulo_indicador').html('<h5>'+ni+'</h5>');
    console.log(nd);
    console.log(ni);
    console.log(f);
}


$(document).ready(()=>{
    cambiar_nombres(nombre_departamento,nombre_indicador, fecha);
    indicador_semi_circulo('tarjeta_1','Indicador país', datos_indicador_pais);
    indicador_semi_circulo('tarjeta_2','Indicador departamento', datos_indicador_depart);
    grafica_linea(datos_grafica_linea, nombre_departamento);
    top_municipios(datos_barras_muni, 'Top municipios '+nombre_departamento);
    top_ips();
});

console.log(datos_barras_muni);
