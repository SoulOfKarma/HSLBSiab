import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);
export default new Vuex.Store({
    state: {
        listadoReportes: [
            {
                id: 1,
                descripcionReporte: "Saldos"
            },
            {
                id: 3,
                descripcionReporte: "Bincard General"
            },
            {
                id: 10,
                descripcionReporte: "Saldo Valorizado PMP"
            },
            {
                id: 4,
                descripcionReporte: "Consumo por Año"
            },
            {
                id: 5,
                descripcionReporte: "Consumo por Mes"
            },
            {
                id: 6,
                descripcionReporte: "Consumo por Mes/Servicio"
            },
            {
                id: 11,
                descripcionReporte: "Despacho por Servicio"
            },
            {
                id: 12,
                descripcionReporte: "Consolidado Despacho"
            },
            {
                id: 7,
                descripcionReporte: "Fecha Vencimiento/Cenabast"
            },
            {
                id: 8,
                descripcionReporte: "ZGEN"
            },
            {
                id: 9,
                descripcionReporte: "ZGEN Priorizados"
            }
        ],
        listadoMes: [
            {
                id: 1,
                descripcionMes: "Enero"
            },
            {
                id: 2,
                descripcionMes: "Febrero"
            },
            {
                id: 3,
                descripcionMes: "Marzo"
            },
            {
                id: 4,
                descripcionMes: "Abril"
            },
            {
                id: 5,
                descripcionMes: "Mayo"
            },
            {
                id: 6,
                descripcionMes: "Junio"
            },
            {
                id: 7,
                descripcionMes: "Julio"
            },
            {
                id: 8,
                descripcionMes: "Agosto"
            },
            {
                id: 9,
                descripcionMes: "Septiembre"
            },
            {
                id: 10,
                descripcionMes: "Octubre"
            },
            {
                id: 11,
                descripcionMes: "Noviembre"
            },
            {
                id: 12,
                descripcionMes: "Diciembre"
            }
        ],
        configFromdateTimePicker: {
            minDate: null,
            maxDate: "today",
            allowInput: true,
            dateFormat: "d/m/Y",
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                    longhand: [
                        "Domingo",
                        "Lunes",
                        "Martes",
                        "Miércoles",
                        "Jueves",
                        "Viernes",
                        "Sábado"
                    ]
                },
                months: {
                    shorthand: [
                        "Ene",
                        "Feb",
                        "Mar",
                        "Abr",
                        "May",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Sep",
                        "Оct",
                        "Nov",
                        "Dic"
                    ],
                    longhand: [
                        "Enero",
                        "Febrero",
                        "Мarzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ]
                }
            }
        },
        configTodateTimePicker: {
            minDate: "today",
            maxDate: null,
            allowInput: true,
            dateFormat: "d/m/Y",
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                    longhand: [
                        "Domingo",
                        "Lunes",
                        "Martes",
                        "Miércoles",
                        "Jueves",
                        "Viernes",
                        "Sábado"
                    ]
                },
                months: {
                    shorthand: [
                        "Ene",
                        "Feb",
                        "Mar",
                        "Abr",
                        "May",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Sep",
                        "Оct",
                        "Nov",
                        "Dic"
                    ],
                    longhand: [
                        "Enero",
                        "Febrero",
                        "Мarzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ]
                }
            }
        },
        configdateTimePicker: {
            enableTime: false,
            //enableSeconds: true,
            noCalendar: true,
            time_24hr: true,
            dateFormat: "H:i"
        },
        configdateToTimePicker: {
            enableTime: false,
            noCalendar: true,
            time_24hr: true,
            dateFormat: "H:i"
        },
        columnZgen: [
            {
                label: "Codigo DEIS Servicio de Salud",
                field: "CDEISSV",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo DEIS establecimiento",
                field: "DEISEST",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo ZGEN",
                field: "ZGEN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo Interno",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Medicamento Corresponde al Arsenal del Establecimiento",
                field: "VALMED",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Mes de Recepcion del Medicamento",
                field: "MES",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Cantidad Recepcionada",
                field: "CANREC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio Unitario",
                field: "PRECIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio Total",
                field: "TOTAL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad de Medida",
                field: "UNIMED",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Mes de Salida de Medicamento a Farmacia Central",
                field: "MESSAL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Cantidad de Salida a Farmacia",
                field: "DESPACHO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Opciones",
                field: "action"
            }
        ],
        headerTitleZGen: [
            "Codigo DEIS Servicio de Salud",
            "Codigo DEIS establecimiento",
            "Codigo ZGEN",
            "Codigo Interno",
            "Descripcion",
            "Medicamento Corresponde al Arsenal del Establecimiento",
            "Mes de Recepcion del Medicamento",
            "Cantidad Recepcionada",
            "Precio Unitario",
            "Precio Total",
            "Unidad de Medida",
            "Mes de Salida de Medicamento a Farmacia Central",
            "Cantidad de Salida a Farmacia"
        ],
        headerValZGen: [
            "CDEISSV",
            "DEISEST",
            "ZGEN",
            "CODART",
            "NOMBRE",
            "VALMED",
            "MES",
            "CANREC",
            "PRECIO",
            "TOTAL",
            "UNIMED",
            "MESSAL",
            "DESPACHO"
        ],
        columnZGenPriorizado: [
            {
                label: "Via Adquisicion",
                field: "NUMORD",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo DEIS Servicio de Salud",
                field: "CDEISSV",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo DEIS establecimiento",
                field: "DEISEST",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo ZGEN",
                field: "ZGEN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo Interno",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Medicamento Corresponde al Arsenal del Establecimiento",
                field: "VALMED",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Mes de Recepcion del Medicamento",
                field: "MES",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Cantidad Recepcionada",
                field: "STOCKFISICO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio Unitario",
                field: "STOCKBINSAL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Cantidad Recepcionada Por Compra",
                field: "CANREC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label:
                    "Cantidad ingresada por concepto de devolucion de prestamo de otro establecimiento",
                field: "CANDEL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label:
                    "Cantidad ingresada por prestamo de otro establecimiento",
                field: "CANPRES",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Cantidad total dispensada a pacientes",
                field: "CANPAC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Cantidad Prestada o devuelta a otro establecimiento",
                field: "CANPOE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidades Mermadas",
                field: "UMERMA",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Monto Mermado",
                field: "MONMERMA",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Stock Final Físico",
                field: "SALDO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Stock Final en Sistema de Inventario",
                field: "SALDOBIN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio Unitario (PPP) de stock",
                field: "PRECIO1",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio 1",
                field: "PRECIO2",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio 2",
                field: "PRECIO3",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio 3",
                field: "PRECIO4",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Opciones",
                field: "action"
            }
        ],
        headerTitleZGenPriorizado: [
            "Via Adquisicion",
            "Codigo DEIS Servicio de Salud",
            "Codigo DEIS establecimiento",
            "Codigo ZGEN",
            "Codigo Interno",
            "Descripcion",
            "Medicamento Corresponde al Arsenal del Establecimiento",
            "Mes de Recepcion del Medicamento",
            "Cantidad Recepcionada",
            "Precio Unitario",
            "Cantidad Recepcionada Por Compra",
            "Cantidad ingresada por concepto de devolucion de prestamo de otro establecimiento",
            "Cantidad ingresada por prestamo de otro establecimiento",
            "Cantidad total dispensada a pacientes",
            "Cantidad Prestada o devuelta a otro establecimiento",
            "Unidades Mermadas",
            "Monto Mermado",
            "Stock Final Físico",
            "Stock Final en Sistema de Inventario",
            "Precio Unitario (PPP) de stock",
            "Precio 1",
            "Precio 2",
            "Precio 3"
        ],
        headerValZGenPriorizado: [
            "NUMORD",
            "CDEISSV",
            "DEISEST",
            "ZGEN",
            "CODART",
            "NOMBRE",
            "VALMED",
            "MES",
            "STOCKFISICO",
            "STOCKBINSAL",
            "CANREC",
            "CANDEL",
            "CANPRES",
            "CANPAC",
            "CANPOE",
            "UMERMA",
            "MONMERMA",
            "SALDO",
            "SALDOBIN",
            "PRECIO1",
            "PRECIO2",
            "PRECIO3",
            "PRECIO4"
        ],
        columnConsumoMesXServicio: [
            {
                label: "Codigo Interno",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo ZGEN",
                field: "ZGEN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Mes",
                field: "MES",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Servicio",
                field: "descripcionServicio",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Consumo",
                field: "CONSUMO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Opciones",
                field: "action"
            }
        ],
        headerTitleConsumoMesXServicio: [
            "N° Interno",
            "Z-Gen",
            "Descripcion",
            "Mes",
            "Servicio",
            "Consumo"
        ],
        headerValConsumoMesXServicio: [
            "CODART",
            "ZGEN",
            "NOMBRE",
            "MES",
            "descripcionServicio",
            "CONSUMO"
        ],
        columnConsumoMes: [
            {
                label: "Codigo Interno",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo ZGEN",
                field: "ZGEN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Mes",
                field: "MES",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Consumo",
                field: "CONSUMO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Opciones",
                field: "action"
            }
        ],
        headerTitleConsumoMes: [
            "N° Interno",
            "Z-Gen",
            "Descripcion",
            "Mes",
            "Consumo"
        ],
        headerValConsumoMes: ["CODART", "ZGEN", "NOMBRE", "MES", "CONSUMO"],
        columnConsumoAnio: [
            {
                label: "Codigo Interno",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo ZGEN",
                field: "ZGEN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad Medida",
                field: "UNIMED",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Consumo",
                field: "CONSUMO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Opciones",
                field: "action"
            }
        ],
        headerTitleConsumoAnio: [
            "N° Interno",
            "Z-Gen",
            "Descripcion",
            "Unidad Medida",
            "Consumo"
        ],
        headerValConsumoAnio: ["CODART", "ZGEN", "NOMBRE", "UNIMED", "CONSUMO"],
        columnFechaVencimiento: [
            {
                label: "Codigo Interno",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Nombre",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad Medida",
                field: "UNIMED",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Fecha Vencimiento",
                field: "FECVEN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Dias de Vencimiento",
                field: "DIASVENCIMIENTO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Lote",
                field: "LOTE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo de Barra",
                field: "CODBAR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Saldo",
                field: "SALDO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Folio",
                field: "FOLIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Fecha Recepcion",
                field: "FRECEP",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Nombre Proveedor",
                field: "NOMPROV",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Tipo Documento",
                field: "TIPDOC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Numero Documento",
                field: "NUMDOC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Dias Recepcionado",
                field: "DIASREC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Ordenes de Compra",
                field: "ORDENCOMPRA",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Opciones",
                field: "action"
            }
        ],
        columnBincard: [
            {
                label: "Tipo",
                field: "TIPO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Fecha",
                field: "FECHA",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Folio Recepcion",
                field: "FOLREC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Orden de Compra",
                field: "NUMORD",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Proveedor",
                field: "PROVEEDOR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Folio Despacho",
                field: "FOLDES",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Servicio",
                field: "SERVICIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo Interno",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo Barra",
                field: "CODBAR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio",
                field: "PRECIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Cantidad",
                field: "CANTIDAD",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Saldo",
                field: "SALDO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Cantidad*Precio",
                field: "TOTAL1",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Total",
                field: "TOTAL2",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "PMP",
                field: "PMP",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Motivo Anulacion",
                field: "NOMMOT",
                filterOptions: {
                    enabled: true
                }
            }
        ],
        columnBincardGeneral: [
            {
                label: "Tipo",
                field: "TIPO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Fecha",
                field: "FECHA",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Folio Recepcion",
                field: "FOLREC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Orden de Compra",
                field: "NUMORD",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Proveedor",
                field: "PROVEEDOR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Folio Despacho",
                field: "FOLDES",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Servicio",
                field: "SERVICIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo Interno",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo Barra",
                field: "CODBAR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio",
                field: "PRECIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Cantidad",
                field: "CANTIDAD",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Saldo",
                field: "SALDO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Motivo Anulacion",
                field: "NOMMOT",
                filterOptions: {
                    enabled: true
                }
            }
        ],
        headerTitleBincardGeneral: [
            "N° Interno",
            "Z-Gen",
            "Descripcion",
            "Unidad Medida",
            "Saldo",
            "Estado"
        ],
        headerValBincardGeneral: [
            "CODART",
            "ZGEN",
            "NOMBRE",
            "UNIMED",
            "saldoCorrecto",
            "Estado"
        ],
        columnSaldos: [
            {
                label: "Codigo Interno",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo ZGEN",
                field: "ZGEN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad Medida",
                field: "UNIMED",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Saldo",
                field: "saldoCorrecto",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Opciones",
                field: "action"
            }
        ],
        columnSaldoV: [
            {
                label: "Codigo Interno",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad Medida",
                field: "UNIMED",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Saldo",
                field: "saldoCorrecto",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Ultimo Precio",
                field: "ULTPRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Total",
                field: "TOTAL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Opciones",
                field: "action"
            }
        ],
        columnBincardInicial: [
            {
                label: "Codigo Interno",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo ZGEN",
                field: "ZGEN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad Medida",
                field: "UNIMED",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Saldo",
                field: "saldoCorrecto",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Estado",
                field: "Estado",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Opciones",
                field: "action"
            }
        ],
        columnSaldoPmp: [
            {
                label: "Codigo Articulo",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad Medida",
                field: "UNIMED",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidades",
                field: "saldoCorrecto",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Total",
                field: "TOTAL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "PMP",
                field: "PMP",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Ultimo Valor",
                field: "ULTPRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Menor Valor",
                field: "MINPRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Opciones",
                field: "action"
            }
        ],
        columnDespachoXServicio: [
            {
                label: "Fecha",
                field: "FECDES",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Folio",
                field: "FOLIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo Interno",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad Medida",
                field: "UNIMED",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Cantidad",
                field: "CANTIDAD",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio",
                field: "PRECIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Total",
                field: "TOTAL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Servicio",
                field: "NOMSER",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Opciones",
                field: "action"
            }
        ],
        columnConsolidadoDespacho: [
            {
                label: "Mes",
                field: "MES",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo Interno",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad Medida",
                field: "UNIMED",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Cantidad",
                field: "CANTIDAD",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio",
                field: "PRECIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Total",
                field: "TOTAL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Opciones",
                field: "action"
            }
        ],
        columnBincardGetArticulosSaldoEstadoCF: [
            {
                label: "Tipo",
                field: "TIPO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Fecha",
                field: "FECHA",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Folio Recepcion",
                field: "FOLREC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Proveedor",
                field: "PROVEEDOR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Folio Despacho",
                field: "FOLDES",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Servicio",
                field: "SERVICIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio",
                field: "PRECIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Cantidad",
                field: "CANTIDAD",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Saldo",
                field: "SALDO",
                filterOptions: {
                    enabled: true
                }
            }
        ],
        headerTitleGetArticulosSaldoEstadoCF: [
            "Tipo",
            "Nombre",
            "Fecha",
            "Folio Recepcion",
            "Proveedor",
            "Folio Despacho",
            "Servicio",
            "Precio",
            "Cantidad",
            "Saldo"
        ],
        headerValGetArticulosSaldoEstadoCF: [
            "TIPO",
            "NOMBRE",
            "FECHA",
            "FOLREC",
            "PROVEEDOR",
            "FOLDES",
            "SERVICIO",
            "PRECIO",
            "CANTIDAD",
            "SALDO"
        ],
        columnBincardGetArticulosSaldoEstado: [
            {
                label: "Tipo",
                field: "TIPO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Fecha",
                field: "FECHA",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Folio Recepcion",
                field: "FOLREC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Proveedor",
                field: "PROVEEDOR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Folio Despacho",
                field: "FOLDES",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Servicio",
                field: "SERVICIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo Interno",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo Barra",
                field: "CODBAR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio",
                field: "PRECIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Cantidad",
                field: "CANTIDAD",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Saldo",
                field: "SALDO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Fecha Vencimiento",
                field: "FECVEN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "LOTE",
                field: "LOTE",
                filterOptions: {
                    enabled: true
                }
            }
        ],
        headerTitleGetArticulosSaldoEstado: [
            "Tipo",
            "Nombre",
            "Fecha",
            "Folio Recepcion",
            "Proveedor",
            "Folio Despacho",
            "Servicio",
            "Codigo Interno",
            "Codigo Barra",
            "Precio",
            "Cantidad",
            "Saldo",
            "Fecha Vencimiento",
            "Lote"
        ],
        headerValGetArticulosSaldoEstado: [
            "TIPO",
            "NOMBRE",
            "FECHA",
            "FOLREC",
            "PROVEEDOR",
            "FOLDES",
            "SERVICIO",
            "CODART",
            "CODBAR",
            "PRECIO",
            "CANTIDAD",
            "SALDO",
            "FECVEN",
            "LOTE"
        ]
    },
    mutations: {},
    actions: {}
});
