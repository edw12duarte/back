
//Grafica 2: semi-circulo_1

function indicador_pais(){ 
    let tarjeta_1 = document.getElementById('tarjeta_1');
    var data1 = [
        {
            domain: { x: [0, 1], y: [0, 1] },
            value: 500,
            title: { text: "Indicador pais" },
            type: "indicator",
            mode: "gauge+number",
            delta: { reference: 400 },
            gauge: { axis: { range: [0, 900] } }
        }
    ];

    var layout1 = { 
        width: tarjeta_1.clientWidth , 
        height: tarjeta_1.clientHeight,
        margin:{t:50, b:5, l:0, r:0},
        paper_bgcolor:"#C2BFBF",
        font:{size:10, color:'000000'}
    };

    Plotly.newPlot('tarjeta_1', data1, layout1);
}



//Grafica 2: semi-circulo_2

function indicador_departamento(){
    let tarjeta_2 = document.getElementById('tarjeta_2');
    var data2 = [
        {
            domain: { x: [0, 1], y: [0, 1] },
            value: 500,
            title: { text: "Indicador Departamento", font:{size:15}},
            type: "indicator",
            mode: "gauge+number",
            delta: { reference: 400 },
            gauge: { axis: { range: [0, 900] } }
        }
    ];

    var layout2 = { 
        width: tarjeta_2.clientWidth , 
        height: tarjeta_2.clientHeight,
        margin:{t:50, b:5, l:0, r:0},
        paper_bgcolor:"#C2BFBF",
        font:{size:10, color:'000000'}
    };

Plotly.newPlot('tarjeta_2', data2, layout2);
}


//grafica 3: Linea de tiempo indicador por region

function indicador_vs_anos(){
    let grafica_1 = document.getElementById('grafica1');
    var data3 = [
        {
            x: ['2015','2016', '2017', '2018', '2019', '2020'],
            y: [1, 3, 6, 7, 2, 10],
            type: 'scatter'
        }
    ];
    var layout3 = {
        title:{text:'Indicador vs años', font:{size:'25', family:'Lexend Deca', color:'000000', weight:'bold'}},
        width: grafica_1.clientWidth , 
        height: grafica_1.clientHeight,
        margin:{t:40, b:15, l:20, r:10},
        paper_bgcolor:"#C2BFBF",
        font:{size:10, color:'000000'},
        plot_bgcolor:"#C2BFBF"

    }
    console.log(data3);
Plotly.newPlot('grafica1', data3, layout3);
}



//grafica 4: top barras -> indicador por municipio

function top_municipios(){
    let barras_muni = document.getElementById('muni_barras_top');
    var yValue = ['Product A', 'Product B', 'Product C'];
    var xValue = [200, 140, 213];

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
        title:{text:'Top municipios', font:{size:'25', family:'Lexend Deca', color:'000000', weight:'bold'}},
        barmode: 'stack',
        width: barras_muni.clientWidth , 
        height: barras_muni.clientHeight,
        margin:{t:40, b:20, l:1, r:10},
        paper_bgcolor:"#C2BFBF",
        font:{size:10, color:'000000'},
        plot_bgcolor:"#C2BFBF"
    };

Plotly.newPlot('muni_barras_top', data4, layout4);
}



//grafica 5: top barras -> indicador por ips

function top_ips(){
    let barras_ips = document.getElementById('ips_barras_top');
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
        width: barras_ips.clientWidth , 
        height: barras_ips.clientHeight,
        margin:{t:40, b:20, l:1, r:10},
        paper_bgcolor:"#C2BFBF",
        font:{size:10, color:'000000'},
        plot_bgcolor:"#C2BFBF"
    };

Plotly.newPlot('ips_barras_top', data5, layout5);
}

indicador_pais();
indicador_departamento();
indicador_vs_anos();
top_municipios();
top_ips();