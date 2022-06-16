<template>
    <div>
        <div class="vx-col md:w-1/1 w-full mb-base">
            <vx-card title="Recepcion">
                <div class="vx-row">
                    <div class="vx-col w-1/2 mt-5">
                        <h6>N° Interno</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="numint"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <h6>N° Folio</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="folio"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/4 mt-5">
                        <h6>Fecha Sistema</h6>
                        <flat-pickr
                            :config="configFromdateTimePicker"
                            v-model="fechaSistema"
                            placeholder="Fecha Sistema"
                            class="w-full "
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/4 mt-5">
                        <h6>Fecha Inicio</h6>
                        <flat-pickr
                            :config="configFromdateTimePicker"
                            v-model="fechaRecepcion"
                            placeholder="Fecha Inicio"
                            @on-change="onFromChange"
                            class="w-full "
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/4 mt-5">
                        <h6>Proveedor</h6>
                        <v-select
                            v-model="seleccionProveedores"
                            placeholder="Activo"
                            class="w-full select-large"
                            label="RUTPROV"
                            :options="listadoProveedores"
                            @input="setProveedor"
                            disabled
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/4 mt-5">
                        <h6>Nombre Proveedor</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="descripcionProveedor"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Tipo Documento</h6>
                        <v-select
                            v-model="seleccionTipoDocumento"
                            placeholder="Activo"
                            class="w-full select-large"
                            label="descripcionDocumento"
                            :options="listaTipoDocumento"
                            disabled
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>N° Documento</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="ndocumento"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Fecha Documento</h6>
                        <flat-pickr
                            :config="configFromdateTimePicker"
                            v-model="fechaDocumento"
                            @on-change="onFromChange"
                            class="w-full "
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>N° Orden Compra</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="nordencompra"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>N° RIB</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="nrib"
                            disabled
                        />
                    </div>
                </div>
                <br />

                <!-- Detalles Articulos -->
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <vue-good-table
                                :columns="colDetalle"
                                :rows="listaDetalleRecepcion"
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
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
                <!-- Calculos -->
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <vue-good-table
                                class="w-full"
                                :columns="colTotal"
                                :rows="listaRecepcion"
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
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <h6>Observaciones</h6>
                            <br /><br />
                            <quill-editor
                                class="w-full"
                                v-model="Observaciones"
                                :options="editorOption"
                            >
                                <div id="toolbar" slot="toolbar"></div>
                            </quill-editor>
                        </div>
                        <br /><br />
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="ImprimirDatos"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Imprimir</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="volver"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                </div>
            </vx-card>
            <div class="vx-row"></div>
        </div>
    </div>
</template>
<script>
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import moment from "moment";
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
        PlusCircleIcon,
        flatPickr
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
            FVEN1: "Si",
            FVEN2: "No",
            codInternoRecepcion: 0,
            descripcionServicio: "",
            ndocumento: "",
            cantidad: 0,
            precio: 0,
            numint: 0,
            folio: 0,
            valorTotal: 0,
            fechaSistema: null,
            fechaRecepcion: null,
            fechaDocumento: null,
            fechaVencimiento: null,
            codigoBarra: "",
            Observaciones: "",
            nordencompra: "",
            nrib: "",
            codigoTrack: "",
            codigoOnu: "",
            codigoArticulo: "",
            nombre: "",
            idEstado: "",
            generico: "",
            categoriaFarmacia: "",
            concentracion: "",
            lote: "",
            actFechaVencimiento: false,
            actLoteSerie: false,
            cantidadEmbalaje: "",
            idBodega: "",
            idZona: "",
            sector: "",
            ubicacion: "",
            unidadMedidaBase: "",
            descripcionProveedor: "",
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
            seleccionFechaVencimiento: {
                id: 0,
                descripcionFVen: "Seleccione Fecha Venciminento"
            },
            seleccionLoteSerie: {
                id: 0,
                descripcionLoteSerie: "Seleccione Lote/Serie"
            },
            seleccionProveedores: {
                id: 0,
                RUTPROV: "Ej. 22222222-2",
                NOMRAZSOC: ""
            },
            seleccionTipoDocumento: {
                id: 0,
                descripcionDocumento: ""
            },
            idMod: 0,
            //Datos Fechas
            configFromdateTimePicker: {
                minDate: null,
                maxDate: "today",
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
                minDate: null,
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
            //Configuracion Columnas
            colDetalle: [
                {
                    label: "Codigo Interno",
                    field: "CODART",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Especificacion Comprador",
                    field: "PRODUCTO",
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
                    label: "Unidad Medida",
                    field: "UNIMED",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Vencimiento Activo?",
                    field: "ACT_FECVEN",
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
                    label: "Lote",
                    field: "LOTE",
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
                    label: "Cantidad Rechazada",
                    field: "CANRECH",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Cantidad Pendiente",
                    field: "PENDIENTE",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Precio Unitario",
                    field: "PREUNI",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Total Recepcionado",
                    field: "VALTOT",
                    filterOptions: {
                        enabled: true
                    }
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
            colTotal: [
                {
                    label: "NETO",
                    field: "NETO"
                },
                {
                    label: "Descuento",
                    field: "DCTO"
                },
                {
                    label: "Cargos",
                    field: "CARGO"
                },
                {
                    label: "Sub Total",
                    field: "SUBTOTAL"
                },
                {
                    label: "19% Iva",
                    field: "IVA"
                },
                {
                    label: "Ajuste",
                    field: "AJUSTE"
                },
                {
                    label: "Total",
                    field: "TOTAL"
                }
            ],
            //Datos Listado
            rows: [],
            listaArticulos: [],
            listaDetalleRecepcion: [],
            listaRecepcion: [],
            listaEstado: [],
            listaBodega: [],
            listaTipoDocumento: [],
            listaZona: [],
            listadoProveedores: [],
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
        onFromChange(selectedDates, dateStr, instance) {
            this.$set(this.configTodateTimePicker, "minDate", dateStr);
        },
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
        setProveedor() {
            try {
                this.descripcionProveedor = "";
                this.descripcionProveedor = this.seleccionProveedores.NOMRAZSOC;
            } catch (error) {
                console.log(error);
            }
        },
        //Funciones Finales Recepcion
        ImprimirDatos() {
            try {
                if (this.numint != 0 && this.folio != 0) {
                    const url =
                        this.localVal +
                        "/api/Recepcion/RecepcionPDF/" +
                        this.numint;
                    window.open(url, "_blank");
                } else {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "No esta creado el Numero Interno",
                        color: "danger",
                        position: "top-right"
                    });
                }
            } catch (error) {
                console.log(error);
            }
        },
        volver() {
            try {
                this.$router.push({
                    name: "ListadoRecepcionCerrada"
                });
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD
        TraerDetalleRecepcion() {
            try {
                let data = {
                    NUMINT: this.$route.params.NUMINT
                };

                this.numint = this.$route.params.NUMINT;

                axios
                    .post(
                        this.localVal +
                            "/api/Mantenedor/GetArticulosIngresadosByCodInterno",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listaDetalleRecepcion = res.data;
                        if (this.listaDetalleRecepcion.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            let c = this.listaDetalleRecepcion;
                            let a = 0;
                            c.forEach((value, index) => {
                                a = a + parseInt(value.VALTOT);
                            });
                            this.valorTotal = a;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerRecepcion() {
            try {
                let data = {
                    NUMINT: this.$route.params.NUMINT
                };
                axios
                    .post(
                        this.localVal +
                            "/api/Mantenedor/GetRecepcionIngresadaByCodInterno",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listaRecepcion = res.data;
                        if (this.listaRecepcion.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            let c = this.listaRecepcion;
                            let idDoc = 0;
                            c.forEach((value, index) => {
                                this.fechaSistema = moment(value.FECSYS)
                                    .format("DD/MM/YYYY")
                                    .toString();
                                this.fechaRecepcion = moment(value.FECDES)
                                    .format("DD/MM/YYYY")
                                    .toString();
                                this.seleccionProveedores.RUTPROV =
                                    value.RUTPRO;
                                this.seleccionProveedores.NOMRAZSOC =
                                    value.NOMPRO;
                                this.descripcionProveedor = value.NOMPRO;
                                idDoc = value.TIPDOC;
                                this.ndocumento = value.NUMDOC;
                                this.fechaDocumento = moment(value.FECDOC)
                                    .format("DD/MM/YYYY")
                                    .toString();
                                this.nordencompra = value.NUMFAC;
                                this.nrib = value.NUMRIB;
                                this.folio = value.FOLIO;
                            });

                            c = [];

                            c = this.listaTipoDocumento;
                            c.forEach((value, index) => {
                                if (idDoc == value.id) {
                                    this.seleccionTipoDocumento.id;
                                    this.seleccionTipoDocumento.descripcionDocumento =
                                        value.descripcionDocumento;
                                }
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerProveedores() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetProveedor", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoProveedores = res.data;
                        if (this.listadoProveedores.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los proveedores correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerTipoDocumentos() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetTipoDocumentos", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaTipoDocumento = res.data;
                        if (this.listaTipoDocumento.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los proveedores correctamente",
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
        cargarHoras() {
            try {
                let date = moment().endOf("day");
                this.fechaRecepcion = date.format("DD/MM/YYYY").toString();
                this.fechaSistema = date.format("DD/MM/YYYY").toString();
                this.fechaDocumento = date.format("DD/MM/YYYY").toString();
                this.fechaVencimiento = date.format("DD/MM/YYYY").toString();
            } catch (error) {
                console.log("No se cargo la ISO hora");
                console.log(error);
            }
        }
    },
    beforeMount() {
        this.TraerTipoDocumentos();
        this.TraerProveedores();
        this.TraerEstado();
        this.TraerBodega();
        this.TraerZona();
        setTimeout(() => {
            this.TraerDetalleRecepcion();
            this.TraerRecepcion();
        }, 2000);

        this.cargarHoras();
        this.openLoadingColor();
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1500px;
}
</style>
