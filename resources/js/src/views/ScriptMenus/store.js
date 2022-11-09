import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);
export default new Vuex.Store({
    state: {
        PageOptions: {
            enabled: true,
            perPage: 10,
            mode: "pages",
            firstLabel: "Primera Pagina",
            lastLabel: "Ultima Pagina",
            nextLabel: "Siguiente",
            prevLabel: "Anterior",
            rowsPerPageLabel: "Filas por pagina",
            pageLabel: "Pagina",
            ofLabel: "de",
            allLabel: "Todo"
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
        ]
    },
    mutations: {},
    actions: {}
});
