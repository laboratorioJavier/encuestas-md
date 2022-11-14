const host = "../controllers/encuesta.php";
let obj = {};
let nombre_representante = "";
let nombre_empresa = "";
let email = "";
let telefono = "";
let promedio = 0;
// Retorna una copia de un objeto, para asignarla a otro objeto y manipularlo, sin alterar el original:
function copyObjectValuesToAnotherObject(object = {}) {
    var newObject = {};
    for (var key in object) {
        newObject[key] = object[key];
    }
    return newObject;
}

function guardarDatosEmpresa(nombreRep, nombreEmp, correo, telf) {
    nombre_representante = nombreRep;
    nombre_empresa = nombreEmp;
    email = correo;
    telefono = telf;
}

function inicializarObjetoRespuestas(objetoArray) {
    obj = {};
    var representante = objetoArray.encuesta.representante;
    guardarDatosEmpresa(representante.nombre, representante.empresa.nombre, representante.usuario.email, representante.telefono);
    var resultados = objetoArray.resultados;
    for (var objeto of resultados) {
        obj[objeto.id] = copyObjectValuesToAnotherObject(objeto);
        obj[objeto.id].niveles = {};
        for (var nivel of objeto.niveles) {
            obj[objeto.id].niveles[nivel.id] = copyObjectValuesToAnotherObject(nivel);
        }
    }
}

/* $(document).ready(function () {
    calcularPromedio();
}); */

/* function calcularPromedio() {
    var items = obj;

    for (var j in items) {//FOR PARA PILARES

        var niv = items[j].niveles;
        var max_opciones = items[j].max_opciones;

        for (var k in niv) {
            var peso_nivel = 0;
            // FOR PARA NIVELES: 
            if (niv[k].cantidad_opciones != 0) {
                // peso_nivel = (max_opciones / niv[k].cantidad_opciones);
                items[j].niveles[k]['peso'] = 1;
            }

        }

    }


    //calculo del promedio general

    for (var j in items) { //FOR PARA PILARES

        var niv = items[j].niveles;
        var promedio_pilar = 0;
        var puntaje_por_nivel = 0;
        var cantidad_opciones_total = 0 ; 
        for (var k in niv) {
             
            var opciones_r = 0;
            opciones_r = items[j].niveles[k].opciones_respondidas;
            if(opciones_r>0){
                cantidad_opciones_total++;
            }
            
            puntaje_por_nivel  += validarOpciones(opciones_r, k);
             }
        promedio_pilar = (puntaje_por_nivel/cantidad_opciones_total);
        items[j]['promedio_pilar'] = parseFloat(promedio_pilar.toFixed(1));
    }

    // console.log(JSON.stringify(items, null, "  "));

    verGrafica(items);
} */





function verGrafica(items, promedioGeneral, venezuela, promedioVenezuela, mundo, promedioMundo) {
    var labels = [];
    var dataMeses = [];
    for (var j in items) {
        // Código aparentemente inútil pero hace que se muestren horizontales los labels de los pilares
    
        var titulo = items[j].titulo.split(' ');
        titulo.join(' ');
        
        // Fin código aparentemente inútil
        
        labels.push(titulo);
        dataMeses.push(items[j].promedio_pilar);
    
    }

    var coloresBorderMes = [];
    var coloresBackgroundMes = [];
    for (var i = 1; i <= 5; i++) {
        var color = crearRGBA(generarColoresRGB(), 1);
        coloresBorderMes.push(color);
        coloresBackgroundMes.push(color);
    }
    // console.log('labels =', labels);
    // console.log('dataMeses = ', dataMeses);
    generarGrafica(labels, dataMeses, promedioGeneral, venezuela, promedioVenezuela, mundo, promedioMundo, coloresBorderMes, coloresBackgroundMes);

}

function generarGrafica(labels, dataMes, promedioGeneral, venezuela, promedioVenezuela, mundo, promedioMundo, coloresBorderMes, coloresBackgroundMes) {
    dataMes.push(promedioGeneral);
    venezuela.push(promedioVenezuela);
    mundo.push(promedioMundo);
    labels.push('Promedios');


    var ctx = document.getElementById('grafico');

    var color = [];
    colorX = [];
    for (var i = 0; i <= 51; i++) {
        color.push('#c6c2bd');

    }
    for (var i = 0; i <= 5; i++) {
        colorX.push('rgba(0,0,0,0)');

    }
    colorX[0] = '#c6c2bd';
    color[38] = 'rgba(0,0,0,0)';
    color[28] = 'rgba(0,0,0,0)';
    color[19] = 'rgba(0,0,0,0)';
    color[9] = 'rgba(0,0,0,0)';
    //color[0] =  'rgba(0,0,0,0)'; 


    var graficaLikert = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [

                {
                    label: 'Nivel ' + nombre_empresa,
                    data: dataMes,
                    /* Color de barra (Azul oscuro) */
                    backgroundColor: '#0A2E51',
                    borderColor: '#0A2E51',
                    datalabels: {
                        color: '#FFFFFF'
                    }
                },
                {
                    label: 'Venezuela',
                    data: venezuela,
                    /* Color de barra (Verde) */
                    backgroundColor: '#7DC714',
                    borderColor: '#7DC714',
                    datalabels: {
                        color: '#FFFFFF'
                    }
                },
                {
                    label: 'El Mundo',
                    data: mundo,
                    /* Color de barra (Azul claro) */
                    backgroundColor: '#1F91FF',
                    borderColor: '#1F91FF',
                    datalabels: {
                        color: '#FFFFFF'
                    }
                }

            ]

        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: true,
                labels: { 
                  fontFamily: 'Poppins',
                  fontSize: 12
                }
              },
            title: {
                display: true,
                fontSize: 15,
                fontFamily: 'Poppins',
                text: 'ÍNDICE DE EVOLUCIÓN DIGITAL RED PBM:'
            },
            scales: {
                xAxes: [{
                    barPercentage: 1,
                    categoryPercentage: 0.8,
                    gridLines: {
                        color: colorX,
                        beginAtZero: true
                    },
                    ticks: {
                        display: true,
                        fontColor: 'black',
                        fontFamily: 'Poppins',
                //        fontStyle: 'bold',
                        fontSize: 10,
                        min: 0,
                        max: 5,
                        beginAtZero: true,
                        stepSize: 0.1/*,
                        callback: function (value, index, values) {
                            if(typeof value === "string"){
                                return value.substring(0,4)+'...'
                            }
                            return value
                        } */
                
                      },
                      
                      scaleLabel: {
                        display: true,
                        labelString: 'Pilares',
                        fontColor: 'black',
                        fontFamily: 'Poppins',
                        fontSize: 16
                      }
                }
                ],
             
                yAxes: [{
                    barPercentage: 1,
                    categoryPercentage: 0.8,
                    gridLines: {
                        display: true,
                        color: color,                    },
                    ticks: {
                        fontColor: 'black',
                        fontFamily: 'Poppins',
                    //    fontStyle: 'bold',
                        fontSize: 12,
                        min: 0,
                        max: 5,
                        beginAtZero: true,
                        stepSize: 0.1,
                        callback: function (value, index, values) {
                            switch (value) {
                                case 1.2:
                                    return `Básico               `;
                                case 2.2:
                                    return `Principiante          `;
                                case 3.1:
                                    return `Transicional          `;
                                case 4.1:
                                    return `Avanzado             `;
                                case 5:
                                    return `Evolucionado     ${value}  `;
                                case 0.5:
                                    return `${value}`;
                                case 1:
                                    return `${value}`;
                                case 1.5:
                                    return `${value}`;
                                case 2:
                                    return `${value}`;
                                case 2.5:
                                    return `${value}`;
                                case 3:
                                    return `${value}`;
                                case 3.5:
                                    return `${value}`;
                                case 4:
                                    return `${value}`;
                                case 4.5:
                                    return `${value}`;



                            }
                        }
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Niveles',
                        fontColor: 'black',
                        fontFamily: 'Poppins',
                        fontSize: 16
                      }
                }],
                animation: {
                    onComplete: function () {
                        if (!rectangleSet) {
                            var scale = window.devicePixelRatio;                       
    
                            var sourceCanvas = chartTest.chart.canvas;
                            var copyWidth = chartTest.scales['y-axis-0'].width - 10;
                            var copyHeight = chartTest.scales['y-axis-0'].height + chartTest.scales['y-axis-0'].top + 10;
    
                            var targetCtx = document.getElementById("axis-Test").getContext("2d");
    
                            targetCtx.scale(scale, scale);
                            targetCtx.canvas.width = copyWidth * scale;
                            targetCtx.canvas.height = copyHeight * scale;
    
                            targetCtx.canvas.style.width = `${copyWidth}px`;
                            targetCtx.canvas.style.height = `${copyHeight}px`;
                            targetCtx.drawImage(sourceCanvas, 0, 0, copyWidth * scale, copyHeight * scale, 0, 0, copyWidth * scale, copyHeight * scale);
    
                            var sourceCtx = sourceCanvas.getContext('2d');
    
                            // Normalize coordinate system to use css pixels.
    
                            sourceCtx.clearRect(0, 0, copyWidth * scale, copyHeight * scale);
                            rectangleSet = true;
                        }
                    },
                    onProgress: function () {
                        if (rectangleSet === true) {
                            var copyWidth = chartTest.scales['y-axis-0'].width;
                            var copyHeight = chartTest.scales['y-axis-0'].height + chartTest.scales['y-axis-0'].top + 10;
    
                            var sourceCtx = chartTest.chart.canvas.getContext('2d');
                            sourceCtx.clearRect(0, 0, copyWidth, copyHeight);
                        }
                    }
                }


            }
        }
    });

    $('#promedioGeneral').val(promedioGeneral);
    //$('#porcentaje').val((promedio / 5 * 100).toFixed(1) + "%");
    $('#promedioGeneral, #porcentaje').prop('disabled', true);
    $('#title').text(`${nombre_representante}, puede visualizar los resultados en la siguiente gráfica y ver su nivel de Evolución digital:`);
    var canvas = document.getElementById('conte');
    canvas.style.width = "100%";
    canvas.style.height = "100%";
    //enviaremail(email, ctx.toDataURL(), dataMes);
}




function generarColoresRGB() {
    var red = Math.floor(Math.random() * 256);
    var green = Math.floor(Math.random() * 256);
    var blue = Math.floor(Math.random() * 256);
    return [red, green, blue];
}

function crearRGB(rgb) {
    return `rgb(${rgb[0]}, ${rgb[1]}, ${rgb[2]})`;
}

function crearRGBA(rgb, transparencia) {
    return `rgba(${rgb[0]}, ${rgb[1]}, ${rgb[2]}, ${transparencia})`;
}

/* function enviaremail(email, imagen, promedio) {
    $.ajax({
        type: "POST",
        data: {
            mode: "enviaremail",
            imagen: imagen,
            email: email,
            promedio_general: promedio,
            token: token
        },
        url: host,
        success: function (data) {
            console.log(data)
        },
        error: function (request, status, error) {
            console.log(error);
        }
    });
} */


/* function validarOpciones(opciones, nivel) {

    switch (nivel) {
        case '1':
            if (opciones == 1) {
                return 0.8;
            } else if (opciones > 1) {

                return 0.6;
            } else {
                return 0
            }

        case '2':
            if (opciones == 1) {
                return 1.1;
            } else if (opciones > 1) {

                return 1.3;
            } else {
                return 0
            }
        case '3':
            if (opciones == 1) {
                return 1.5;
            } else if (opciones > 1) {

                return 1.7;
            } else {
                return 0
            }
        case '4':
            if (opciones == 1) {
                return 2.5;
            } else if (opciones > 1) {

                return 3.2;
            } else {
                return 0
            }
        case '5':
            if (opciones == 1) {
                return 3.8;
            } else if (opciones > 1) {

                return 5;
            } else {
                return 0
            }

    }


} */