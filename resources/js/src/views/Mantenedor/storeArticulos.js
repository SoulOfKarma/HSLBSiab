import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";
Vue.use(Vuex);
export default new Vuex.Store({
    state: {
        //Datos Locales - Variables de Entorno Ubicada en el Archivo .Env del proyecto.
        localVal: process.env.MIX_APP_URL,
        //Datos Generales
        listaBodega: [],
        listaZona: [],
        listaEstado: [],
        rowsMed: [],
        listaLaboratorio: [],
        listaTempFamilia1: [],
        listaTempFamilia2: [],
        listaTempFamilia3: [],
        listaTempFamilia4: [],
        listaTempFamilia5: [],
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
                label: "Codigo Interno",
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
                label: "Codigo Interno",
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
                label: "Codigo Interno",
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
                label: "Codigo Interno",
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
    getters: {
        getBodegas: state => state.listaBodega,
        getZonas: state => state.listaZona,
        getEstados: state => state.listaEstado,
        getFAM1: state => state.listaTempFamilia1,
        getFAM2: state => state.listaTempFamilia2,
        getFAM3: state => state.listaTempFamilia3,
        getFAM4: state => state.listaTempFamilia4,
        getFAM5: state => state.listaTempFamilia5,
        getProductos: state => state.rowsMed,
        getLaboratorios: state => state.listaLaboratorio
    },
    mutations: {
        SET_BODEGA(state, listado) {
            state.listaBodega = listado;
        },
        SET_ZONAS(state, listado) {
            state.listaZona = listado;
        },
        SET_FAM1(state, listado) {
            state.listaTempFamilia1 = listado;
        },
        SET_FAM2(state, listado) {
            state.listaTempFamilia2 = listado;
        },
        SET_FAM3(state, listado) {
            state.listaTempFamilia3 = listado;
        },
        SET_FAM4(state, listado) {
            state.listaTempFamilia4 = listado;
        },
        SET_FAM5(state, listado) {
            state.listaTempFamilia5 = listado;
        },
        SET_ESTADOS(state, listado) {
            state.listaEstado = listado;
        },
        SET_PRODUCTOS(state, listado) {
            state.rowsMed = listado;
        },
        SET_LABORATORIOS(state, listado) {
            state.listaLaboratorio = listado;
        }
    },
    actions: {
        async TraerBodega({ commit }) {
            try {
                return axios
                    .get(this.state.localVal + "/api/Mantenedor/GetBodega", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        commit("SET_BODEGA", res.data);
                    });
            } catch (error) {
                return console.log(error);
            }
        },
        async TraerZona({ commit }) {
            try {
                return axios
                    .get(this.state.localVal + "/api/Mantenedor/GetZona", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        commit("SET_ZONAS", res.data);
                    });
            } catch (error) {
                return console.log(error);
            }
        },
        async TraerFamilia1({ commit }) {
            try {
                return axios
                    .get(this.state.localVal + "/api/Mantenedor/GetFamilia1", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        commit("SET_FAM1", res.data);
                    });
            } catch (error) {
                return console.log(error);
            }
        },
        async TraerFamilia2({ commit }) {
            try {
                return axios
                    .get(this.state.localVal + "/api/Mantenedor/GetFamilia2", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        commit("SET_FAM2", res.data);
                    });
            } catch (error) {
                console.log(error);
            }
        },
        async TraerFamilia3({ commit }) {
            try {
                return axios
                    .get(this.state.localVal + "/api/Mantenedor/GetFamilia3", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        commit("SET_FAM3", res.data);
                    });
            } catch (error) {
                console.log(error);
            }
        },
        async TraerFamilia4({ commit }) {
            try {
                return axios
                    .get(this.state.localVal + "/api/Mantenedor/GetFamilia4", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        commit("SET_FAM4", res.data);
                    });
            } catch (error) {
                console.log(error);
            }
        },
        async TraerFamilia5({ commit }) {
            try {
                return axios
                    .get(this.state.localVal + "/api/Mantenedor/GetFamilia5", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        commit("SET_FAM5", res.data);
                    });
            } catch (error) {
                console.log(error);
            }
        },
        async TraerEstado({ commit }) {
            try {
                return axios
                    .get(
                        this.state.localVal + "/api/Mantenedor/GetAuthEstado",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        commit("SET_ESTADOS", res.data);
                    });
            } catch (error) {
                console.log(error);
            }
        },
        async TraerProductos({ commit }) {
            try {
                return axios
                    .get(
                        this.state.localVal + "/api/Mantenedor/GetAllProductos",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        commit("SET_PRODUCTOS", res.data);
                    });
            } catch (error) {
                console.log(error);
            }
        },
        async TraerLaboratorios({ commit }) {
            try {
                return axios
                    .get(
                        this.state.localVal + "/api/Mantenedor/GetLaboratorio",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        commit("SET_LABORATORIOS", res.data);
                    });
            } catch (error) {
                console.log(error);
            }
        }
    }
});
