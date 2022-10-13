import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);
export default new Vuex.Store({
    state: {
        columns: [
            {
                label: "Codigo de Barra",
                field: "CODART_BARR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Bodega",
                field: "descripcionBodega",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo Onu",
                field: "CODART_ONU",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo Articulo",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Nombre Articulo",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad de Medida",
                field: "UNIMEDBASE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Opciones",
                field: "action"
            }
        ],
        col: [
            {
                label: "Codigo de Barra",
                field: "CODART_BARR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Bodega",
                field: "descripcionBodega",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo Articulo",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Nombre Medicamento",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad de Medida",
                field: "UNIMEDBASE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Opciones",
                field: "action"
            }
        ],
        columnsMed: [
            {
                label: "Codigo de Barra",
                field: "CODART_BARR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Bodega",
                field: "descripcionBodega",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo Articulo",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Nombre Medicamento",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Generico",
                field: "GENERICO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Categoria Farmacia",
                field: "CAT_FARMACIA",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad de Medida",
                field: "UNIMEDBASE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Concentracion",
                field: "CONCENTRACION",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Laboratorio",
                field: "LABORATORIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Estado",
                field: "descripcionEstado",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Opciones",
                field: "action"
            }
        ],
        colMed: [
            {
                label: "Codigo de Barra",
                field: "CODART_BARR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo Articulo",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Nombre Medicamento",
                field: "NOMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad de Medida",
                field: "UNIMEDBASE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Opciones",
                field: "action"
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
        ]
    },
    mutations: {},
    actions: {}
});
