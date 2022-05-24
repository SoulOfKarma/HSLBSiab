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
                                :pagination-options="{
                                    enabled: true,
                                    perPage: 10
                                }"
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
            idMod: 0,
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
                this.unidadMedidaBase = "";
                this.idMod = 0;
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
                                `Bearer ` + sessionStorage.getItem("token")
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
                                `Bearer ` + sessionStorage.getItem("token")
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
                                `Bearer ` + sessionStorage.getItem("token")
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
                                `Bearer ` + sessionStorage.getItem("token")
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
                                `Bearer ` + sessionStorage.getItem("token")
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

        AgregarSaldoInventario() {
            try {
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
                    CODART_ONU: this.codigoOnu,
                    CODART: this.codigoArticulo,
                    NOMBRE: this.nombre,
                    idEstado: this.seleccionEstado.id,
                    ACT_FECVEN: boolFVen,
                    ACT_LOTE: boolFLoteSerie,
                    CANTXENB: this.cantidadEmbalaje,
                    idBodega: this.seleccionBodega.id,
                    idZona: this.seleccionZona.id,
                    SECTOR: this.sector,
                    UBICACION: this.ubicacion,
                    NOMFAM1: this.seleccionFamilia1.descripcionFamilia,
                    NOMFAM2: this.seleccionFamilia2.descripcionFamilia,
                    NOMFAM3: this.seleccionFamilia3.descripcionFamilia,
                    NOMFAM4: this.seleccionFamilia4.descripcionFamilia,
                    NOMFAM5: this.seleccionFamilia5.descripcionFamilia,
                    UNIMEDBASE: this.unidadMedidaBase,
                    PRECIO: this.precio,
                    SALDO: this.saldo
                };
                const dat = data;
                axios
                    .post(
                        this.localVal + "/api/Mantenedor/PostSaldoInventario",
                        dat,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
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
            } catch (error) {
                console.log(error);
            }
        }
    },
    beforeMount() {
        this.TraerSaldoInventario();
        this.TraerArticulos();
        this.TraerEstado();
        this.TraerBodega();
        this.TraerZona();
        this.openLoadingColor();
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1500px;
}
</style>
