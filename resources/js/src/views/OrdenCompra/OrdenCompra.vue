<template>
    <div>
        <!-- Orden de Compra -->
        <vx-card title="Orden de Compra" class="md:w-1/1 w-full mb-2 mt-3">
            <div class="vx-row">
                <div class="vx-col w-full mt-5">
                    <vs-button
                        @click="popRecepciones"
                        color="primary"
                        type="filled"
                        class="w-full"
                        >Buscar Recepciones</vs-button
                    >
                </div>
                <div
                    class="vx-col w-full mt-5"
                    v-if="listaDetalleOrdenCompra.length > 0"
                >
                    <h6>N° Interno</h6>
                    <vs-input
                        class="inputx w-full  "
                        v-model="numint"
                        disabled
                    />
                </div>
            </div>
        </vx-card>
        <vx-card title="" class="md:w-1/1 w-full mb-2 mt-3">
            <div class="vx-row">
                <div
                    class="vx-col mt-5"
                    style="padding: 0 1rem; width: 7.3% !important;"
                >
                    <h6>F. Sistema</h6>
                    <flat-pickr
                        :config="configFromdateTimePicker"
                        v-model="fechaSistema"
                        placeholder="Fecha Sistema"
                        class="w-full "
                        disabled
                    />
                </div>
                <div
                    class="vx-col mt-5"
                    style="padding: 0 0.2rem; width: 7.3% !important;"
                >
                    <h6>F. Inicio</h6>
                    <flat-pickr
                        :config="configFromdateTimePicker"
                        v-model="fechaOrdenCompra"
                        placeholder="Fecha Inicio"
                        @on-change="onFromChange"
                        class="w-full "
                    />
                </div>
                <div
                    class="vx-col mt-5"
                    style="padding: 0 0.2rem; width: 14.3% !important;"
                >
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
                <div
                    class="vx-col mt-5"
                    style="padding: 0 0.2rem; width: 16.3% !important;"
                >
                    <h6>Nombre Proveedor</h6>
                    <vs-input
                        class="inputx w-full  "
                        v-model="descripcionProveedor"
                        disabled
                    />
                </div>
                <div
                    class="vx-col mt-5"
                    style="padding: 0 0.2rem; width: 7.3% !important;"
                >
                    <h6>Sigfe</h6>
                    <vs-input class="inputx w-full  " v-model="nsigfe" />
                </div>
                <div
                    class="vx-col mt-5"
                    style="padding: 0 0.2rem; width: 10.3% !important;"
                >
                    <h6>
                        Folio Recepcionado
                    </h6>
                    <vs-input
                        class="inputx w-full  "
                        v-model="nfoliorecepcionado"
                        disabled
                    />
                </div>
                <div
                    class="vx-col mt-5"
                    style="padding: 0 0.2rem; width: 7.3% !important;"
                >
                    <h6>
                        Año
                    </h6>
                    <vs-input class="inputx w-full  " v-model="anio" />
                </div>
                <div
                    class="vx-col mt-5"
                    style="padding: 0 0.2rem; width: 29.3% !important;"
                >
                    <h6>
                        .
                    </h6>
                    <vs-button
                        @click="AgregarRecepcionCerrada"
                        color="success"
                        type="filled"
                        class="w-full"
                        >Añadir</vs-button
                    >
                </div>
            </div>
        </vx-card>
        <!-- Detalles Orden Compra -->
        <div class="vx-col md:w-1/1 w-full mb-base mt-5">
            <vx-card title="">
                <div class="vx-row">
                    <vue-good-table
                        class="w-full"
                        :columns="colDetalle"
                        :rows="listaDetalleOrdenCompra"
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
                            <span v-else-if="props.column.field === 'action'">
                                <plus-circle-icon
                                    content="Modificar Orden Compra"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="popModDetalle(props.row.id)"
                                ></plus-circle-icon>
                            </span>
                            <!-- Column: Common -->
                            <span v-else>
                                {{ props.formattedRow[props.column.field] }}
                            </span>
                        </template>
                    </vue-good-table>
                </div>
            </vx-card>
            <div class="vx-row"></div>
        </div>
        <!-- Observaciones y totales -->
        <div class="vx-col md:w-1/1 w-full mb-base mt-5">
            <vx-card title="">
                <div class="vx-row">
                    <div class="vx-col w-full mt-5">
                        <h6>
                            Total
                        </h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="valorTotal"
                        />
                    </div>
                    <div class="vx-col w-full mt-5">
                        <h6>Observaciones</h6>
                        <vs-textarea v-model="Observaciones" height="70px" />
                    </div>
                </div>
            </vx-card>
        </div>
        <div class="vx-col md:w-1/1 w-full mb-base mt-5">
            <vx-card title="">
                <div class="vx-row">
                    <div class="vx-col w-1/3 mt-5">
                        <vs-button
                            @click="ActualizarListado"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Actualizar</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/3 mt-5">
                        <vs-button
                            @click="volver"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Volver</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/3 mt-5">
                        <vs-button
                            @click="CerrarOrdenCompra"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Cerrar Orden Compra</vs-button
                        >
                    </div>
                </div>
            </vx-card>
        </div>
        <!-- Listado Recepciones -->
        <vs-popup
            classContent="ListadoRecepcionesCerradas"
            title="Recepciones Cerradas"
            :active.sync="popUpRecepciones"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row">
                        <vx-card>
                            <vue-good-table
                                :columns="col"
                                :rows="listaRecepcion"
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
                                            content="Agregar Recepcion al listado"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                AgregarOrdenCompraDetalle(
                                                    props.row.FOLIO,
                                                    props.row.RUTPRO
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
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import moment from "moment";
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
import store from "../ScriptMenus/store.js";
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
            PageOptions: store.state.PageOptions,
            popUpRecepciones: false,
            validarRecepcion: false,
            codInternoRecepcion: 0,
            descripcionServicio: "",
            nsigfe: "",
            anio: 0,
            numint: 0,
            valorTotal: 0,
            totalRecepcion: 0,
            contador: 0,
            fechaSistema: null,
            fechaOrdenCompra: null,
            validadorProv: false,
            nfoliorecepcionado: "",
            Observaciones: "",
            nombre: "",
            tipoDocumento: "",
            folio: 0,
            folrec: 0,
            descripcionProveedor: "",
            seleccionProveedores: {
                id: 0,
                RUTPROV: "Ej. 22222222-2",
                NOMRAZSOC: ""
            },
            idMod: 0,
            //Datos Fechas
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
                minDate: null,
                dateFormat: "d/m/Y",
                allowInput: true,
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
                    label: "Folio Recepcion",
                    field: "FOLREC"
                },
                {
                    label: "Tipo Documento",
                    field: "TIPDOC"
                },
                {
                    label: "N° Documento",
                    field: "NUMDOC"
                },
                {
                    label: "Fecha Documento",
                    field: "FECDOC"
                },
                {
                    label: "OC Recepcion",
                    field: "NOMORD"
                },
                {
                    label: "Total",
                    field: "TOTAL"
                }
            ],
            col: [
                {
                    label: "Folio",
                    field: "FOLIO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "N° Orden Compra",
                    field: "NUMORD",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Fecha Recepcion",
                    field: "FECDES",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Rut Proveedor",
                    field: "RUTPRO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Nombre Proveedor",
                    field: "NOMPRO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "N° Documento",
                    field: "NUMDOC",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Usuario",
                    field: "USUING",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            //Datos Listado
            rows: [],
            listaDetalleOrdenCompra: [],
            listaDetalleOrdenCompraTemporal: [],
            listaRecepcion: [],
            listadoProveedores: [],
            listaConsumoInmediato: [
                {
                    id: 1,
                    descripcionConsumoInmediato: "Si"
                },
                {
                    id: 2,
                    descripcionConsumoInmediato: "No"
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
        limpiarCampos() {
            try {
                this.popUpRecepciones = false;
                this.codInternoRecepcion = 0;
                this.descripcionServicio = "";
                this.nsigfe = "";
                this.anio = 0;
                this.valorTotal = 0;
                this.totalRecepcion = 0;
                this.fechaSistema = null;
                this.fechaOrdenCompra = null;
                this.nfoliorecepcionado = "";
                this.Observaciones = "";
                this.nombre = "";
                this.tipoDocumento = "";
                this.descripcionProveedor = "";
                this.seleccionProveedores = {
                    id: 0,
                    RUTPROV: "Ej. 22222222-2",
                    NOMRAZSOC: ""
                };
                this.idMod = 0;
            } catch (error) {
                console.log(error);
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
        ActualizarListado() {
            try {
                let data = {
                    NUMINT: this.numint,
                    NUMSIGFE: this.nsigfe
                };

                axios
                    .post(
                        this.localVal + "/api/Mantenedor/PutOrdenCompras",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let data = res.data;
                        if (data == true) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Finalizado",
                                text:
                                    "Se han actualizado datos, se recargara la ventana",
                                color: "success",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        volver() {
            try {
                this.$router.push({
                    name: "home"
                });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarOrdenCompraDetalle(folio, rutprov) {
            try {
                let c = this.listaRecepcion;
                let validador = false;
                c.forEach((value, index) => {
                    if (this.validadorProv == false) {
                        if (folio == value.FOLIO) {
                            this.nfoliorecepcionado = value.FOLIO;
                            this.tipoDocumento = value.descripcionDocumento;
                            this.ndocumento = value.NUMDOC;
                            this.fechaDocumento = moment(value.FECDOC)
                                .format("DD/MM/YYYY")
                                .toString();
                            this.nordencompra = value.NUMORD;
                            this.totalRecepcion = value.TOTAL;
                            this.seleccionProveedores.RUTPROV = value.RUTPRO;
                            this.seleccionProveedores.NOMRAZSOC = value.NOMPRO;
                            this.descripcionProveedor = value.NOMPRO;
                        }
                    } else {
                        if (rutprov == this.seleccionProveedores.RUTPROV) {
                            this.nfoliorecepcionado = value.FOLIO;
                            this.tipoDocumento = value.descripcionDocumento;
                            this.ndocumento = value.NUMDOC;
                            this.fechaDocumento = moment(value.FECDOC)
                                .format("DD/MM/YYYY")
                                .toString();
                            this.nordencompra = value.NUMORD;
                            this.totalRecepcion = value.TOTAL;
                        } else {
                            validador = true;
                        }
                    }
                });

                if (validador == true) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "Proveedor no puede ser diferente al agregado en la orden de compra",
                        color: "danger",
                        position: "top-right"
                    });
                }

                c = [];

                this.popUpRecepciones = false;
            } catch (error) {
                console.log(error);
            }
        },
        CerrarOrdenCompra() {
            try {
                if (this.listaDetalleOrdenCompra.length < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "No existen datos en el detalle de ordenes de compra para generar un N° de Folio",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.folio == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "No se pudo generar un N° de Folio",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        NUMINT: this.numint,
                        FOLIO: this.folio
                    };
                    axios
                        .post(
                            this.localVal +
                                "/api/Mantenedor/PostCerrarOrdenCompra",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let data = res.data;
                            if (data == true) {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Finalizado",
                                    text:
                                        "Orden de Compra Cerrada, se recargara la ventana",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.$router.push({
                                    name: "OrdenCompraCerrada",
                                    params: {
                                        NUMINT: `${this.numint}`
                                    }
                                });
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popRecepciones() {
            try {
                this.popUpRecepciones = true;
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD
        TraerDetalleOrdenCompra() {
            try {
                let data = {
                    NUMINT: this.numint
                };

                axios
                    .post(
                        this.localVal +
                            "/api/Mantenedor/GetOrdenCompraDetallesIngresadosByCodInterno",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listaDetalleOrdenCompra = res.data;
                        if (this.listaDetalleOrdenCompra.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            let c = this.listaDetalleOrdenCompra;
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
        TraerDetalleOrdenCompraTemporal() {
            try {
                let data = {
                    NUMINT: this.numint
                };

                axios
                    .post(
                        this.localVal +
                            "/api/OrdenCompras/GetOrdenCompraDetallesIngresadosByCodInterno",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listaDetalleOrdenCompraTemporal = res.data;
                        if (this.listaDetalleOrdenCompraTemporal.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            let c = this.listaDetalleOrdenCompraTemporal;
                            let d = this.listaDetalleOrdenCompra;

                            d.forEach((value, index) => {
                                c.forEach((val, ind) => {
                                    if (
                                        value.FOLIO != val.FOLIO ||
                                        val.FOLIO != null
                                    ) {
                                        this.folrec = val.FOLREC;
                                        this.validarRecepcion = true;
                                    }
                                });
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerRecepcion() {
            try {
                axios
                    .get(
                        this.localVal + "/api/Recepcion/GetRecepcionCerradaOC",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
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
                                `Bearer ` + localStorage.getItem("token")
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
        TraerUltimoNInterno() {
            try {
                axios
                    .get(
                        this.localVal + "/api/Mantenedor/GetUltimoNInternoOC",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let data = res.data;
                        if (
                            data == 0 ||
                            data == null ||
                            data == [] ||
                            data == {}
                        ) {
                            this.numint = 1;
                        } else {
                            this.numint = data + 1;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerUltimoNFolio() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetUltimoNFolioOC", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        let data = res.data;
                        if (
                            data == 0 ||
                            data == null ||
                            data == [] ||
                            data == {}
                        ) {
                            this.folio = 1;
                        } else {
                            this.folio = data + 1;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarRecepcionCerrada() {
            try {
                if (this.anio == null || this.anio < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe Ingresar un año",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.fechaOrdenCompra == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una fecha de recepcion",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.nfoliorecepcionado == null ||
                    this.nfoliorecepcionado == "" ||
                    this.nfoliorecepcionado == 0
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una recepcion",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.tipoDocumento == null ||
                    this.tipoDocumento == ""
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Tipo Documento no Existe",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.ndocumento == null || this.ndocumento == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "N° Documento no Existe",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.fechaDocumento == null ||
                    this.fechaDocumento == ""
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Fecha Documento no Existe",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.nordencompra == null ||
                    this.nordencompra == ""
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "N° Orden Compra no existe",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.totalRecepcion == null ||
                    this.totalRecepcion == ""
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Total recepcion no existe",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    if (this.validarRecepcion == true) {
                        this.$vs.notify({
                            time: 5000,
                            title: "Error",
                            text:
                                "Recepcion N°" +
                                this.folrec +
                                " ya esta ingresada, quitela del listado para continuar",
                            color: "danger",
                            position: "top-right"
                        });
                    } else {
                        let nombreUsuario =
                            localStorage.getItem("nombre") +
                            " " +
                            localStorage.getItem("apellido");
                        let data = {
                            NUMINT: this.numint,
                            FECSYS: moment(
                                this.fechaSistema,
                                "DD-MM-YYYY"
                            ).format("YYYY-MM-DD"),
                            FECORD: moment(
                                this.fechaOrdenCompra,
                                "DD-MM-YYYY"
                            ).format("YYYY-MM-DD"),
                            RUTPRO: this.seleccionProveedores.RUTPROV,
                            NOMPRO: this.seleccionProveedores.NOMRAZSOC.toUpperCase(),
                            NUMSIGFE: this.nsigfe,

                            OBS: this.Observaciones.toUpperCase(),
                            USUING: nombreUsuario.toUpperCase(),
                            TIPDOC: this.tipoDocumento,
                            NUMDOC: this.ndocumento,
                            FECDOC: moment(
                                this.fechaDocumento,
                                "DD-MM-YYYY"
                            ).format("YYYY-MM-DD"),
                            TOTAL: parseInt(this.totalRecepcion),
                            FOLREC: this.nfoliorecepcionado,
                            NOMORD: this.nordencompra
                        };
                        const dat = data;

                        if (this.contador > 0) {
                            axios
                                .post(
                                    this.localVal +
                                        "/api/Mantenedor/PostOrdenComprasDetalleByCodInterno",
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
                                                "Recepcion ingresada al detalle Correctamente",
                                            color: "success",
                                            position: "top-right"
                                        });

                                        this.validadorProv = true;
                                        this.TraerRecepcion();
                                        this.TraerDetalleOrdenCompra();
                                        this.nfoliorecepcionado = 0;
                                        this.anio = 0;
                                    } else {
                                        this.$vs.notify({
                                            time: 5000,
                                            title: "Error",
                                            text:
                                                "No fue posible agregar la recepcion al detalle,intentelo nuevamente",
                                            color: "danger",
                                            position: "top-right"
                                        });
                                    }
                                });
                        } else {
                            axios
                                .post(
                                    this.localVal +
                                        "/api/Mantenedor/PostOrdenCompras",
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
                                                "Recepcion fue ingresado al detalle Correctamente",
                                            color: "success",
                                            position: "top-right"
                                        });
                                        this.contador = parseInt(
                                            this.contador + 1
                                        );
                                        this.validadorProv = true;
                                        this.TraerRecepcion();
                                        this.TraerDetalleOrdenCompra();
                                        this.nfoliorecepcionado = 0;
                                        this.anio = 0;
                                    } else {
                                        this.$vs.notify({
                                            time: 5000,
                                            title: "Error",
                                            text:
                                                "No fue posible agregar la recepcion al detalle,intentelo nuevamente",
                                            color: "danger",
                                            position: "top-right"
                                        });
                                    }
                                });
                        }
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },
        cargarHoras() {
            try {
                let date = moment().endOf("day");
                this.fechaOrdenCompra = date.format("DD/MM/YYYY").toString();
                this.fechaSistema = date.format("DD/MM/YYYY").toString();
            } catch (error) {
                console.log("No se cargo la ISO hora");
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
            this.TraerRecepcion();
            this.TraerUltimoNInterno();
            this.TraerUltimoNFolio();
            this.TraerProveedores();
            this.cargarHoras();
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
