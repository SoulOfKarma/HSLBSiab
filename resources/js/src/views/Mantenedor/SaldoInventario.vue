<template>
    <div>
        <div class="vx-col md:w-1/1 w-full mb-base">
            <vx-card title="">
                <div class="vx-row">
                    <div class="vx-col w-full mt-5">
                        <vs-button
                            @click="popArticulos"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Buscar Articulo</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Bodega</h6>

                        <v-select
                            v-model="seleccionBodega"
                            placeholder="Activo"
                            class="w-full select-large"
                            label="descripcionBodega"
                            :options="listaBodega"
                            disabled
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Nombre Articulo</h6>

                        <vs-input
                            class="inputx w-full  "
                            v-model="nombre"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Codigo Interno</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="codigoArticulo"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Unidad Medida Base</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="unidadMedidaBase"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>
                            Codigo de Barra
                        </h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="codigoBarra"
                            disabled
                        />
                    </div>
                </div>
                <br />
                <div class="vx-row">
                    <div class="vx-col w-1/2 mt-5">
                        <h6>
                            Saldo
                        </h6>
                        <vs-input class="inputx w-full  " v-model="saldo" />
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <h6>
                            Precio
                        </h6>
                        <vs-input class="inputx w-full  " v-model="precio" />
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            @click="limpiarCampos"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Limpiar Campos</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            @click="AgregarSaldoInventario"
                            color="success"
                            type="filled"
                            class="w-full"
                            >Agregar Articulo Saldo Inventario</vs-button
                        >
                    </div>
                </div>
                <div class="vx-row">
                    <vx-card>
                        <vue-good-table
                            :columns="columns"
                            :rows="rows"
                            :pagination-options="PageOptions"
                            styleClass="vgt-table condensed bordered"
                        >
                            <template slot="table-row" slot-scope="props">
                                <!-- Column: Name -->
                                <span
                                    v-if="props.column.field === 'fullName'"
                                    class="text-nowrap"
                                >
                                </span>

                                <!-- Column: Common -->
                                <span v-else>
                                    {{ props.formattedRow[props.column.field] }}
                                </span>
                            </template>
                        </vue-good-table>
                    </vx-card>
                </div>
                <br />
            </vx-card>
            <div class="vx-row"></div>
        </div>
        <vs-popup
            classContent="ListadoArticulos"
            title="Listado Articulos"
            :active.sync="popUpArticulos"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row">
                        <vx-card>
                            <vue-good-table
                                :columns="col"
                                :rows="listaCodNuevo"
                                :pagination-options="PageOptions"
                                styleClass="vgt-table condensed bordered"
                            >
                                <template slot="table-row" slot-scope="props">
                                    <!-- Column: Name -->
                                    <span
                                        v-if="props.column.field === 'fullName'"
                                        class="text-nowrap"
                                    >
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'action'
                                        "
                                    >
                                        <plus-circle-icon
                                            content="Agregar Articulo al listado"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                popAgregarArticulo(
                                                    props.row.NOMBRE,
                                                    props.row.UNIMEDBASE,
                                                    props.row.CODART_ONU,
                                                    props.row.CODART,
                                                    props.row.CODART_BARR,
                                                    props.row.idEstado,
                                                    props.row.UBICACION,
                                                    props.row.SECTOR,
                                                    props.row.idBodega,
                                                    props.row.idZona,
                                                    props.row.CANTXENB,
                                                    props.row.NOMFAM1,
                                                    props.row.NOMFAM2,
                                                    props.row.NOMFAM3,
                                                    props.row.NOMFAM4,
                                                    props.row.NOMFAM5,
                                                    props.row.idACT_FECVEN,
                                                    props.row.idACTLOTE
                                                )
                                            "
                                        ></plus-circle-icon>
                                    </span>
                                    <!-- Column: Common -->
                                    <span v-else>
                                        {{
                                            props.formattedRow[
                                                props.column.field
                                            ]
                                        }}
                                    </span>
                                </template>
                            </vue-good-table>
                        </vx-card>
                    </div>
                </vx-card>
                <div class="vx-row"></div>
            </div>
        </vs-popup>
    </div>
</template>
<script>
import axios from "axios";
import router from "@/router";
import vSelect from "vue-select";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";
import { PlusCircleIcon } from "vue-feather-icons";
import Vue from "vue";
import VueTippy, { TippyComponent } from "vue-tippy";
import store from "../ScriptMenus/store.js";
Vue.use(VueTippy);
Vue.component("tippy", TippyComponent);

export default {
    components: {
        VueGoodTable,
        "v-select": vSelect,
        quillEditor,
        PlusCircleIcon
    },
    data() {
        return {
            //Datos Locales - Variables de Entorno
            localVal: process.env.MIX_APP_URL,
            editorOption: {
                modules: {
                    toolbar: [
                        ["bold", "italic", "underline", "strike"],
                        ["blockquote", "code-block"],
                        [{ header: 1 }, { header: 2 }],
                        [{ list: "ordered" }, { list: "bullet" }],
                        [{ indent: "-1" }, { indent: "+1" }],
                        [{ direction: "rtl" }],
                        [{ font: [] }],
                        [{ align: [] }],
                        ["clean"]
                    ]
                }
            },
            //Datos Campos
            PageOptions: store.state.PageOptions,
            popUpArticulos: false,
            descripcionServicio: "",
            saldo: 0,
            precio: 0,
            codigoBarra: "",
            codigoTrack: "",
            codigoOnu: "",
            codigoArticulo: "",
            nombre: "",
            idEstado: "",
            generico: "",
            categoriaFarmacia: "",
            concentracion: "",
            actFechaVencimiento: false,
            actLoteSerie: false,
            cantidadEmbalaje: "",
            idBodega: "",
            idZona: "",
            sector: "",
            ubicacion: "",
            unidadMedidaBase: "",
            zgen: "",
            seleccionEstado: {
                id: 0,
                descripcionEstado: ""
            },
            seleccionBodega: {
                id: 0,
                descripcionBodega: ""
            },
            seleccionZona: {
                id: 0,
                descripcionZonas: ""
            },
            seleccionFechaVenciminento: {
                id: 0,
                descripcionFVen: "Seleccione Fecha Venciminento"
            },
            seleccionLoteSerie: {
                id: 0,
                descripcionLoteSerie: "Seleccione Lote/Serie"
            },
            seleccionFamilia1: {
                id: 0,
                descripcionFamilia: "",
                idBodega: 0
            },
            seleccionFamilia2: {
                id: 0,
                descripcionFamilia: "",
                idDesFam: 0
            },
            seleccionFamilia3: {
                id: 0,
                descripcionFamilia: "",
                idDesFam01: 0
            },
            seleccionFamilia4: {
                id: 0,
                descripcionFamilia: "",
                idDesFam02: 0
            },
            seleccionFamilia5: {
                id: 0,
                descripcionFamilia: "",
                idDesFam03: 0
            },
            idMod: 0,
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
            //Datos Listado Proveedor
            rows: [],
            listaCodNuevo: [],
            listaEstado: [],
            listaBodega: [],
            listaZona: [],
            listaFamilia1: [],
            listaFamilia2: [],
            listaFamilia3: [],
            listaFamilia4: [],
            listaFamilia5: [],
            listaTempFamilia1: [],
            listaTempFamilia2: [],
            listaTempFamilia3: [],
            listaTempFamilia4: [],
            listaTempFamilia5: [],
            listaFVenciminento: [
                {
                    id: 1,
                    descripcionFVen: "Si"
                },
                {
                    id: 2,
                    descripcionFVen: "No"
                }
            ],
            listaFLoteSerie: [
                {
                    id: 1,
                    descripcionLoteSerie: "Si"
                },
                {
                    id: 2,
                    descripcionLoteSerie: "No"
                }
            ]
        };
    },
    methods: {
        //Metodos Reusables
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 1000);
        },
        isNumber: function(evt) {
            evt = evt ? evt : window.event;
            var charCode = evt.which ? evt.which : evt.keyCode;
            if (
                charCode > 31 &&
                (charCode < 48 || charCode > 57) &&
                charCode !== 46
            ) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
        limpiarCampos() {
            try {
                this.saldo = 0;
                this.precio = 0;
                this.codigoBarra = "";
                this.codigoOnu = "";
                this.codigoArticulo = "";
                this.nombre = "";
                this.seleccionEstado = {
                    id: 0,
                    descripcionEstado: ""
                };
                this.seleccionFechaVenciminento = {
                    id: 0,
                    descripcionFVen: "Seleccione Fecha Venciminento"
                };
                this.seleccionLoteSerie = {
                    id: 0,
                    descripcionLoteSerie: "Seleccione Lote/Serie"
                };
                this.cantidadEmbalaje = "";
                this.idBodega = 0;
                this.seleccionBodega = {
                    id: 0,
                    descripcionBodega: ""
                };
                this.idZona = 0;
                this.seleccionZona = {
                    id: 0,
                    descripcionZonas: ""
                };
                this.sector = "";
                this.ubicacion = "";
                this.seleccionFamilia1 = {
                    id: 0,
                    descripcionFamilia: "",
                    idBodega: 0
                };
                this.seleccionFamilia2 = {
                    id: 0,
                    descripcionFamilia: "",
                    idDesFam: 0
                };
                this.seleccionFamilia3 = {
                    id: 0,
                    descripcionFamilia: "",
                    idDesFam01: 0
                };
                this.seleccionFamilia4 = {
                    id: 0,
                    descripcionFamilia: "",
                    idDesFam02: 0
                };
                this.seleccionFamilia5 = {
                    id: 0,
                    descripcionFamilia: "",
                    idDesFam03: 0
                };
                this.unidadMedidaBase = "";
                this.idMod = 0;
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemBodegaFamilia() {
            try {
                this.listaFamilia1 = [];
                let c = this.listaTempFamilia1;
                let b = this.seleccionBodega.id;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.idBodega) {
                        a.push(value);
                    }
                });

                this.listaFamilia1 = a;
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemFamilia1() {
            try {
                this.listaFamilia2 = [];
                let c = this.listaTempFamilia2;
                let b = this.seleccionFamilia1.CODFAM1;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.idDesFam) {
                        a.push(value);
                    }
                });

                this.listaFamilia2 = a;
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemFamilia2() {
            try {
                this.listaFamilia3 = [];
                let c = this.listaTempFamilia3;
                let b = this.seleccionFamilia2.CODFAM2;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.idDesFam01) {
                        a.push(value);
                    }
                });

                this.listaFamilia3 = a;
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemFamilia3() {
            try {
                this.listaFamilia4 = [];
                let c = this.listaTempFamilia4;
                let b = this.seleccionFamilia3.CODFAM3;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.idDesFam02) {
                        a.push(value);
                    }
                });

                this.listaFamilia4 = a;
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemFamilia4() {
            try {
                this.listaFamilia5 = [];
                let c = this.listaTempFamilia5;
                let b = this.seleccionFamilia4.CODFAM4;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.idDesFam03) {
                        a.push(value);
                    }
                });

                this.listaFamilia5 = a;
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popArticulos() {
            try {
                this.popUpArticulos = true;
            } catch (error) {
                console.log(error);
            }
        },
        popAgregarArticulo(
            NOMBRE,
            UNIMEDBASE,
            CODART_ONU,
            CODART,
            CODART_BARR,
            idEstado,
            UBICACION,
            SECTOR,
            idBodega,
            idZona,
            CANTXENB,
            NOMFAM1,
            NOMFAM2,
            NOMFAM3,
            NOMFAM4,
            NOMFAM5,
            idACT_FECVEN,
            idACTLOTE
        ) {
            try {
                this.limpiarCampos();
                this.popUpCodInsumoEco = true;
                this.codigoBarra = CODART_BARR;
                this.codigoOnu = CODART_ONU;
                this.codigoArticulo = CODART;
                this.nombre = NOMBRE;
                let c = this.listaEstado;

                c.forEach((value, index) => {
                    if (idEstado == value.id) {
                        this.seleccionEstado.id = value.id;
                        this.seleccionEstado.descripcionEstado =
                            value.descripcionEstado;
                    }
                });

                c = [];

                if (idACT_FECVEN == 1) {
                    this.seleccionFechaVenciminento = {
                        id: 1,
                        descripcionFVen: "Si"
                    };
                } else {
                    this.seleccionFechaVenciminento = {
                        id: 2,
                        descripcionFVen: "No"
                    };
                }

                if (idACTLOTE == 1) {
                    this.seleccionLoteSerie = {
                        id: 1,
                        descripcionLoteSerie: "Si"
                    };
                } else {
                    this.seleccionLoteSerie = {
                        id: 2,
                        descripcionLoteSerie: "No"
                    };
                }

                this.cantidadEmbalaje = CANTXENB;
                this.idBodega = 0;

                c = this.listaBodega;

                c.forEach((value, index) => {
                    if (idBodega == value.id) {
                        this.seleccionBodega.id = value.id;
                        this.seleccionBodega.descripcionBodega =
                            value.descripcionBodega;
                    }
                });

                c = [];

                this.idZona = 0;

                c = this.listaZona;

                c.forEach((value, index) => {
                    if (idZona == value.id) {
                        this.seleccionZona.id = value.id;
                        this.seleccionZona.descripcionZonas =
                            value.descripcionZonas;
                    }
                });

                c = [];
                this.sector = SECTOR;
                this.ubicacion = UBICACION;

                c = this.listaTempFamilia1;

                c.forEach((value, index) => {
                    if (NOMFAM1 == value.descripcionFamilia) {
                        this.seleccionFamilia1.id = value.id;
                        this.seleccionFamilia1.idBodega = value.idBodega;
                        this.seleccionFamilia1.descripcionFamilia =
                            value.descripcionFamilia;
                    }
                });

                c = [];

                c = this.listaTempFamilia2;

                c.forEach((value, index) => {
                    if (NOMFAM2 == value.descripcionFamilia) {
                        this.seleccionFamilia2.id = value.id;
                        this.seleccionFamilia2.idDesFam = value.idDesFam;
                        this.seleccionFamilia2.descripcionFamilia =
                            value.descripcionFamilia;
                    }
                });

                c = [];

                c = this.listaTempFamilia3;

                c.forEach((value, index) => {
                    if (NOMFAM3 == value.descripcionFamilia) {
                        this.seleccionFamilia3.id = value.id;
                        this.seleccionFamilia3.idDesFam01 = value.idDesFam01;
                        this.seleccionFamilia3.descripcionFamilia =
                            value.descripcionFamilia;
                    }
                });

                c = [];

                c = this.listaTempFamilia4;

                c.forEach((value, index) => {
                    if (NOMFAM4 == value.descripcionFamilia) {
                        this.seleccionFamilia4.id = value.id;
                        this.seleccionFamilia4.idDesFam02 = value.idDesFam02;
                        this.seleccionFamilia4.descripcionFamilia =
                            value.descripcionFamilia;
                    }
                });

                c = [];

                c = this.listaTempFamilia5;

                c.forEach((value, index) => {
                    if (NOMFAM5 == value.descripcionFamilia) {
                        this.seleccionFamilia5.id = value.id;
                        this.seleccionFamilia5.idDesFam03 = value.idDesFam03;
                        this.seleccionFamilia5.descripcionFamilia =
                            value.descripcionFamilia;
                    }
                });

                this.unidadMedidaBase = UNIMEDBASE;
                this.popUpArticulos = false;
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD
        TraerArticulos() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetAllArticulos", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaCodNuevo = res.data;
                        if (this.listaCodNuevo.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerSaldoInventario() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetSaldoInventario", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.rows = res.data;
                        if (this.rows.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerEstado() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetAuthEstado", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaEstado = res.data;
                        if (this.listaEstado.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de Estado correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerBodega() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetBodega", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaBodega = res.data;
                        if (this.listaBodega.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de las Bodegas correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerZona() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetZona", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaZona = res.data;
                        if (this.listaZona.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de los servicios correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerFamilia1() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetFamilia1", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaTempFamilia1 = res.data;
                        if (this.listaTempFamilia1.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de Familias Asociadas correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerFamilia2() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetFamilia2", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaTempFamilia2 = res.data;
                        if (this.listaTempFamilia2.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de Familias Asociadas correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerFamilia3() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetFamilia3", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaTempFamilia3 = res.data;
                        if (this.listaTempFamilia3.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de Familias Asociadas correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerFamilia4() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetFamilia4", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaTempFamilia4 = res.data;
                        if (this.listaTempFamilia4.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de Familias Asociadas correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerFamilia5() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetFamilia5", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaTempFamilia5 = res.data;
                        if (this.listaTempFamilia5.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de Familias Asociadas correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },

        AgregarSaldoInventario() {
            try {
                if (this.codigoBarra == "" || this.codigoBarra == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar un articulo",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.saldo == 0 || this.saldo < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un saldo",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.precio == 0 || this.precio < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un precio",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let boolFVen = false;
                    if (this.seleccionFechaVenciminento.id == 1) {
                        boolFVen = true;
                    } else {
                        boolFVen = true;
                    }

                    let boolFLoteSerie = false;
                    if (this.seleccionLoteSerie.id == 1) {
                        boolFLoteSerie = true;
                    } else {
                        boolFLoteSerie = true;
                    }

                    let data = {
                        CODART_BARR: this.codigoBarra,
                        CODART_ONU: this.codigoOnu.toUpperCase(),
                        CODART: this.codigoArticulo.toUpperCase(),
                        NOMBRE: this.nombre.toUpperCase(),
                        idEstado: this.seleccionEstado.id,
                        ACT_FECVEN: boolFVen,
                        ACT_LOTE: boolFLoteSerie,
                        CANTXENB: this.cantidadEmbalaje,
                        idBodega: this.seleccionBodega.id,
                        idZona: this.seleccionZona.id,
                        SECTOR: this.sector.toUpperCase(),
                        UBICACION: this.ubicacion.toUpperCase(),
                        NOMFAM1: this.seleccionFamilia1.descripcionFamilia,
                        NOMFAM2: this.seleccionFamilia2.descripcionFamilia,
                        NOMFAM3: this.seleccionFamilia3.descripcionFamilia,
                        NOMFAM4: this.seleccionFamilia4.descripcionFamilia,
                        NOMFAM5: this.seleccionFamilia5.descripcionFamilia,
                        UNIMEDBASE: this.unidadMedidaBase.toUpperCase(),
                        PRECIO: this.precio,
                        SALDO: this.saldo
                    };
                    const dat = data;
                    axios
                        .post(
                            this.localVal +
                                "/api/Mantenedor/PostSaldoInventario",
                            dat,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text:
                                        "Saldo Inventario Ingresado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.TraerSaldoInventario();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible agregar el codigo de Insumo/Economato,intentelo nuevamente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        RefreshToken() {
            try {
                let data = {
                    token: localStorage.getItem("token")
                };
                axios
                    .post(this.localVal + "/api/auth/RefreshToken", data)
                    .then(res => {
                        let tok = res.data;
                        if (tok == "") {
                        } else if (tok == false) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No se pudo refrescar su sesion, sera redirigido a el inicio de sesion",
                                color: "danger",
                                position: "top-right"
                            });
                            window.localStorage.clear();
                            window.localStorage.clear();
                            router.push("/pages/login");
                        } else {
                            localStorage.setItem("token", tok);
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        }
    },
    beforeMount() {
        this.RefreshToken();
        setTimeout(() => {
            this.TraerSaldoInventario();
            this.TraerArticulos();
            this.TraerEstado();
            this.TraerBodega();
            this.TraerZona();
            this.TraerFamilia1();
            this.TraerFamilia2();
            this.TraerFamilia3();
            this.TraerFamilia4();
            this.TraerFamilia5();
            this.openLoadingColor();
        }, 2000);
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1500px;
}
</style>
